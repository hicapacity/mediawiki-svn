<?php
#(c) Aaron Schulz, Joerg Baach, 2007 GPL

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}

class RevisionReview extends UnlistedSpecialPage
{
    function __construct() {
        UnlistedSpecialPage::UnlistedSpecialPage( 'RevisionReview', 'review' );
    }

    function execute( $par ) {
        global $wgRequest, $wgUser, $wgOut;

		$confirm = $wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) );

		if( $wgUser->isAllowed( 'review' ) ) {
			if( $wgUser->isBlocked( !$confirm ) ) {
				$wgOut->blockedPage();
				return;
			}
		} else {
			$wgOut->permissionRequired( 'review' );
			return;
		}
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		$this->setHeaders();
		# Our target page
		$this->target = $wgRequest->getVal( 'target' );
		$this->page = Title::newFromUrl( $this->target );
		# Basic patrolling
		$this->patrolonly = $wgRequest->getBool( 'patrolonly' );
		$this->rcid = $wgRequest->getIntOrNull( 'rcid' );
		# Param for sites with no tags, otherwise discarded
		$this->approve = $wgRequest->getBool( 'wpApprove' );

		if( is_null($this->page) ) {
			$wgOut->showErrorPage('notargettitle', 'notargettext' );
			return;
		}
		
		# Patrol the edit if requested
		if( $this->patrolonly && $this->rcid ) {
			$this->markPatrolled( $wgRequest->getVal('token') );
			return;
		}

		global $wgFlaggedRevTags, $wgFlaggedRevValues;
		# Revision ID
		$this->oldid = $wgRequest->getIntOrNull( 'oldid' );
		if( !$this->oldid || !FlaggedRevs::isPageReviewable( $this->page ) ) {
			$wgOut->addHTML( wfMsgExt('revreview-main',array('parse')) );
			return;
		}
		# Check if page is protected
		if( !$this->page->quickUserCan( 'edit' ) ) {
			$wgOut->permissionRequired( 'badaccess-group0' );
			return;
		}
		# Special parameter mapping
		$this->templateParams = $wgRequest->getVal( 'templateParams' );
		$this->imageParams = $wgRequest->getVal( 'imageParams' );
		$this->validatedParams = $wgRequest->getVal( 'validatedParams' );
		
		# Special token to discourage fiddling...
		$checkCode = self::getValidationKey( $this->templateParams, $this->imageParams, $wgUser->getID(), $this->oldid );
		# Must match up
		if( $this->validatedParams !== $checkCode ) {
			$this->templateParams = '';
			$this->imageParams = '';
		}
		
		# Log comment
		$this->comment = $wgRequest->getText( 'wpReason' );
		# Additional notes (displayed at bottom of page)
		$this->notes = ( FlaggedRevs::allowComments() && $wgUser->isAllowed('validate') ) ?
			$wgRequest->getText('wpNotes') : '';
		# Get the revision's current flags, if any
		$this->oflags = FlaggedRevs::getRevisionTags( $this->page, $this->oldid );
		# Get our accuracy/quality dimensions
		$this->dims = array();
		$this->unapprovedTags = 0;
		foreach( $wgFlaggedRevTags as $tag => $minQL ) {
			$this->dims[$tag] = $wgRequest->getIntOrNull( "wp$tag" );
			if( $this->dims[$tag] === 0 ) {
				$this->unapprovedTags++;
			} else if( is_null($this->dims[$tag]) ) {
				# This happens if we uncheck a checkbox
				$this->unapprovedTags++;
				$this->dims[$tag] = 0;
			}
		}
		# Check permissions and validate
		if( !$this->userCanSetFlags( $this->dims, $this->oflags ) ) {
			$wgOut->permissionRequired( 'badaccess-group0' );
			return;
		}
		# We must at least rate each category as 1, the minimum
		# Exception: we can rate ALL as unapproved to depreciate a revision
		$valid = true;
		if( $this->unapprovedTags > 0 ) {
			if( $this->unapprovedTags < count($wgFlaggedRevTags) )
				$valid = false;
		}
		if( !$wgUser->matchEditToken( $wgRequest->getVal('wpEditToken') ) )
			$valid = false;

		if( $valid && $wgRequest->wasPosted() ) {
			$this->submit();
		} else {
			$this->showRevision();
		}
	}
	
	/**
	* Get a validation key from versioning metadata
	* @param string $tmpP
	* @param string $imgP
	* @param integer $uid user ID
	* @param integer $rid rev ID
	* @return string
	*/
	public static function getValidationKey( $tmpP, $imgP, $uid, $rid ) {
		global $wgReviewCodes;
		# Fall back to $wgSecretKey/$wgProxyKey
		if( empty($wgReviewCodes) ) {
			global $wgSecretKey, $wgProxyKey;
			$key = $wgSecretKey ? $wgSecretKey : $wgProxyKey;
			$p = md5($key.$uid.$imgP.$tmpP.$rid);
		} else {
			$p = md5($wgReviewCodes[0].$uid.$imgP.$rid.$tmpP.$wgReviewCodes[1]);
		}
		return $p;
	}

	/**
	 * Returns true if a user can do something
	 * @param string $tag
	 * @param int $value
	 * @returns bool
	 */
	public static function userCan( $tag, $value ) {
		global $wgFlagRestrictions, $wgUser;

		if( !isset($wgFlagRestrictions[$tag]) )
			return true;
		# Validators always have full access
		if( $wgUser->isAllowed('validate') )
			return true;
		# Check if this user has any right that lets him/her set
		# up to this particular value
		foreach( $wgFlagRestrictions[$tag] as $right => $level ) {
			if( $value <= $level && $level > 0 && $wgUser->isAllowed($right) ) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Returns true if a user can set $flags.
	 * This checks if the user has the right to review
	 * to the given levels for each tag.
	 * @param array $flags, suggested flags
	 * @param array $oldflags, pre-existing flags
	 * @returns bool
	 */
	public static function userCanSetFlags( $flags, $oldflags = array() ) {
		global $wgUser, $wgFlaggedRevTags, $wgFlaggedRevValues;
		
		if( !$wgUser->isAllowed('review') ) {
			return false;
		}
		# Check if all of the required site flags have a valid value
		# that the user is allowed to set.
		foreach( $wgFlaggedRevTags as $qal => $minQL ) {
			$level = isset($flags[$qal]) ? $flags[$qal] : 0;
			if( !self::userCan($qal,$level) ) {
				return false;
			} else if( isset($oldflags[$qal]) && !self::userCan($qal,$oldflags[$qal]) ) {
				return false;
			} else if( $level < 0 || $level > $wgFlaggedRevValues ) {
				return false;
			}
		}
		return true;
	}

	private function markPatrolled( $token ) {
		global $wgOut, $wgUser;

		$wgOut->setPageTitle( wfMsg( 'revreview-patrol-title' ) );
		# Prevent hijacking
		if( !$wgUser->matchEditToken( $token, $this->page->getPrefixedText(), $this->rcid ) ) {
			$wgOut->addWikiText( wfMsg('sessionfailure') );
			return;
		}
		# Make sure page is not reviewable. This can be spoofed in theory,
		# but the token is salted with the id and title and this should
		# be a trusted user...so it is not really worth doing extra query
		# work over.
		if( FlaggedRevs::isPageReviewable( $this->page ) ) {
			$wgOut->showErrorPage('notargettitle', 'notargettext' );
			return;
		}
		# Mark as patrolled
		$changed = RecentChange::markPatrolled( $this->rcid );
		if( $changed ) {
			PatrolLog::record( $this->rcid );
		}
		# Inform the user
		$wgOut->addWikiText( wfMsg( 'revreview-patrolled', $this->page->getPrefixedText() ) );
		$wgOut->returnToMain( false, SpecialPage::getTitleFor( 'Recentchanges' ) );
	}

	/**
	 * Show revision review form
	 */
	private function showRevision() {
		global $wgOut, $wgUser, $wgTitle, $wgFlaggedRevComments, $wgFlaggedRevsOverride,
			$wgFlaggedRevTags, $wgFlaggedRevValues;

		if( $this->unapprovedTags )
			$wgOut->addWikiText( '<strong>' . wfMsg( 'revreview-toolow' ) . '</strong>' );

		$wgOut->addWikiText( wfMsg( 'revreview-selected', $this->page->getPrefixedText() ) );

		$this->skin = $wgUser->getSkin();
		$rev = Revision::newFromTitle( $this->page, $this->oldid );
		# Check if rev exists
		# Do not mess with deleted revisions
		if( !isset( $rev ) || $rev->mDeleted ) {
			$wgOut->showErrorPage( 'internalerror', 'notargettitle', 'notargettext' );
			return;
		}

		$wgOut->addHtml( "<ul>" );
		$wgOut->addHtml( $this->historyLine( $rev ) );
		$wgOut->addHtml( "</ul>" );

		if( $wgFlaggedRevsOverride )
			$wgOut->addWikiText( wfMsg('revreview-text') );

		$formradios = array();
		# Dynamically contruct our radio options
		foreach( $wgFlaggedRevTags as $tag => $minQL ) {
			$formradios[$tag] = array();
			for ($i=0; $i <= $wgFlaggedRevValues; $i++) {
				$formradios[$tag][] = array( "revreview-$tag-$i", "wp$tag", $i );
			}
		}
		$hidden = array(
			Xml::hidden( 'wpEditToken', $wgUser->editToken() ),
			Xml::hidden( 'target', $this->page->getPrefixedText() ),
			Xml::hidden( 'oldid', $this->oldid ) );

		$action = $wgTitle->escapeLocalUrl( 'action=submit' );
		$form = "<form name='RevisionReview' action='$action' method='post'>";
		$form .= '<fieldset><legend>' . wfMsgHtml( 'revreview-legend' ) . '</legend><table><tr>';
		# Dynamically contruct our review types
		foreach( $wgFlaggedRevTags as $tag => $minQL ) {
			$form .= '<td><strong>' . wfMsgHtml( "revreview-$tag" ) . '</strong></td><td width=\'20\'></td>';
		}
		$form .= '</tr><tr>';
		foreach( $formradios as $set => $ratioset ) {
			$form .= '<td>';
			foreach( $ratioset as $item ) {
				list( $message, $name, $field ) = $item;
				# Don't give options the user can't set unless its the status quo
				$attribs = array('id' => $name.$field);
				if( !$this->userCan($set,$field) )
					$attribs['disabled'] = 'true';
				$form .= "<div>";
				$form .= Xml::radio( $name, $field, ($field==$this->dims[$set]), $attribs );
				$form .= Xml::label( wfMsg($message), $name.$field );
				$form .= "</div>\n";
			}
			$form .= '</td><td width=\'20\'></td>';
		}
		$form .= '</tr></table></fieldset>';
		# Add box to add live notes to a flagged revision
		if( $wgFlaggedRevComments && $wgUser->isAllowed( 'validate' ) ) {
			$form .= "<fieldset><legend>" . wfMsgHtml( 'revreview-notes' ) . "</legend>" .
			"<textarea tabindex='1' name='wpNotes' id='wpNotes' rows='3' cols='80' style='width:100%'>" .
			htmlspecialchars( $this->notes ) .
			"</textarea>" .
			"</fieldset>";
		}

		$form .= '<fieldset><legend>' . wfMsgHtml('revisionreview') . '</legend>';
		$form .= '<p>'.Xml::inputLabel( wfMsg( 'revreview-log' ), 'wpReason', 'wpReason', 60 ).'</p>';
		$form .= '<p>'.Xml::submitButton( wfMsg( 'revreview-submit' ) ).'</p>';
		foreach( $hidden as $item ) {
			$form .= $item;
		}
		# Hack, versioning params
		$form .= Xml::hidden( 'templateParams', $this->templateParams ) . "\n";
		$form .= Xml::hidden( 'imageParams', $this->imageParams ) . "\n";
		$form .= Xml::hidden( 'wpApprove', $this->approve ) . "\n";
		$form .= Xml::hidden( 'rcid', $this->rcid ) . "\n";
		# Special token to discourage fiddling...
		$checkCode = self::getValidationKey( $this->templateParams, $this->imageParams, $wgUser->getID(), $rev->getId() );
		$form .= Xml::hidden( 'validatedParams', $checkCode );
		$form .= '</fieldset>';

		$form .= '</form>';
		$wgOut->addHtml( $form );
	}

	/**
	 * @param Revision $rev
	 * @return string
	 */
	private function historyLine( $rev ) {
		global $wgContLang;
		$date = $wgContLang->timeanddate( $rev->getTimestamp() );

		$difflink = '(' . $this->skin->makeKnownLinkObj( $this->page, wfMsgHtml('diff'),
		'&diff=' . $rev->getId() . '&oldid=prev' ) . ')';

		$revlink = $this->skin->makeLinkObj( $this->page, $date, 'oldid=' . $rev->getId() );

		return
			"<li> $difflink $revlink " . $this->skin->revUserLink( $rev ) . " " . $this->skin->revComment( $rev ) . "</li>";
	}

	private function submit() {
		global $wgOut, $wgUser, $wgFlaggedRevTags;
		# If all values are set to zero, this has been unapproved
		$approved = empty($wgFlaggedRevTags) && $this->approve;
		foreach( $this->dims as $quality => $value ) {
			if( $value ) {
				$approved = true;
				break;
			}
		}
		# We can only approve actual revisions...
		if( $approved ) {
			$rev = Revision::newFromTitle( $this->page, $this->oldid );
			# Do not mess with archived/deleted revisions
			if( is_null($rev) || $rev->mDeleted ) {
				$wgOut->showErrorPage( 'internalerror', 'revnotfoundtext' );
				return;
			}
		# We can only unapprove approved revisions...
		} else {
			$frev = FlaggedRevs::getFlaggedRev( $this->page, $this->oldid );
			# If we can't find this flagged rev, return to page???
			if( is_null($frev) ) {
				$wgOut->redirect( $this->page->getFullUrl() );
				return;
			}
		}

		$success = $approved ? $this->approveRevision( $rev ) : $this->unapproveRevision( $frev );
		# Return to our page
		if( $success ) {
			global $wgFlaggedRevsOverride;

			$wgOut->setPageTitle( wfMsgHtml('actioncomplete') );
			
			# Show success message
			$msg = $approved ? 'revreview-successful' : 'revreview-successful2';
			$wgOut->addHtml( "<div class='plainlinks'>" .wfMsgExt( $msg, array('parseinline'), 
				$this->page->getPrefixedText(), $this->page->getPrefixedUrl() ) );
			if( $wgFlaggedRevsOverride ) {
				$wgOut->addHtml( '<p>'.wfMsgExt( 'revreview-text', array('parseinline') ).'</p>' );
			} else {
				$wgOut->addHtml( '<p>'.wfMsgExt( 'revreview-text2', array('parseinline') ).'</p>' );
			}
			$msg = $approved ? 'revreview-stable1' : 'revreview-stable2';
			$id = $approved ? $rev->getId() : $frev->getRevId();
			$wgOut->addHtml( '<p>'.wfMsgExt( $msg, array('parseinline'), $this->page->getPrefixedUrl(), $id ).'</p>' );
			$wgOut->addHtml( "</div>" );

			if( $wgUser->isAllowed( 'unreviewedpages' ) ) {
				$wgOut->returnToMain( false, SpecialPage::getTitleFor( 'UnreviewedPages' ) );
				$wgOut->returnToMain( false, SpecialPage::getTitleFor( 'OldReviewedPages' ) );
			}
			# Watch page if set to do so
			if( $wgUser->getOption('flaggedrevswatch') && !$this->page->userIsWatching() ) {
				$wgUser->addWatch( $this->page );
			}
		} else {
			$wgOut->showErrorPage( 'internalerror', 'revreview-changed', array($this->page->getPrefixedText()) );
		}
	}

	/**
	 * Adds or updates the flagged revision table for this page/id set
	 * @param Revision $rev
	 */
	private function approveRevision( $rev ) {
		global $wgUser, $wgParser, $wgRevisionCacheExpiry, $wgMemc;

		wfProfileIn( __METHOD__ );
		# Get the page this corresponds to
		$title = $rev->getTitle();

		$quality = 0;
		if( FlaggedRevs::isQuality($this->dims) ) {
			$quality = FlaggedRevs::isPristine($this->dims) ? 2 : 1;
		}
		# Our flags
		$flags = $this->dims;

		# Some validation vars to make sure nothing changed during
		$lastTempID = 0;
		$lastImgTime = "0";

		# Our template version pointers
		$tmpset = $tmpParams = array();
		$templateMap = explode('#',trim($this->templateParams) );
		foreach( $templateMap as $template ) {
			if( !$template )
				continue;

			$m = explode('|',$template,2);
			if( !isset($m[0]) || !isset($m[1]) || !$m[0] )
				continue;

			list($prefixed_text,$rev_id) = $m;

			$tmp_title = Title::newFromText( $prefixed_text ); // Normalize this to be sure...
			if( is_null($title) )
				continue; // Page must be valid!

			if( $rev_id > $lastTempID )
				$lastTempID = $rev_id;

			$tmpset[] = array(
				'ft_rev_id' => $rev->getId(),
				'ft_namespace' => $tmp_title->getNamespace(),
				'ft_title' => $tmp_title->getDBkey(),
				'ft_tmp_rev_id' => $rev_id
			);
			if( !isset($tmpParams[$tmp_title->getNamespace()]) ) {
				$tmpParams[$tmp_title->getNamespace()] = array();
			}
			$tmpParams[$tmp_title->getNamespace()][$tmp_title->getDBkey()] = $rev_id;
		}
		# Our image version pointers
		$imgset = $imgParams = array();
		$imageMap = explode('#',trim($this->imageParams) );
		# If this is an image page, store corresponding file info
		$fileData = array();
		foreach( $imageMap as $image ) {
			if( !$image )
				continue;
			$m = explode('|',$image,3);
			# Expand our parameters ... <name>#<timestamp>#<key>
			if( !isset($m[0]) || !isset($m[1]) || !isset($m[2]) || !$m[0] )
				continue;

			list($dbkey,$timestamp,$key) = $m;

			$img_title = Title::makeTitle( NS_IMAGE, $dbkey ); // Normalize
			if( is_null($img_title) )
				continue; // Page must be valid!

			# Is this parameter for THIS image itself?
			if( $title->equals($img_title) ) {
				$fileData['name'] = $img_title->getDBkey();
				$fileData['timestamp'] = $timestamp;
				$fileData['sha1'] = $key;
				continue;
			}

			if( $timestamp > $lastImgTime )
				$lastImgTime = $timestamp;

			$imgset[] = array(
				'fi_rev_id' => $rev->getId(),
				'fi_name' => $img_title->getDBkey(),
				'fi_img_timestamp' => $timestamp,
				'fi_img_sha1' => $key
			);
			if( !isset($imgParams[$img_title->getDBkey()]) ) {
				$imgParams[$img_title->getDBkey()] = array();
			}
			$imgParams[$img_title->getDBkey()][$timestamp] = $key;
		}
		
		$article = new Article( $this->page );
		# Is this rev already flagged?
		$flaggedOutput = false;
		if( $oldfrev = FlaggedRevs::getFlaggedRev( $title, $rev->getId(), true, true ) ) {
			$flaggedOutput = FlaggedRevs::parseStableText( $article, $oldfrev->getExpandedText(), $oldfrev->getRevId() );
		}
		# Set our versioning params cache
		FlaggedRevs::setIncludeVersionCache( $rev->getId(), $tmpParams, $imgParams );
        # Get the expanded text and resolve all templates.
		# Store $templateIDs and add it to final parser output later...
        list($fulltext,$tmps,$tmpIDs,$ok,$maxID) = FlaggedRevs::expandText( $rev->getText(), $rev->getTitle(), $rev->getId() );
        if( !$ok || $maxID > $lastTempID ) {
			wfProfileOut( __METHOD__ );
        	return false;
        }
		
		# Parse the rest and check if it matches up
		$stableOutput = FlaggedRevs::parseStableText( $article, $fulltext, $rev->getId(), false );
		if( !$stableOutput->fr_includesMatched || $stableOutput->fr_newestImageTime > $lastImgTime ) {
			wfProfileOut( __METHOD__ );
        	return false;
        }
		# Merge in template params from first phase of parsing...
		$this->mergeTemplateParams( $stableOutput, $tmps, $tmpIDs, $maxID );
		
		# Clear our versioning params cache
		FlaggedRevs::clearIncludeVersionCache( $rev->getId() );
		
		# Is this a duplicate review?
		if( $oldfrev && $flaggedOutput ) {
			$synced = true;
			if( $stableOutput->fr_newestImageTime != $flaggedOutput->fr_newestImageTime )
				$synced = false;
			if( $stableOutput->fr_newestTemplateID != $flaggedOutput->fr_newestTemplateID )
				$synced = false;
			if( $oldfrev->getTags() != $flags )
				$synced = false;
			if( $oldfrev->getFileSha1() != @$fileData['sha1'] )
				$synced = false;
			# Don't review if the same
			if( $synced ) {
				wfProfileOut( __METHOD__ );
				return true;
			}
		} 
		
        # Compress $fulltext, passed by reference
        $textFlags = FlaggedRevision::compressText( $fulltext );

		# Write to external storage if required
		$storage = FlaggedRevs::getExternalStorage();
		if( $storage ) {
			if( is_array($storage) ) {
				# Distribute storage across multiple clusters
				$store = $storage[mt_rand(0, count( $storage ) - 1)];
			} else {
				$store = $storage;
			}
			# Store and get the URL
			$fulltext = ExternalStore::insert( $store, $fulltext );
			if( !$fulltext ) {
				# This should only happen in the case of a configuration error, where the external store is not valid
				wfProfileOut( __METHOD__ );
				throw new MWException( "Unable to store text to external storage $store" );
			}
			if( $textFlags ) {
				$textFlags .= ',';
			}
			$textFlags .= 'external';
		}

		$dbw = wfGetDB( DB_MASTER );
		# Our review entry
 		$revset = array(
 			'fr_rev_id'        => $rev->getId(),
 			'fr_page_id'       => $title->getArticleID(),
			'fr_user'          => $wgUser->getId(),
			'fr_timestamp'     => $dbw->timestamp( wfTimestampNow() ),
			'fr_comment'       => $this->notes,
			'fr_quality'       => $quality,
			'fr_tags'          => FlaggedRevision::flattenRevisionTags( $flags ),
			'fr_text'          => $fulltext, # Store expanded text for speed
			'fr_flags'         => $textFlags,
			'fr_img_name'      => $fileData ? $fileData['name'] : null,
			'fr_img_timestamp' => $fileData ? $fileData['timestamp'] : null,
			'fr_img_sha1'      => $fileData ? $fileData['sha1'] : null
		);
		
		# Start!
		$dbw->begin();
		# Update flagged revisions table
		$dbw->replace( 'flaggedrevs', array( array('fr_page_id','fr_rev_id') ), $revset, __METHOD__ );
		# Clear out any previous garbage.
		# We want to be able to use this for tracking...
		$dbw->delete( 'flaggedtemplates',
			array('ft_rev_id' => $rev->getId() ),
			__METHOD__ );
		$dbw->delete( 'flaggedimages',
			array('fi_rev_id' => $rev->getId() ),
			__METHOD__ );
		# Update our versioning params
		if( !empty($tmpset) ) {
			$dbw->insert( 'flaggedtemplates', $tmpset, __METHOD__, 'IGNORE' );
		}
		if( !empty($imgset) ) {
			$dbw->insert( 'flaggedimages', $imgset, __METHOD__, 'IGNORE' );
		}
		$dbw->commit();
		
		# Kill any text cache
		if( $wgRevisionCacheExpiry ) {
			$key = wfMemcKey( 'flaggedrevisiontext', 'revid', $rev->getId() );
			$wgMemc->delete( $key );
		}
		
		# Update recent changes
		$this->updateRecentChanges( $title, $dbw, $rev, $this->rcid );

		# Update the article review log
		$this->updateLog( $this->page, $this->dims, $this->oflags, $this->comment, $this->oldid, true );

		# Update the links tables as the stable version may now be the default page.
		# Try using the parser cache first since we didn't actually edit the current version.
		$parserCache = ParserCache::singleton();
		$poutput = $parserCache->get( $article, $wgUser );
		if( $poutput==false ) {
			$text = $article->getContent();
			$options = FlaggedRevs::makeParserOptions( $wgUser );
			$poutput = $wgParser->parse( $text, $article->mTitle, $options );
		}
		# If we know that this is now the new stable version 
		# (which it probably is), save it to the stable cache...
		$sv = FlaggedRevs::getStablePageRev( $this->page, false, true );
		if( $sv && $sv->getRevId() == $rev->getId() ) {
			# Clear the cache...
			$this->page->invalidateCache();
			# Update stable cache with the revision we reviewed
			FlaggedRevs::updatePageCache( $article, $stableOutput );
		} else {
			# Get the old stable cache
			$stableOutput = FlaggedRevs::getPageCache( $article );
			# Clear the cache...(for page histories)
			$this->page->invalidateCache();
			if( $stableOutput !== false ) {
				# Reset stable cache if it existed, since we know it is the same.
				FlaggedRevs::updatePageCache( $article, $stableOutput );
			}
		}
		$u = new LinksUpdate( $this->page, $poutput );
		$u->doUpdate(); // Will trigger our hook to add stable links too...
		# Might as well save the cache, since it should be the same
		global $wgEnableParserCache;
		if( $wgEnableParserCache )
			$parserCache->save( $poutput, $article, $wgUser );
		# Purge squid for this page only
		$article->getTitle()->purgeSquid();

		wfProfileOut( __METHOD__ );
        return true;
    }

	/**
	 * @param FlaggedRevision $frev
	 * Removes flagged revision data for this page/id set
	 */
	private function unapproveRevision( $frev ) {
		global $wgUser, $wgParser, $wgRevisionCacheExpiry, $wgMemc;

		$user = $wgUser->getId();

		wfProfileIn( __METHOD__ );
		
        $dbw = wfGetDB( DB_MASTER );
		# Delete from flaggedrevs table
		$dbw->delete( 'flaggedrevs',
			array( 'fr_page_id' => $this->page->getArticleID(), 'fr_rev_id' => $frev->getRevId() ) );
		# Wipe versioning params
		$dbw->delete( 'flaggedtemplates', array( 'ft_rev_id' => $frev->getRevId() ) );
		$dbw->delete( 'flaggedimages', array( 'fi_rev_id' => $frev->getRevId() ) );

		# Update the article review log
		$this->updateLog( $this->page, $this->dims, $this->oflags, $this->comment, $this->oldid, false );

		# Kill any text cache
		if( $wgRevisionCacheExpiry ) {
			$key = wfMemcKey( 'flaggedrevisiontext', 'revid', $frev->getRevId() );
			$wgMemc->delete( $key );
		}

		$article = new Article( $this->page );
		# Update the links tables as a new stable version
		# may now be the default page.
		$parserCache = ParserCache::singleton();
		$poutput = $parserCache->get( $article, $wgUser );
		if( $poutput==false ) {
			$text = $article->getContent();
			$options = FlaggedRevs::makeParserOptions( $wgUser );
			$poutput = $wgParser->parse( $text, $article->mTitle, $options );
		}
		$u = new LinksUpdate( $this->page, $poutput );
		$u->doUpdate();

		# Clear the cache...
		$this->page->invalidateCache();
		# Might as well save the cache
		global $wgEnableParserCache;
		if( $wgEnableParserCache )
			$parserCache->save( $poutput, $article, $wgUser );
		# Purge squid for this page only
		$this->page->purgeSquid();

		wfProfileOut( __METHOD__ );

        return true;
    }
	
	private function updateRecentChanges( $title, $dbw, $rev, $rcid ) {
		wfProfileIn( __METHOD__ );
		# Should olders edits be marked as patrolled now?
		global $wgFlaggedRevsCascade;
		if( $wgFlaggedRevsCascade ) {
			$dbw->update( 'recentchanges',
				array( 'rc_patrolled' => 1 ),
				array( 'rc_namespace' => $title->getNamespace(),
					'rc_title' => $title->getDBKey(),
					'rc_this_oldid <= ' . $rev->getId() ),
				__METHOD__,
				array( 'USE INDEX' => 'rc_namespace_title', 'LIMIT' => 50 ) );
		} else {
			# Mark this edit as patrolled...
			$dbw->update( 'recentchanges',
				array( 'rc_patrolled' => 1 ),
				array( 'rc_this_oldid' => $rev->getId(),
					'rc_user_text' => $rev->getRawUserText(),
					'rc_timestamp' => $dbw->timestamp( $rev->getTimestamp() ) ),
				__METHOD__,
				array( 'USE INDEX' => 'rc_user_text', 'LIMIT' => 1 ) );
			# New page patrol may be enabled. If so, the rc_id may be the first
			# edit and not this one. If it is different, mark it too.
			if( $rcid && $rcid != $rev->getId() ) {
				$dbw->update( 'recentchanges',
					array( 'rc_patrolled' => 1 ),
					array( 'rc_id' => $rcid,
						'rc_type' => RC_NEW ),
					__METHOD__ );
			}
		}
		wfProfileOut( __METHOD__ );
	}
	
	private function mergeTemplateParams( $pout, $tmps, $tmpIds, $maxID ) {
		foreach( $tmps as $ns => $dbkey_id ) {
			foreach( $dbkey_id as $dbkey => $pageid ) {
				if( !isset($pout->mTemplates[$ns]) )
					$pout->mTemplates[$ns] = array();
				# Add in this template; overrides
				$pout->mTemplates[$ns][$dbkey] = $pageid;
			}
		}
		# Merge in template params from first phase of parsing...
		foreach( $tmpIds as $ns => $dbkey_id ) {
			foreach( $dbkey_id as $dbkey => $revid ) {
				if( !isset($pout->mTemplateIds[$ns]) )
					$pout->mTemplateIds[$ns] = array();
				# Add in this template; overrides
				$pout->mTemplateIds[$ns][$dbkey] = $revid;
			}
		}
		if( $maxID > $pout->fr_newestTemplateID ) {
			$pout->fr_newestTemplateID = $maxID;
		}
	}

	/**
	 * Record a log entry on the action
	 * @param Title $title
	 * @param array $dims
	 * @param array $oldDims
	 * @param string $comment
	 * @param int $revid
	 * @param bool $approve
	 * @param bool $auto
	 */
	public static function updateLog( $title, $dims, $oldDims, $comment, $oldid, $approve, $auto=false ) {
		global $wgFlaggedRevsLogInRC;
		$putInRC = $auto ? false : $wgFlaggedRevsLogInRC; // don't put these in RC
		$log = new LogPage( 'review', $putInRC );
		# ID, accuracy, depth, style
		$ratings = array();
		foreach( $dims as $quality => $level ) {
			$ratings[] = wfMsgForContent( "revreview-$quality" ) . ": " . wfMsgForContent("revreview-$quality-$level");
		}
		# Append comment with ratings
		if( $approve ) {
			$rating = !empty($ratings) ? '[' . implode(', ',$ratings). ']' : '';
			$comment .= $comment ? " $rating" : $rating;
		}
		if( $approve ) {
			$action = (FlaggedRevs::isQuality($dims) || FlaggedRevs::isQuality($oldDims)) ? 'approve2' : 'approve';
			$log->addEntry( $action, $title, $comment, array($oldid) );
		} else {
			$action = FlaggedRevs::isQuality($oldDims) ? 'unapprove2' : 'unapprove';
			$log->addEntry( $action, $title, $comment, array($oldid) );
		}
	}
}
