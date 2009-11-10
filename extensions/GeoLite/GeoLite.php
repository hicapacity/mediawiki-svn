<?php

# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/GeoLite/GeoLite.php" );
EOT;
	exit( 1 );
}

$wgLandingPageBase = 'http://wikimediafoundation.org/wiki/Support_Wikipedia';
$wgChaptersPageBase = 'http://wikimediafoundation.org/wiki/Global_Support';

# Which Chapters actually have landing pages
$wgChapterLandingPages = array(
	'HK' => 'hk',
	'DE' => 'de',
	'UK' => 'uk',
	'FR' => 'fr',
	'CH' => 'ch',
);

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'GeoLite',
	'version' => '1.0',
	'url' => 'http://www.mediawiki.org/wiki/Extension:GeoLite',
	'author' => 'Tomasz Finc',
	'descriptionmsg' => 'geolite-desc',
);

$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses['SpecialGeoLite'] = $dir . 'GeoLite_body.php';
$wgExtensionMessagesFiles['GeoLite'] = $dir . 'GeoLite.i18n.php';
$wgSpecialPages['GeoLite'] = 'SpecialGeoLite';
$wgSpecialPageGroups['GeoLite'] = 'contribution';