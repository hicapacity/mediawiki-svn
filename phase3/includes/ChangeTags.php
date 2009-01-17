<?php

if (!defined( 'MEDIAWIKI' ))
	die;

class ChangeTags {
	static function formatSummaryRow( $tags, $page, &$classes ) {
		if (!$tags)
			return '';
		
		$tags = explode( ',', $tags );
		$displayTags = array();
		foreach( $tags as $tag ) {
			if (!wfEmptyMsg( "tag-$tag" , wfMsg( "tag-$tag" ) ) ) {
				$displayTags[] = wfMsgExt( "tag-$tag", 'parseinline' );
			} else {
				$displayTags[] = $tag;
			}
			$classes[] = "mw-tag-$tag";
		}

		return '(' . implode( ', ', $displayTags ) . ')';
	}

	## Basic utility method to add tags to a particular change, given its rc_id, rev_id and/or log_id.
	static function addTags( $tags, $rc_id=null, $rev_id=null, $log_id=null, $params = null ) {
		if ( !is_array($tags) ) {
			$tags = array( $tags );
		}

		if (!$rc_id && !$rev_id && !$log_id) {
			throw new MWException( "At least one of: RCID, revision ID, and log ID MUST be specified when adding a tag to a change!" );
		}

		$dbr = wfGetDB( DB_SLAVE );

		// Might as well look for rcids and so on.
		if (!$rc_id) {
			$dbr = wfGetDB( DB_MASTER ); // Info might be out of date, somewhat fractionally, on slave.
			if ($log_id) {
				$rc_id = $dbr->selectField( 'recentchanges', 'rc_id', array( 'rc_logid' => $log_id ), __METHOD__ );
			} elseif ($rev_id) {
				$rc_id = $dbr->selectField( 'recentchanges', 'rc_id', array( 'rc_this_oldid' => $rev_id ), __METHOD__ );
			}
		} elseif (!$log_id && !$rev_id) {
			$dbr = wfGetDB( DB_MASTER ); // Info might be out of date, somewhat fractionally, on slave.
			$log_id = $dbr->selectField( 'recentchanges', 'rc_logid', array( 'rc_id' => $rc_id ), __METHOD__ );
			$rev_id = $dbr->selectField( 'recentchanges', 'rc_this_oldid', array( 'rc_id' => $rc_id ), __METHOD__ );
		}

		$tsConds = array_filter( array( 'ts_rc_id' => $rc_id, 'ts_rev_id' => $rev_id, 'ts_log_id' => $log_id ) );

		## Update the summary row.
		$prevTags = $dbr->selectField( 'tag_summary', 'ts_tags', $tsConds, __METHOD__ );
		$prevTags = $prevTags ? $prevTags : '';
		$prevTags = array_filter( explode( ',', $prevTags ) );
		$newTags = array_unique( array_merge( $prevTags, $tags ) );
		sort($prevTags);
		sort($newTags);

		if ( $prevTags == $newTags ) {
			// No change.
			return false;
		}

		$dbw = wfGetDB( DB_MASTER );
		$dbw->replace( 'tag_summary', array( 'ts_rev_id', 'ts_rc_id', 'ts_log_id' ),  array_filter( array_merge( $tsConds, array( 'ts_tags' => implode( ',', $newTags ) ) ) ), __METHOD__ );

		// Insert the tags rows.
		$tagsRows = array();
		foreach( $tags as $tag ) {
			$tagsRows[] = array( 'ct_tag' => $tag, 'ct_rc_id' => $rc_id, 'ct_log_id' => $log_id, 'ct_rev_id' => $rev_id, 'ct_params' => $params );
		}

		$dbw->replace( 'change_tag', array( array( 'ct_tag', 'ct_rc_id', 'ct_rev_id', 'ct_log_id' ) ), $tagsRows, __METHOD__ );

		return true;
	}
}