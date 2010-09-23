<?php
/**
 * Main class for the Approved Revs extension.
 *
 * @file
 * @ingroup Extensions
 *
 * @author Yaron Koren
 */

class ApprovedRevs {
	/**
	 * Gets the approved revision ID for this page, or null if there isn't
	 * one.
	 */
	public static function getApprovedRevID( $title ) {
		if ( ! self::pageIsApprovable( $title ) ) {
			return null;
		}
		$dbr = wfGetDB( DB_SLAVE );
		$page_id = $title->getArticleId();
		$rev_id = $dbr->selectField( 'approved_revs', 'rev_id', array( 'page_id' => $page_id ) );
		return $rev_id;
	}

	/**
	 * Returns whether or not this page has a revision ID.
	 */
	public static function hasApprovedRevision( $title ) {
		$revision_id = self::getApprovedRevID( $title );
		return ( ! empty( $revision_id ) );
	}

	/**
	 * Returns the content of the approved revision of this page, or null
	 * if there isn't one.
	 */
	public static function getApprovedContent( $title ) {
		$revision_id = ApprovedRevs::getApprovedRevID( $title );
		if ( empty( $revision_id ) ) {
			return null;
		}
		$article = new Article( $title, $revision_id );
		return( $article->getContent() );
	}

	/**
	 * Helper function - determine whether a boolean page property is
	 * set; the regular getProperty() function isn't working here, for
	 * some reason, so just make a database call.
	 */
	public static function isPagePropertySet( $title, $propName ) {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'page_props', 'COUNT(*)',
			array(
				'pp_page' => $title->getArticleID(),
				'pp_propname' => $propName,
				'pp_value' => 'y'
			)
		);
		$row = $dbr->fetchRow( $res );
		return ( $row[0] == 1 );
	}

	/**
	 * Returns whether this page can be approved - either because it's in
	 * a supported namespace, or because it's been specially marked as
	 * approvable. Also stores the boolean answer as a field in the page
	 * object, to speed up processing if it's called more than once.
	 */
	public static function pageIsApprovable( $title ) {
		// if this function was already called for this page, the
		// value should have been stored as a field in the $title object
		if ( isset( $title->isApprovable ) ) {
			return $title->isApprovable;
		}

		// check the namespace
		global $egApprovedRevsNamespaces;
		if ( in_array( $title->getNamespace(), $egApprovedRevsNamespaces ) ) {
			$title->isApprovable = true;
			return true;
		}

		// it's not in an included namespace, so check for the page
		// property.
		$isApprovable = self::isPagePropertySet( $title, 'approvedrevs' );
		$title->isApprovable = $isApprovable;
		return $isApprovable;
	}

	/**
	 * Sets a certain revision as the approved one for this page in the
	 * approved_revs DB table; calls a "links update" on this revision
	 * so that category information can be stored correctly, as well as
	 * info for extensions such as Semantic MediaWiki; and logs the action.
	 */
	public static function setApprovedRevID( $title, $rev_id, $is_latest = false ) {
		$dbr = wfGetDB( DB_MASTER );
		$page_id = $title->getArticleId();
		$old_rev_id = $dbr->selectField( 'approved_revs', 'rev_id', array( 'page_id' => $page_id ) );
		if ( $old_rev_id ) {
			$dbr->update( 'approved_revs', array( 'rev_id' => $rev_id ), array( 'page_id' => $page_id ) );
		} else {
			$dbr->insert( 'approved_revs', array( 'page_id' => $page_id, 'rev_id' => $rev_id ) );
		}

		// if the revision being approved is definitely the latest
		// one, there's no need to call the parser on it
		if ( !$is_latest ) {
			$parser = new Parser();
			$parser->setTitle( $title );
			$article = new Article( $title, $rev_id );
			$text = $article->getContent();
			$options = new ParserOptions();
			$parser->parse( $text, $title, $options, true, true, $rev_id );
			$u = new LinksUpdate( $title, $parser->getOutput() );
			$u->doUpdate();
		}

		$log = new LogPage( 'approval' );
		$rev_url = $title->getFullURL( array( 'old_id' => $rev_id ) );
		$rev_link = Xml::element(
			'a',
			array( 'href' => $rev_url ),
			$rev_id
		);
		$logParams = array( $rev_link );
		$log->addEntry(
			'approve',
			$title,
			'',
			$logParams
		);

		wfRunHooks( 'ApprovedRevsRevisionApproved', array( $parser, $title, $rev_id ) );
	}

	public static function deleteRevisionApproval( $title ) {
		$dbr = wfGetDB( DB_MASTER );
		$page_id = $title->getArticleId();
		$dbr->delete( 'approved_revs', array( 'page_id' => $page_id ) );
	}

	/**
	 * Unsets the approved revision for this page in the approved_revs DB
	 * table; calls a "links update" on this page so that category
	 * information can be stored correctly, as well as info for
	 * extensions such as Semantic MediaWiki; and logs the action.
	 */
	public static function unsetApproval( $title ) {
		self::deleteRevisionApproval( $title );

		$parser = new Parser();
		$parser->setTitle( $title );
		$article = new Article( $title );
		$text = $article->getContent();
		$options = new ParserOptions();
		$parser->parse( $text, $title, $options );
		$u = new LinksUpdate( $title, $parser->getOutput() );
		$u->doUpdate();

		$log = new LogPage( 'approval' );
		$log->addEntry(
			'unapprove',
			$title,
			''
		);

		wfRunHooks( 'ApprovedRevsRevisionUnapproved', array( $parser, $title ) );
	}
}
