<?php
/**
 * MediaWiki Wikilog extension
 * Copyright © 2008, 2009 Juliano F. Ravasi
 * http://www.mediawiki.org/wiki/Extension:Wikilog
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

/**
 * @addtogroup Extensions
 * @author Juliano F. Ravasi < dev juliano info >
 */

if ( !defined( 'MEDIAWIKI' ) )
	die();

/**
 * This class holds the parser functions that hooks into the Parser in order
 * to collect Wikilog metadata.
 */
class WikilogParser
{
	/**
	 * True if parsing articles with feed output specific settings.
	 * This is an horrible hack needed because of many MediaWiki misdesigns.
	 */
	static private $feedParsing = false;

	/**
	 * True if we are expanding local URLs (in order to render stand-alone,
	 * base-less feeds). This is an horrible hack needed because of many
	 * MediaWiki misdesigns.
	 */
	static private $expandingUrls = false;


	###
	## Parser hooks
	#

	/**
	 * ParserFirstCallInit hook handler function.
	 */
	public static function FirstCallInit( &$parser ) {
		$mwSummary =& MagicWord::get( 'wlk-summary' );
		foreach ( $mwSummary->getSynonyms() as $tagname ) {
			$parser->setHook( $tagname, array( 'WikilogParser', 'summary' ) );
		}

		$parser->setFunctionHook( 'wl-settings', array( 'WikilogParser', 'settings' ), SFH_NO_HASH );
		$parser->setFunctionHook( 'wl-publish',  array( 'WikilogParser', 'publish'  ), SFH_NO_HASH );
		$parser->setFunctionHook( 'wl-author',   array( 'WikilogParser', 'author'   ), SFH_NO_HASH );
		$parser->setFunctionHook( 'wl-tags',     array( 'WikilogParser', 'tags'     ), SFH_NO_HASH );
		$parser->setFunctionHook( 'wl-info',     array( 'WikilogParser', 'info'     ), SFH_NO_HASH );
		return true;
	}

	/**
	 * ParserClearState hook handler function.
	 */
	public static function ClearState( &$parser ) {
		$parser->mExtWikilog = new WikilogParserOutput;

		# Disable TOC in feeds.
		if ( self::$feedParsing ) {
			$parser->mShowToc = false;
		}
		return true;
	}

	/**
	 * ParserBeforeInternalParse hook handler function.
	 */
	public static function BeforeInternalParse( &$parser, &$text, &$stripState ) {
		global $wgUser;

		# Do nothing if a title is not set.
		if ( ! ( $title = $parser->getTitle() )  )
			return true;

		# Do nothing if it is not a wikilog article.
		if ( ! ( $wi = Wikilog::getWikilogInfo( $parser->getTitle() ) ) )
			return true;

		if ( $wi->isItem() ) {
			# By default, use the item name as the default sort in categories.
			# This can be overriden by {{DEFAULTSORT:...}} if the user wants.
			$parser->setDefaultSort( $wi->getItemName() );
		}

		return true;
	}

	/**
	 * ParserAfterTidy hook handler function.
	 */
	public static function AfterTidy( &$parser, &$text ) {
		$parser->mOutput->mExtWikilog = $parser->mExtWikilog;
		return true;
	}

	/**
	 * GetLocalURL hook handler function.
	 * Expands local URL @a $url if self::$expandingUrls is true.
	 */
	static function GetLocalURL( &$title, &$url, $query ) {
		if ( self::$expandingUrls ) {
			$url = wfExpandUrl( $url );
		}
		return true;
	}

	/**
	 * GetFullURL hook handler function.
	 * Fix some brain-damage in Title::getFullURL() (as of MW 1.13) that
	 * prepends $wgServer to URL without using wfExpandUrl(), in part because
	 * we want (above in Wikilog::GetLocalURL()) to return an absolute URL
	 * from Title::getLocalURL() in situations where action != 'render'.
	 * @todo Report this bug to MediaWiki bugzilla.
	 */
	static function GetFullURL( &$title, &$url, $query ) {
		global $wgServer;
		if ( self::$expandingUrls ) {
			$l = strlen( $wgServer );
			if ( substr( $url, 0, 2 * $l ) == $wgServer . $wgServer ) {
				$url = substr( $url, $l );
			}
		}
		return true;
	}

	###
	## Parser tags and functions
	#

	/**
	 * Summary tag parser hook handler.
	 */
	public static function summary( $text, $params, $parser ) {
		$mwHidden =& MagicWord::get( 'wlk-hidden' );

		# Remove extra space to make block rendering easier.
		$text = trim( $text );

		if ( !$parser->mExtWikilog->mSummary ) {
			$popt = $parser->getOptions();
			$popt->enableLimitReport( false );
			$output = $parser->parse( $text, $parser->getTitle(), $popt, true, false );
			$parser->mExtWikilog->mSummary = $output->getText();
		}

		$hidden = WikilogUtils::arrayMagicKeyGet( $params, $mwHidden );
		return $hidden ? '<!-- -->' : $parser->recursiveTagParse( $text );
	}

	/**
	 * {{wl-settings:...}} parser function handler.
	 */
	public static function settings( &$parser /* ... */ ) {
		global $wgOut;
		wfLoadExtensionMessages( 'Wikilog' );
		self::checkNamespace( $parser );

		$mwIcon     =& MagicWord::get( 'wlk-icon' );
		$mwLogo     =& MagicWord::get( 'wlk-logo' );
		$mwSubtitle =& MagicWord::get( 'wlk-subtitle' );

		$args = array_slice( func_get_args(), 1 );
		foreach ( $args as $arg ) {
			$parts = array_map( 'trim', explode( '=', $arg, 2 ) );

			if ( empty( $parts[0] ) ) continue;
			if ( count( $parts ) < 2 ) $parts[1] = '';
			list( $key, $value ) = $parts;

			if ( $mwIcon->matchStart( $key ) ) {
				if ( ( $icon = self::parseImageLink( $parser, $value ) ) ) {
					$parser->mExtWikilog->mIcon = $icon->getTitle();
				}
			} else if ( $mwLogo->matchStart( $key ) ) {
				if ( ( $logo = self::parseImageLink( $parser, $value ) ) ) {
					$parser->mExtWikilog->mLogo = $logo->getTitle();
				}
			} else if ( $mwSubtitle->matchStart( $key ) ) {
				$popt = $parser->getOptions();
				$popt->enableLimitReport( false );
				$output = $parser->parse( $value, $parser->getTitle(), $popt, true, false );
				$parser->mExtWikilog->mSummary = $output->getText();
			} else {
				$warning = wfMsg( 'wikilog-error-msg', wfMsg( 'wikilog-invalid-param', htmlspecialchars( $key ) ) );
				$parser->mOutput->addWarning( $warning );
			}
		}

		return '<!-- -->';
	}

	/**
	 * {{wl-publish:...}} parser function handler.
	 */
	public static function publish( &$parser, $pubdate /*, $author... */ ) {
		wfLoadExtensionMessages( 'Wikilog' );
		self::checkNamespace( $parser );

		$parser->mExtWikilog->mPublish = true;
		$args = array_slice( func_get_args(), 2 );

		# First argument is the publish date
		if ( !is_null( $pubdate ) ) {
			wfSuppressWarnings(); // Shut up E_STRICT warnings about timezone.
			$ts = strtotime( $pubdate );
			wfRestoreWarnings();
			if ( $ts > 0 ) {
				$parser->mExtWikilog->mPubDate = wfTimestamp( TS_MW, $ts );
			}
			else {
				$warning = wfMsg( 'wikilog-error-msg', wfMsg( 'wikilog-invalid-date', $pubdate ) );
				$parser->mOutput->addWarning( $warning );
			}
		}

		# Remaining arguments are author names
		foreach ( $args as $name ) {
			if ( !self::tryAddAuthor( $parser, $name ) )
				break;
		}

		return '<!-- -->';
	}

	/**
	 * {{wl-author:...}} parser function handler.
	 */
	public static function author( &$parser /*, $author... */ ) {
		wfLoadExtensionMessages( 'Wikilog' );
		self::checkNamespace( $parser );

		$args = array_slice( func_get_args(), 1 );
		foreach ( $args as $name ) {
			if ( !self::tryAddAuthor( $parser, $name ) )
				break;
		}
		return '<!-- -->';
	}

	/**
	 * {{wl-tags:...}} parser function handler.
	 */
	public static function tags( &$parser /*, $tag... */ ) {
		wfLoadExtensionMessages( 'Wikilog' );
		self::checkNamespace( $parser );

		$args = array_slice( func_get_args(), 1 );
		foreach ( $args as $tag ) {
			if ( !self::tryAddTag( $parser, $tag ) )
				break;
		}
		return '<!-- -->';
	}

	/**
	 * {{wl-info:...}} parser function handler.
	 * Provides general information about the extension.
	 */
	public static function info( &$parser, $id /*, $tag... */ ) {
		global $wgWikilogNamespaces, $wgWikilogEnableTags;
		global $wgWikilogEnableComments;
		global $wgContLang;

		$args = array_slice( func_get_args(), 2 );

		switch ( $id ) {
			case 'num-namespaces':
				return count( $wgWikilogNamespaces );
			case 'all-namespaces':
				$namespaces = array();
				foreach ( $wgWikilogNamespaces as $ns )
					$namespaces[] = $wgContLang->getFormattedNsText( $ns );
				return $wgContLang->listToText( $namespaces );
			case 'namespace-by-index':
				$index = empty( $args ) ? 0 : intval( array_shift( $args ) );
				if ( isset( $wgWikilogNamespaces[$index] ) ) {
					return $wgContLang->getFormattedNsText( $wgWikilogNamespaces[$index] );
				} else {
					return '';
				}
			case 'tags-enabled':
				return $wgWikilogEnableTags ? '*' : '';
			case 'comments-enabled':
				return $wgWikilogEnableComments ? '*' : '';
			default:
				return '';
		}
	}

	###
	## Wikilog parser settings.
	#

	/**
	 * Enable special wikilog feed parsing.
	 *
	 * This function changes the parser behavior in order to output
	 *
	 * The proper way to use this function is:
	 * @code
	 *   $saveFeedParse = WikilogParser::enableFeedParsing();
	 *   # ...code that uses $wgParser in order to parse articles...
	 *   WikilogParser::enableFeedParsing( $saveFeedParse );
	 * @endcode
	 *
	 * @note Using this function changes the behavior of Parser. When enabled,
	 *   parsed content should be cached under a different key.
	 */
	public static function enableFeedParsing( $enable = true ) {
		$prev = self::$feedParsing;
		self::$feedParsing = $enable;
		return $prev;
	}

	/**
	 * Enable expansion of local URLs.
	 *
	 * In order to output stand-alone content with all absolute links, it is
	 * necessary to expand local URLs. MediaWiki tries to do this in a few
	 * places by sniffing into the 'action' GET request parameter, but this
	 * fails in many ways. This function tries to remedy this.
	 *
	 * This function pre-expands all base URL fragments used by MediaWiki,
	 * and also enables URL expansion in the Wikilog::GetLocalURL hook.
	 * The original values of all URLs are saved when $enable = true, and
	 * restored back when $enabled = false.
	 *
	 * The proper way to use this function is:
	 * @code
	 *   $saveExpUrls = WikilogParser::expandLocalUrls();
	 *   # ...code that uses $wgParser in order to parse articles...
	 *   WikilogParser::expandLocalUrls( $saveExpUrls );
	 * @endcode
	 *
	 * @note Using this function changes the behavior of Parser. When enabled,
	 *   parsed content should be cached under a different key.
	 */
	public static function expandLocalUrls( $enable = true ) {
		global $wgScriptPath, $wgUploadPath, $wgStylePath, $wgMathPath, $wgLocalFileRepo;
		static $originalPaths = NULL;

		$prev = self::$expandingUrls;

		if ( $enable ) {
			if ( !self::$expandingUrls ) {
				self::$expandingUrls = true;

				# Save original values.
				$originalPaths = array( $wgScriptPath, $wgUploadPath,
					$wgStylePath, $wgMathPath, $wgLocalFileRepo['url'] );

				# Expand paths.
				$wgScriptPath = wfExpandUrl( $wgScriptPath );
				$wgUploadPath = wfExpandUrl( $wgUploadPath );
				$wgStylePath  = wfExpandUrl( $wgStylePath  );
				$wgMathPath   = wfExpandUrl( $wgMathPath   );
				$wgLocalFileRepo['url'] = wfExpandUrl( $wgLocalFileRepo['url'] );

				# Destroy existing RepoGroup, if any.
				RepoGroup::destroySingleton();
			}
		} else {
			if ( self::$expandingUrls ) {
				self::$expandingUrls = false;

				# Restore original values.
				list( $wgScriptPath, $wgUploadPath, $wgStylePath, $wgMathPath,
					$wgLocalFileRepo['url'] ) = $originalPaths;

				# Destroy existing RepoGroup, if any.
				RepoGroup::destroySingleton();
			}
		}

		return $prev;
	}


	###
	## Internal stuff.
	#

	/**
	 * Adds an author to the current article. If too many authors, warns.
	 * @return False on overflow, true otherwise.
	 */
	private static function tryAddAuthor( &$parser, $name ) {
		global $wgWikilogMaxAuthors;

		if ( count( $parser->mExtWikilog->mAuthors ) >= $wgWikilogMaxAuthors ) {
			$warning = wfMsg( 'wikilog-error-msg', wfMsg( 'wikilog-too-many-authors' ) );
			$parser->mOutput->addWarning( $warning );
			return false;
		}

		$user = User::newFromName( $name );
		if ( !is_null( $user ) ) {
			$parser->mExtWikilog->mAuthors[$user->getName()] = $user->getID();
		}
		else {
			$warning = wfMsg( 'wikilog-error-msg', wfMsg( 'wikilog-invalid-author', $name ) );
			$parser->mOutput->addWarning( $warning );
		}
		return true;
	}

	/**
	 * Adds a tag to the current article. If too many tags, warns.
	 * @return False on overflow, true otherwise.
	 */
	private static function tryAddTag( &$parser, $tag ) {
		global $wgWikilogMaxTags;

		static $tcre = false;
		if ( !$tcre ) { $tcre = '/[^' . Title::legalChars() . ']/'; }

		if ( count( $parser->mExtWikilog->mTags ) >= $wgWikilogMaxTags ) {
			$warning = wfMsg( 'wikilog-error-msg', wfMsg( 'wikilog-too-many-tags' ) );
			$parser->mOutput->addWarning( $warning );
			return false;
		}

		if ( !empty( $tag ) && !preg_match( $tcre, $tag ) ) {
			$parser->mExtWikilog->mTags[$tag] = 1;
		}
		else {
			$warning = wfMsg( 'wikilog-error-msg', wfMsg( 'wikilog-invalid-tag', $tag ) );
			$parser->mOutput->addWarning( $warning );
		}
		return true;
	}

	/**
	 * Check if the calling parser function is being executed in Wikilog
	 * context. Generates a parser warning if it isn't.
	 */
	private static function checkNamespace( &$parser ) {
		global $wgWikilogNamespaces;
		static $tested = false;

		if ( !$tested ) {
			$title = $parser->getTitle();
			if ( !in_array( $title->getNamespace(), $wgWikilogNamespaces ) ) {
				$warning = wfMsg( 'wikilog-error-msg', wfMsg( 'wikilog-out-of-context' ) );
				$parser->mOutput->addWarning( $warning );
			}
			$tested = true;
		}
	}

	/**
	 * Parses an image link.
	 * Wrapper around parseMediaLink() that only returns images. Parser
	 * warnings are generated if the file is not an image, or if it is
	 * invalid.
	 *
	 * @return File instance, or NULL.
	 */
	private static function parseImageLink( &$parser, $text ) {
		$obj = self::parseMediaLink( $parser, $text );
		if ( !$obj ) {
			$warning = wfMsg( 'wikilog-error-msg', wfMsg( 'wikilog-invalid-file', htmlspecialchars( $text ) ) );
			$parser->mOutput->addWarning( $warning );
			return NULL;
		}

		list( $t1, $t2, $file ) = $obj;
		if ( !$file ) {
			$warning = wfMsg( 'wikilog-error-msg', wfMsg( 'wikilog-file-not-found', htmlspecialchars( $t1 ) ) );
			$parser->mOutput->addWarning( $warning );
			return NULL;
		}

		$type = $file->getMediaType();
		if ( $type != MEDIATYPE_BITMAP && $type != MEDIATYPE_DRAWING ) {
			$warning = wfMsg( 'wikilog-error-msg', wfMsg( 'wikilog-not-an-image', $file->getName() ) );
			$parser->mOutput->addWarning( $warning );
			return NULL;
		}

		return $file;
	}

	/**
	 * Parses a media link.
	 * This is a very small subset of Parser::replaceInternalLinks() that
	 * parses a single image or media link, and returns the parsed text,
	 * as well as a File instance of the referenced media, if available.
	 *
	 * @return Three-element array containing the matched parts of the link,
	 *   and the file object, or NULL.
	 */
	private static function parseMediaLink( &$parser, $text ) {
		$tc = Title::legalChars();
		if ( !preg_match( "/\\[\\[([{$tc}]+)(?:\\|(.+?))?]]/", $text, $m ) )
			return NULL;

		$nt = Title::newFromText( $m[1] );
		if ( !$nt )
			return NULL;

		$ns = $nt->getNamespace();
		if ( $ns == NS_IMAGE || $ns == NS_MEDIA ) {
			$parser->mOutput->addLink( $nt );
			return @ array( $m[1], $m[2], wfFindFile( $nt ) );
		} else {
			return NULL;
		}
	}
}

/**
 * Wikilog parser output. This class is first attached to the Parser as
 * $parser->mExtWikilog, and then copied to the parser output
 * $popt->mExtWikilog in WikilogParser::AfterTidy().
 */
class WikilogParserOutput
{
	/* Item and Wikilog metadata */
	public $mSummary = false;
	public $mAuthors = array();
	public $mTags = array();

	/* Item metadata */
	public $mPublish = false;
	public $mPubDate = NULL;

	/* Wikilog settings */
	public $mIcon = NULL;
	public $mLogo = NULL;

	/* Acessor functions, lacking... */
	public function getAuthors() { return $this->mAuthors; }
	public function getTags() { return $this->mTags; }
}

/**
 * Since wikilog parses articles with specific options in order to be
 * rendered in feeds, it is necessary to store these parsed outputs in
 * the cache separately. This derived class from ParserCache overloads the
 * getKey() function in order to provide a specific namespace for this
 * purpose.
 */
class WikilogParserCache
	extends ParserCache
{
	public static function &singleton() {
		static $instance;
		if ( !isset( $instance ) ) {
			global $parserMemc;
			$instance = new WikilogParserCache( $parserMemc );
		}
		return $instance;
	}

	public function getKey( &$article, $popts ) {
		if ( $popts instanceof User )	// API change in MediaWiki 1.15.
			$popts = ParserOptions::newFromUser( $popts );

		$user = $popts->mUser;
		$pageid = intval( $article->getID() );
		$hash = $user->getPageRenderingHash();
		$key = wfMemcKey( 'wlcache', 'idhash', "$pageid-$hash" );
		return $key;
	}
}
