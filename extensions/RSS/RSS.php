<?php
/**
 * RSS-Feed MediaWiki extension
 *
 * @file
 * @ingroup Extensions
 * @version 1.7
 * @author mutante, Daniel Kinzler, Rdb, Mafs, Alxndr, Chris Reigrut, K001
 * @author Kellan Elliott-McCrea <kellan@protest.net> -- author of MagpieRSS
 * @author Jeroen De Dauw
 * @author Jack Phoenix <jack@countervandalism.net>
 * @copyright © Kellan Elliott-McCrea <kellan@protest.net>
 * @copyright © mutante, Daniel Kinzler, Rdb, Mafs, Alxndr, Chris Reigrut, K001
 * @link http://www.mediawiki.org/wiki/Extension:RSS Documentation
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

define( 'RSS_USER_AGENT', 'MediaWikiRSS/0.01 (+http://www.mediawiki.org/wiki/Extension:RSS) / MediaWiki RSS extension' );

// Extension credits that will show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'RSS feed',
	'author' => array(
		'Kellan Elliott-McCrea',
		'mutante',
		'Daniel Kinzler',
		'Rdb',
		'Mafs',
		'Alxndr',
		'Wikinaut',
		'Chris Reigrut',
		'K001',
		'Jack Phoenix',
		'Jeroen De Dauw',
		'Mark A. Hershberger'
	),
	'version' => '1.8',
	'url' => 'http://www.mediawiki.org/wiki/Extension:RSS',
	'descriptionmsg' => 'rss-desc',
);

// Internationalization file and autoloadable classes
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['RSS'] = $dir . 'RSS.i18n.php';
$wgAutoloadClasses['RSSData'] = $dir . 'RSSData.php';

$wgHooks['ParserFirstCallInit'][] = 'RSS::parserInit';

$wgRSSCacheAge = 3600; // one hour
$wgRSSCacheFreshOnly = false;
$wgRSSOutputEncoding = 'ISO-8859-1';
$wgRSSInputEncoding = null;
$wgRSSDetectEncoding = true;
$wgRSSFetchTimeout = 5; // 5 second timeout
$wgRSSUseGzip = true;

class RSS {
	protected $charset;
	protected $maxheads = 32;
	protected $reversed = false;
	protected $highlight = array();
	protected $filter = array();
	protected $filterOut = array();
	protected $itemTemplate;
	protected $url;
	protected $etag;
	protected $lastModified;
	protected $xml;
	protected $ERROR;
	protected $displayFields = array( 'author', 'title', 'encodedContent', 'description' );

	public $client;

	static function parserInit( $parser ) {
		# Install parser hook for <rss> tags
		$parser->setHook( 'rss', array( __CLASS__, 'renderRss' ) );
		return true;
	}

	# Parser hook callback function
	static function renderRss( $input, $args, $parser, $frame ) {
		if ( !$input ) {
			return ''; # if <rss>-section is empty, return nothing
		}
		$parser->disableCache();

		$rss = new RSS( $input, $args );

		$status = $rss->fetch();

		# Check for errors.
		if ( $status === false || !is_object( $rss->rss ) || !is_array( $rss->rss->items ) )
			return wfMsg( 'rss-empty', $input );

		if ( isset( $rss->ERROR ) )
			return wfMsg( 'rss-error', $rss->ERROR );

		return $rss->renderFeed( $parser, $frame );
	}

	static function explodeOnSpaces( $str ) {
		$found = preg_split( '# +#', $str );
		return is_array( $found ) ? $found : array();
	}

	function __construct( $url, $args ) {

		if ( isset( $url ) ) {
			$this->url = $url;
		}

		# Get charset from argument array
		if ( isset( $args['charset'] ) ) {
			$this->charset = $args['charset'];
		} else {
			global $wgOutputEncoding;
			$args['charset'] = $wgOutputEncoding;
		}

		# Get max number of headlines from argument-array
		if ( isset( $args['max'] ) ) {
			$this->maxheads = $args['max'];
		}

		# Get reverse flag from argument array
		if ( isset( $args['reverse'] ) ) {
			$this->reversed = true;
		}

		# Get date format from argument array
		# FIXME: not used yet
		if ( isset( $args['date'] ) ) {
			$this->date = $args['date'];
		}

		# Get highlight terms from argument array
		if ( isset( $args['highlight'] ) ) {
			# mapping to lowercase here so the regex can be case insensitive below.
			$this->highlight = array_flip( array_map( 'strtolower', self::explodeOnSpaces( $args['highlight'] ) ) );
		}

		# Get filter terms from argument array
		if ( isset( $args['filter'] ) ) {
			$this->filter = self::explodeOnSpaces( $args['filter'] );
		}

		if ( isset( $args['filterout'] ) ) {
			$this->filterOut = self::explodeOnSpaces( $args['filterout'] );

		}

		if ( isset( $args['template'] ) ) {
			$titleObject = Title::newFromText( $args['template'], NS_TEMPLATE );
			$article = new Article( $titleObject, 0 );
			$this->itemTemplate = $article->fetchContent( 0 );
		} else {
			$this->itemTemplate = wfMsgNoTrans( 'rss-item' );
		}
	}

	/**
	* Return RSS object for the given URL, maintaining caching.
	*
	* NOTES ON RETRIEVING REMOTE FILES:
	* If conditional gets are on (MAGPIE_CONDITIONAL_GET_ON) fetch_rss will
	* return a cached object, and touch the cache object upon recieving a 304.
	*
	* NOTES ON FAILED REQUESTS:
	* If there is an HTTP error while fetching an RSS object, the cached version
	* will be returned, if it exists (and if $wgRSSCacheFreshOnly is off
	*
	* @param $url String: URL of RSS file
	* @return boolean true if the fetch worked.
	*/
	function fetch( ) {
		global $wgRSSCacheAge, $wgRSSCacheFreshOnly;
		global $wgRSSCacheDirectory, $wgRSSFetchTimeout;
		global $wgRSSOutputEncoding, $wgRSSInputEncoding;
		global $wgRSSDetectEncoding, $wgRSSUseGzip;

		if ( !isset( $this->url ) ) {
			wfDebugLog( 'RSS', 'Fetch called without a URL!' );
			return false;
		}

		// Flow
		// 1. check cache
		// 2. if there is a hit, make sure its fresh
		// 3. if cached obj fails freshness check, fetch remote
		// 4. if remote fails, return stale object, or error
		$key = wfMemcKey( $this->url );
		$cachedFeed = $this->loadFromCache( $key );
		if ( $cachedFeed !== false ) {
			wfDebugLog( 'RSS', 'Outputting cached feed for ' . $this->url );
			return true;
		}
		wfDebugLog( 'RSS', 'Cache Failed ' . $this->url );

		$status = $this->fetchRemote( $key );
		return $status;
	}

	function loadFromCache( $key ) {
		global $wgMemc;

		$data = $wgMemc->get( $key );
		if ( $data === false ) {
			return false;
		}

		list( $etag, $lastModified, $rss ) =
			unserialize( $data );

		if ( !isset( $rss->items ) ) {
			return false;
		}

		wfDebugLog( 'RSS', "Got '$key' from cache" );

		# Now that we've verified that we got useful data, keep it around.
		$this->rss = $rss;
		$this->etag = $etag;
		$this->lastModified = $lastModified;

		return true;
	}

	function storeInCache( $key ) {
		global $wgMemc, $wgRSSCacheAge;

		if ( !isset( $this->rss ) ) {
			return false;
		}
		$wgMemc->set( $key,
			serialize( array( $this->etag, $this->lastModified, $this->rss ) ),
			$wgRSSCacheAge );

		wfDebugLog( 'RSS', "Stored '$key' in cache" );
		return true;
	}

	/**
	 * Retrieve a feed.
	 * @param $url String: URL of the feed.
	 * @param $headers Array: headers to send along with the request
	 * @return Status object
	 */
	protected function fetchRemote( $key, $headers = '' ) {
		global $wgRSSFetchTimeout, $wgRSSUseGzip;

		if ( $this->etag ) {
			wfDebugLog( 'RSS', 'Used etag: ' . $this->etag );
			$headers['If-None-Match'] = $this->etag;
		}
		if ( $this->lastModified ) {
			wfDebugLog( 'RSS', 'Used last modified: ' . $this->lastModified );
			$headers['If-Last-Modified'] = $this->lastModified;
		}

		$client =
			HttpRequest::factory( $this->url, array( 'timeout' => $wgRSSFetchTimeout ) );
		$client->setUserAgent( RSS_USER_AGENT );
		/* $client->use_gzip = $wgRSSUseGzip; */
		if ( is_array( $headers ) && count( $headers ) > 0 ) {
			foreach ( $headers as $h ) {
				if ( count( $h ) > 1 ) {
					$client->setHeader( $h[0], $h[1] );
				}
			}
		}

		$fetch = $client->execute();
		$this->client = $client;

		if ( !$fetch->isGood() ) {
			wfDebug( 'RSS', 'Request Failed: ' . $fetch->getWikiText() );
			return $fetch;
		}

		$ret = $this->responseToXML( $key );
		return $ret;
	}

	function renderFeed( $parser, $frame ) {
		$output = "";
		if ( $this->itemTemplate ) {
			$headcnt = 0;
			if ( $this->reversed ) {
				$this->rss->items = array_reverse( $this->rss->items );
			}

			foreach ( $this->rss->items as $item ) {
				if ( $this->maxheads > 0 && $headcnt >= $this->maxheads ) {
					continue;
				}

				if ( $this->canDisplay( $item ) ) {
					$output .= $this->renderItem( $item, $parser, $frame );
					$headcnt++;
				}
			}
		}
		return $output;
	}

	function renderItem( $item, $parser, $frame ) {
		$parts = explode( '|', $this->itemTemplate );

		$output = "";
		if ( count( $parts ) > 1 && isset( $parser ) && isset( $frame ) ) {
			$rendered = array();
			foreach ( $this->displayFields as $field ) {
				if ( isset( $item[$field] ) ) {
					$item[$field] = $this->highlightTerms( $item[$field] );
				}
			}

			foreach ( $parts as $part ) {
				$bits = explode( '=', $part );
				$left = null;

				if ( count( $bits ) == 2 ) {
					$left = trim( $bits[0] );
				}

				if ( isset( $item[$left] ) ) {
					$leftValue = preg_replace( '/{{{' . preg_quote( $left, '/' ) . '}}}/',
						$item[$left], $bits[1] );
					$rendered[] = implode( '=', array( $left, $leftValue ) );
				} else {
					$rendered[] = $part;
				}
			}
			$output .= $parser->recursiveTagParse( implode( " | ", $rendered ), $frame );
		}
		return $output;
	}

	/**
	 * Parse an HTTP response object into an RSS object.
	 * @param $resp Object: an HTTP response object (see Snoopy)
	 * @return parsed RSS object (see RSSParse) or false
	 */
	function responseToXML( $key ) {
		$this->xml = new DOMDocument;
		$this->xml->loadXML( $this->client->getContent() );
		$this->rss = new RSSData( $this->xml );

		// if RSS parsed successfully
		if ( $this->rss && !$this->rss->ERROR ) {
			$this->etag = $this->client->getResponseHeader( 'Etag' );
			$this->lastModified = $this->client->getResponseHeader( 'Last-Modified' );
			wfDebugLog( 'RSS', 'Stored etag (' . $this->etag . ') and Last-Modified (' .
				$this->lastModified . ') and items (' . count( $this->rss->items ) . ')!' );
			$this->storeInCache( $key );

			return Status::newGood();
		} else {
			return Status::newfatal( 'rss-parse-error', $this->rss->ERROR );
		}
	}

	function canDisplay( $item ) {
		$check = "";
		foreach ( $this->displayFields as $field ) {
			if ( isset( $item[$field] ) ) {
				$check .= $item[$field];
			}
		}

		if ( $this->filter( $check, 'filterOut' ) ) {
			return false;
		}
		if ( $this->filter( $check, 'filter' ) ) {
			return true;
		}
		return false;
	}

	function filter( $text, $filterType ) {
		if ( $filterType === 'filterOut' ) {
			$filter = $this->filterOut;
		} else {
			$filter = $this->filter;
		}

		if ( count( $filter ) == 0 ) return $filterType !== 'filterOut';

		/* Using : for delimiter here since it'll be quoted automatically. */
		$match = preg_match( ':(' . implode( "|", array_map('preg_quote', $filter ) ) . '):i', $text ) ;
		if ( $match ) {
			return true;
		}
		return false;
	}

	static function highlightThis( $term, $match ) {
		$styleStart = "<span style='font-weight: bold; background: none repeat scroll 0%% 0%% rgb(%s); color: %s;'>";
		$styleEnd   = "</span>";

		# bg colors cribbed from Google's highlighting of search teerms
		$bgcolor = array( '255, 255, 102', '160, 255, 255', '153, 255, 153',
			'255, 153, 153', '255, 102, 255', '136, 0, 0', '0, 170, 0', '136, 104, 0',
			'0, 70, 153', '153, 0, 153' );
		# Spelling out the fg colors instead of using processing time to create this list
		$color = array("black", "black", "black", "black", "black",
			"white", "white", "white", "white", "white" );

		$index = $term[strtolower($match[0])] % count( $bgcolor );

		return sprintf($styleStart, $bgcolor[$index], $color[$index]). $match[0] .$styleEnd;
	}

	function highlightTerms( $text ) {
		if ( count( $this->highlight ) === 0 ) {
			return $text;
		}
		# SIGH ... anonymous functions are not available until 5.3
		$f = create_function('$match', '$term = '.var_export($this->highlight, true).'; return RSS::highlightThis($term, $match);');

		$highlight = '/'. implode( "|", array_map( 'preg_quote', array_keys( $this->highlight ) ) ) . '/i';
		return preg_replace_callback( $highlight, $f, $text );
	}
}