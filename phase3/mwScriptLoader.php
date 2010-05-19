<?php
/**
 * mwScriptLoader.php
 * Script Loading Library for MediaWiki
 *
 * @file
 * @author Michael Dale mdale@wikimedia.org
 * @date  feb, 2009
 * @link http://www.mediawiki.org/wiki/ScriptLoader Documentation
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

// Set a constant so the script-loader knows its not being used in "stand alone mode"
define( 'SCRIPTLOADER_MEDIAWIKI', true);

//First do a quick static check for the cached file
require_once( dirname(__FILE__) . '/js/mwEmbed/jsScriptLoader.php');
$myScriptLoader = new jsScriptLoader();
if( $myScriptLoader->outputFromCache() ){
	// We do a simple exit call since we have not touch mediaWiki code yet
	exit();
}

//Else load up mediaWiki stuff and continue scriptloader processing:

// include WebStart.php
ob_start();
require_once('includes/WebStart.php'); //60ms
$webstartwhitespace = ob_end_clean();

wfProfileIn( 'mwScriptLoader.php' );

if( $wgRequest->isPathInfoBad() ){
	wfHttpError( 403, 'Forbidden',
		'Invalid file extension found in PATH_INFO. ' .
		'mwScriptLoader must be accessed through the primary script entry point.' );
	return;
}

//load the language file and
// Run jsScriptLoader action:
$myScriptLoader->doScriptLoader();


wfProfileOut( 'mwScriptLoader.php' );