<?
# DO NOT EDIT THIS FILE!
# To customize your installation, edit "WikiLocalSettings.php".

$wgServer           = "http://" . getenv( "SERVER_NAME" );
$wgScriptPath	    = "/wiki";
$wgScript           = "{$wgScriptPath}/wiki.phtml";
$wgStyleSheetPath   = "{$wgServer}/style";
$wgArticlePath      = "{$wgServer}{$wgScript}?title=$1";
$wgUploadPath       = "{$wgServer}/upload";
$wgLogo				= "{$wgUploadPath}/wiki.png";
$wgUploadDirectory	= "/usr/local/apache/htdocs/upload";

# MySQL settings
#
$wgDBserver         = "127.0.0.1";
$wgDBname           = "wikidb";
$wgDBuser           = "wikiuser";
$wgDBpassword       = "userpwd";
$wgDBconnection     = "";

$wgReadOnlyFile		= "/usr/local/apache/htdocs/upload/dblockflag838942";
$wgDebugComments	= false;
$wgCachePages		= false;

$wgLanguageCode     = "en";
$wgInterwikiMagic	= true; # Treat language links as magic connectors, not inline links
$wgInputEncoding	= "ISO-8859-1";
$wgOutputEncoding	= "ISO-8859-1";
$wgEditEncoding		= "";

$wgDocType          = "-//W3C//DTD HTML 4.01 Transitional//EN";
$wgCookieExpiration = 2592000;

$wgAllowExternalImages = true;
$wgMiserMode = false; # Disable database-intensive features

?>
