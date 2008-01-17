<?php
# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install ParserDiffTest, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/ParserDiffTest/ParserDiffTest.php" );
EOT;
        exit( 1 );
}

$wgAutoloadClasses['ParserDiffTest'] = dirname(__FILE__) . '/ParserDiffTest_body.php';
$wgExtensionMessagesFiles['ParserDiffTest'] = dirname(__FILE__).'/ParserDiffTest.i18n.php';
$wgSpecialPages['ParserDiffTest'] = 'ParserDiffTest';


$wgPDT_OldConf = array( 'class' => 'Parser_OldPP' );
$wgPDT_NewConf = array( 'class' => 'Parser' );

