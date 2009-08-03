<?php

/*
 * Collection Extension for MediaWiki
 *
 * Copyright (C) PediaPress GmbH
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

class CollectionHooks {
	/**
	 * Callback for hook SkinBuildSidebar (MediaWiki >= 1.14)
	 */
	static function buildSidebar( $skin, &$bar ) {
		global $wgUser;
		global $wgCollectionPortletForLoggedInUsersOnly;

		if( !$wgCollectionPortletForLoggedInUsersOnly || $wgUser->isLoggedIn() ) {
			$html = self::getPortlet();
			if( $html ) {
				$bar[ 'coll-print_export' ] = $html;
			}
		}
		return true;
	}

	/**
	 * This function is the fallback solution for MediaWiki < 1.14
	 * (where the hook SkinBuildSidebar does not exist)
	 */
	static function printPortlet() {
		wfLoadExtensionMessages( 'CollectionCore' );

		$html = self::getPortlet();

		if( $html ) {
			$portletTitle = wfMsg( 'coll-print_export' );
			print "<div id=\"p-coll-print_export\" class=\"portlet\">
	<h5>$portletTitle</h5>
		<div class=\"pBody\">\n$html\n</div></div>";
		}
	}

	/**
	 * Return HTML-code to be inserted as portlet
	 */
	static function getPortlet() {
		global $wgTitle;
		global $wgUser;
		global $wgCollectionArticleNamespaces;
		global $wgCollectionFormats;
		
		$namespace = $wgTitle->getNamespace();

		if ( !in_array( $namespace, $wgCollectionArticleNamespaces )
			&& $namespace != NS_CATEGORY ) {
				return false;
		}

		wfLoadExtensionMessages( 'CollectionCore' );

		$sk = $wgUser->getSkin();

		$out = Xml::element( 'ul', array( 'id' => 'collectionPortletList' ), null );

		$out .= Xml::tags( 'li',
			array( 'id' => 'coll-create_a_book' ),
			$sk->link(
				SpecialPage::getTitleFor( 'Book', 'create_a_book/' ),
				wfMsg( 'coll-create_a_book' ),
				array(
					'rel' => 'nofollow',
					'title' => wfMsg( 'coll-create_a_book_tooltip' )
				),
				array( 'referer' => $wgTitle->getPrefixedText() ),
				array( 'known', 'noclasses' )
			)
		);

		foreach ( $wgCollectionFormats as $writer => $name ) {
			$out .= Xml::tags( 'li',
				array( 'id' => 'coll-download-as-' . $writer ),
				$sk->link(
					SpecialPage::getTitleFor( 'Book', 'render_collection/' ),
					wfMsg( 'coll-download_as', $name ),
					array(
						'rel' => 'nofollow',
						'title' => wfMsg( 'coll-download_as_tooltip', $name )
					),
					array( 'writer', $writer ),
					array( 'known', 'noclasses' )
				)
			);
		}

		$out .= Xml::closeElement( 'ul' );

		return $out;
	}

	/**
	 * Callback for hook SiteNoticeAfter
	 */
	static function renderCreateABookBox( &$siteNotice ) {
		global $wgCollectionArticleNamespaces;
		global $wgCollectionNavPopups;
		global $wgCollectionStyleVersion;
		global $wgCollectionVersion;
		global $wgJsMimeType;
		global $wgScriptPath;
		global $wgTitle;
		global $wgUser;

		$namespace = $wgTitle->getNamespace();
		if ( !in_array( $namespace, $wgCollectionArticleNamespaces )
			&& $namespace != NS_CATEGORY ) {
				return true;
		}

		if ( !CollectionSession::hasSession()
			|| !$_SESSION['wsCollection']['enabled'] ) {
				return true;
		}

		wfLoadExtensionMessages( 'CollectionCore' );

		$sk = $wgUser->getSkin();
		$jsPath = "$wgScriptPath/extensions/Collection/js";
		$imagePath = "$wgScriptPath/extensions/Collection/images";
		$ptext = $wgTitle->getPrefixedText();
		$html = '';

		$html .= Xml::element( 'script', 
			array(
				'type' => $wgJsMimeType,
				'src' => "$jsPath/createabook.js?$wgCollectionStyleVersion",
			),
			'', false
		);
		
		// activate popup check:
		if ( $wgCollectionNavPopups ) {
			$html .= Skin::makeVariablesScript(
				array(
					'wgCollectionNavPopupJSURL' => "$jsPath/Gadget-popups.js?$wgCollectionStyleVersion",
					'wgCollectionNavPopupCSSURL' => "$jsPath/Gadget-navpop.css?$wgCollectionStyleVersion",
					'wgCollectionAddPageText' => wfMsg( 'coll-add_page_popup' ),
					'wgCollectionAddCategoryText' => wfMsg( 'coll-add_category_popup' ),
					'wgCollectionRemovePageText' => wfMsg( 'coll-remove_page_popup' ),
					'wgCollectionArticleNamespaces' => $wgCollectionArticleNamespaces,
					'wgCollectionAddRemoveState' => null,
				)
			);
			$html .= Xml::element( 'script',
				array(
					'type' => $wgJsMimeType,
					'src' => "$jsPath/json2.js?$wgCollectionStyleVersion"
				),
				'', false
			);
			$html .= Xml::element( 'script',
				array(
					'type' => $wgJsMimeType,
					'src' => "$jsPath/popupcheck.js?$wgCollectionStyleVersion"
				),
				'', false
			);
		}


		$html .= Xml::element( 'div',
			array( 'style' => wfMsg( 'coll-create_a_book_box_style' ) ),
			null
		);

		$html .= Xml::element( 'img',
			array(
				'src' => "$imagePath/Open_book.png?$wgCollectionStyleVersion",
				'alt' => '',
				'width' => '80',
				'height' => '45',
				'style' => 'float: left; margin-right: 10px',
			),
			'',
			true
		);

		$html .= Xml::tags( 'div',
			null,
			Xml::tags( 'div',
				array( 'style' => 'float: right' ),
				$sk->link(
					Title::newFromText( wfMsg( 'coll-helppage' ) ),
					wfMsg( 'coll-help' ),
					array( 
						'rel' => 'nofollow',
						'title' => wfMsg( 'coll-help_tooltip' ),
					),
					array(),
					array( 'known', 'noclasses' )
				)
			)
			. Xml::tags( 'strong',
				null,
				wfMsgHtml( 'coll-create_a_book' )
			)
			. ' ('
			. $sk->link(
				SpecialPage::getTitleFor( 'Book', 'stop_create_mode/' ),
				wfMsg( 'coll-disable' ),
				array(
					'rel' => 'nofollow',
					'title' => wfMsg( 'coll-disable_tooltip' ),
				),
				array( 'referer' => $ptext ),
				array( 'known', 'noclasses' )
			)
			. ')'
		);

		$html .= Xml::tags( 'div',
			array( 'id' => 'coll-create_a_book' ),
			self::getCreateABookContent()
	 	);

		$html .= Xml::closeElement( 'div' );

		$siteNotice .= $html;
		return true;
	}

	static function getCreateABookContent( $ajaxHint=null, $oldid=null ) {
		global $wgArticle;
		global $wgJsMimeType;
		global $wgUser;
		global $wgTitle;

		wfLoadExtensionMessages( 'CollectionCore' );

		$namespace = $wgTitle->getNamespace();
		$ptext = $wgTitle->getPrefixedText();

		if ( !is_null( $wgArticle ) ) {
			$oldid = $wgArticle->getOldID();
			if ( !$oldid  || $oldid == $wgArticle->getLatest() ) {
				$oldid = 0;
			} 
		}

		$sk = $wgUser->getSkin();

		$html = '';

		$numArticles = CollectionSession::countArticles();
		if ( $numArticles > 0 ) {
			$html .= Xml::tags( 'div',
				array( 'style' => 'float: right; font-weight: bold' ),
				$sk->link(
					SpecialPage::getTitleFor( 'Book' ),
					wfMsg( 'coll-show_collection' )
						. ' (' . wfMsg( 'coll-n_pages', $numArticles ) . ')',
					array( 
						'rel' => 'nofollow',
						'title' => wfMsg( 'coll-show_collection_tooltip' ),
					),
					array(),
					array( 'known', 'noclasses' )
				)
			);
		}

		if ( $ajaxHint == 'addcategory' || $namespace == NS_CATEGORY ) {
			$id = 'coll-add_category';
			$subpage = 'add_category/';
			$captionMsg = 'coll-add_category';
			$tooltipMsg = 'coll-add_category_tooltip';
			$query = array( 'cattitle' => $wgTitle->getText() );
			$onclick = "collectionCall('AddCategory', ['addcategory', wgTitle]); return false;";
		} else {
			if ( $ajaxHint == 'addarticle'
				|| ($ajaxHint == '' && CollectionSession::findArticle( $ptext, $oldid ) == -1) ) {
				$id = 'coll-add_article';
				$subpage = 'add_article/';
				$captionMsg = 'coll-add_this_page';
				$tooltipMsg = 'coll-add_page_tooltip';
				$query = array( 'arttitle' => $ptext, 'oldid' => $oldid );
				$onclick = "collectionCall('AddArticle', ['removearticle', wgNamespaceNumber, wgTitle, $oldid]); return false;";
			} else {
				$id = 'coll-remove_article';
				$subpage = 'remove_article/';
				$captionMsg = 'coll-remove_this_page';
				$tooltipMsg = 'coll-remove_page_tooltip';
				$query = array( 'arttitle' => $ptext, 'oldid' => $oldid );
				$onclick = "collectionCall('RemoveArticle', ['addarticle', wgNamespaceNumber, wgTitle, $oldid]); return false;";
			}
		}
		$html .= $sk->link(
			SpecialPage::getTitleFor( 'Book', $subpage ),
			wfMsg( $captionMsg ),
			array(
				'id' => $id,
				'rel' => 'nofollow',
				'title' => wfMsg( $tooltipMsg ),
				'onclick' => $onclick,
			),
			$query,
			array( 'known', 'noclasses' )
		);

		return $html;
	}

	/**
	* OutputPageCheckLastModified hook
	*/
	static function checkLastModified( $modifiedTimes ) {
		if ( CollectionSession::hasSession() ) {
			$modifiedTimes['collection'] = $_SESSION['wsCollection']['timestamp'];
		}
		return true;
	}
}

