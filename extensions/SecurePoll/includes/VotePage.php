<?php

class SecurePoll_VotePage extends SecurePoll_Page {
	var $parent, $request, $languages;
	var $election, $auth, $user;

	function __construct( $parent ) {
		$this->parent = $parent;
		$this->request = $parent->request;
	}

	function execute( $params ) {
		global $wgOut;
		if ( !count( $params ) ) {
			$wgOut->addWikiMsg( 'securepoll-too-few-params' );
			return;
		}

		$electionId = intval( $params[0] );
		$this->election = $this->parent->getElection( $electionId );
		if ( !$this->election ) {
			$wgOut->addWikiMsg( 'securepoll-invalid-election', $electionId );
			return;
		}

		$this->auth = $this->election->getAuth();
		$this->user = $this->auth->login( $this->election );
		if ( !$this->user ) {
			$wgOut->addWikiMsg( 'securepoll-not-authorised' );
			return;
		}
		$languages = array( $this->user->getLanguage(), $this->election->getLanguage() );
		$languages = array_unique( $languages );
		SecurePoll_Entity::setLanguages( $languages );

		$wgOut->setPageTitle( $this->election->getMessage( 'title' ) );

		if ( !$this->election->isStarted() ) {
			$wgOut->addWikiMsg( 'securepoll-not-started',
				$wgLang->timeanddate( $this->election->getStartDate() ) );
			return;
		}

		// Show welcome
		if ( $this->user->isRemote() ) {
			$wgOut->addWikiMsg( 'securepoll-welcome', $this->user->getName() );
		}

		// Show qualification notice
		$status = $this->election->getQualifiedStatus( $this->user );
		if ( !$status->isOK() ) {
			$wgOut->addWikiText( $status->getWikiText( 'securepoll-not-qualified' ) );
			return;
		}

		// Show change notice
		if ( $this->election->hasVoted( $this->user ) && !$this->election->allowChange() ) {
			$wgOut->addWikiMsg( 'securepoll-change-disallowed' );
			return;
		}

		// Show/submit the form
		if ( $this->request->wasPosted() ) {
			$this->doSubmit();
		} else {
			$this->showForm();
		}
	}

	function getTitle() {
		return $this->parent->getTitle( 'vote/' . $this->election->getId() );
	}

	function showForm() {
		global $wgOut;

		// Show introduction
		if ( $this->election->hasVoted( $this->user ) && $this->election->allowChange() ) {
			$wgOut->addWikiMsg( 'securepoll-change-allowed' );
		}
		$wgOut->addWikiText( $this->election->getMessage( 'intro' ) );

		// Show form
		$thisTitle = $this->getTitle();
		$encAction = $thisTitle->escapeLocalURL( "action=vote" );
		$encOK = wfMsgHtml( 'securepoll-submit' );
		$encToken = htmlspecialchars( $this->parent->getEditToken() );

		$wgOut->addHTML(
			"<form name=\"securepoll\" id=\"securepoll\" method=\"post\" action=\"$encAction\">\n" .
			$this->election->getBallot()->getForm() .
			"<input name=\"submit\" type=\"submit\" value=\"$encOK\">\n" .
			"<input type='hidden' name='edit_token' value=\"{$encToken}\" /></td>\n" .
			"</form>"
		);
	}

	function doSubmit() {
		global $wgOut;
		$ballot = $this->election->getBallot();
		$status = $ballot->submitForm();
		if ( !$status->isOK() ) {
			$wgOut->addWikiText( $status->getWikiText( 'securepoll_invalidentered' ) );
			$this->showForm();
		} else {
			$this->logVote( $status->value );
		}
	}

	function logVote( $record ) {
		global $wgOut, $wgRequest;

		$now = wfTimestampNow();

		$crypt = $this->election->getCrypt();
		if ( !$crypt ) {
			$encrypted = $record;
		} else {
			$status = $crypt->encrypt( $record );
			if ( !$status->isOK() ) {
				$wgOut->addWikiText( $status->getWikiText( 'securepoll-encrypt-error' ) );
				return;
			}
			$encrypted = $status->value;
		}

		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();

		# Mark previous votes as old
		$dbw->update( 'securepoll_votes',
			array( 'vote_current' => 0 ), # SET
			array( # WHERE
				'vote_election' => $this->election->getId(),
				'vote_user' => $this->user->getId(),
			),
			__METHOD__
		);

		# Add vote to log
		$xff = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		if ( !$xff ) {
			$xff = '';
		}

		$tokenMatch = $this->parent->getEditToken() == $wgRequest->getVal( 'edit_token' );

		$dbw->insert( 'securepoll_votes',
			array(
				'vote_election' => $this->election->getId(),
				'vote_user' => $this->user->getId(),
				'vote_record' => $encrypted,
				'vote_ip' => wfGetIP(),
				'vote_xff' => $xff,
				'vote_ua' => $_SERVER['HTTP_USER_AGENT'],
				'vote_timestamp' => $now,
				'vote_current' => 1,
				'vote_token_match' => $tokenMatch ? 1 : 0,
			),
			__METHOD__ );
		$dbw->commit();

		if ( $crypt ) {
			$wgOut->addWikiMsg( 'securepoll-gpg-receipt', $encrypted );
		} else {
			$wgOut->addWikiMsg( 'securepoll-thanks' );
		}
		$returnUrl = $this->election->getProperty( 'return-url' );
		$returnText = $this->election->getProperty( 'return-text' );
		if ( $returnUrl ) {
			if ( strval( $returnText ) === '' ) {
				$returnText = $returnUrl;
			}
			$link = "[$returnUrl $returnText]";
			$wgOut->addWikiMsg( 'securepoll-return', $link );
		}
	}

	function displayInvalidVoteError() {
		global $wgOut;
		$wgOut->addWikiMsg( 'securepoll_invalidentered' );
	}
}
