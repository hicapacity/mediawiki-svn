<?
# DO NOT EDIT THIS FILE!
# To customize your installation, edit "LocalSettings.php".
# Note that since all these string interpolations are expanded
# before LocalSettings is included, if you localize something
# like $wgScriptPath, you must also localize everything that
# depends on it.

$wgSitename         = "Wikipedia";
$wgMetaNamespace    = FALSE; # will be same as you set $wgSitename

$wgServer           = "http://" . getenv( "SERVER_NAME" );
$wgScriptPath	    = "/wiki";
$wgScript           = "{$wgScriptPath}/wiki.phtml";
$wgRedirectScript   = "{$wgScriptPath}/redirect.phtml";
$wgStyleSheetPath   = "{$wgScriptPath}/style";
$wgStyleSheetDirectory = "{$IP}/style";
$wgArticlePath      = "{$wgScript}?title=$1";
$wgUploadPath       = "{$wgScriptPath}/upload";
$wgUploadDirectory	= "{$IP}/upload";
$wgLogo				= "{$wgUploadPath}/wiki.png";
$wgMathPath         = "{$wgUploadPath}/math";
$wgMathDirectory    = "{$wgUploadDirectory}/math";
$wgTmpDirectory     = "{$wgUploadDirectory}/tmp";
$wgEmergencyContact = "wikiadmin@" . getenv( "SERVER_NAME" );

# MySQL settings
#
$wgDBserver         = "localhost";
$wgDBname           = "wikidb";
$wgDBconnection     = "";
$wgDBuser           = "wikiuser";
$wgDBpassword       = "userpass";
$wgDBsqluser		= "sqluser";
$wgDBsqlpassword	= "sqlpass";
$wgDBminWordLen     = 4;
$wgDBtransactions	= false; # Set to true if using InnoDB tables
$wgDBmysql4			= false; # Set to true to use enhanced fulltext search

# Language settings
#
$wgLanguageCode     = "en";
$wgInterwikiMagic	= true; # Treat language links as magic connectors, not inline links
$wgInputEncoding	= "ISO-8859-1";
$wgOutputEncoding	= "ISO-8859-1";
$wgEditEncoding		= "";
$wgDocType          = "-//W3C//DTD HTML 4.01 Transitional//EN";
$wgDTD              = "http://www.w3.org/TR/html4/loose.dtd";
$wgUseDynamicDates  = false; # Enable to allow rewriting dates in page text
$wgAmericanDates    = false; # Enable for English module to print dates
							 # as eg 'May 12' instead of '12 May'
$wgLocalInterwiki   = "w";
$wgShowIPinHeader	= true; # For non-logged in users
$wgUseDynamicDates	= false; # Allows the user to pick their preferred date format

# Miscellaneous configuration settings
#
$wgReadOnlyFile		= "{$wgUploadDirectory}/lock_yBgMBwiR";
$wgDebugLogFile     = "{$wgUploadDirectory}/log_dlJbnMZb";
$wgDebugComments	= false;
$wgReadOnly			= false;
$wgSqlLogFile		= "{$wgUploadDirectory}/sqllog_mFhyRe6";
$wgLogQueries		= false;
$wgUseBetterLinksUpdate = true;
$wgSysopUserBans        = true; # Allow sysops to ban logged-in users
$wgIPBlockExpiration    = 86400; # IP blocks expire after this many seconds, 0=infinite
$wgUserBlockExpiration  = 0; # As above, but for logged-in users


# Client-side caching:
$wgCachePages       = true; # Allow client-side caching of pages

# Set this to current time to invalidate all prior cached pages.
# Affects both client- and server-side caching.
$wgCacheEpoch = "20030516000000";

# Server-side caching:
#  This will cache static pages for non-logged-in users
#  to reduce database traffic on public sites.
#  Must set $wgShowIPinHeader = false
$wgUseFileCache = false;
$wgFileCacheDirectory = "{$wgUploadDirectory}/cache";

$wgCookieExpiration = 2592000;

$wgAllowExternalImages = true;
$wgMiserMode = false; # Disable database-intensive features
$wgUseTeX = false;
$wgProfiling = false; # Enable for more detailed by-function times in debug log

$wgDisableCounters = false;
$wgDisableTextSearch = false;
$wgDisableUploads = false;
$wgDisableAnonTalk = false;

# We can serve pages compressed in order to save bandwidth,
# but this will increase CPU usage.
# Requires zlib support enabled in PHP.
$wgUseGzip = false;

# For security, the user password hashes include "salt" to
# make it more difficult for someone who somehow gets ahold
# of the hashes to crack them all at once.
# 
# For compatibility with old installations, set to false.
$wgPasswordSalt = true;

# Which namespaces should support subpages?
# See Language.php for a list of namespaces.
#
$wgNamespacesWithSubpages = array( -1 => 0, 0 => 0, 1 => 1,
  2 => 1, 3 => 1, 4 => 0, 5 => 1, 6 => 0, 7 => 1 );

$wgNamespacesToBeSearchedDefault = array( -1 => 0, 0 => 1, 1 => 0,
  2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0 );

?>
