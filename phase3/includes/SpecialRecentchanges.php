<?php

require_once( "Feed.php" );

function wfSpecialRecentchanges( $par )
{
	global $wgUser, $wgOut, $wgLang, $wgTitle, $wgMemc, $wgDBname;
	global $wgRequest, $wgSitename, $wgLanguageCode;
	global $wgFeedClasses;
	$fname = "wfSpecialRecentchanges";

	# Get query parameters
	$feedFormat = $wgRequest->getVal( "feed" );

	$defaultDays = $wgUser->getOption( 'rcdays' );
	if ( !$defaultDays ) {
		$defaultDays = 3;
	}

	$days = $wgRequest->getInt( 'days', $defaultDays );
	$hideminor = $wgRequest->getBool( 'hideminor', $wgUser->getOption( 'hideminor' ) ) ? 1 : 0;
	$from = $wgRequest->getText( 'from' );
	$hidebots = $wgRequest->getBool( 'hidebots', true ) ? 1 : 0;
	$hideliu = $wgRequest->getBool( 'hideliu', false ) ? 1 : 0;
	$hidepatrolled = $wgRequest->getBool( 'hidepatrolled', false ) ? 1 : 0;

	# Get query parameters from path
	if( $par ) {
		$bits = preg_split( '/\s*,\s*/', trim( $par ) );
		if( in_array( "hidebots", $bits ) ) $hidebots = 1;
		if( in_array( "bots", $bits ) ) $hidebots = 0;
		if( in_array( "hideminor", $bits ) ) $hideminor = 1;
		if( in_array( "minor", $bits ) ) $hideminor = 0;
		if( in_array( "hideliu", $bits) ) $hideliu = 1;
		if( in_array( "hidepatrolled", $bits) ) $hidepatrolled = 1;
	}

	$dbr =& wfGetDB( DB_SLAVE );
	extract( $dbr->tableNames( 'recentchanges', 'watchlist' ) );

	$lastmod = $dbr->selectField( 'recentchanges', 'MAX(rc_timestamp)', false, $fname );
	# 10 seconds server-side caching max
	$wgOut->setSquidMaxage( 10 );
	if( $wgOut->checkLastModified( $lastmod ) ){
		# Client cache fresh and headers sent, nothing more to do.
		return;
	}

	# The next few lines can probably be commented out now that wfMsg can get text from the DB
	$rctext = $dbr->selectField( 'cur', 'cur_text',
		array( 'cur_namespace' => NS_WIKIPEDIA, 'cur_title' => 'Recentchanges' ),
		$fname
	);
	if( !$rctext ) {
		$rctext = wfMsg( "recentchangestext" );
	}

	$wgOut->addWikiText( $rctext );

	list( $limit, $offset ) = wfCheckLimits( 100, "rclimit" );
	$now = wfTimestampNow();
	$cutoff_unixtime = time() - ( $days * 86400 );
	$cutoff_unixtime = $cutoff_unixtime - ($cutoff_unixtime % 86400);
	$cutoff = wfUnix2Timestamp( $cutoff_unixtime );
	if(preg_match('/^[0-9]{14}$/', $from) and $from > $cutoff) {
		$cutoff = $from;
	} else {
		unset($from);
	}

	$sk = $wgUser->getSkin();
	$showhide = array( wfMsg( "show" ), wfMsg( "hide" ));

	$hidem  = ( $hideminor )    ? "AND rc_minor=0" : "";
	$hidem .= ( $hidebots )     ? " AND rc_bot=0" : "";
	$hidem .= ( $hideliu )      ? " AND rc_user=0" : "";
	$hidem .= ( $hidepatrolled )? " AND rc_patrolled=0" : "";

	$urlparams = array( "hideminor" => $hideminor,  "hideliu"       => $hideliu,
	                    "hidebots"  => $hidebots,   "hidepatrolled" => $hidepatrolled );
	$hideparams = wfArrayToCGI( $urlparams );

	$minorLink = $sk->makeKnownLink( $wgLang->specialPage( "Recentchanges" ),
	  $showhide[1-$hideminor], wfArrayToCGI( array( "hideminor" => 1-$hideminor ), $urlparams ) );
	$botLink = $sk->makeKnownLink( $wgLang->specialPage( "Recentchanges" ),
	  $showhide[1-$hidebots], wfArrayToCGI( array( "hidebots" => 1-$hidebots ), $urlparams ) );
	$liuLink = $sk->makeKnownLink( $wgLang->specialPage( "Recentchanges" ),
	  $showhide[1-$hideliu], wfArrayToCGI( array( "hideliu" => 1-$hideliu ), $urlparams ) );
	$patrLink = $sk->makeKnownLink( $wgLang->specialPage( "Recentchanges" ),
	  $showhide[1-$hidepatrolled], wfArrayToCGI( array( "hidepatrolled" => 1-$hidepatrolled ), $urlparams ) );

	$uid = $wgUser->getID();
	$sql2 = "SELECT $recentchanges.*" . ($uid ? ",wl_user" : "") . " FROM $recentchanges " .
	  ($uid ? "LEFT OUTER JOIN $watchlist ON wl_user={$uid} AND wl_title=rc_title AND wl_namespace=rc_namespace & 65534 " : "") .
	  "WHERE rc_timestamp > '{$cutoff}' {$hidem} " .
	  "ORDER BY rc_timestamp DESC LIMIT {$limit}";

	$res = $dbr->query( $sql2, DB_SLAVE, $fname );
	$rows = array();
	while( $row = $dbr->fetchObject( $res ) ){
		$rows[] = $row;
	}
	$dbr->freeResult( $res );

	if(isset($from)) {
		$note = wfMsg( "rcnotefrom", $wgLang->formatNum( $limit ),
			$wgLang->timeanddate( $from, true ) );
	} else {
		$note = wfMsg( "rcnote", $wgLang->formatNum( $limit ), $wgLang->formatNum( $days ) );
	}
	$wgOut->addHTML( "\n<hr />\n{$note}\n<br />" );

	$note = rcDayLimitLinks( $days, $limit, "Recentchanges", $hideparams, false, $minorLink, $botLink, $liuLink, $patrLink );

	$note .= "<br />\n" . wfMsg( "rclistfrom",
	  $sk->makeKnownLink( $wgLang->specialPage( "Recentchanges" ),
	  $wgLang->timeanddate( $now, true ), "{$hideparams}&from=$now" ) );

	$wgOut->addHTML( "{$note}\n" );

	if( isset($wgFeedClasses[$feedFormat]) ) {
		$feed = new $wgFeedClasses[$feedFormat](
			$wgSitename . " - " . wfMsg( "recentchanges" ) . " [" . $wgLanguageCode . "]",
			htmlspecialchars( wfMsg( "recentchangestext" ) ),
			$wgTitle->getFullUrl() );
		$feed->outHeader();
		foreach( $rows as $obj ) {
			$title = Title::makeTitle( $obj->rc_namespace, $obj->rc_title );
			$talkpage = $title->getTalkPage();
			$item = new FeedItem(
				$title->getPrefixedText(),
				htmlspecialchars( $obj->rc_comment ),
				$title->getFullURL(),
				$obj->rc_timestamp,
				$obj->rc_user_text,
				$talkpage->getFullURL()
				);
			$feed->outItem( $item );
		}
		$feed->outFooter();
	} else {
		$wgOut->setSyndicated( true );
		$s = $sk->beginRecentChangesList();
		$counter = 1;
		foreach( $rows as $obj ){
			if( $limit == 0) {
				break;
			}

			if ( ! ( $hideminor     && $obj->rc_minor     ) &&
			     ! ( $hidepatrolled && $obj->rc_patrolled ) ) {
				$rc = RecentChange::newFromRow( $obj );
				$rc->counter = $counter++;
				$s .= $sk->recentChangesLine( $rc, !empty( $obj->wl_user ) );
				--$limit;
			}
		}
		$s .= $sk->endRecentChangesList();
		$wgOut->addHTML( $s );
	}
}

function rcCountLink( $lim, $d, $page="Recentchanges", $more="" )
{
	global $wgUser, $wgLang;
	$sk = $wgUser->getSkin();
	$s = $sk->makeKnownLink( $wgLang->specialPage( $page ),
	  ($lim ? $wgLang->formatNum( "{$lim}" ) : wfMsg( "all" ) ), "{$more}" .
	  ($d ? "days={$d}&" : "") . "limit={$lim}" );
	return $s;
}

function rcDaysLink( $lim, $d, $page="Recentchanges", $more="" )
{
	global $wgUser, $wgLang;
	$sk = $wgUser->getSkin();
	$s = $sk->makeKnownLink( $wgLang->specialPage( $page ),
	  ($d ? $wgLang->formatNum( "{$d}" ) : wfMsg( "all" ) ), "{$more}days={$d}" .
	  ($lim ? "&limit={$lim}" : "") );
	return $s;
}

function rcDayLimitLinks( $days, $limit, $page="Recentchanges", $more="", $doall = false, $minorLink = "",
	$botLink = "", $liuLink = "", $patrLink = "" )
{
	if ($more != "") $more .= "&";
	$cl = rcCountLink( 50, $days, $page, $more ) . " | " .
	  rcCountLink( 100, $days, $page, $more  ) . " | " .
	  rcCountLink( 250, $days, $page, $more  ) . " | " .
	  rcCountLink( 500, $days, $page, $more  ) .
	  ( $doall ? ( " | " . rcCountLink( 0, $days, $page, $more ) ) : "" );
	$dl = rcDaysLink( $limit, 1, $page, $more  ) . " | " .
	  rcDaysLink( $limit, 3, $page, $more  ) . " | " .
	  rcDaysLink( $limit, 7, $page, $more  ) . " | " .
	  rcDaysLink( $limit, 14, $page, $more  ) . " | " .
	  rcDaysLink( $limit, 30, $page, $more  ) .
	  ( $doall ? ( " | " . rcDaysLink( $limit, 0, $page, $more ) ) : "" );
	$shm = wfMsg( "showhideminor", $minorLink, $botLink, $liuLink, $patrLink );
	$note = wfMsg( "rclinks", $cl, $dl, $shm );
	return $note;
}

# Obsolete? Isn't called from anywhere and $mlink isn't defined
function rcLimitLinks( $page="Recentchanges", $more="", $doall = false )
{
	if ($more != "") $more .= "&";
	$cl = rcCountLink( 50, 0, $page, $more ) . " | " .
	  rcCountLink( 100, 0, $page, $more  ) . " | " .
	  rcCountLink( 250, 0, $page, $more  ) . " | " .
	  rcCountLink( 500, 0, $page, $more  ) .
	  ( $doall ? ( " | " . rcCountLink( 0, $days, $page, $more ) ) : "" );
	$note = wfMsg( "rclinks", $cl, "", $mlink );
	return $note;
}

?>
