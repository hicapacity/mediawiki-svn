<?php
#apd_set_pprof_trace();
# Main wiki script; see design.doc
#
$wgRequestTime = microtime();

unset( $IP );
@ini_set( 'allow_url_fopen', 0 ); # For security...
if( !file_exists( 'LocalSettings.php' ) ) {
	define( 'MEDIAWIKI', true );
	require_once( 'includes/DefaultSettings.php' ); # used for printing the version
?>
<!DOCTYPE html PUBLIC "-//W3C/DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>MediaWiki <?php echo $wgVersion ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<style type='text/css' media='screen, projection'>
			html, body {
				color: #000;
				background-color: #fff;
				font-family: serif;
				text-align:center;
			}

			h1 {
				font-size: 150%;
			}
		</style>
	</head>
	<body>
		<img src='skins/common/images/wiki.png' alt='The MediaWiki logo' />
		
		<h1>MediaWiki <?php echo $wgVersion ?></h1>
		<div class='error'>
		<?php
		if ( file_exists( 'config/LocalSettings.php' ) ) {
			echo( "To complete the installation, move <tt>config/LocalSettings.php</tt> to the parent directory." );
		} else {
			echo( "You'll have to <a href='config/index.php' title='setup'>set the wiki up</a> first!" );
		}
		?>

		</div>
	</body>
</html>
<?php
	die();
}

# Valid web server entry point, enable includes.
# Please don't move this line to includes/Defines.php. This line essentially defines
# a valid entry point. If you put it in includes/Defines.php, then any script that includes
# it becomes an entry point, thereby defeating its purpose.
define( 'MEDIAWIKI', true );

require_once( './includes/Defines.php' );
require_once( './LocalSettings.php' );
require_once( 'includes/Setup.php' );

wfProfileIn( 'main-misc-setup' );
OutputPage::setEncodings(); # Not really used yet

# Query string fields
$action = $wgRequest->getVal( 'action', 'view' );
$title = $wgRequest->getVal( 'title' );

$action = strtolower( trim( $action ) );
if ($wgRequest->getVal( 'printable' ) == 'yes') {
	$wgOut->setPrintable();
}

if ( '' == $title && 'delete' != $action ) {
	$wgTitle = Title::newFromText( wfMsgForContent( 'mainpage' ) );
} elseif ( $curid = $wgRequest->getInt( 'curid' ) ) {
	# URLs like this are generated by RC, because rc_title isn't always accurate
	$wgTitle = Title::newFromID( $curid );
} else {
	$wgTitle = Title::newFromURL( $title );
}
wfProfileOut( 'main-misc-setup' );

# Debug statement for user levels
// print_r($wgUser);

# If the user is not logged in, the Namespace:title of the article must be in
# the Read array in order for the user to see it. (We have to check here to
# catch special pages etc. We check again in Article::view())
if ( !is_null( $wgTitle ) && !$wgTitle->userCanRead() ) {
	$wgOut->loginToUse();
	$wgOut->output();
	exit;
}

wfProfileIn( 'main-action' );

$search = $wgRequest->getText( 'search' );
if( !$wgDisableInternalSearch && !is_null( $search ) && $search !== '' ) {
	require_once( 'includes/SpecialSearch.php' );
	$wgTitle = Title::makeTitle( NS_SPECIAL, 'Search' );
	wfSpecialSearch();
} else if( !$wgTitle or $wgTitle->getDBkey() == '' ) {
	$wgTitle = Title::newFromText( wfMsgForContent( 'badtitle' ) );
	$wgOut->errorpage( 'badtitle', 'badtitletext' );
} else if ( $wgTitle->getInterwiki() != '' ) {
	if( $rdfrom = $wgRequest->getVal( 'rdfrom' ) ) {
		$url = $wgTitle->getFullURL( 'rdfrom=' . urlencode( $rdfrom ) );
	} else {
		$url = $wgTitle->getFullURL();
	}
	# Check for a redirect loop
	if ( !preg_match( '/^' . preg_quote( $wgServer, '/' ) . '/', $url ) && $wgTitle->isLocal() ) {
		$wgOut->redirect( $url );
	} else {
		$wgTitle = Title::newFromText( wfMsgForContent( 'badtitle' ) );
		$wgOut->errorpage( 'badtitle', 'badtitletext' );
	}
} else if ( ( $action == 'view' ) &&
	(!isset( $_GET['title'] ) || $wgTitle->getPrefixedDBKey() != $_GET['title'] ) &&
	!count( array_diff( array_keys( $_GET ), array( 'action', 'title' ) ) ) )
{
	/* redirect to canonical url, make it a 301 to allow caching */
	$wgOut->setSquidMaxage( 1200 );
	$wgOut->redirect( $wgTitle->getFullURL(), '301');
} else if ( NS_SPECIAL == $wgTitle->getNamespace() ) {
	# actions that need to be made when we have a special pages
	require_once( 'includes/SpecialPage.php' );
	SpecialPage::executePath( $wgTitle );
} else {
	if ( NS_MEDIA == $wgTitle->getNamespace() ) {
		$wgTitle = Title::makeTitle( NS_IMAGE, $wgTitle->getDBkey() );
	}

	switch( $wgTitle->getNamespace() ) {
	case NS_IMAGE:
		require_once( 'includes/ImagePage.php' );
		$wgArticle = new ImagePage( $wgTitle );
		break;
	case NS_CATEGORY:
		if ( $wgUseCategoryMagic ) {
			require_once( 'includes/CategoryPage.php' );
			$wgArticle = new CategoryPage( $wgTitle );
			break;
		}
		# NO break if wgUseCategoryMagic is false, drop through to next (default).
		# Don't insert other cases between NS_CATEGORY and default.
	default:
		$wgArticle = new Article( $wgTitle );
	}

	if ( in_array( $action, $wgDisabledActions ) ) {
		$wgOut->errorpage( 'nosuchaction', 'nosuchactiontext' );
	} else {
		switch( $action ) {
			case 'view':
				$wgOut->setSquidMaxage( $wgSquidMaxage );
				$wgArticle->view();
				break;
			case 'watch':
			case 'unwatch':
			case 'delete':
			case 'revert':
			case 'rollback':
			case 'protect':
			case 'unprotect':
			case 'info':
			case 'markpatrolled':
			case 'validate':
				$wgArticle->$action();
				break;
			case 'print':
				$wgArticle->view();
				break;
			case 'dublincore':
				if( !$wgEnableDublinCoreRdf ) {
					wfHttpError( 403, 'Forbidden', wfMsg( 'nodublincore' ) );
				} else {
					require_once( 'includes/Metadata.php' );
					wfDublinCoreRdf( $wgArticle );
				}
				break;
			case 'creativecommons':
				if( !$wgEnableCreativeCommonsRdf ) {
					wfHttpError( 403, 'Forbidden', wfMsg('nocreativecommons') );
				} else {
					require_once( 'includes/Metadata.php' );
					wfCreativeCommonsRdf( $wgArticle );
				}
				break;
			case 'credits':
				require_once( 'includes/Credits.php' );
				showCreditsPage( $wgArticle );
				break;
			case 'submit':
				if( !$wgCommandLineMode && !$wgRequest->checkSessionCookie() ) {
					# Send a cookie so anons get talk message notifications
					User::SetupSession();
				}
				# Continue...
			case 'edit':			
				$internal = $wgRequest->getVal( 'internaledit' );
				$external = $wgRequest->getVal( 'externaledit' );
				$section = $wgRequest->getVal( 'section' );
				$oldid = $wgRequest->getVal( 'oldid' );						
				if(!$wgUseExternalEditor || $action=='submit' || $internal || 
				   $section || $oldid || (!$wgUser->getOption('externaleditor') && !$external)) {
					require_once( 'includes/EditPage.php' );
					$editor = new EditPage( $wgArticle );
					$editor->submit();				
				} elseif($wgUseExternalEditor && ($external || $wgUser->getOption('externaleditor'))) {
					require_once( 'includes/ExternalEdit.php' );
					$mode = $wgRequest->getVal( 'mode' );
					$extedit = new ExternalEdit( $wgArticle, $mode );				
					$extedit->edit();
				}
				break;
			case 'history':
				if ($_SERVER['REQUEST_URI'] == $wgTitle->getInternalURL('action=history')) {
					$wgOut->setSquidMaxage( $wgSquidMaxage );
				}
				require_once( 'includes/PageHistory.php' );
				$history = new PageHistory( $wgArticle );
				$history->history();
				break;
			case 'raw':
				require_once( 'includes/RawPage.php' );
				$raw = new RawPage( $wgArticle );
				$raw->view();
				break;
			case 'purge':
				wfPurgeSquidServers(array($wgTitle->getInternalURL()));
				$wgOut->setSquidMaxage( $wgSquidMaxage );
				$wgTitle->invalidateCache();
				$wgArticle->view();
				break;
			default:
				if (wfRunHooks('UnknownAction', $action, $wgArticle)) {
					$wgOut->errorpage( 'nosuchaction', 'nosuchactiontext' );
				}
		}
	}
}
wfProfileOut( 'main-action' );

# Deferred updates aren't really deferred anymore. It's important to report errors to the
# user, and that means doing this before OutputPage::output(). Note that for page saves,
# the client will wait until the script exits anyway before following the redirect.
wfProfileIn( 'main-updates' );
foreach ( $wgDeferredUpdateList as $up ) {
	$up->doUpdate();
}
wfProfileOut( 'main-updates' );

wfProfileIn( 'main-cleanup' );
$wgLoadBalancer->saveMasterPos();

# Now commit any transactions, so that unreported errors after output() don't roll back the whole thing
$wgLoadBalancer->commitAll();

$wgOut->output();

foreach ( $wgPostCommitUpdateList as $up ) {
	$up->doUpdate();
}

wfProfileOut( 'main-cleanup' );

logProfilingData();
$wgLoadBalancer->closeAll();
wfDebug( "Request ended normally\n" );
?>
