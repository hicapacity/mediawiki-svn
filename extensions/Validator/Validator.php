<?php

/**
 * Initialization file for the Validator extension.
 * Extension documentation: http://www.mediawiki.org/wiki/Extension:Validator
 *
 * You will be validated. Resistance is futile.
 *
 * @file Validator.php
 * @ingroup Validator
 *
 * @author Jeroen De Dauw
 */

/**
 * This documenation group collects source code files belonging to Validator.
 *
 * Please do not use this group name for other code.
 *
 * @defgroup Validator Validator
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

define( 'Validator_VERSION', '0.4 alpha-5' );

// Constants indicating the strictness of the parameter validation.
define( 'Validator_ERRORS_NONE', 0 );
define( 'Validator_ERRORS_LOG', 1 );
define( 'Validator_ERRORS_WARN', 2 );
define( 'Validator_ERRORS_SHOW', 3 );
define( 'Validator_ERRORS_STRICT', 4 );

// Register the internationalization file.
$wgExtensionMessagesFiles['Validator'] = dirname( __FILE__ ) . '/Validator.i18n.php';

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Validator',
	'version' => Validator_VERSION,
	'author' => array( '[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]' ),
	'url' => 'http://www.mediawiki.org/wiki/Extension:Validator',
	'descriptionmsg' => 'validator-desc',
);

// This function has been deprecated in 1.16, but needed for earlier versions.
// It's present in 1.16 as a stub, but lets check if it exists in case it gets removed at some point.
if ( function_exists( 'wfLoadExtensionMessages' ) ) {
	wfLoadExtensionMessages( 'Validator' );
}

// Autoload the classes.
$incDir = dirname( __FILE__ ) . '/includes/';
$wgAutoloadClasses['CriterionValidationResult']	= $incDir . 'CriterionValidationResult.php'; 
$wgAutoloadClasses['ItemParameterCriterion']	= $incDir . 'ItemParameterCriterion.php';
$wgAutoloadClasses['ListParameter'] 			= $incDir . 'ListParameter.php';
$wgAutoloadClasses['ListParameterCriterion']	= $incDir . 'ListParameterCriterion.php';
$wgAutoloadClasses['Parameter'] 				= $incDir . 'Parameter.php';
$wgAutoloadClasses['ParameterCriterion'] 		= $incDir . 'ParameterCriterion.php';
$wgAutoloadClasses['ParserHook'] 				= $incDir . 'ParserHook.php';
$wgAutoloadClasses['Validator'] 				= $incDir . 'Validator.php';
$wgAutoloadClasses['TopologicalSort'] 			= $incDir . 'TopologicalSort.php';
$wgAutoloadClasses['ValidationFormats'] 		= $incDir . 'ValidationFormats.php';
$wgAutoloadClasses['ValidationError']			= $incDir . 'ValidationError.php';
$wgAutoloadClasses['ValidationErrorHandler']	= $incDir . 'ValidationErrorHandler.php';

$wgAutoloadClasses['CriterionHasLength']		= $incDir . 'criteria/CriterionHasLength.php';
$wgAutoloadClasses['CriterionInArray']			= $incDir . 'criteria/CriterionInArray.php';
$wgAutoloadClasses['CriterionInRange']			= $incDir . 'criteria/CriterionInRange.php';
$wgAutoloadClasses['CriterionIsFloat']			= $incDir . 'criteria/CriterionIsFloat.php';
$wgAutoloadClasses['CriterionIsInteger']		= $incDir . 'criteria/CriterionIsInteger.php';
$wgAutoloadClasses['CriterionIsNumeric']		= $incDir . 'criteria/CriterionIsNumeric.php';
$wgAutoloadClasses['CriterionItemCount']		= $incDir . 'criteria/CriterionItemCount.php';
$wgAutoloadClasses['CriterionMatchesRegex']		= $incDir . 'criteria/CriterionMatchesRegex.php';
$wgAutoloadClasses['CriterionNotEmpty']			= $incDir . 'criteria/CriterionNotEmpty.php'; 
$wgAutoloadClasses['CriterionTrue']				= $incDir . 'criteria/CriterionTrue.php';
$wgAutoloadClasses['CriterionUniqueItems']		= $incDir . 'criteria/CriterionUniqueItems.php';

$wgAutoloadClasses['ValidatorListErrors'] 		= $incDir . 'parserHooks/Validator_ListErrors.php';
unset( $incDir );

// Include the settings file.
require_once 'Validator_Settings.php';