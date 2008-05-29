<?php

class OldReviewedPages extends SpecialPage
{
    function __construct() {
        SpecialPage::SpecialPage( 'OldReviewedPages', 'unreviewedpages' );
    }

    function execute( $par ) {
        global $wgRequest, $wgUser, $wgOut;
		$this->setHeaders();
		if( !$wgUser->isAllowed( 'unreviewedpages' ) ) {
			$wgOut->permissionRequired( 'unreviewedpages' );
			return;
		}
		$this->skin = $wgUser->getSkin();
		$this->showList( $wgRequest );
	}

	function showList( $wgRequest ) {
		global $wgOut, $wgScript, $wgTitle, $wgFlaggedRevsNamespaces;

		$namespace = $wgRequest->getIntOrNull( 'namespace' );
		$category = trim( $wgRequest->getVal( 'category' ) );

		$action = htmlspecialchars( $wgScript );
		
		$wgOut->addHTML( "<form action=\"$action\" method=\"get\">\n" .
			'<fieldset><legend>' . wfMsg('oldreviewedpages-legend') . '</legend>');
		if( count($wgFlaggedRevsNamespaces) > 1 ) {
			$wgOut->addHTML( Xml::label( wfMsg("namespace"), 'namespace' ) . 
				FlaggedRevsXML::getNamespaceMenu( $namespace ) . '&nbsp;' );
		}
		$wgOut->addHTML( Xml::hidden( 'title', $wgTitle->getPrefixedText() ) .
			Xml::label( wfMsg("unreviewed-category"), 'category' ) .
			' ' . Xml::input( 'category', 35, $category, array('id' => 'category') ) .
			'&nbsp;&nbsp;' . Xml::submitButton( wfMsg( 'allpagessubmit' ) ) . "\n" .
			"</fieldset></form>" );
		
		$pager = new OldReviewedPagesPager( $this, $namespace, $category );
		if( $pager->getNumRows() ) {
			$wgOut->addHTML( wfMsgExt('oldreviewedpages-list', array('parse') ) );
			$wgOut->addHTML( $pager->getNavigationBar() );
			$wgOut->addHTML( "<ul>" . $pager->getBody() . "</ul>" );
			$wgOut->addHTML( $pager->getNavigationBar() );
		} else {
			$wgOut->addHTML( wfMsgExt('oldreviewedpages-none', array('parse') ) );
		}
	}
	
	function formatRow( $result ) {
		global $wgLang;
		
		$title = Title::makeTitle( $result->page_namespace, $result->page_title );
		$link = $this->skin->makeKnownLinkObj( $title );
		$css = $stxt = $review = '';
		if( !is_null($size = $result->page_len) ) {
			$stxt = ($size == 0) ? 
				wfMsgHtml('historyempty') : wfMsgHtml('historysize', $wgLang->formatNum( $size ) );
			$stxt = " <small>$stxt</small>";
		}
		$review = $this->skin->makeKnownLinkObj( $title, wfMsg('unreviewed-diff'),
				"diff=cur&oldid={$result->fp_stable}" );
		$quality = $result->fp_quality ? wfMsgHtml('oldreviewedpages-quality') : wfMsgHtml('oldreviewedpages-stable');
		# Is anybody watching?
		$uw = UnreviewedPages::usersWatching( $title );
		# Get how long the first unreviewed edit has been waiting...
		$firstPending = $title->getNextRevisionID($result->fp_stable);
		if( $firstPendingTime = Revision::getTimestampFromID($firstPending) ) {
			$currentTime = wfTimestamp( TS_UNIX ); // now
			$firstPendingTime = wfTimestamp( TS_UNIX, $firstPendingTime );
			$hours = ($currentTime - $firstPendingTime)/3600;
			// After three days, just use days
			if( $hours > (3*24) ) {
				$days = round($hours/24,0);
				$age = wfMsgExt('oldreviewedpages-days',array('parsemag'),$days);
			// If one or more hours, use hours
			} else if( $hours >= 1 ) {
				$hours = round($hours,0);
				$age = wfMsgExt('oldreviewedpages-hours',array('parsemag'),$hours);
			} else {
				$age = wfMsg('oldreviewedpages-recent'); // hot of the press :)
			}
			// Oh-noes!
			$css = self::getLineClass( $hours, $uw );
			$css = $css ? " class='$css'" : "";
		} else {
			$age = ""; // wtf?
		}
		$watching = $uw ? wfMsgExt("unreviewed-watched",array('parsemag'),$uw,$uw) : wfMsgHtml("unreviewed-unwatched");

		return( "<li{$css}>{$link} {$stxt} ({$review}) <i>{$age}</i> <strong>[{$quality}]</strong> {$watching}</li>" );
	}
	
	protected static function getLineClass( $hours, $uw ) {
		global $wgFlaggedRevsLongPending;
		if( !$uw ) {
			return 'fr-unreviewed-unwatched';
		}
		if( !is_array($wgFlaggedRevsLongPending) ) {
			return ($hours > $wgFlaggedRevsLongPending) ? 'fr-pending-long' : "";
		}
		# If an array, show variable colors
		if( $hours > $wgFlaggedRevsLongPending[2] )
			return 'fr-pending-long3';
		if( $hours > $wgFlaggedRevsLongPending[1] )
			return 'fr-pending-long2';
		if( $hours > $wgFlaggedRevsLongPending[0] )
			return 'fr-pending-long';
		# Default: none
		return "";
	}
}

/**
 * Query to list out unreviewed pages
 */
class OldReviewedPagesPager extends AlphabeticPager {
	public $mForm, $mConds;
	private $category, $namespace;

	function __construct( $form, $namespace, $category=NULL, $conds = array() ) {
		$this->mForm = $form;
		$this->mConds = $conds;
		# Must be a content page...
		global $wgFlaggedRevsNamespaces;
		if( !is_null($namespace) ) {
			$namespace = intval($namespace);
		}
		if( is_null($namespace) || !in_array($namespace,$wgFlaggedRevsNamespaces) ) {
			$namespace = empty($wgFlaggedRevsNamespaces) ? -1 : $wgFlaggedRevsNamespaces[0]; 	 
		}
		$this->namespace = $namespace;
		$this->category = $category ? str_replace(' ','_',$category) : NULL;
		
		parent::__construct();
	}

	function formatRow( $row ) {
		return $this->mForm->formatRow( $row );
	}

	function getQueryInfo() {
		$conds = $this->mConds;
		$tables = array( 'flaggedpages', 'page' );
		$fields = array('page_namespace','page_title','page_len','fp_stable','fp_quality','fp_page_id');
		$conds['fp_reviewed'] = 0;
		$conds[] = 'page_id = fp_page_id';
		$conds['page_namespace'] = $this->namespace;
		$useIndex = array('flaggedpages' => 'fp_reviewed_page','page' => 'PRIMARY');
		# Filter by category
		if( $this->category ) {
			$tables[] = 'categorylinks';
			$conds[] = 'cl_from = page_id';
			$conds['cl_to'] = $this->category;
			$useIndex['categorylinks'] = 'cl_from';
		}
		return array(
			'tables'  => $tables,
			'fields'  => $fields,
			'conds'   => $conds,
			'options' => array( 'USE INDEX' => $useIndex )
		);
	}

	function getIndexField() {
		return 'fp_page_id';
	}
}
