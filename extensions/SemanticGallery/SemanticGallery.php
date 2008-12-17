<?php

if ( !defined('MEDIAWIKI') )
	die(1);

$wgExtensionFunctions[] = 'semanticGallery_Setup';

function semanticGallery_Setup()
{
	global $wgParser, $wgHooks;

	// credits
	$wgExtensionCredits['parserhook'][] = array(
		'name'            => 'Semantic Gallery',
		'version'         => '0.1.1',
		'author'          => array( 'Rowan Rodrik van der Molen' ),
		'url'             => 'http://www.mediawiki.org/wiki/Extension:Semantic_Gallery',
		'description'     => 'Adds a gallery output format to SMW inline queries',
		'descriptionmsg'  => 'semanticgallery-desc',
	);

	require_once('SG_ResultPrinter.php');

	// global variable introduced in SMW 1.2.2
	global $smwgResultFormats;
	if (isset($smwgResultFormats))
		$smwgResultFormats['gallery'] = 'SemanticGallery_ResultPrinter';
	else
		SMWQueryProcessor::$formats['gallery'] = 'SemanticGallery_ResultPrinter';
}


# vim:set tabstop=4 noexpandtab shiftwidth=4:
?>
