<?php

/**
 * Extension HideNamespace - Hides namespace in the header and title when a page is in specified namespace
 * or when the {{#hidens:}} parser function is called
 *
 * @file
 * @ingroup Extensions
 * @author Matěj Grabovský (mgrabovsky.github.com)
 * @copyright © 2010, Matěj Grabovský
 * @license GNU General Public Licence 2.0 or later
 */

if( !defined('MEDIAWIKI') ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die();
}

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['HideNamespace'] = $dir . 'HideNamespace.i18n.php';
$wgExtensionMessagesFiles['HideNamespaceMagic'] = $dir . 'HideNamespace.i18n.magic.php';

$wgExtensionFunctions[] = 'wfHideNamespaceSetup';
$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'HideNamespace',
	'descriptionmsg' => 'hidens-desc',
	'version'        => '1.4.2',
	'author'         => 'Matěj Grabovský',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:HideNamespace',
);

function wfHideNamespaceSetup() {
	global $wgParser, $wgHooks;

	$extHidensObj = new ExtensionHideNamespace;

	// Register hooks
	$wgHooks['ArticleViewHeader'][] = array( &$extHidensObj, 'onArticleViewHeader' );
	$wgHooks['BeforePageDisplay'][] = array( &$extHidensObj, 'onBeforePageDisplay' );
	$wgHooks['ParserFirstCallInit'][] = array( &$extHidensObj, 'registerParser' );
}

class ExtensionHideNamespace {
	private static $namespace, $namespaceL10n;
	private static $forceHide = false, $forceShow = false;

	/**
	 * Register our parser functions
	 */
	function registerParser( &$parser ) {
		$parser->setFunctionHook( 'hidens', array( &$this, 'hideNs' ) );
		$parser->setFunctionHook( 'showns', array( &$this, 'showNs' ) );

		return true;
	}

	/**
	 * Callback for our parser function {{#hidens:}}
	 *
	 * Force to hide the namespace
	 */
	function hideNs( &$parser ) {
		self::$forceHide = true;

		return '';
	}

	/**
	 * Callback for our parser function {{#showns:}}
	 *
	 * Force to show the namespace
	 */
	function showNs( &$parser ) {
		self::$forceShow = true;

		return '';
	}

	/**
	 * Callback for the ArticleViewHeader hook.
	 *
	 * Saves namespace identifier and localized namespace name to the $namespace and
	 * $namespaceL10n variables
	 */
	function onArticleViewHeader( $article, $outputDone, $enableParserCcache ) {
		self::$namespace = $article->mTitle->mNamespace;

		if( self::$namespace === NS_MAIN ) {
			self::$namespaceL10n = '';
		} else {
			self::$namespaceL10n = substr( $article->mTitle->getPrefixedText(), 0,
				strpos( $article->mTitle->getPrefixedText(),':' ) );
		}

		return true;
	}

	/**
	 * Callback for the OutputPageBeforeHTML hook
	 *
	 * "Hides" the namespace in the header and in title
	 */
	function onBeforePageDisplay( &$out, $skin ) {
		if( self::$namespace === NS_MAIN )
			return true;

		global $wgHideNsNamespaces;

		/**
		 * Hide the namespace if:
		 *   the page's namespace is contained in the $wgHideNsNamespaces array or
		 *   the {{#hidens:}} function was called
		 * but not when the {{#showns:}} function was called
		 */

		if( ( (isset($wgHideNsNamespaces) && in_array(self::$namespace, $wgHideNsNamespaces)) || self::$forceHide ) &&
		    !self::$forceShow )
		{
			$out->setPageTitle( substr( $out->getPageTitle(), strlen( self::$namespaceL10n ) + 1 ) );
		}

		return true;
	}
}
