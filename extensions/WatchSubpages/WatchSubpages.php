<?php
# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "$IP/extensions/WatchSubpages/WatchSubpages.php" );
EOT;
        exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'author' => '[http://www.strategywiki.org/wiki/User:Prod User:Prod]',
	'name' => 'Watch Guide Subpages',
	'version' => preg_replace('/^.* (\d\d\d\d-\d\d-\d\d) .*$/', '\1', '$LastChangedDate$'), #just the date of the last change
	'url' => 'http://www.strategywiki.org/wiki/User:Prod',
	'description' => 'Quickly add all subpages of a guide to the users watchlist',
	'descriptionmsg' => 'watchsubpages-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['WatchSubpages'] = $dir . 'WatchSubpages.i18n.php';
$wgAutoloadClasses['WatchSubpages'] = $dir . 'WatchSubpages_body.php';
$wgSpecialPages['WatchSubpages'] = 'WatchSubpages';
