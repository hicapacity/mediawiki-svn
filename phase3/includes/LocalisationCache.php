<?php

define( 'MW_LC_VERSION', 1 );

/**
 * Class for caching the contents of localisation files, Messages*.php
 * and *.i18n.php.
 *
 * An instance of this class is available using Language::getLocalisationCache().
 *
 * The values retrieved from here are merged, containing items from extension 
 * files, core messages files and the language fallback sequence (e.g. zh-cn -> 
 * zh-hans -> en ). Some common errors are corrected, for example namespace
 * names with spaces instead of underscores, but heavyweight processing, such
 * as grammatical transformation, is done by the caller.
 */
class LocalisationCache {
	/** Configuration associative array */
	var $conf;

	/**
	 * True if recaching should only be done on an explicit call to recache().
	 * Setting this reduces the overhead of cache freshness checking, which
	 * requires doing a stat() for every extension i18n file.
	 */
	var $manualRecache = false;

	/**
	 * True to treat all files as expired until they are regenerated by this object.
	 */
	var $forceRecache = false;

	/**
	 * The cache data. 3-d array, where the first key is the language code,
	 * the second key is the item key e.g. 'messages', and the third key is
	 * an item specific subkey index. Some items are not arrays and so for those
	 * items, there are no subkeys.
	 */
	var $data = array();

	/**
	 * The persistent store object. An instance of LCStore.
	 */
	var $store;

	/**
	 * A 2-d associative array, code/key, where presence indicates that the item
	 * is loaded. Value arbitrary.
	 *
	 * For split items, if set, this indicates that all of the subitems have been
	 * loaded.
	 */
	var $loadedItems = array();

	/**
	 * A 3-d associative array, code/key/subkey, where presence indicates that
	 * the subitem is loaded. Only used for the split items, i.e. messages.
	 */
	var $loadedSubitems = array();

	/**
	 * An array where presence of a key indicates that that language has been
	 * initialised. Initialisation includes checking for cache expiry and doing
	 * any necessary updates.
	 */
	var $initialisedLangs = array();

	/**
	 * An array mapping non-existent pseudo-languages to fallback languages. This
	 * is filled by initShallowFallback() when data is requested from a language
	 * that lacks a Messages*.php file.
	 */
	var $shallowFallbacks = array();

	/**
	 * An array where the keys are codes that have been recached by this instance.
	 */
	var $recachedLangs = array();

	/**
	 * Data added by extensions using the deprecated $wgMessageCache->addMessages() 
	 * interface.
	 */
	var $legacyData = array();

	/**
	 * All item keys
	 */
	static public $allKeys = array(
		'fallback', 'namespaceNames', 'mathNames', 'bookstoreList',
		'magicWords', 'messages', 'rtl', 'capitalizeAllNouns', 'digitTransformTable',
		'separatorTransformTable', 'fallback8bitEncoding', 'linkPrefixExtension',
		'defaultUserOptionOverrides', 'linkTrail', 'namespaceAliases',
		'dateFormats', 'datePreferences', 'datePreferenceMigrationMap',
		'defaultDateFormat', 'extraUserToggles', 'specialPageAliases',
		'imageFiles', 'preloadedMessages',
	);

	/**
	 * Keys for items which consist of associative arrays, which may be merged
	 * by a fallback sequence.
	 */
	static public $mergeableMapKeys = array( 'messages', 'namespaceNames', 'mathNames',
		'dateFormats', 'defaultUserOptionOverrides', 'magicWords', 'imageFiles',
		'preloadedMessages',
	);

	/**
	 * Keys for items which are a numbered array.
	 */
	static public $mergeableListKeys = array( 'extraUserToggles' );

	/**
	 * Keys for items which contain an array of arrays of equivalent aliases
	 * for each subitem. The aliases may be merged by a fallback sequence.
	 */
	static public $mergeableAliasListKeys = array( 'specialPageAliases' );

	/**
	 * Keys for items which contain an associative array, and may be merged if
	 * the primary value contains the special array key "inherit". That array
	 * key is removed after the first merge.
	 */
	static public $optionalMergeKeys = array( 'bookstoreList' );

	/**
	 * Keys for items where the subitems are stored in the backend separately.
	 */
	static public $splitKeys = array( 'messages' );

	/**
	 * Keys which are loaded automatically by initLanguage()
	 */
	static public $preloadedKeys = array( 'dateFormats', 'namespaceNames',
		'defaultUserOptionOverrides' );

	/**
	 * Constructor.
	 * For constructor parameters, see the documentation in DefaultSettings.php 
	 * for $wgLocalisationCacheConf.
	 */
	function __construct( $conf ) {
		global $wgCacheDirectory;

		$this->conf = $conf;
		$storeConf = array();
		if ( !empty( $conf['storeClass'] ) ) {
			$storeClass = $conf['storeClass'];
		} else {
			switch ( $conf['store'] ) {
				case 'files':
				case 'file':
					$storeClass = 'LCStore_CDB';
					break;
				case 'db':
					$storeClass = 'LCStore_DB';
					break;
				case 'detect':
					$storeClass = $wgCacheDirectory ? 'LCStore_CDB' : 'LCStore_DB';
					break;
				default:
					throw new MWException( 
						'Please set $wgLocalisationConf[\'store\'] to something sensible.' );
			}
		}

		wfDebug( get_class( $this ) . ": using store $storeClass\n" );
		if ( !empty( $conf['storeDirectory'] ) ) {
			$storeConf['directory'] = $conf['storeDirectory'];
		}

		$this->store = new $storeClass( $storeConf );
		foreach ( array( 'manualRecache', 'forceRecache' ) as $var ) {
			if ( isset( $conf[$var] ) ) {
				$this->$var = $conf[$var];
			}
		}
	}

	/**
	 * Returns true if the given key is mergeable, that is, if it is an associative
	 * array which can be merged through a fallback sequence.
	 */
	public function isMergeableKey( $key ) {
		if ( !isset( $this->mergeableKeys ) ) {
			$this->mergeableKeys = array_flip( array_merge(
				self::$mergeableMapKeys,
				self::$mergeableListKeys,
				self::$mergeableAliasListKeys,
				self::$optionalMergeKeys
			) );
		}
		return isset( $this->mergeableKeys[$key] );
	}

	/**
	 * Get a cache item.
	 *
	 * Warning: this may be slow for split items (messages), since it will
	 * need to fetch all of the subitems from the cache individually.
	 */
	public function getItem( $code, $key ) {
		if ( !isset( $this->loadedItems[$code][$key] ) ) {
			wfProfileIn( __METHOD__.'-load' );
			$this->loadItem( $code, $key );
			wfProfileOut( __METHOD__.'-load' );
		}
		if ( $key === 'fallback' && isset( $this->shallowFallbacks[$code] ) ) {
			return $this->shallowFallbacks[$code];
		}
		return $this->data[$code][$key];
	}

	/**
	 * Get a subitem, for instance a single message for a given language.
	 */
	public function getSubitem( $code, $key, $subkey ) {
		if ( isset( $this->legacyData[$code][$key][$subkey] ) ) {
			return $this->legacyData[$code][$key][$subkey];
		}
		if ( !isset( $this->loadedSubitems[$code][$key][$subkey] ) ) {
			if ( isset( $this->loadedItems[$code][$key] ) ) {
				if ( isset( $this->data[$code][$key][$subkey] ) ) {
					return $this->data[$code][$key][$subkey];
				} else {
					return null;
				}
			} else {
				wfProfileIn( __METHOD__.'-load' );
				$this->loadSubitem( $code, $key, $subkey );
				wfProfileOut( __METHOD__.'-load' );
			}
		}
		return $this->data[$code][$key][$subkey];
	}

	/**
	 * Load an item into the cache.
	 */
	protected function loadItem( $code, $key ) {
		if ( !isset( $this->initialisedLangs[$code] ) ) {
			$this->initLanguage( $code );
		}
		// Check to see if initLanguage() loaded it for us
		if ( isset( $this->loadedItems[$code][$key] ) ) {
			return;
		}
		if ( isset( $this->shallowFallbacks[$code] ) ) {
			$this->loadItem( $this->shallowFallbacks[$code], $key );
			return;
		}
		if ( in_array( $key, self::$splitKeys ) ) {
			$subkeyList = $this->getSubitem( $code, 'list', $key );
			foreach ( $subkeyList as $subkey ) {
				if ( isset( $this->data[$code][$key][$subkey] ) ) {
					continue;
				}
				$this->data[$code][$key][$subkey] = $this->getSubitem( $code, $key, $subkey );
			}
		} else {
			$this->data[$code][$key] = $this->store->get( $code, $key );
		}
		$this->loadedItems[$code][$key] = true;
	}

	/**
	 * Load a subitem into the cache
	 */
	protected function loadSubitem( $code, $key, $subkey ) {
		if ( !in_array( $key, self::$splitKeys ) ) {
			$this->loadItem( $code, $key );
			return;
		}
		if ( !isset( $this->initialisedLangs[$code] ) ) {
			$this->initLanguage( $code );
		}
		// Check to see if initLanguage() loaded it for us
		if ( isset( $this->loadedItems[$code][$key] )
			|| isset( $this->loadedSubitems[$code][$key][$subkey] ) )
		{
			return;
		}
		if ( isset( $this->shallowFallbacks[$code] ) ) {
			$this->loadSubitem( $this->shallowFallbacks[$code], $key, $subkey );
			return;
		}
		$value = $this->store->get( $code, "$key:$subkey" );
		$this->data[$code][$key][$subkey] = $value;
		$this->loadedSubitems[$code][$key][$subkey] = true;
	}

	/**
	 * Returns true if the cache identified by $code is missing or expired.
	 */
	public function isExpired( $code ) {
		if ( $this->forceRecache && !isset( $this->recachedLangs[$code] ) ) {
			wfDebug( __METHOD__."($code): forced reload\n" );
			return true;
		}

		$deps = $this->store->get( $code, 'deps' );
		if ( $deps === null ) {
			wfDebug( __METHOD__."($code): cache missing, need to make one\n" );
			return true;
		}
		foreach ( $deps as $dep ) {
			if ( $dep->isExpired() ) {
				wfDebug( __METHOD__."($code): cache for $code expired due to " . 
					get_class( $dep ) . "\n" );
				return true;
			}
		}
		return false;
	}

	/**
	 * Initialise a language in this object. Rebuild the cache if necessary.
	 */
	protected function initLanguage( $code ) {
		if ( isset( $this->initialisedLangs[$code] ) ) {
			return;
		}
		$this->initialisedLangs[$code] = true;

		# Recache the data if necessary
		if ( !$this->manualRecache && $this->isExpired( $code ) ) {
			if ( file_exists( Language::getMessagesFileName( $code ) ) ) {
				$this->recache( $code );
			} elseif ( $code === 'en' ) {
				throw new MWException( 'MessagesEn.php is missing.' );
			} else {
				$this->initShallowFallback( $code, 'en' );
			}
			return;
		}

		# Preload some stuff
		$preload = $this->getItem( $code, 'preload' );
		if ( $preload === null ) {
			if ( $this->manualRecache ) {
				// No Messages*.php file. Do shallow fallback to en.
				if ( $code === 'en' ) {
					throw new MWException( 'No localisation cache found for English. ' . 
						'Please run maintenance/rebuildLocalisationCache.php.' );
				}
				$this->initShallowFallback( $code, 'en' );
				return;
			} else {
				throw new MWException( 'Invalid or missing localisation cache.' );
			}
		}
		$this->data[$code] = $preload;
		foreach ( $preload as $key => $item ) {
			if ( in_array( $key, self::$splitKeys ) ) {
				foreach ( $item as $subkey => $subitem ) {
					$this->loadedSubitems[$code][$key][$subkey] = true;
				}
			} else {
				$this->loadedItems[$code][$key] = true;
			}
		}
	}

	/**
	 * Create a fallback from one language to another, without creating a 
	 * complete persistent cache.
	 */
	public function initShallowFallback( $primaryCode, $fallbackCode ) {
		$this->data[$primaryCode] =& $this->data[$fallbackCode];
		$this->loadedItems[$primaryCode] =& $this->loadedItems[$fallbackCode];
		$this->loadedSubitems[$primaryCode] =& $this->loadedSubitems[$fallbackCode];
		$this->shallowFallbacks[$primaryCode] = $fallbackCode;
	}

	/**
	 * Read a PHP file containing localisation data.
	 */
	protected function readPHPFile( $_fileName, $_fileType ) {
		// Disable APC caching
		$_apcEnabled = ini_set( 'apc.enabled', '0' );
		include( $_fileName );
		ini_set( 'apc.enabled', $_apcEnabled );

		if ( $_fileType == 'core' || $_fileType == 'extension' ) {
			$data = compact( self::$allKeys );
		} elseif ( $_fileType == 'aliases' ) {
			$data = compact( 'aliases' );
		} else {
			throw new MWException( __METHOD__.": Invalid file type: $_fileType" );
		}
		return $data;
	}

	/**
	 * Merge two localisation values, a primary and a fallback, overwriting the 
	 * primary value in place.
	 */
	protected function mergeItem( $key, &$value, $fallbackValue ) {
		if ( !is_null( $value ) ) {
			if ( !is_null( $fallbackValue ) ) {
				if ( in_array( $key, self::$mergeableMapKeys ) ) {
					$value = $value + $fallbackValue;
				} elseif ( in_array( $key, self::$mergeableListKeys ) ) {
					$value = array_unique( array_merge( $fallbackValue, $value ) );
				} elseif ( in_array( $key, self::$mergeableAliasListKeys ) ) {
					$value = array_merge_recursive( $value, $fallbackValue );
				} elseif ( in_array( $key, self::$optionalMergeKeys ) ) {
					if ( !empty( $value['inherit'] ) )  {
						$value = array_merge( $fallbackValue, $value );
					}
					if ( isset( $value['inherit'] ) ) {
						unset( $value['inherit'] );
					}
				}
			}
		} else {
			$value = $fallbackValue;
		}
	}

	/**
	 * Given an array mapping language code to localisation value, such as is
	 * found in extension *.i18n.php files, iterate through a fallback sequence
	 * to merge the given data with an existing primary value.
	 *
	 * Returns true if any data from the extension array was used, false 
	 * otherwise.
	 */
	protected function mergeExtensionItem( $codeSequence, $key, &$value, $fallbackValue ) {
		$used = false;
		foreach ( $codeSequence as $code ) {
			if ( isset( $fallbackValue[$code] ) ) {
				$this->mergeItem( $key, $value, $fallbackValue[$code] );
				$used = true;
			}
		}
		return $used;
	}

	/**
	 * Load localisation data for a given language for both core and extensions
	 * and save it to the persistent cache store and the process cache
	 */
	public function recache( $code ) {
		static $recursionGuard = array();
		global $wgExtensionMessagesFiles, $wgExtensionAliasesFiles;
		wfProfileIn( __METHOD__ );

		if ( !$code ) {
			throw new MWException( "Invalid language code requested" );
		}
		$this->recachedLangs[$code] = true;

		# Initial values
		$initialData = array_combine(
			self::$allKeys, 
			array_fill( 0, count( self::$allKeys ), null ) );
		$coreData = $initialData;
		$deps = array();

		# Load the primary localisation from the source file
		$fileName = Language::getMessagesFileName( $code );
		if ( !file_exists( $fileName ) ) {
			wfDebug( __METHOD__.": no localisation file for $code, using fallback to en\n" );
			$coreData['fallback'] = 'en';
		} else {
			$deps[] = new FileDependency( $fileName );
			$data = $this->readPHPFile( $fileName, 'core' );
			wfDebug( __METHOD__.": got localisation for $code from source\n" );

			# Merge primary localisation
			foreach ( $data as $key => $value ) {
				$this->mergeItem( $key, $coreData[$key], $value );
			}
		}

		# Fill in the fallback if it's not there already
		if ( is_null( $coreData['fallback'] ) ) {
			$coreData['fallback'] = $code === 'en' ? false : 'en';
		}

		if ( $coreData['fallback'] !== false ) {
			# Guard against circular references
			if ( isset( $recursionGuard[$code] ) ) {
				throw new MWException( "Error: Circular fallback reference in language code $code" );
			}
			$recursionGuard[$code] = true;

			# Load the fallback localisation item by item and merge it
			$deps = array_merge( $deps, $this->getItem( $coreData['fallback'], 'deps' ) );
			foreach ( self::$allKeys as $key ) {
				if ( is_null( $coreData[$key] ) || $this->isMergeableKey( $key ) ) {
					$fallbackValue = $this->getItem( $coreData['fallback'], $key );
					$this->mergeItem( $key, $coreData[$key], $fallbackValue );
				}
			}
			$fallbackSequence = $this->getItem( $coreData['fallback'], 'fallbackSequence' );
			array_unshift( $fallbackSequence, $coreData['fallback'] );
			$coreData['fallbackSequence'] = $fallbackSequence;
			unset( $recursionGuard[$code] );
		} else {
			$coreData['fallbackSequence'] = array();
		}
		$codeSequence = array_merge( array( $code ), $coreData['fallbackSequence'] );

		# Load the extension localisations
		# This is done after the core because we know the fallback sequence now.
		# But it has a higher precedence for merging so that we can support things 
		# like site-specific message overrides.
		$allData = $initialData;
		foreach ( $wgExtensionMessagesFiles as $fileName ) {
			$data = $this->readPHPFile( $fileName, 'extension' );
			$used = false;
			foreach ( $data as $key => $item ) {
				if( $this->mergeExtensionItem( $codeSequence, $key, $allData[$key], $item ) ) {
					$used = true;
				}
			}
			if ( $used ) {
				$deps[] = new FileDependency( $fileName );
			}
		}

		# Load deprecated $wgExtensionAliasesFiles
		foreach ( $wgExtensionAliasesFiles as $fileName ) {
			$data = $this->readPHPFile( $fileName, 'aliases' );
			if ( !isset( $data['aliases'] ) ) {
				continue;
			}
			$used = $this->mergeExtensionItem( $codeSequence, 'specialPageAliases',
				$allData['specialPageAliases'], $data['aliases'] );
			if ( $used ) {
				$deps[] = new FileDependency( $fileName );
			}
		}

		# Merge core data into extension data
		foreach ( $coreData as $key => $item ) {
			$this->mergeItem( $key, $allData[$key], $item );
		}

		# Add cache dependencies for any referenced globals
		$deps['wgExtensionMessagesFiles'] = new GlobalDependency( 'wgExtensionMessagesFiles' );
		$deps['wgExtensionAliasesFiles'] = new GlobalDependency( 'wgExtensionAliasesFiles' );
		$deps['version'] = new ConstantDependency( 'MW_LC_VERSION' );

		# Add dependencies to the cache entry
		$allData['deps'] = $deps;

		# Replace spaces with underscores in namespace names
		$allData['namespaceNames'] = str_replace( ' ', '_', $allData['namespaceNames'] );

		# And do the same for special page aliases. $page is an array.
		foreach ( $allData['specialPageAliases'] as &$page ) {
			$page = str_replace( ' ', '_', $page );
		}
		# Decouple the reference to prevent accidental damage
		unset($page);
	
		# Fix broken defaultUserOptionOverrides
		if ( !is_array( $allData['defaultUserOptionOverrides'] ) ) {
			$allData['defaultUserOptionOverrides'] = array();
		}

		# Set the preload key
		$allData['preload'] = $this->buildPreload( $allData );

		# Set the list keys
		$allData['list'] = array();
		foreach ( self::$splitKeys as $key ) {
			$allData['list'][$key] = array_keys( $allData[$key] );
		}

		# Run hooks
		wfRunHooks( 'LocalisationCacheRecache', array( $this, $code, &$allData ) );

		if ( is_null( $allData['defaultUserOptionOverrides'] ) ) {
			throw new MWException( __METHOD__.': Localisation data failed sanity check! ' . 
				'Check that your languages/messages/MessagesEn.php file is intact.' );
		}

		# Save to the process cache and register the items loaded
		$this->data[$code] = $allData;
		foreach ( $allData as $key => $item ) {
			$this->loadedItems[$code][$key] = true;
		}

		# Save to the persistent cache
		$this->store->startWrite( $code );
		foreach ( $allData as $key => $value ) {
			if ( in_array( $key, self::$splitKeys ) ) {
				foreach ( $value as $subkey => $subvalue ) {
					$this->store->set( "$key:$subkey", $subvalue );
				}
			} else {
				$this->store->set( $key, $value );
			}
		}
		$this->store->finishWrite();

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Build the preload item from the given pre-cache data.
	 *
	 * The preload item will be loaded automatically, improving performance
	 * for the commonly-requested items it contains.
	 */
	protected function buildPreload( $data ) {
		$preload = array( 'messages' => array() );
		foreach ( self::$preloadedKeys as $key ) {
			$preload[$key] = $data[$key];
		}
		foreach ( $data['preloadedMessages'] as $subkey ) {
			if ( isset( $data['messages'][$subkey] ) ) {
				$subitem = $data['messages'][$subkey];
			} else {
				$subitem = null;
			}
			$preload['messages'][$subkey] = $subitem;
		}
		return $preload;
	}

	/**
	 * Unload the data for a given language from the object cache. 
	 * Reduces memory usage.
	 */
	public function unload( $code ) {
		unset( $this->data[$code] );
		unset( $this->loadedItems[$code] );
		unset( $this->loadedSubitems[$code] );
		unset( $this->initialisedLangs[$code] );
		// We don't unload legacyData because there's no way to get it back 
		// again, it's not really a cache
		foreach ( $this->shallowFallbacks as $shallowCode => $fbCode ) {
			if ( $fbCode === $code ) {
				$this->unload( $shallowCode );
			}
		}
	}

	/**
	 * Unload all data
	 */
	public function unloadAll() {
		foreach ( $this->initialisedLangs as $lang => $unused ) {
			$this->unload( $lang );
		}
	}

	/**
	 * Add messages to the cache, from an extension that has not yet been 
	 * migrated to $wgExtensionMessages or the LocalisationCacheRecache hook. 
	 * Called by deprecated function $wgMessageCache->addMessages(). 
	 */
	public function addLegacyMessages( $messages ) {
		foreach ( $messages as $lang => $langMessages ) {
			if ( isset( $this->legacyData[$lang]['messages'] ) ) {
				$this->legacyData[$lang]['messages'] = 
					$langMessages + $this->legacyData[$lang]['messages'];
			} else {
				$this->legacyData[$lang]['messages'] = $langMessages;
			}
		}
	}

	/**
	 * Disable the storage backend
	 */
	public function disableBackend() {
		$this->store = new LCStore_Null;
		$this->manualRecache = false;
	}
}

/**
 * Interface for the persistence layer of LocalisationCache.
 *
 * The persistence layer is two-level hierarchical cache. The first level
 * is the language, the second level is the item or subitem.
 *
 * Since the data for a whole language is rebuilt in one operation, it needs 
 * to have a fast and atomic method for deleting or replacing all of the 
 * current data for a given language. The interface reflects this bulk update
 * operation. Callers writing to the cache must first call startWrite(), then 
 * will call set() a couple of thousand times, then will call finishWrite() 
 * to commit the operation. When finishWrite() is called, the cache is 
 * expected to delete all data previously stored for that language.
 *
 * The values stored are PHP variables suitable for serialize(). Implementations 
 * of LCStore are responsible for serializing and unserializing.
 */
interface LCStore {
	/**
	 * Get a value.
	 * @param $code Language code
	 * @param $key Cache key
	 */
	public function get( $code, $key );

	/**
	 * Start a write transaction.
	 * @param $code Language code
	 */
	public function startWrite( $code );

	/**
	 * Finish a write transaction.
	 */
	public function finishWrite();

	/**
	 * Set a key to a given value. startWrite() must be called before this
	 * is called, and finishWrite() must be called afterwards.
	 */
	public function set( $key, $value );

}

/**
 * LCStore implementation which uses the standard DB functions to store data. 
 * This will work on any MediaWiki installation.
 */
class LCStore_DB implements LCStore {
	var $currentLang;
	var $writesDone = false;
	var $dbw, $batch;
	var $readOnly = false;

	public function get( $code, $key ) {
		if ( $this->writesDone ) {
			$db = wfGetDB( DB_MASTER );
		} else {
			$db = wfGetDB( DB_SLAVE );
		}
		$row = $db->selectRow( 'l10n_cache', array( 'lc_value' ),
			array( 'lc_lang' => $code, 'lc_key' => $key ), __METHOD__ );
		if ( $row ) {
			return unserialize( $row->lc_value );
		} else {
			return null;
		}
	}

	public function startWrite( $code ) {
		if ( $this->readOnly ) {
			return;
		}
		if ( !$code ) {
			throw new MWException( __METHOD__.": Invalid language \"$code\"" );
		}
		$this->dbw = wfGetDB( DB_MASTER );
		try {
			$this->dbw->begin();
			$this->dbw->delete( 'l10n_cache', array( 'lc_lang' => $code ), __METHOD__ );
		} catch ( DBQueryError $e ) {
			if ( $this->dbw->wasReadOnlyError() ) {
				$this->readOnly = true;
				$this->dbw->rollback();
				$this->dbw->ignoreErrors( false );
				return;
			} else {
				throw $e;
			}
		}
		$this->currentLang = $code;
		$this->batch = array();
	}

	public function finishWrite() {
		if ( $this->readOnly ) {
			return;
		}
		if ( $this->batch ) {
			$this->dbw->insert( 'l10n_cache', $this->batch, __METHOD__ );
		}
		$this->dbw->commit();
		$this->currentLang = null;
		$this->dbw = null;
		$this->batch = array();
		$this->writesDone = true;
	}

	public function set( $key, $value ) {
		if ( $this->readOnly ) {
			return;
		}
		if ( is_null( $this->currentLang ) ) {
			throw new MWException( __CLASS__.': must call startWrite() before calling set()' );
		}
		$this->batch[] = array(
			'lc_lang' => $this->currentLang,
			'lc_key' => $key,
			'lc_value' => serialize( $value ) );
		if ( count( $this->batch ) >= 100 ) {
			$this->dbw->insert( 'l10n_cache', $this->batch, __METHOD__ );
			$this->batch = array();
		}
	}
}

/**
 * LCStore implementation which stores data as a collection of CDB files in the
 * directory given by $wgCacheDirectory. If $wgCacheDirectory is not set, this
 * will throw an exception.
 *
 * Profiling indicates that on Linux, this implementation outperforms MySQL if 
 * the directory is on a local filesystem and there is ample kernel cache 
 * space. The performance advantage is greater when the DBA extension is 
 * available than it is with the PHP port.
 *
 * See Cdb.php and http://cr.yp.to/cdb.html
 */
class LCStore_CDB implements LCStore {
	var $readers, $writer, $currentLang, $directory;

	function __construct( $conf = array() ) {
		global $wgCacheDirectory;
		if ( isset( $conf['directory'] ) ) {
			$this->directory = $conf['directory'];
		} else {
			$this->directory = $wgCacheDirectory;
		}
	}

	public function get( $code, $key ) {
		if ( !isset( $this->readers[$code] ) ) {
			$fileName = $this->getFileName( $code );
			if ( !file_exists( $fileName ) ) {
				$this->readers[$code] = false;
			} else {
				$this->readers[$code] = CdbReader::open( $fileName );
			}
		}
		if ( !$this->readers[$code] ) {
			return null;
		} else {
			$value = $this->readers[$code]->get( $key );
			if ( $value === false ) {
				return null;
			}
			return unserialize( $value );
		}
	}

	public function startWrite( $code ) {
		if ( !file_exists( $this->directory ) ) {
			if ( !wfMkdirParents( $this->directory ) ) {
				throw new MWException( "Unable to create the localisation store " . 
					"directory \"{$this->directory}\"" );
			}
		}
		// Close reader to stop permission errors on write
		if( !empty($this->readers[$code]) ) {
			$this->readers[$code]->close();
		}
		$this->writer = CdbWriter::open( $this->getFileName( $code ) );
		$this->currentLang = $code;
	}

	public function finishWrite() {
		// Close the writer
		$this->writer->close();
		$this->writer = null;
		unset( $this->readers[$this->currentLang] );
		$this->currentLang = null;
	}

	public function set( $key, $value ) {
		if ( is_null( $this->writer ) ) {
			throw new MWException( __CLASS__.': must call startWrite() before calling set()' );
		}
		$this->writer->set( $key, serialize( $value ) );
	}

	protected function getFileName( $code ) {
		if ( !$code || strpos( $code, '/' ) !== false ) {
			throw new MWException( __METHOD__.": Invalid language \"$code\"" );
		}
		return "{$this->directory}/l10n_cache-$code.cdb";
	}
}

/**
 * Null store backend, used to avoid DB errors during install
 */
class LCStore_Null implements LCStore {
	public function get( $code, $key ) {
		return null;
	}

	public function startWrite( $code ) {}
	public function finishWrite() {}
	public function set( $key, $value ) {}
}

/**
 * A localisation cache optimised for loading large amounts of data for many 
 * languages. Used by rebuildLocalisationCache.php.
 */
class LocalisationCache_BulkLoad extends LocalisationCache {
	/**
	 * A cache of the contents of data files.
	 * Core files are serialized to avoid using ~1GB of RAM during a recache.
	 */
	var $fileCache = array();

	/**
	 * Most recently used languages. Uses the linked-list aspect of PHP hashtables
	 * to keep the most recently used language codes at the end of the array, and 
	 * the language codes that are ready to be deleted at the beginning.
	 */
	var $mruLangs = array();

	/**
	 * Maximum number of languages that may be loaded into $this->data
	 */
	var $maxLoadedLangs = 10;

	protected function readPHPFile( $fileName, $fileType ) {
		$serialize = $fileType === 'core';
		if ( !isset( $this->fileCache[$fileName][$fileType] ) ) {
			$data = parent::readPHPFile( $fileName, $fileType );
			if ( $serialize ) {
				$encData = serialize( $data );
			} else {
				$encData = $data;
			}
			$this->fileCache[$fileName][$fileType] = $encData;
			return $data;
		} elseif ( $serialize ) {
			return unserialize( $this->fileCache[$fileName][$fileType] );
		} else {
			return $this->fileCache[$fileName][$fileType];
		}
	}

	public function getItem( $code, $key ) {
		unset( $this->mruLangs[$code] );
		$this->mruLangs[$code] = true;
		return parent::getItem( $code, $key );
	}

	public function getSubitem( $code, $key, $subkey ) {
		unset( $this->mruLangs[$code] );
		$this->mruLangs[$code] = true;
		return parent::getSubitem( $code, $key, $subkey );
	}

	public function recache( $code ) {
		parent::recache( $code );
		unset( $this->mruLangs[$code] );
		$this->mruLangs[$code] = true;
		$this->trimCache();
	}

	public function unload( $code ) {
		unset( $this->mruLangs[$code] );
		parent::unload( $code );
	}

	/**
	 * Unload cached languages until there are less than $this->maxLoadedLangs
	 */
	protected function trimCache() {
		while ( count( $this->data ) > $this->maxLoadedLangs && count( $this->mruLangs ) ) {
			reset( $this->mruLangs );
			$code = key( $this->mruLangs );
			wfDebug( __METHOD__.": unloading $code\n" );
			$this->unload( $code );
		}
	}
}
