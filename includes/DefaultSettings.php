<?php
/**
 * DO NOT EDIT THIS FILE!
 *
 * To customize your installation, edit "LocalSettings.php".
 *
 * Note that since all these string interpolations are expanded
 * before LocalSettings is included, if you localize something
 * like $wgScriptPath, you must also localize everything that
 * depends on it.
 *
 * @version $Id$
 * @package MediaWiki
 */

# This is not a valid entry point, perform no further processing unless MEDIAWIKI is defined
if( defined( 'MEDIAWIKI' ) ) {

/**
 * MediaWiki version number
 * @global string $wgVersion
 */
$wgVersion			= '1.4-prealpha';

/** 
 * Name of the site.
 * It must be changed in LocalSettings.php
 * @global string $wgSitename
 */
$wgSitename         = 'MediaWiki';

/**
 * Will be same as you set @see $wgSitename
 * @global mixed $wgMetaNamespace
 */
$wgMetaNamespace    = FALSE;


/** 
 * URL of the server
 * It will be automaticly build including https mode
 * @global string $wgServer
 */
$wgServer = '';
# check if server use https:
$wgProto = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';

if ( @$wgCommandLineMode ) {
	$wgServer = $wgProto.'://localhost';
} else {
	$wgServer           = $wgProto.'://' . $_SERVER['SERVER_NAME'];
	if( $_SERVER['SERVER_PORT'] != 80 ) $wgServer .= ":" . $_SERVER['SERVER_PORT'];
}
unset($wgProto);


/**
 * The path we should point to.
 * It might be a virtual path in case with use apache mod_rewrite for example
 * @global string $wgScriptPath
 */
$wgScriptPath	    = '/wiki';

/**
 * Whether to support URLs like index.php/Page_title
 * @global bool $wgUsePathInfo
 */
$wgUsePathInfo		= ( strpos( php_sapi_name(), 'cgi' ) === false );


/**#@+
 * Script users will request to get articles
 * ATTN: Old installations used wiki.phtml and redirect.phtml -
 * make sure that LocalSettings.php is correctly set!
 * @deprecated
 */
/** 
 *	@global string $wgScript
 */
$wgScript           = "{$wgScriptPath}/index.php";
/**
 *	@global string $wgRedirectScript
 */
$wgRedirectScript   = "{$wgScriptPath}/redirect.php";
/**#@-*/


/**#@+
 * @global string
 */
/**
 * style path as seen by users
 * @global string $wgStylePath
 */
$wgStylePath   = "{$wgScriptPath}/skins";
/**
 * filesystem stylesheets directory
 * @global string $wgStyleDirectory
 */
$wgStyleDirectory = "{$IP}/skins";
$wgStyleSheetPath = &$wgStylePath;
$wgStyleSheetDirectory = &$wgStyleDirectory;
$wgArticlePath      = "{$wgScript}?title=$1";
$wgUploadPath       = "{$wgScriptPath}/upload";
$wgUploadDirectory	= "{$IP}/upload";
$wgLogo				= "{$wgUploadPath}/wiki.png";
$wgMathPath         = "{$wgUploadPath}/math";
$wgMathDirectory    = "{$wgUploadDirectory}/math";
$wgTmpDirectory     = "{$wgUploadDirectory}/tmp";
$wgUploadBaseUrl    = "";
/**#@-*/


# Email settings
#
/**
 * Site admin email address
 * Default to wikiadmin@SERVER_NAME
 * @global string $wgEmergencyContact
 */
$wgEmergencyContact = 'wikiadmin@' . $_SERVER['SERVER_NAME'];

/**
 * Password reminder email address
 * The address we should use as sender when a user is requesting his password
 * Default to apache@SERVER_NAME
 * @global string $wgPasswordSender
 */
$wgPasswordSender	= 'Wikipedia Mail <apache@' . $_SERVER['SERVER_NAME'] . '>';


/**
 * SMTP Mode
 * For using a direct (authenticated) SMTP server connection. 
 * Default to false or fill an array :
 * <code>
 * "host" => 'SMTP domain',
 * "IDHost" => 'domain for MessageID',
 * "port" => "25",
 * "auth" => true/false,
 * "username" => user,
 * "password" => password
 * </code>
 *
 * @global mixed $wgSMTP
 */
$wgSMTP				= false;


/**#@+
 * Database settings
 */
/** database host name or ip address */
$wgDBserver         = 'localhost';
/** name of the database */
$wgDBname           = 'wikidb';
/** */
$wgDBconnection     = '';
/** Database username */
$wgDBuser           = 'wikiuser';
/** Database type
 * "mysql" for working code and "PostgreSQL" for development/broken code
 */
$wgDBtype           = "mysql";
/** Search type
 * "MyISAM" for MySQL native full text search, "Tsearch2" for PostgreSQL
 * based search engine
 */
$wgSearchType	    = "MyISAM";
/** Table name prefix */
$wgDBprefix         = ''; 
/** Database schema
 * on some databases this allows separate 
 * logical namespace for application data
 */
$wgDBschema	    = 'mediawiki';
/**#@-*/



# Shared database for multiple wikis.
# Presently used for storing a user table for single sign-on
# The server for this database must be the same as for the main
# database.
# EXPERIMENTAL
# $wgSharedDB='';

# Database load balancer
# This is a two-dimensional array, an array of server info structures
# Fields are: 
#   host:      Host name
#   dbname:    Default database name
#   user:      DB user
#   password:  DB password
#   type:      "mysql" or "pgsql"
#   load:      ratio of DB_SLAVE load, must be >=0, the sum of all loads must be >0
#   flags:     bit field
#                 DBO_DEFAULT -- turns on DBO_TRX only if !$wgCommandLineMode (recommended)
#                 DBO_DEBUG -- equivalent of $wgDebugDumpSql
#                 DBO_TRX -- wrap entire request in a transaction
#                 DBO_IGNORE -- ignore errors (not useful in LocalSettings.php)
#                 DBO_NOBUFFER -- turn off buffering (not useful in LocalSettings.php)
#
# Leave at false to use the single-server variables above
$wgDBservers		= false; 

# Sysop SQL queries
#   The sql user shouldn't have too many rights other the database, restrict
#   it to SELECT only on 'cur' table for example
#
$wgAllowSysopQueries = false; # Dangerous if not configured properly.
$wgDBsqluser		= 'sqluser';
$wgDBsqlpassword	= 'sqlpass';
$wgDBpassword       = 'userpass';
$wgSqlLogFile           = "{$wgUploadDirectory}/sqllog_mFhyRe6";
$wgDBerrorLog		= false; # File to log MySQL errors to

# wgDBminWordLen :
#  MySQL 3.x : used to discard words that MySQL will not return any results for
#  shorter values configure mysql directly
#  MySQL 4.x : ignore it and configure mySQL
# See: http://dev.mysql.com/doc/mysql/en/Fulltext_Fine-tuning.html
$wgDBminWordLen     = 4;
$wgDBtransactions	= false; # Set to true if using InnoDB tables
$wgDBmysql4			= false; # Set to true to use enhanced fulltext search
$wgSqlTimeout		= 30;

$wgBufferSQLResults     = true; # use buffered queries by default

# Other wikis on this site, can be administered from a single developer account
# Array, interwiki prefix => database name
$wgLocalDatabases   = array();


# Memcached settings
# See docs/memcached.doc
#
$wgMemCachedDebug   = false; # Will be set to false in Setup.php, if the server isn't working
$wgUseMemCached     = false;
$wgMemCachedServers = array( '127.0.0.1:11000' );
$wgMemCachedDebug   = false;
$wgSessionsInMemcached = false;
$wgLinkCacheMemcached = false; # Not fully tested

/**
 * Turck MMCache shared memory
 * You can use this for persistent caching where your wiki runs on a small
 * number of servers. Mutually exclusive with memcached. MMCache must be
 * installed.
 *
 * @global bool $wgUseTurckShm Enable or disabled Turck MMCache
 */
$wgUseTurckShm      = false;


# Language settings
#
/**
 * Site language code
 * Default to 'en'. Should be one of ./language/Language(.*).php
 * @global string $wgLanguageCode
 */
$wgContLanguageCode     = 'en';

/**
 * Filename of a language file generated by dumpMessages.php
 * @global string|false $wgLanguageFile (default:false)
 */
$wgLanguageFile     = false;
/**
 * Treat language links as magic connectors, not inline links
 * @global bool $wgInterwikiMagic (default:true)
 */
$wgInterwikiMagic	= true;
$wgInputEncoding	= 'ISO-8859-1'; # LanguageUtf8.php normally overrides this
$wgOutputEncoding	= 'ISO-8859-1'; # unless you set the next option to true:
$wgUseLatin1 		= false; # Enable ISO-8859-1 compatibility mode
$wgEditEncoding		= '';
$wgMimeType			= 'text/html';
$wgDocType			= '-//W3C//DTD XHTML 1.0 Transitional//EN';
$wgDTD				= 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd';
$wgUseDynamicDates  = false; # Enable to allow rewriting dates in page text
							 # DOES NOT FORMAT CORRECTLY FOR MOST LANGUAGES
$wgAmericanDates    = false; # Enable for English module to print dates
							 # as eg 'May 12' instead of '12 May'
$wgTranslateNumerals = true; # For Hindi and Arabic use local numerals instead
                             # of Western style (0-9) numerals in interface.


# Translation using MediaWiki: namespace
# This will increase load times by 25-60% unless memcached is installed
# Interface messages will be get from the database.
$wgUseDatabaseMessages = true;
$wgMsgCacheExpiry	= 86400;


# Miscellaneous configuration settings
#

$wgLocalInterwiki   = 'w';
$wgInterwikiExpiry = 10800; # Expiry time for cache of interwiki table

$wgShowIPinHeader	= true; # For non-logged in users
$wgMaxNameChars     = 32; # Maximum number of bytes in username

$wgExtraSubtitle	= '';
$wgSiteSupportPage	= ''; # A page where you users can receive donations

$wgReadOnlyFile         = "{$wgUploadDirectory}/lock_yBgMBwiR";
$wgUseData = false ;

# The debug log file should be not be publicly accessible if it is
# used, as it may contain private data.
$wgDebugLogFile         = '';

/**#@+
 * @global bool
 */
$wgDebugRedirects		= false;
$wgDebugRawPage         = false; # Avoid overlapping debug entries by leaving out CSS

$wgDebugComments        = false;
$wgReadOnly             = false;
$wgLogQueries           = false;
$wgDebugDumpSql         = false;

# Whether to disable automatic generation of "we're sorry,
# but there has been a database error" pages.
$wgIgnoreSQLErrors      = false;

# Should [[Category:Dog]] on a page associate it with the
# category "Dog"? (a link to that category page will be
# added to the article, clicking it reveals a list of
# all articles in the category)
$wgUseCategoryMagic		= true;

# disable experimental dmoz-like category browsing. Output things like:
# Encyclopedia > Music > Style of Music > Jazz
# FIXME: need fixing
$wgUseCategoryBrowser   = false;

$wgEnablePersistentLC	= false;	# Obsolete, do not use
$wgCompressedPersistentLC = true; # use gzcompressed blobs
$wgUseOldExistenceCheck = false;  # use old prefill link method, for debugging only

$wgEnableParserCache = false; # requires that php was compiled --with-zlib
/**#@-*/

# wgHitcounterUpdateFreq sets how often page counters should be
# updated, higher values are easier on the database. A value of 1
# causes the counters to be updated on every hit, any higher value n
# cause them to update *on average* every n hits. Should be set to
# either 1 or something largish, eg 1000, for maximum efficiency.

$wgHitcounterUpdateFreq = 1;

# User rights
#   It's not 100% safe, there could be security hole using that one. Use at your
# own risks.

$wgWhitelistEdit = false;   # true = user must login to edit.
$wgWhitelistRead = false;	# Pages anonymous user may see, like: = array ( ":Main_Page", "Special:Userlogin", "Wikipedia:Help");
$wgWhitelistAccount = array ( 'user' => 1, 'sysop' => 1, 'developer' => 1 );

$wgAllowAnonymousMinor = false; # Allow anonymous users to mark changes as 'minor'

$wgSysopUserBans        = false; # Allow sysops to ban logged-in users
$wgSysopRangeBans		= false; # Allow sysops to ban IP ranges
$wgDefaultBlockExpiry	= '24 hours'; # default expiry time
                                # strtotime format, or "infinite" for an infinite block
$wgAutoblockExpiry		= 86400; # Number of seconds before autoblock entries expire

# Proxy scanner settings
#
$wgBlockOpenProxies = false; # Automatic open proxy test on edit
$wgProxyPorts = array( 80, 81, 1080, 3128, 6588, 8000, 8080, 8888, 65506 );
$wgProxyScriptPath = "$IP/proxy_check.php";
$wgProxyMemcExpiry = 86400;
$wgProxyKey = 'W1svekXc5u6lZllTZOwnzEk1nbs';
$wgProxyList = array();  # big list of banned IP addresses, in the keys not the values

# Number of accounts each IP address may create, 0 to disable.
# Requires memcached
$wgAccountCreationThrottle = 0;


# Client-side caching:
$wgCachePages       = true; # Allow client-side caching of pages

# Set this to current time to invalidate all prior cached pages.
# Affects both client- and server-side caching.
$wgCacheEpoch = '20030516000000';


# Server-side caching:
#  This will cache static pages for non-logged-in users
#  to reduce database traffic on public sites.
#  Must set $wgShowIPinHeader = false
$wgUseFileCache = false;
$wgFileCacheDirectory = "{$wgUploadDirectory}/cache";

# When using the file cache, we can store the cached HTML gzipped to save disk
# space. Pages will then also be served compressed to clients that support it.
# THIS IS NOT COMPATIBLE with ob_gzhandler which is now enabled if supported in
# the default LocalSettings.php! If you enable this, remove that setting first.
#
# Requires zlib support enabled in PHP.
$wgUseGzip = false;


$wgCookieExpiration = 2592000;


# Squid-related settings
#

# Enable/disable Squid
 $wgUseSquid = false;
 
# If you run Squid3 with ESI support, enable this (default:false):
 $wgUseESI = false;
 
# Internal server name as known to Squid, if different
# $wgInternalServer = 'http://yourinternal.tld:8000';
 $wgInternalServer = $wgServer;
 
# Cache timeout for the squid, will be sent as s-maxage (without ESI) or 
# Surrogate-Control (with ESI). Without ESI, you should strip out s-maxage in the Squid config.
# 18000 seconds = 5 hours, more cache hits with 2678400 = 31 days
 $wgSquidMaxage = 18000;
 
# A list of proxy servers (ips if possible) to purge on changes
# don't specify ports here (80 is default)
# $wgSquidServers = array('127.0.0.1');

# Maximum number of titles to purge in any one client operation
$wgMaxSquidPurgeTitles = 400;


# Cookie settings:
#   Set to set an explicit domain on the login cookies
#   eg, "justthis.domain.org" or ".any.subdomain.net"
$wgCookieDomain = '';
$wgCookiePath = '/';
$wgDisableCookieCheck = false;

# Whether to allow inline image pointing to other websites
$wgAllowExternalImages = true;

$wgMiserMode = false; # Disable database-intensive features
$wgDisableQueryPages = false; # Disable all query pages if miser mode is on, not just some
$wgUseWatchlistCache = false; # Generate a watchlist once every hour or so
$wgWLCacheTimeout = 3600;     # The hour or so mentioned above

# To use inline TeX, you need to compile 'texvc' (in the 'math' subdirectory
# of the MediaWiki package and have latex, dvips, gs (ghostscript), and
# convert (ImageMagick) installed and available in the PATH.
# Please see math/README for more information.
$wgUseTeX = false;
$wgTexvc = './math/texvc'; # Location of the texvc binary

# Profiling / debugging
$wgProfiling = false; # Enable for more detailed by-function times in debug log
$wgProfileLimit = 0.0; # Only record profiling info for pages that took longer than this
$wgProfileOnly = false; # Don't put non-profiling info into log file
$wgProfileToDatabase = false; # Log sums from profiling into "profiling" table in db.
$wgProfileSampleRate = 1; # Only profile every n requests when profiling is turned on
$wgDebugProfiling = false; # Detects non-matching wfProfileIn/wfProfileOut calls
$wgDebugFunctionEntry = 0; # Output debug message on every wfProfileIn/wfProfileOut
$wgDebugSquid = false; # Lots of debugging output from SquidUpdate.php

$wgDisableCounters = false;
$wgDisableTextSearch = false;
$wgDisableFuzzySearch = false;
$wgDisableSearchUpdate = false; # If you've disabled search semi-permanently, this also disables updates to the table. If you ever re-enable, be sure to rebuild the search table.
$wgDisableUploads = true; # Uploads have to be specially set up to be secure
$wgRemoteUploads = false; # Set to true to enable the upload _link_ while local uploads are disabled. Assumes that the special page link will be bounced to another server where uploads do work.
$wgDisableAnonTalk = false;

# Path to the GNU diff3 utility. If the file doesn't exist,
# edit conflicts will fall back to the old behaviour (no merging).
$wgDiff3 = '/usr/bin/diff3';


# We can also compress text in the old revisions table. If this is set on,
# old revisions will be compressed on page save if zlib support is available.
# Any compressed revisions will be decompressed on load regardless of this
# setting *but will not be readable at all* if zlib support is not available.
$wgCompressRevisions = false;

# This is the list of preferred extensions for uploading files. Uploading
# files with extensions not in this list will trigger a warning.
$wgFileExtensions = array( 'png', 'gif', 'jpg', 'jpeg', 'ogg' );

# Files with these extensions will never be allowed as uploads.
$wgFileBlacklist = array(
	# HTML may contain cookie-stealing JavaScript and web bugs
	'html', 'htm',
	# PHP scripts may execute arbitrary code on the server
	'php', 'phtml', 'php3', 'php4', 'phps',
	# Other types that may be interpreted by some servers
	'shtml', 'jhtml', 'pl', 'py',
	# May contain harmful executables for Windows victims
	'exe', 'scr', 'dll', 'msi', 'vbs', 'bat', 'com', 'pif', 'cmd', 'vxd', 'cpl' );

# This is a flag to determine whether or not to check file extensions on
# upload.
$wgCheckFileExtensions = true;

# If this is turned off, users may override the warning for files not
# covered by $wgFileExtensions.
$wgStrictFileExtensions = true;

# Warn if uploaded files are larger than this
$wgUploadSizeWarning = 150000;

$wgPasswordSalt = true; # For compatibility with old installations set to false

# Which namespaces should support subpages?
# See Language.php for a list of namespaces.
#
$wgNamespacesWithSubpages = array( -1 => 0, 0 => 0, 1 => 1,
  2 => 1, 3 => 1, 4 => 0, 5 => 1, 6 => 0, 7 => 1, 8 => 0, 9 => 1, 10 => 0, 11 => 1);

$wgNamespacesToBeSearchedDefault = array( -1 => 0, 0 => 1, 1 => 0,
  2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 1, 10 => 0, 11 => 1 );

# If set, a bold ugly notice will show up at the top of every page.
$wgSiteNotice = "";

## Set $wgUseImageResize to true if you want to enable dynamic
## server side image resizing ("Thumbnails")
# 
$wgUseImageResize		= false;

## Resizing can be done using PHP's internal image libraries
## or using ImageMagick. The later supports more file formats
## than PHP, which only supports PNG, GIF, JPG, XBM and WBMP.
##
## Set $wgUseImageMagick to true to use Image Magick instead
## of the builtin functions
#
$wgUseImageMagick		= false;
$wgImageMagickConvertCommand    = '/usr/bin/convert';

# PHPTal is a library for page templates. MediaWiki includes
# a recent PHPTal distribution. It is required to use the
# Monobook (default) skin.
#
# Currently it does not work on PHP5.
$wgUsePHPTal = version_compare( phpversion(), "5.0", "lt" );

if( !isset( $wgCommandLineMode ) ) {
	$wgCommandLineMode = false;
}

# Show seconds in Recent Changes
$wgRCSeconds = false;

# Log IP addresses in the recentchanges table
$wgPutIPinRC = false;

# RDF metadata toggles
$wgEnableDublinCoreRdf = false;
$wgEnableCreativeCommonsRdf = false;

# Override for copyright metadata.
# TODO: these options need documentation
$wgRightsPage = NULL;
$wgRightsUrl = NULL;
$wgRightsText = NULL;
$wgRightsIcon = NULL;

# Set this to true if you want detailed copyright information forms on Upload.
$wgUseCopyrightUpload = false;

# Set this to false if you want to disable checking that detailed 
# copyright information values are not empty.
$wgCheckCopyrightUpload = true;


# Set this to false to avoid forcing the first letter of links
# to capitals. WARNING: may break links! This makes links
# COMPLETELY case-sensitive. Links appearing with a capital at
# the beginning of a sentence will *not* go to the same place
# as links in the middle of a sentence using a lowercase initial.
$wgCapitalLinks = true;

# List of interwiki prefixes for wikis we'll accept as sources
# for Special:Import (for sysops). Since complete page history
# can be imported, these should be 'trusted'.
$wgImportSources = array();

# Set this to the number of authors that you want to be credited below an
# article text. Set it to zero to hide the attribution block, and a
# negative number (like -1) to show all authors. Note that this will
# require 2-3 extra database hits, which can have a not insignificant
# impact on performance for large wikis.
$wgMaxCredits = 0;

# If there are more than $wgMaxCredits authors, show $wgMaxCredits of them.
# Otherwise, link to a separate credits page.
$wgShowCreditsIfMax = true;

# Text matching this regular expression will be recognised as spam
# See http://en.wikipedia.org/wiki/Regular_expression
$wgSpamRegex = false; 
# Similarly if this function returns true
$wgFilterCallback = false;

# Go button goes straight to the edit screen if the article doesn't exist
$wgGoToEdit = false;

# Allow limited user-specified HTML in wiki pages?
# It will be run through a whitelist for security.
# Set this to false if you want wiki pages to consist only of wiki
# markup. Note that replacements do not yet exist for all HTML
# constructs.
$wgUserHtml = true;

# Allow raw, unchecked HTML in <html>...</html> sections.
# THIS IS VERY DANGEROUS on a publically editable site, so
# you can't enable it unless you've restricted editing to
# trusted users only with $wgWhitelistEdit.
$wgRawHtml = false;

# $wgUseTidy: use tidy to make sure HTML output is sane.
# This should only be enabled if $wgUserHtml is true.
# tidy is a free tool that fixes broken HTML. 
# See http://www.w3.org/People/Raggett/tidy/
# $wgTidyBin should be set to the path of the binary and 
# $wgTidyConf to the path of the configuration file.
# $wgTidyOpts can include any number of parameters.
$wgUseTidy = false;
$wgTidyBin = 'tidy';
$wgTidyConf = $IP.'/extensions/tidy/tidy.conf'; 
$wgTidyOpts = '';

# See list of skins and their symbolic names in language/Language.php
$wgDefaultSkin = 'monobook';

# Whether or not to allow real name fields. Defaults to true.
$wgAllowRealName = true;

# Extensions
$wgSkinExtensionFunctions = array();
$wgExtensionFunctions = array();

# Allow user Javascript page?
$wgAllowUserJs = true;

# Allow user Cascading Style Sheets (CSS)?
$wgAllowUserCss = true;

# Filter for Special:Randompage. Part of a WHERE clause
$wgExtraRandompageSQL = false;

# Allow the "info" action, very inefficient at the moment
$wgAllowPageInfo = false;

# Maximum indent level of toc.
$wgMaxTocLevel = 999;

# Recognise longitude/latitude coordinates
$wgUseGeoMode = false;

# Validation for print or other production versions
$wgUseValidation = true;

# Use external C++ diff engine (module wikidiff from the
# extensions package)
$wgUseExternalDiffEngine = false;

# Use RC Patrolling to check for vandalism
$wgUseRCPatrol = true;

# Additional namespaces. If the namespaces defined in Language.php and Namespace.php are insufficient,
# you can create new ones here, for example, to import Help files in other languages.
# PLEASE NOTE: Once you delete a namespace, the pages in that namespace will no longer be accessible.
# If you rename it, then you can access them through the new namespace name.
#
# Custom namespaces should start at 100.
#$wgExtraNamespaces =
#	array(100 => "Hilfe",
#	      101 => "Hilfe_Diskussion",
#	      102 => "Aide",
#	      103 => "Discussion_Aide"
#	      );
$wgExtraNamespaces = NULL;

# Enable SOAP interface. Off by default
# SOAP is a protocoll for remote procedure calls (RPC) using http as middleware.
# This interface can be used by bots or special clients to receive articles from
# a wiki.
# Most bots use the normal HTTP interface and don't use SOAP.
# If unsure, set to false.
$wgEnableSOAP = false;

# Limit images on image description pages to a user-selectable limit. In order to
# reduce disk usage, limits can only be selected from a list. This is the list of
# settings the user can choose from:
$wgImageLimits = array (
	array(320,240),
	array(640,480),
	array(800,600),
	array(1024,768),
	array(1280,1024),
	array(10000,10000) );

} else {
	die();
}
?>
