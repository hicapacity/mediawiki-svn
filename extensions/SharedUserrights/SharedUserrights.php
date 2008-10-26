<?php
/**
* SharedUserRights -- adds a special page to manage rights in a shared database
*
* @ingroup Extensions
*
* @author Charles Melbye <charlie@yourwiki.net>
* @version 0.10
* @copyright Copyright (C) 2008 YourWiki, Inc.
* @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
*
*/

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( 'THIS IS NOT A VALID ENTRY POINT.' );
	exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'SharedUserRights',
	'url' => 'http://www.mediawiki.org/wiki/Extension:SharedUserRights',
	'version' => '0.10',
	'author' => 'Charles Melbye',
	'description' => 'Easy global user rights administration',
	'descriptionmsg' => 'gblrights-desc',
);

$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses['SharedUserRights'] = $dir . 'SharedUserRights_body.php';
$wgExtensionMessagesFiles['SharedUserRights'] = $dir . 'SharedUserRights.i18n.php';
$wgExtensionAliasesFiles['SharedUserRights'] = $dir . 'SharedUserRights.alias.php';
$wgSpecialPages['SharedUserRights'] = 'SharedUserRights';
$wgSpecialPageGroups['SharedUserRights'] = 'users';

$wgLogTypes[]                     = 'gblrights';
$wgLogNames['gblrights']          = 'gblrights-logpage';
$wgLogHeaders['gblrights']        = 'gblrights-pagetext';
$wgLogActions['gblrights/rights'] = 'gblrights-rights-entry';


// Hooked functions
$wgHooks['UserEffectiveGroups'][] = 'efAddSharedUserRights';

function efAddSharedUserRights( $user, $groups ) {
	global $wgSharedDB, $wgDBname;

	$dbr = wfGetDB( DB_SLAVE );

	if ( $dbr->selectDB( $wgSharedDB ) ) {
		$res = $dbr->select( 'shared_user_groups',
			'sug_group',
			array ( 'sug_user' => $user->mId ) );
		while ( $row = $dbr->fetchObject( $res ) ) {
			$groups[] = $row->sug_group;
		}
		$dbr->freeResult( $res );
		$dbr->selectDB( $wgDBname ); # to prevent Listusers from breaking
	}

	return $groups;
}
