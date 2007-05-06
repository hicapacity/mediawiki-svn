<?php
# Copyright (C) 2004 Brion Vibber <brion@pobox.com>
# http://www.mediawiki.org/
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
# http://www.gnu.org/copyleft/gpl.html

/**
 *
 * @addtogroup SpecialPage
 */

/**
 * constructor
 */
function wfSpecialLog( $par = '' ) {
	global $wgRequest;
	$logReader = new LogReader( $wgRequest );
	if( $wgRequest->getVal( 'type' ) == '' && $par != '' ) {
		$logReader->limitType( $par );
	}
	$logViewer = new LogViewer( $logReader );
	$logViewer->show();
}

/**
 *
 * @addtogroup SpecialPage
 */
class LogReader {
	var $db, $joinClauses, $whereClauses;
	var $type = '', $user = '', $title = null, $pattern = false;

	/**
	 * @param WebRequest $request For internal use use a FauxRequest object to pass arbitrary parameters.
	 */
	function LogReader( $request ) {
		$this->db = wfGetDB( DB_SLAVE );
		$this->setupQuery( $request );
	}

	/**
	 * Basic setup and applies the limiting factors from the WebRequest object.
	 * @param WebRequest $request
	 * @private
	 */
	function setupQuery( $request ) {
		$page = $this->db->tableName( 'page' );
		$user = $this->db->tableName( 'user' );
		$this->joinClauses = array( 
			"LEFT OUTER JOIN $page ON log_namespace=page_namespace AND log_title=page_title",
			"INNER JOIN $user ON user_id=log_user" );
		$this->whereClauses = array();

		$this->limitType( $request->getVal( 'type' ) );
		$this->limitUser( $request->getText( 'user' ) );
		$this->limitTitle( $request->getText( 'page' ) , $request->getBool( 'pattern' ) );
		$this->limitTime( $request->getVal( 'from' ), '>=' );
		$this->limitTime( $request->getVal( 'until' ), '<=' );

		list( $this->limit, $this->offset ) = $request->getLimitOffset();
		
		// XXX This all needs to use Pager, ugly hack for now.
		global $wgMiserMode;
		if ($wgMiserMode && ($this->offset >10000)) $this->offset=10000;
	}

	/**
	 * Set the log reader to return only entries of the given type.
	 * Type restrictions enforced here
	 * @param string $type A log type ('upload', 'delete', etc)
	 * @private
	 */
	function limitType( $type ) {
		global $wgLogRestrictions, $wgUser;
		
		// Exclude logs this user can't see
		if( isset($wgLogRestrictions) ) {
			foreach ( $wgLogRestrictions as $logtype => $right ) {
				if ( !$wgUser->isAllowed( $right ) || empty( $type ) ) {
					$safetype = $this->db->strencode( $logtype );
					$this->whereClauses[] = "log_type <> '$safetype'";
				}
			}
			// Do not add to where clause if user can't see $type log
			if( isset($wgLogRestrictions[$type]) && !$wgUser->isAllowed( $wgLogRestrictions[$type] ) )
				return false;
		}
		
		if( empty( $type ) ) {
			return false;
		}
		
		$this->type = $type;
		$safetype = $this->db->strencode( $type );
		$this->whereClauses[] = "log_type='$safetype'";
	}

	/**
	 * Set the log reader to return only entries by the given user.
	 * @param string $name (In)valid user name
	 * @private
	 */
	function limitUser( $name ) {
		if ( $name == '' )
			return false;
		$usertitle = Title::makeTitleSafe( NS_USER, $name );
		if ( is_null( $usertitle ) )
			return false;
		$this->user = $usertitle->getText();
		
		/* Fetch userid at first, if known, provides awesome query plan afterwards */
		$userid = $this->db->selectField('user','user_id',array('user_name'=>$this->user));
		if (!$userid)
			/* It should be nicer to abort query at all, 
			   but for now it won't pass anywhere behind the optimizer */
			$this->whereClauses[] = "NULL";
		else
			$this->whereClauses[] = "log_user=$userid";
	}

	/**
	 * Set the log reader to return only entries affecting the given page.
	 * (For the block and rights logs, this is a user page.)
	 * @param string $page Title name as text
	 * @private
	 */
	function limitTitle( $page , $pattern ) {
		global $wgMiserMode;
		$title = Title::newFromText( $page );
		if( empty( $page ) || is_null( $title )  ) {
			return false;
		}
		$this->title =& $title;
		$this->pattern = $pattern;
		$ns = $title->getNamespace();
		if ( $pattern && !$wgMiserMode ) {
			$safetitle = $this->db->escapeLike( $title->getDBkey() ); // use escapeLike to avoid expensive search patterns like 't%st%'
			$this->whereClauses[] = "log_namespace=$ns AND log_title LIKE '$safetitle%'";
		} else {
			$safetitle = $this->db->strencode( $title->getDBkey() );
			$this->whereClauses[] = "log_namespace=$ns AND log_title = '$safetitle'";
		}
	}

	/**
	 * Set the log reader to return only entries in a given time range.
	 * @param string $time Timestamp of one endpoint
	 * @param string $direction either ">=" or "<=" operators
	 * @private
	 */
	function limitTime( $time, $direction ) {
		# Direction should be a comparison operator
		if( empty( $time ) ) {
			return false;
		}
		$safetime = $this->db->strencode( wfTimestamp( TS_MW, $time ) );
		$this->whereClauses[] = "log_timestamp $direction '$safetime'";
	}

	/**
	 * Build an SQL query from all the set parameters.
	 * @return string the SQL query
	 * @private
	 */
	function getQuery() {
		$logging = $this->db->tableName( "logging" );
		$sql = "SELECT /*! STRAIGHT_JOIN */ log_type, log_action, log_timestamp,
			log_user, user_name,
			log_id, log_deleted,
			log_namespace, log_title, page_id,
			log_comment, log_params FROM $logging ";
		if( !empty( $this->joinClauses ) ) {
			$sql .= implode( ' ', $this->joinClauses );
		}
		if( !empty( $this->whereClauses ) ) {
			$sql .= " WHERE " . implode( ' AND ', $this->whereClauses );
		}
		$sql .= " ORDER BY log_timestamp DESC ";
		$sql = $this->db->limitResult($sql, $this->limit, $this->offset );
		return $sql;
	}

	/**
	 * Execute the query and start returning results.
	 * @return ResultWrapper result object to return the relevant rows
	 */
	function getRows() {
		$res = $this->db->query( $this->getQuery(), 'LogReader::getRows' );
		return $this->db->resultObject( $res );
	}

	/**
	 * @return string The query type that this LogReader has been limited to.
	 */
	function queryType() {
		return $this->type;
	}

	/**
	 * @return string The username type that this LogReader has been limited to, if any.
	 */
	function queryUser() {
		return $this->user;
	}

	/**
	 * @return boolean The checkbox, if titles should be searched by a pattern too
	 */
	function queryPattern() {
		return $this->pattern;
	}

	/**
	 * @return string The text of the title that this LogReader has been limited to.
	 */
	function queryTitle() {
		if( is_null( $this->title ) ) {
			return '';
		} else {
			return $this->title->getPrefixedText();
		}
	}
	
	/**
	 * Returns a row of log data
	 * @param Title $title
	 * @param integer $logid, optional
	 * @private
	 */	
	function newFromTitle( $title, $logid=0 ) {
		$fname = 'LogReader::newFromTitle';

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'logging', array('*'),
			array('log_id' => intval( $logid ), 
				'log_namespace' => $title->getNamespace(), 
				'log_title' => $title->getDBkey() ), 
			$fname );

		if ( $res ) {
		   $ret = $dbr->fetchObject( $res );
		   if ( $ret ) {
		   	  return $ret;
			}
		} 
		return null;
	}
}

/**
 *
 * @addtogroup SpecialPage
 */
class LogViewer {
	const DELETED_ACTION = 1;
	const DELETED_COMMENT = 2;
	const DELETED_USER = 4;
    const DELETED_RESTRICTED = 8;
    
	/**
	 * @var LogReader $reader
	 */
	var $reader;
	var $numResults = 0;

	/**
	 * @param LogReader &$reader where to get our data from
	 */
	function LogViewer( &$reader ) {
		global $wgUser;
		$this->skin = $wgUser->getSkin();
		$this->reader =& $reader;
		$this->preCacheMessages();
	}
	
	/**
	 * As we use the same small set of messages in various methods and that
	 * they are called often, we call them once and save them in $this->message
	 */
	function preCacheMessages() {
		// Precache various messages
		if( !isset( $this->message ) ) {
			foreach( explode(' ', 'viewpagelogs revhistory imghistory rev-delundel' ) as $msg ) {
				$this->message[$msg] = wfMsgExt( $msg, array( 'escape') );
			}
		}
	}

	/**
	 * Take over the whole output page in $wgOut with the log display.
	 */
	function show() {
		global $wgOut;
		$this->showHeader( $wgOut );
		$this->showOptions( $wgOut );
		$result = $this->getLogRows();
		if ( $this->numResults > 0 ) {
			$this->showPrevNext( $wgOut );
			$this->doShowList( $wgOut, $result );
			$this->showPrevNext( $wgOut );
		} else {
			$this->showError( $wgOut );
		}
	}
	
	/**
	 * Determine if the current user is allowed to view a particular
	 * field of this event, if it's marked as deleted.
	 * @param int $field
	 * @return bool
	 */
	function userCan( $event, $field ) {
		if( ( $event->log_deleted & $field ) == $field ) {
			global $wgUser;
			$permission = ( $event->log_deleted & Revision::DELETED_RESTRICTED ) == Revision::DELETED_RESTRICTED
				? 'hiderevision'
				: 'deleterevision';
			wfDebug( "Checking for $permission due to $field match on $event->log_deleted\n" );
			return $wgUser->isAllowed( $permission );
		} else {
			return true;
		}
	}
	
	/**
	 * int $field one of DELETED_* bitfield constants
	 * @return bool
	 */
	function isDeleted( $event, $field ) {
		return ($event->log_deleted & $field) == $field;
	}
	
		/**
	 * Fetch event's user id if it's available to all users
	 * @return int
	 */
	function getUser( $event ) {
		if( $this->isDeleted( $event, Revision::DELETED_USER ) ) {
			return 0;
		} else {
			return $event->log_user;
		}
	}

	/**
	 * Fetch event's user id without regard for the current user's permissions
	 * @return string
	 */
	function getRawUser( $event ) {
		return $event->log_user;
	}

	/**
	 * Fetch event's username if it's available to all users
	 * @return string
	 */
	function getUserText( $event ) {
		if( $this->isDeleted( $event, Revision::DELETED_USER ) ) {
			return "";
		} else {
		  	if ( isset($event->user_name) ) {
		  	   return $event->user_name;
		  	} else {
			  return User::whoIs( $event->log_user );
			}
		}
	}

	/**
	 * Fetch event's username without regard for view restrictions
	 * @return string
	 */
	function getRawUserText( $event ) {
		if ( isset($event->user_name) ) {
			return $event->user_name;
		} else {
			return User::whoIs( $event->log_user );
		}
	}
	
	/**
	 * Fetch event comment if it's available to all users
	 * @return string
	 */
	function getComment( $event ) {
		if( $this->isDeleted( $event, Revision::DELETED_COMMENT ) ) {
			return "";
		} else {
			return $event->log_comment;
		}
	}

	/**
	 * Fetch event comment without regard for the current user's permissions
	 * @return string
	 */
	function getRawComment( $event ) {
		return $event->log_comment;
	}
	
	/**
	 * Returns the title of the page associated with this entry.
	 * @return Title
	 */
	function getTitle( $event ) {
		return Title::makeTitle( $event->log_namespace, $event->log_title );
	}

	/**
	 * Return the parsed log action text
	 * @return Title
	 */
	function logActionText( $log_type, $log_action, $title, $skin, $paramArray ) {
		return LogPage::actionText( $log_type, $log_action, $title, $this->skin, $paramArray, true, true );
	}

	/**
	 * Load the data from the linked LogReader
	 * Preload the link cache
	 * Initialise numResults
	 *
	 * Must be called before calling showPrevNext
	 *
	 * @return object database result set
	 */
	function getLogRows() {
		$result = $this->reader->getRows();
		$this->numResults = 0;

		// Fetch results and form a batch link existence query
		$batch = new LinkBatch;
		while ( $s = $result->fetchObject() ) {
			// User link
			$batch->addObj( Title::makeTitleSafe( NS_USER, $s->user_name ) );
			$batch->addObj( Title::makeTitleSafe( NS_USER_TALK, $s->user_name ) );

			// Move destination link
			if ( $s->log_type == 'move' ) {
				$paramArray = LogPage::extractParams( $s->log_params );
				$title = Title::newFromText( $paramArray[0] );
				$batch->addObj( $title );
			}
			++$this->numResults;
		}
		$batch->execute();

		return $result;
	}


	/**
	 * Output just the list of entries given by the linked LogReader,
	 * with extraneous UI elements. Use for displaying log fragments in
	 * another page (eg at Special:Undelete)
	 * @param OutputPage $out where to send output
	 */
	function showList( &$out ) {
		$result = $this->getLogRows();
		if ( $this->numResults > 0 ) {
			$this->doShowList( $out, $result );
		} else {
			$this->showError( $out );
		}
	}

	function doShowList( &$out, $result ) {
		// Rewind result pointer and go through it again, making the HTML
		$html = "\n<ul>\n";
		$result->seek( 0 );
		while( $s = $result->fetchObject() ) {
			$html .= $this->logLine( $s );
		}
		$html .= "\n</ul>\n";
		$out->addHTML( $html );
		$result->free();
	}

	function showError( &$out ) {
		$out->addWikiText( wfMsg( 'logempty' ) );
	}

	/**
	 * @param Object $s a single row from the result set
	 * @return string Formatted HTML list item
	 * @private
	 */
	function logLine( $s ) {
		global $wgLang, $wgUser;
		
		$skin = $wgUser->getSkin();
		$title = Title::makeTitle( $s->log_namespace, $s->log_title );
		$time = $wgLang->timeanddate( wfTimestamp(TS_MW, $s->log_timestamp), true );

		// Enter the existence or non-existence of this page into the link cache,
		// for faster makeLinkObj() in LogPage::actionText()
		$linkCache =& LinkCache::singleton();
		if( $s->page_id ) {
			$linkCache->addGoodLinkObj( $s->page_id, $title );
		} else {
			$linkCache->addBadLinkObj( $title );
		}
		// User links
		$userLink = $this->skin->logUserTools( $s, true );
		// Comment
		$comment = $this->skin->logComment( $s, true );
		
		$paramArray = LogPage::extractParams( $s->log_params );
		$revert = ''; $del = '';
		
		// Some user can hide log items and have review links
		if( $wgUser->isAllowed( 'deleterevision' ) ) {
			$del = $this->showhideLinks( $s, $title );
		}
		
		// Show restore/unprotect/unblock
		$revert = $this->showReviewLinks( $s, $title, $paramArray );
		
		// Event description
		if ( $s->log_deleted & self::DELETED_ACTION )
			$action = '<span class="history-deleted">' . wfMsgHtml('rev-deleted-event') . '</span>';
		else
			$action = $this->logActionText( $s->log_type, $s->log_action, $title, $this->skin, $paramArray );
		
		$out = "<li><tt>$del</tt> $time $userLink $action $comment $revert</li>\n";
		return $out;
	}

	/**
	 * @param $s, row object
	 * @param $s, title object
	 * @private
	 */
	function showhideLinks( $s, $title ) {
		$revdel = SpecialPage::getTitleFor( 'Revisiondelete' );
		if( !self::userCan( $s, Revision::DELETED_RESTRICTED ) ) {
		// If event was hidden from sysops
			$del = $this->message['rev-delundel'];
		} else if( $s->log_type == 'oversight' ) {
		// No one should be hiding from the oversight log
			$del = $this->message['rev-delundel'];
		} else {
			$del = $this->skin->makeKnownLinkObj( $revdel,
			$this->message['rev-delundel'],
			'target=' . urlencode( $title->getPrefixedDbkey() ) . '&logid=' . $s->log_id );
			// Bolden oversighted content
			if( self::isDeleted( $s, Revision::DELETED_RESTRICTED ) )
			$del = "<strong>$del</strong>";
		}
		return "(<small>$del</small>)";
	}

	/**
	 * @param $s, row object
	 * @param $title, title object
	 * @param $s, param array
	 * @private
	 */
	function showReviewLinks( $s, $title, $paramArray ) {
		global $wgUser;
		
		$reviewlink='';
		// Don't give away the page name
		if( self::isDeleted($s,self::DELETED_ACTION) )
			return $reviewlink;
		
		// Show revertmove link
		if( $s->log_type == 'move' && isset( $paramArray[0] ) ) {
			$destTitle = Title::newFromText( $paramArray[0] );
			if ( $destTitle ) {
				$revert = '(' . $this->skin->makeKnownLinkObj( SpecialPage::getTitleFor( 'Movepage' ),
					wfMsg( 'revertmove' ),
					'wpOldTitle=' . urlencode( $destTitle->getPrefixedDBkey() ) .
					'&wpNewTitle=' . urlencode( $title->getPrefixedDBkey() ) .
					'&wpReason=' . urlencode( wfMsgForContent( 'revertmove' ) ) .
					'&wpMovetalk=0' ) . ')';
			}
		// show undelete link
		} else if( $s->log_action == 'delete' && $wgUser->isAllowed( 'delete' ) ) {
			$reviewlink = $this->skin->makeKnownLinkObj( SpecialPage::getTitleFor( 'Undelete' ),
				wfMsg( 'undeletebtn' ) ,
				'target='. urlencode( $title->getPrefixedDBkey() ) );
		// show unblock link
		} elseif( $s->log_action == 'block' && $wgUser->isAllowed( 'block' ) ) {
			$reviewlink = $this->skin->makeKnownLinkObj( SpecialPage::getTitleFor( 'Ipblocklist' ),
				wfMsg( 'unblocklink' ),
				'action=unblock&ip=' . urlencode( $s->log_title ) );
		// show change protection link
		} elseif( $s->log_action == 'protect' && $wgUser->isAllowed( 'protect' ) ) {
			$reviewlink = $this->skin->makeKnownLink( $title->getPrefixedDBkey() ,
				wfMsg( 'protect_change' ),
				'action=unprotect' );
		// show user tool links for self created users
		} elseif( $s->log_action == 'create2' ) {
			$revert = $this->skin->userToolLinksRedContribs( $s->log_user, $s->log_title );
			// do not show $comment for self created accounts. It includes wrong user tool links:
			// 'blockip' for users w/o block allowance and broken links for very long usernames (bug 4756)
			$comment = '';
		// If an edit was hidden from a page give a review link to the history
		} else if( ($s->log_action=='revision' || $s->log_action=='event') && $wgUser->isAllowed( 'deleterevision' ) ) {
			$revdel = SpecialPage::getTitleFor( 'Revisiondelete' );
			$subtype = isset($paramArray[2]) ? $paramArray[1] : ''; // URL param
			
			switch ( $subtype ) {
				case 'oldid':
					$reviewlink = $this->skin->makeKnownLinkObj( $title, $this->message['revhistory'],
					wfArrayToCGI( array('action' => 'history' ) ) ) . ':';
					break;
				case 'arid':
					$undelete = SpecialPage::getTitleFor( 'Undelete' );
					$reviewlink = $this->skin->makeKnownLinkObj( $undelete, $this->message['revhistory'],
					wfArrayToCGI( array('target' => $title->getPrefixedText() ) ) ) . ':';	
					break;
				case 'oldimage':
					$reviewlink = $this->skin->makeKnownLink( $title->getPrefixedText().'#filehistory', 
					$this->message['imghistory'] ) . ':';
					break;		
				case 'fileid':
					$undelete = SpecialPage::getTitleFor( 'Undelete' );
					$reviewlink = $this->skin->makeKnownLinkObj( $undelete, $this->message['imghistory'],
					wfArrayToCGI( array('target' => $title->getPrefixedText() ) ) ) . ':';
					break;
				case 'logid':
					$undelete = SpecialPage::getTitleFor( 'Undelete' );
					$reviewlink = $this->skin->makeKnownLinkObj( $undelete, $this->message['imghistory'],
					wfArrayToCGI( array('target' => $title->getPrefixedText() ) ) ) . ':';
					break;
			}
			
			if ( $reviewlink ) {
				// Link to each hidden object ID, $paramArray[1] is the url param
				$Ids = explode( ',', $paramArray[2] );
				foreach ( $Ids as $n => $id ) {
					$reviewlink .= ' '.$this->skin->makeKnownLinkObj( $revdel, '#'.($n+1),
					wfArrayToCGI( array('target' => $paramArray[0], $paramArray[1] => $id ) ) );
				}
			}
		}
		$reviewlink = ( $reviewlink=='' ) ? "" : "&nbsp;&nbsp;&nbsp;($reviewlink) ";
		return $reviewlink;
	}

	/**
	 * @param OutputPage &$out where to send output
	 * @private
	 */
	function showHeader( &$out ) {
		$type = $this->reader->queryType();
		if( LogPage::isLogType( $type ) ) {
			$out->setPageTitle( LogPage::logName( $type ) );
			$out->addWikiText( LogPage::logHeader( $type ) );
		}
	}

	/**
	 * @param OutputPage &$out where to send output
	 * @private
	 */
	function showOptions( &$out ) {
		global $wgScript, $wgMiserMode;
		$action = htmlspecialchars( $wgScript );
		$title = SpecialPage::getTitleFor( 'Log' );
		$special = htmlspecialchars( $title->getPrefixedDBkey() );
		$out->addHTML( "<form action=\"$action\" method=\"get\">\n" .
			'<fieldset>' .
			Xml::element( 'legend', array(), wfMsg( 'log' ) ) .
			Xml::hidden( 'title', $special ) . "\n" .
			$this->getTypeMenu() . "\n" .
			$this->getUserInput() . "\n" .
			$this->getTitleInput() . "\n" .
			(!$wgMiserMode?($this->getTitlePattern()."\n"):"") .
			Xml::submitButton( wfMsg( 'allpagessubmit' ) ) . "\n" .
			"</fieldset></form>" );
	}

	/**
	 * @return string Formatted HTML
	 * @private
	 */
	function getTypeMenu() {
		global $wgLogRestrictions, $wgUser;
	
		$out = "<select name='type'>\n";

		$validTypes = LogPage::validTypes();
		$m = array(); // Temporary array

		// First pass to load the log names
		foreach( $validTypes as $type ) {
			$text = LogPage::logName( $type );
			$m[$text] = $type;
		}

		// Second pass to sort by name
		ksort($m);

		// Third pass generates sorted XHTML content
		foreach( $m as $text => $type ) {
			$selected = ($type == $this->reader->queryType());
			// Restricted types
			if ( isset($wgLogRestrictions[$type]) ) {
				if ( $wgUser->isAllowed( $wgLogRestrictions[$type] ) ) {
				$out .= Xml::option( $text, $type, $selected ) . "\n";
				}
			} else {
			$out .= Xml::option( $text, $type, $selected ) . "\n";
			}
		}

		$out .= '</select>';
		return $out;
	}

	/**
	 * @return string Formatted HTML
	 * @private
	 */
	function getUserInput() {
		$user =  $this->reader->queryUser();
		return Xml::inputLabel( wfMsg( 'specialloguserlabel' ), 'user', 'user', 12, $user );
	}

	/**
	 * @return string Formatted HTML
	 * @private
	 */
	function getTitleInput() {
		$title = $this->reader->queryTitle();
		return Xml::inputLabel( wfMsg( 'speciallogtitlelabel' ), 'page', 'page', 20, $title );
	}

	/**
	 * @return boolean Checkbox
	 * @private
	 */
	function getTitlePattern() {
		$pattern = $this->reader->queryPattern();
		return Xml::checkLabel( wfMsg( 'log-title-wildcard' ), 'pattern', 'pattern', $pattern );
	}

	/**
	 * @param OutputPage &$out where to send output
	 * @private
	 */
	function showPrevNext( &$out ) {
		global $wgContLang,$wgRequest;
		$pieces = array();
		$pieces[] = 'type=' . urlencode( $this->reader->queryType() );
		$pieces[] = 'user=' . urlencode( $this->reader->queryUser() );
		$pieces[] = 'page=' . urlencode( $this->reader->queryTitle() );
		$pieces[] = 'pattern=' . urlencode( $this->reader->queryPattern() );
		$bits = implode( '&', $pieces );
		list( $limit, $offset ) = $wgRequest->getLimitOffset();

		# TODO: use timestamps instead of offsets to make it more natural
		# to go huge distances in time
		$html = wfViewPrevNext( $offset, $limit,
			$wgContLang->specialpage( 'Log' ),
			$bits,
			$this->numResults < $limit);
		$out->addHTML( '<p>' . $html . '</p>' );
	}
}

/**
 * Aliases for backwards compatibility with 1.6
 */
define( 'MW_LOG_DELETED_ACTION', LogViewer::DELETED_ACTION );
define( 'MW_LOG_DELETED_USER', LogViewer::DELETED_USER );
define( 'MW_LOG_DELETED_COMMENT', LogViewer::DELETED_COMMENT );
define( 'MW_LOG_DELETED_RESTRICTED', LogViewer::DELETED_RESTRICTED );

?>
