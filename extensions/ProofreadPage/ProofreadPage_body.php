<?php

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

/*
 todo :
 - check unicity of the index page : when index is saved too
*/

class ProofreadPage {

	/* Page and Index namespaces */
	var $page_namespace = null;
	var $index_namespace = null;

	/* Parser object for index pages */
	var $index_parser = null;

	/**
	 * Constructor
	 */
	function __construct() {
		global $wgHooks, $wgScriptPath;
		$wgHooks['ParserFirstCallInit'][] = array( $this, 'parserFirstCallInit' );
		$wgHooks['BeforePageDisplay'][] = array( &$this, 'beforePageDisplay' );
		$wgHooks['GetLinkColours'][] = array( &$this, 'getLinkColoursHook' );
		$wgHooks['ImageOpenShowImageInlineBefore'][] = array( &$this, 'imageMessage' );
		$wgHooks['EditPage::attemptSave'][] = array( &$this, 'attemptSave' );
		$wgHooks['ArticleSaveComplete'][] = array( &$this, 'articleSaveComplete' );
		$wgHooks['ArticleDelete'][] = array( &$this, 'articleDelete' );
		$wgHooks['EditFormPreloadText'][] = array( &$this, 'preloadText' );
		$wgHooks['ArticlePurge'][] = array( &$this, 'articlePurge' );
		$wgHooks['SpecialMovepageAfterMove'][] = array( &$this, 'movePage' );
		$wgHooks['LoadExtensionSchemaUpdates'][] = array( &$this, 'schema_update' );
		$wgHooks['EditPage::importFormData'][] = array( &$this, 'importFormData' );
		$wgHooks['OutputPageParserOutput'][] = array( &$this, 'OutputPageParserOutput' );
		$wgHooks['ResourceLoaderRegisterModules'][] = array( &$this, 'resourceLoaderRegisterModules' );

		/* Namespaces */
		$this->page_namespace = preg_quote( wfMsgForContent( 'proofreadpage_namespace' ), '/' );
		$this->index_namespace = preg_quote( wfMsgForContent( 'proofreadpage_index_namespace' ), '/' );

		/* Navigation icons */ 
		$path = $wgScriptPath . '/extensions/ProofreadPage';
		$this->prev_icon = Html::element( 'img', array(	'src' => $path . '/leftarrow.png', 
								'alt' =>  wfMsg( 'proofreadpage_prevpage' ),
								'width' => 15, 'height' => 15 ) );
		$this->next_icon = Html::element( 'img', array(	'src' => $path . '/rightarrow.png', 
								'alt' =>  wfMsg( 'proofreadpage_nextpage' ),
								'width' => 15, 'height' => 15 ) );
		$this->up_icon = Html::element( 'img', array(	'src' => $path . '/uparrow.png', 
								'alt' =>  wfMsg( 'proofreadpage_index' ),
								'width' => 15, 'height' => 15 ) );

	}

	/**
	 * Set up our custom parser hooks when initializing parser.
	 * 
	 * @param Parser $parser
	 * @return boolean hook return value
	 */
	public function parserFirstCallInit( $parser ) {
		$parser->setHook( 'pagelist', array( $this, 'renderPageList' ) );
		$parser->setHook( 'pages', array( $this, 'renderPages' ) );
		$parser->setHook( 'pagequality', array( $this, 'pageQuality' ) );
		return true;
	}

	public static function resourceLoaderRegisterModules( &$resourceLoader ) {
		global $wgExtensionAssetsPath;
		$localpath = dirname( __FILE__ );
		$remotepath = "$wgExtensionAssetsPath/ProofreadPage";
		$resourceLoader->register(
			'ext.proofreadpage.page',
			new ResourceLoaderFileModule(
				array(
					'scripts' => 'proofread.js',
					'messages' => array(
						'proofreadpage_header',
						'proofreadpage_body',
						'proofreadpage_footer',
						'proofreadpage_toggleheaders',
						'proofreadpage_page_status',
						'proofreadpage_quality0_category',
						'proofreadpage_quality1_category',
						'proofreadpage_quality2_category',
						'proofreadpage_quality3_category',
						'proofreadpage_quality4_category',
					)
				), $localpath, $remotepath
			)
		);

		$resourceLoader->register(
			'ext.proofreadpage.article',
			new ResourceLoaderFileModule(
				array(
					'scripts' => 'proofread_article.js'
				), $localpath, $remotepath
			)
		);

		$resourceLoader->register(
			'ext.proofreadpage.index',
			new ResourceLoaderFileModule(
				array( 'scripts' => 'proofread_index.js' ),
				$localpath, $remotepath
			)
		);

		return true;
	}

	function schema_update() {
		global $wgExtNewTables;
		$base = dirname( __FILE__ );
		$wgExtNewTables[] = array( 'pr_index', "$base/ProofreadPage.sql" );
		return true;
	}

	/**
	 * Query the database to find if the current page is referred in an Index page.
	 */
	function load_index( $title ) {
		$page_namespace = $this->page_namespace;
		$index_namespace = $this->index_namespace;

		$title->pr_index_title = null;
		$dbr = wfGetDB( DB_SLAVE );
		$result = $dbr->select(
			array( 'page', 'pagelinks' ),
			array( 'page_namespace', 'page_title' ),
			array(
				'pl_namespace' => $title->getNamespace(),
				'pl_title' => $title->getDBkey(),
				'pl_from=page_id'
			),
			__METHOD__
		);

		foreach ( $result as $x ) {
			$ref_title = Title::makeTitle( $x->page_namespace, $x->page_title );
			if ( preg_match( "/^$index_namespace:(.*)$/", $ref_title->getPrefixedText() ) ) {
				$title->pr_index_title = $ref_title->getPrefixedText();
				break;
			}
		}
		$dbr->freeResult( $result ) ;

		if ( $title->pr_index_title ) {
			return;
		}

		/* check if we are a page of a multipage file */
		if ( preg_match( "/^$page_namespace:(.*?)(\/([0-9]*)|)$/", $title->getPrefixedText(), $m ) ) {
			$imageTitle = Title::makeTitleSafe( NS_IMAGE, $m[1] );
		}
		if ( !$imageTitle ) {
			return;
		}

		$image = wfFindFile( $imageTitle );

		// if it is multipage, we use the page order of the file
		if ( $image && $image->exists() && $image->isMultiPage() ) {
			$name = $image->getTitle()->getText();
			$index_name = "$index_namespace:$name";

			if ( !$title->pr_index_title ) {
				// there is no index, or the page is not listed in the index : use canonical index
				$title->pr_index_title = $index_name;
			}
		}
	}

	/**
	 * return the URLs of the index, previous and next pages.
	 */
	function navigation( $title ) {
		$page_namespace = $this->page_namespace;
		$default_header = wfMsgGetKey( 'proofreadpage_default_header', true, true, false );
		$default_footer = wfMsgGetKey( 'proofreadpage_default_footer', true, true, false );

		$err = array( '', '', '', '', '', '' );
		$index_title = Title::newFromText( $title->pr_index_title );
		if ( !$index_title ) {
			return $err;
		}

		$imageTitle = Title::makeTitleSafe( NS_IMAGE, $index_title->getText() );
		$image = wfFindFile( $imageTitle );
		// if multipage, we use the page order, but we should read pagenum from the index
		if ( $image && $image->exists() && $image->isMultiPage() ) {
			$pagenr = 1;
			$parts = explode( '/', $title->getText() );
			if ( count( $parts ) > 1 ) {
				$pagenr = intval( array_pop( $parts ) );
			}
			$count = $image->pageCount();
			if ( $pagenr < 1 || $pagenr > $count || $count <= 1 ) {
				return $err;
			}
			$name = $image->getTitle()->getText();
			$prev_name = "$page_namespace:$name/" . ( $pagenr - 1 );
			$next_name = "$page_namespace:$name/" . ( $pagenr + 1 );
			$prev_title = ( $pagenr == 1 ) ? null : Title::newFromText( $prev_name );
			$next_title = ( $pagenr == $count ) ? null : Title::newFromText( $next_name );

		} else {
			$prev_title = null;
			$next_title = null;
		}

		if ( !$index_title->exists() ) {
			return array( $index_title, $prev_title, $next_title,  $default_header, $default_footer );
		}

		// if the index page exists, find current page number, previous and next pages
		list( $links, $params, $attributes ) = $this->parse_index( $index_title );

		if( $links == null ) {
			list( $pagenum, $links, $mode ) = $this->pageNumber( $pagenr, $params );
			$attributes['pagenum'] = $pagenum;
		} else {
			for( $i = 0; $i < count( $links[1] ); $i++ ) {
				$a_title = Title::newFromText( $page_namespace . ':' . $links[1][$i] );
				if( !$a_title ) {
					continue;
				}
				if( $a_title->getPrefixedText() == $title->getPrefixedText() ) {
					$attributes['pagenum'] = $links[3][$i];
					break;
				}
			}
			if( ( $i > 0 ) && ( $i < count( $links[1] ) ) ) {
				$prev_title = Title::newFromText( $page_namespace . ':' . $links[1][$i - 1] );
			}
			if( ( $i >= 0 ) && ( $i + 1 < count( $links[1] ) ) ) {
				$next_title = Title::newFromText( $page_namespace . ':' . $links[1][$i + 1] );
			}
		}

		// Header and Footer
		// use a js dictionary for style, width, header footer
		$header = $attributes['header'] ? $attributes['header'] : $default_header;
		$footer = $attributes['footer'] ? $attributes['footer'] : $default_footer;
		foreach ( $attributes as $key => $val ) {
			$header = str_replace( "{{{{$key}}}}", $val, $header );
			$footer = str_replace( "{{{{$key}}}}", $val, $footer );
		}
		$css = $attributes['css'] ? $attributes['css'] : '';
		$edit_width = $attributes['width'] ? $attributes['width'] : '';

		return array( $index_title, $prev_title, $next_title, $header, $footer, $css, $edit_width );
	}

	/**
	 * Read metadata from an index page.
	 * Depending on whether the index uses pagelist,
	 * it will return either a list of links or a list
	 * of parameters to pagelist, and a list of attributes.
	 */
	function parse_index( $index_title ) {
		$err = array( false, false, array() );
		if ( !$index_title ) {
			return $err;
		}
		if ( !$index_title->exists() ) {
			return $err;
		}

		$rev = Revision::newFromTitle( $index_title );
		$text =	$rev->getText();
		return $this->parse_index_text( $text );
	}

	function parse_index_text( $text ) {
		$page_namespace = $this->page_namespace;
		//check if it is using pagelist
		preg_match_all( "/<pagelist([^<]*?)\/>/is", $text, $m, PREG_PATTERN_ORDER );
		if( $m[1] ) {
			$params_s = '';
			for( $k = 0; $k < count( $m[1] ); $k++ ) {
				$params_s = $params_s . $m[1][$k];
			}
			$params = Sanitizer::decodeTagAttributes( $params_s );
			$links = null;
		} else {
			$params = null;
			$tag_pattern = "/\[\[$page_namespace:(.*?)(\|(.*?)|)\]\]/i";
			preg_match_all( $tag_pattern, $text, $links, PREG_PATTERN_ORDER );
		}

		// read attributes
		$attributes = array();
		$var_names = explode( ' ', wfMsgForContent( 'proofreadpage_js_attributes' ) );
		for( $i = 0; $i < count( $var_names ); $i++ ) {
			$tag_pattern = "/\n\|" . $var_names[$i] . "=(.*?)\n(\||\}\})/is";
			//$var = 'proofreadPage' . $var_names[$i];
			$var = strtolower( $var_names[$i] );
			if( preg_match( $tag_pattern, $text, $matches ) ) {
				$attributes[$var] = $matches[1];
			} else {
				$attributes[$var] = '';
			}
		}
		return array( $links, $params, $attributes );

	}

	/**
	 * Return the ordered list of links to ns-0 from an index page
	 */
	function parse_index_links( $index_title ) {
		// Instanciate a new parser object to avoid side effects of $parser->replaceVariables
		if( is_null( $this->index_parser ) ) {
			$this->index_parser = new Parser;
		}
		$rev = Revision::newFromTitle( $index_title );
		$text =	$rev->getText();
		$options = new ParserOptions();
		$rtext = $this->index_parser->preprocess( $text, $index_title, $options );
		$text_links_pattern = "/\[\[\s*([^:\|]*?)\s*(\|(.*?)|)\]\]/i";
		preg_match_all( $text_links_pattern, $rtext, $text_links, PREG_PATTERN_ORDER );
		return $text_links;
	}

	/**
	 * Append javascript variables and code to the page.
	 */
	function beforePageDisplay( &$out ) {
		global $wgTitle, $wgRequest;

		$action = $wgRequest->getVal( 'action' );
		$isEdit = ( $action == 'submit' || $action == 'edit' ) ? 1 : 0;
		if ( !isset( $wgTitle ) || ( !$out->isArticle() && !$isEdit ) || isset( $out->proofreadPageDone ) ) {
			return true;
		}
		$out->proofreadPageDone = true;

		$page_namespace = $this->page_namespace;
		if ( preg_match( "/^$page_namespace:(.*?)(\/([0-9]*)|)$/", $wgTitle->getPrefixedText(), $m ) ) {
			$this->preparePage( $out, $m, $isEdit );
			return true;
		}

		$index_namespace = $this->index_namespace;
		if ( $isEdit && ( preg_match( "/^$index_namespace:(.*?)(\/([0-9]*)|)$/", $wgTitle->getPrefixedText(), $m ) ) ) {
			$this->prepareIndex( $out );
			return true;
		}

		if( $wgTitle->getNamespace() == NS_MAIN ) {
			$this->prepareArticle( $out );
			return true;
		}

		return true;
	}

	function prepareIndex( $out ) {
		$out->addModules( 'ext.proofreadpage.index' );
		$out->addInlineScript("
var prp_index_attributes = \"" . Xml::escapeJsString( wfMsgForContent( 'proofreadpage_index_attributes' ) ) . "\";
var prp_default_header = \"" . Xml::escapeJsString( wfMsgGetKey( 'proofreadpage_default_header', true, true, false ) ) . "\";
var prp_default_footer = \"" . Xml::escapeJsString( wfMsgGetKey( 'proofreadpage_default_footer', true, true, false ) ) . "\";" );
	}

	function preparePage( $out, $m, $isEdit ) {
		global $wgTitle, $wgUser;

		if ( !isset( $wgTitle->pr_index_title ) ) {
			$this->load_index( $wgTitle );
		}

		$imageTitle = Title::makeTitleSafe( NS_IMAGE, $m[1] );
		if ( !$imageTitle ) {
			return true;
		}

		$image = wfFindFile( $imageTitle );
		if ( $image && $image->exists() ) {
			$width = $image->getWidth();
			$height = $image->getHeight();
			if ( $m[2] ) {
				$thumbName = $image->thumbName( array( 'width' => '##WIDTH##', 'page' => $m[3] ) );
			} else {
				$thumbName = $image->thumbName( array( 'width' => '##WIDTH##' ) );
			}
			$thumbURL = $image->getThumbUrl( $thumbName );
			$thumbURL = str_replace( '%23', '#', $thumbURL );
			$scan_link = Html::element( 'a', 
						    array( 'href' => str_replace( '##WIDTH##', "$width", $thumbURL ), 
							   'title' =>  wfMsg( 'proofreadpage_image' ) ), 
						    wfMsg( 'proofreadpage_image' ) );
		} else {
			$width = 0;
			$height = 0;
			$thumbURL = '';
			$scan_link = '';
		}

		list( $index_title, $prev_title, $next_title, $header, $footer, $css, $edit_width ) = $this->navigation( $wgTitle );

		$sk = $wgUser->getSkin();
		$next_link = $next_title ? $sk->link( $next_title, $this->next_icon, 
						      array( 'title' => wfMsg( 'proofreadpage_nextpage' ) ) ) : '';
		$prev_link = $prev_title ? $sk->link( $prev_title, $this->prev_icon, 
						      array( 'title' => wfMsg( 'proofreadpage_prevpage' ) ) ): '';
		$index_link = $index_title ? $sk->link( $index_title, $this->up_icon, 
							array( 'title' => wfMsg( 'proofreadpage_index' ) ) ) : '';

		$jsVars = array(
			'proofreadPageWidth' => intval( $width ),
			'proofreadPageHeight' => intval( $height ),
			'proofreadPageEditWidth' => $edit_width,
			'proofreadPageThumbURL' => $thumbURL,
			'proofreadPageIsEdit' => intval( $isEdit ),
			'proofreadPageIndexLink' => $index_link,
			'proofreadPageNextLink' => $next_link,
			'proofreadPagePrevLink' => $prev_link,
			'proofreadPageScanLink' => $scan_link,
			'proofreadPageHeader' => $header,
			'proofreadPageFooter' => $footer,
			'proofreadPageAddButtons' => $wgUser->isAllowed( 'pagequality' ),
			'proofreadPageUserName' => $wgUser->getName(),
			'proofreadPageCss' => $css,
		);
		$out->addInlineScript( ResourceLoader::makeConfigSetScript( $jsVars ) );

		$out->addModules( 'ext.proofreadpage.page' );

		return true;
	}

	/**
	 * Hook function
	 */
	function getLinkColoursHook( $page_ids, &$colours ) {
		global $wgTitle;
		if ( !isset( $wgTitle ) ) {
			return true;
		}
		// abort if we are not an index page
		$index_namespace = $this->index_namespace;
		if ( !preg_match( "/^$index_namespace:(.*?)$/", $wgTitle->getPrefixedText(), $m ) ) {
			return true;
		}
		$this->getLinkColours( $page_ids, $colours );
		return true;
	}

	/**
	 * Return the quality colour codes to pages linked from an index page
	 */
	function getLinkColours( $page_ids, &$colours ) {
		$page_namespace = $this->page_namespace;
		$dbr = wfGetDB( DB_SLAVE );
		$catlinks = $dbr->tableName( 'categorylinks' );

		$values = array();
		foreach ( $page_ids as $id => $pdbk ) {
			// consider only link in page namespace
			if ( preg_match( "/^$page_namespace:(.*?)$/", $pdbk ) ) {
				$colours[$pdbk] = 'quality1';
				$values[] = intval( $id );
			}
		}

		if ( count( $values ) ) {
			$query .= "SELECT cl_from, cl_to FROM $catlinks WHERE cl_from IN(" . implode( ",", $values ) . ")";
			$res = $dbr->query( $query, __METHOD__ );

			foreach ( $res as $x ) {
				$pdbk = $page_ids[$x->cl_from];
				switch( $x->cl_to ) {
				case str_replace( ' ' , '_' , wfMsgForContent( 'proofreadpage_quality0_category' ) ):
					$colours[$pdbk] = 'quality0';
					break;
				case str_replace( ' ' , '_' , wfMsgForContent( 'proofreadpage_quality1_category' ) ):
					$colours[$pdbk] = 'quality1';
					break;
				case str_replace( ' ' , '_' , wfMsgForContent( 'proofreadpage_quality2_category' ) ):
					$colours[$pdbk] = 'quality2';
					break;
				case str_replace( ' ' , '_' , wfMsgForContent( 'proofreadpage_quality3_category' ) ):
					$colours[$pdbk] = 'quality3';
					break;
				case str_replace( ' ' , '_' , wfMsgForContent( 'proofreadpage_quality4_category' ) ):
					$colours[$pdbk] = 'quality4';
					break;
				}
			}
		}
	}

	function imageMessage( &$imgpage, &$out ) {
		global $wgUser;
		$index_namespace = $this->index_namespace;
		$image = $imgpage->img;
		if ( !$image->isMultiPage() ) {
			return true;
		}
		$sk = $wgUser->getSkin();
		$name = $image->getTitle()->getText();
		$link = $sk->makeKnownLink( "$index_namespace:$name", wfMsg( 'proofreadpage_image_message' ) );
		$out->addHTML( "{$link}" );
		return true;
	}

	// credit : http://www.mediawiki.org/wiki/Extension:RomanNumbers
	function toRoman( $num ) {
		if ( $num < 0 || $num > 9999 ) {
			return - 1;
		}
		$romanOnes = array(
			1 => 'I',
			2 => 'II',
			3 => 'III',
			4 => 'IV',
			5 => 'V',
			6 => 'VI',
			7 => 'VII',
			8 => 'VIII',
			9 => 'IX'
		);
		$romanTens = array(
			1 => 'X',
			2 => 'XX',
			3 => 'XXX',
			4 => 'XL',
			5 => 'L',
			6 => 'LX',
			7 => 'LXX',
			8 => 'LXXX',
			9 => 'XC'
		);
		$romanHund = array(
			1 => 'C',
			2 => 'CC',
			3 => 'CCC',
			4 => 'CD',
			5 => 'D',
			6 => 'DC',
			7 => 'DCC',
			8 => 'DCCC',
			9 => 'CM'
		);
		$romanThou = array(
			1 => 'M',
			2 => 'MM',
			3 => 'MMM',
			4 => 'MMMM',
			5 => 'MMMMM',
			6 => 'MMMMMM',
			7 => 'MMMMMMM',
			8 => 'MMMMMMMM',
			9 => 'MMMMMMMMM'
		);

		$ones = $num % 10;
		$tens = ( $num - $ones ) % 100;
		$hund = ( $num - $tens - $ones ) % 1000;
		$thou = ( $num - $hund - $tens - $ones ) % 10000;

		$tens = $tens / 10;
		$hund = $hund / 100;
		$thou = $thou / 1000;

		if ( $thou ) {
			$romanNum .= $romanThou[$thou];
		}
		if ( $hund ) {
			$romanNum .= $romanHund[$hund];
		}
		if ( $tens ) {
			$romanNum .= $romanTens[$tens];
		}
		if ( $ones ) {
			$romanNum .= $romanOnes[$ones];
		}

		return $romanNum;
	}

	function pageNumber( $i, $args ) {
		$mode = 'normal'; // default
		$offset = 0;
		$links = true;
		foreach ( $args as $num => $param ) {
			if ( ( preg_match( "/^([0-9]*)to([0-9]*)$/", $num, $m ) && ( $i >= $m[1] && $i <= $m[2] ) )
			     || ( is_numeric( $num ) && ( $i == $num ) ) ) {
				$params = explode( ';', $param );
				foreach ( $params as $iparam ) {
					switch( $iparam ) {
					case 'roman':
						$mode = 'roman';
						break;
					case 'highroman':
						$mode = 'highroman';
						break;
					case 'empty':
						$links = false;
						break;
					default:
						if ( !is_numeric( $iparam ) ) {
							$mode = $iparam;
						}
					}
				}
			}

			if ( is_numeric( $num ) && ( $i >= $num ) )  {
				$params = explode( ';', $param );
				foreach ( $params as $iparam ) {
					if ( is_numeric( $iparam ) ) {
						$offset = $num - $iparam;
					}
				}
			}

		}
		$view = ( $i - $offset );
		switch( $mode ) {
		case 'highroman':
			$view = toRoman( $view );
			break;
		case 'roman':
			$view = strtolower( toRoman( $view ) );
			break;
		case 'normal':
			$view = '' . $view;
			break;
		case 'empty':
			$view = '' . $view;
			break;
		default:
			$view = $mode;
		}
		return array( $view, $links, $mode );
	}

	/**
	 * Add the pagequality category.
	 * @todo FIXME: display whether page has been proofread by the user or by someone else
	 */
	function pageQuality( $input, $args, $parser ) {
		$page_namespace = $this->page_namespace;
		if ( !preg_match( "/^$page_namespace:(.*?)(\/([0-9]*)|)$/", $parser->Title()->getPrefixedText() ) ) {
			return '';
		}

		$q = $args['level'];
		if( !in_array( $q, array( '0', '1', '2', '3', '4' ) ) ) {
			return '';
		}
		$message = "<div id=\"pagequality\" width=100% class=quality$q>" .
			wfMsgForContent( "proofreadpage_quality{$q}_message" ) . '</div>';
		$out = '__NOEDITSECTION__[[Category:' .
			wfMsgForContent( "proofreadpage_quality{$q}_category" ) . ']]';
		return $parser->recursiveTagParse( $out . $message );
	}

	/**
	 * Parser hook for index pages
	 * Display a list of coloured links to pages
	 */
	function renderPageList( $input, $args, $parser ) {
		$page_namespace = $this->page_namespace;
		$index_namespace = $this->index_namespace;
		if ( !preg_match( "/^$index_namespace:(.*?)(\/([0-9]*)|)$/", $parser->Title()->getPrefixedText(), $m ) ) {
			return '';
		}

		$imageTitle = Title::makeTitleSafe( NS_IMAGE, $m[1] );
		if ( !$imageTitle ) {
			return '<strong class="error">' . wfMsgForContent( 'proofreadpage_nosuch_file' ) . '</strong>';
		}

		$image = wfFindFile( $imageTitle );
		if ( !( $image && $image->isMultiPage() && $image->pageCount() ) ) {
			return '<strong class="error">' . wfMsgForContent( 'proofreadpage_nosuch_file' ) . '</strong>';
		}

		$return = '';

		$name = $imageTitle->getDBkey();
		$count = $image->pageCount();

		$from = $args['from'];
		$to = $args['to'];
		if( !$from ) {
			$from = 1;
		}
		if( !$to ) {
			$to = $count;
		}

		if( !is_numeric( $from ) || !is_numeric( $to ) ) {
			return '<strong class="error">' . wfMsgForContent( 'proofreadpage_number_expected' ) . '</strong>';
		}
		if( ( $from > $to ) || ( $from < 1 ) || ( $to < 1 ) || ( $to > $count ) ) {
			return '<strong class="error">' . wfMsgForContent( 'proofreadpage_invalid_interval' ) . '</strong>';
		}

		for ( $i = $from; $i < $to + 1; $i++ ) {
			$pdbk = "$page_namespace:$name" . '/' . $i ;
			list( $view, $links, $mode ) = $this->pageNumber( $i, $args );

			if ( $mode == 'highroman' || $mode == 'roman' ) {
				$view = '&#160;' . $view;
			}

			$n = strlen( $count ) - strlen( $view );
			if ( $n && ( $mode == 'normal' || $mode == 'empty' ) ) {
				$txt = '<span style="visibility:hidden;">';
				for ( $j = 0; $j < $n; $j++ ) {
					$txt = $txt . '0';
				}
				$view = $txt . '</span>' . $view;
			}
			$title = Title::newFromText( $pdbk );

			if ( $links == false ) {
				$return .= $view . ' ';
			} else {
				$return .= '[[' . $title->getPrefixedText() . "|$view]] ";
			}
		}
		$return = $parser->recursiveTagParse( $return );
		return $return;
	}

	/**
	 * Parser hook that includes a list of pages.
	 *  parameters : index, from, to, header
	 */
	function renderPages( $input, $args, $parser ) {
		$page_namespace = $this->page_namespace;
		$index_namespace = $this->index_namespace;
		$index = $args['index'];
		$from = $args['from'];
		$to = $args['to'];
		$header = $args['header'];

		// abort if the tag is on an index page
		if ( preg_match( "/^$index_namespace:(.*?)(\/([0-9]*)|)$/", $parser->Title()->getPrefixedText() ) ) {
			return '';
		}
		// abort too if the tag is in the page namespace
		if ( preg_match( "/^$page_namespace:(.*?)(\/([0-9]*)|)$/", $parser->Title()->getPrefixedText() ) ) {
			return '';
		}
		if( !$index ) {
			return '<strong class="error">' . wfMsgForContent( 'proofreadpage_index_expected' ) . '</strong>';
		}
		$index_title = Title::newFromText( "$index_namespace:$index" );
		if( !$index_title || !$index_title->exists() ) {
			return '<strong class="error">' . wfMsgForContent( 'proofreadpage_nosuch_index' ) . '</strong>';
		}

		$parser->getOutput()->addTemplate( $index_title, $index_title->getArticleID(), $index_title->getLatestRevID() );

		$out = '';

		list( $links, $params, $attributes ) = $this->parse_index( $index_title );

		if( $from || $to ) {
			$pages = array();
			if( $links == null ) {
				$imageTitle = Title::makeTitleSafe( NS_IMAGE, $index );
				if ( !$imageTitle ) {
					return '<strong class="error">' . wfMsgForContent( 'proofreadpage_nosuch_file' ) . '</strong>';
				}
				$image = wfFindFile( $imageTitle );
				if ( !( $image && $image->isMultiPage() && $image->pageCount() ) ) {
					return '<strong class="error">' . wfMsgForContent( 'proofreadpage_nosuch_file' ) . '</strong>';
				}
				$count = $image->pageCount();

				if( !$from ) {
					$from = 1;
				}
				if( !$to ) {
					$to = $count;
				}

				if( !is_numeric( $from ) || !is_numeric( $to ) ) {
					return '<strong class="error">' . wfMsgForContent( 'proofreadpage_number_expected' ) . '</strong>';
				}
				if( ($from > $to) || ($from < 1) || ($to < 1 ) || ($to > $count) ) {
					return '<strong class="error">' . wfMsgForContent( 'proofreadpage_invalid_interval' ) . '</strong>';
				}
				if( $to - $from > 1000 ) {
					return '<strong class="error">' . wfMsgForContent( 'proofreadpage_interval_too_large' ) . '</strong>';
				}

				for( $i = $from; $i <= $to; $i++ ) {
					list( $pagenum, $links, $mode ) = $this->pageNumber( $i, $params );
					$page = str_replace( ' ' , '_', "$index/" . $i );
					if( $i == $from ) {
						$from_page = $page;
						$from_pagenum = $pagenum;
					}
					if( $i == $to ) {
						$to_page = $page;
						$to_pagenum = $pagenum;
					}
					$pages[] = array( $page, $pagenum );
				}
			} else {
				if( $from ) {
					$adding = false;
				} else {
					$adding = true;
					$from_pagenum = $links[3][0];
				}
				for( $i = 0; $i < count( $links[1] ); $i++ ) {
					$text = $links[1][$i];
					$pagenum = $links[3][$i];
					if( $text == $from ) {
						$adding = true;
						$from_page = $from;
						$from_pagenum = $pagenum;
					}
					if( $adding ) {
						$pages[] = array( $text, $pagenum );
					}
					if( $text == $to ) {
						$adding = false;
						$to_page = $to;
						$to_pagenum = $pagenum;
					}
				}
				if( !$to ) {
					$to_pagenum = $links[3][count( $links[1] ) - 1];
				}
			}
			// find which pages have quality0
			$q0_pages = array();
			if( !empty( $pages ) ) {
				$pp = array();
				foreach( $pages as $item ) {
					list( $page, $pagenum ) = $item;
					$pp[] = $page;
				}
				$page_ns_index = MWNamespace::getCanonicalIndex( strtolower( $page_namespace ) );
				$dbr = wfGetDB( DB_SLAVE );
				$cat = str_replace( ' ' , '_' , wfMsgForContent( 'proofreadpage_quality0_category' ) );
				$res = $dbr->select(
						    array( 'page', 'categorylinks' ),
						    array( 'page_title' ),
						    array(
							  'page_title' => $pp,
							  'cl_to' => $cat,
							  'page_namespace' => $page_ns_index
							  ),
						    __METHOD__,
						    null,
						    array( 'categorylinks' => array( 'LEFT JOIN', 'cl_from=page_id' ) )
						    );
				
				if( $res ) {
					foreach ( $res as $o ) {
						array_push( $q0_pages, $o->page_title );
					}
				}
			}

			// write the output
			foreach( $pages as $item ) {
				list( $page, $pagenum ) = $item;
				if( in_array( $page, $q0_pages ) ) {
					$is_q0 = true;
				} else {
					$is_q0 = false;
				}
				$text = "$page_namespace:$page";
				if( !$is_q0 ) {
					$out .= '<span>{{:MediaWiki:Proofreadpage_pagenum_template|page=' . $text . "|num=$pagenum}}</span>";
				}
				if( $args["$i"] != null ) {
					$out .= '{{#lst:' . $text . '|' . $args["$i"] . '}}';
				} elseif( $page == $from && $args['fromsection'] ) {
					$out .= '{{#lst:' . $text . '|' . $args['fromsection'] . '}}';
				} elseif( $page == $to && $args['tosection'] ) {
					$out .= '{{#lst:' . $text . '|' . $args['tosection'] . '}}';
				} else {
					$out .= '{{:' . $text . '}}';
				}
				if( !$is_q0 ) {
					$out.= "\n";
				}
			}
		} else {
			/* table of Contents */
			$header = 'toc';
			if( $links == null ) {
				$firstpage = str_replace( ' ' , '_', "$index/1" );
			} else {
				$firstpage = $links[1][0];
			}
			$firstpage_title = Title::newFromText( "$page_namespace:$firstpage" );
			$parser->getOutput()->addTemplate(
				$firstpage_title,
				$firstpage_title->getArticleID(),
				$firstpage_title->getLatestRevID()
			);
		}

		if( $header ) {
			if( $header == 'toc') {
				$parser->getOutput()->is_toc = true;
			}
			$text_links = $this->parse_index_links( $index_title );
			$h_out = '{{:MediaWiki:Proofreadpage_header_template';
			$h_out .= "|value=$header";
			// find next and previous pages in list
			for( $i = 1; $i < count( $text_links[1] ); $i++ ) {
				if( $text_links[1][$i] == $parser->Title()->getPrefixedText() ) {
					$current = $text_links[0][$i];
					break;
				}
			}
			if( ( $i > 1 ) && ( $i < count( $text_links[1] ) ) ) {
				$prev = $text_links[0][$i - 1];
			}
			if( ( $i >= 1 ) && ( $i + 1 < count( $text_links[1] ) ) ) {
				$next = $text_links[0][$i + 1];
			}
			if( isset( $args['current'] ) ) {
				$current = $args['current'];
			}
			if( isset( $args['prev'] ) ) {
				$prev = $args['prev'];
			}
			if( isset( $args['next'] ) ) {
				$next = $args['next'];
			}
			if( $current ) {
				$h_out .= "|current=$current";
			}
			if( $prev ) {
				$h_out .= "|prev=$prev";
			}
			if( $next ) {
				$h_out .= "|next=$next";
			}
			if( $from_pagenum ) {
				$h_out .= "|from=$from_pagenum";
			}
			if( $to_pagenum ) {
				$h_out .= "|to=$to_pagenum";
			}
			foreach ( $attributes as $key => $val ) {
				if( $args[$key] ) {
					$val = $args[$key];
				}
				$h_out .= "|$key=$val";
			}
			$h_out .= '}}';
			$out = $h_out . $out ;
		}

		// wrap the output in a div, to prevent the parser from inserting pararaphs
		$out = "<div>$out</div>";
		$out = $parser->recursiveTagParse( $out );
		return $out;
	}

	/**
	 * Set is_toc flag (true if page is a table of contents)
	 */
	function OutputPageParserOutput( $outputPage, $parserOutput ) {
		if( isset( $parserOutput->is_toc ) ) {
			$outputPage->is_toc = $parserOutput->is_toc;
		} else {
			$outputPage->is_toc = false;
		}
		return true;
	}

	/**
	 * Try to parse a page.
	 * Return quality status of the page and username of the proofreader
	 * Return -1 if the page cannot be parsed
	 */
	function parse_page( $text ) {
		global $wgTitle, $wgUser;

		$username = $wgUser->getName();
		$page_regexp = "/^<noinclude>(.*?)<\/noinclude>(.*?)<noinclude>(.*?)<\/noinclude>$/s";
		if( !preg_match( $page_regexp, $text, $m ) ) {
			$this->load_index( $wgTitle );
			list( $index_title, $prev_title, $next_title, $header, $footer, $css, $edit_width ) = $this->navigation( $wgTitle );
			$new_text = "<noinclude><pagequality level=\"1\" user=\"$username\" />"
				."$header\n\n\n</noinclude>$text<noinclude>\n$footer</noinclude>";
			return array( -1, null, $new_text );
		}

		$header = $m[1];
		$body = $m[2];
		$footer = $m[3];

		$header_regexp = "/^<pagequality level=\"(0|1|2|3|4)\" user=\"(.*?)\" \/>/";
		if( preg_match( $header_regexp, $header, $m2 ) ) {
			return array( intval($m2[1]), $m2[2], null );
		}

		$old_header_regexp = "/^\{\{PageQuality\|(0|1|2|3|4)(|\|(.*?))\}\}/is";
		if( preg_match( $old_header_regexp, $header, $m3 ) ) {
			return array( intval($m3[1]), $m3[3], null );
		}

		$new_text = "<noinclude><pagequality level=\"1\" user=\"$username\" />"
			. "$header\n\n\n</noinclude>$body<noinclude>\n$footer</noinclude>";
		return array( -1, null, $new_text );
	}

	function importFormData( $editpage, $request ) {
		global $wgTitle;

		$page_namespace = $this->page_namespace;
		// abort if we are not a page
		if ( !preg_match( "/^$page_namespace:(.*)$/", $wgTitle->getPrefixedText() ) ) {
			return true;
		}
		if ( !$request->wasPosted() ) {
			return true;
		}
		$editpage->quality = $request->getVal( 'quality' );
		$editpage->username = $editpage->safeUnicodeInput( $request, 'wpProofreader' );
		$editpage->header = $editpage->safeUnicodeInput( $request, 'wpHeaderTextbox' );
		$editpage->footer = $editpage->safeUnicodeInput( $request, 'wpFooterTextbox' );

		// we want to keep ordinary spaces at the end of the main textbox
		$text = rtrim( $request->getText( 'wpTextbox1' ), "\t\n\r\0\x0B" );
		$editpage->textbox1 = $request->getBool( 'safemode' )
			? $editpage->unmakesafe( $text )
			: $text;

		if( in_array( $editpage->quality, array( '0', '1', '2', '3', '4' ) ) ) {
			// format the page
			$text = '<noinclude><pagequality level="' . $editpage->quality . '" user="' . $editpage->username . '" />' .
				'<div class="pagetext">' . $editpage->header."\n\n\n</noinclude>" .
				$editpage->textbox1 .
				"<noinclude>\n" . $editpage->footer . '</div></noinclude>';
			$editpage->textbox1 = $text;
		} else {
			// replace deprecated template
			$text = $editpage->textbox1;
			$text = preg_replace(
				"/\{\{PageQuality\|(0|1|2|3|4)(|\|(.*?))\}\}/is",
				"<pagequality level=\"\\1\" user=\"\\3\" />",
				$text
			);
			$editpage->textbox1 = $text;
		}
		return true;
	}

	/**
	 * Check the format of pages in "Page" namespace.
	 *
	 * @param $editpage Object: EditPage object
	 * @return Boolean
	 */
	function attemptSave( $editpage ) {
		global $wgOut, $wgUser;

		$page_namespace = $this->page_namespace;
		$index_namespace = $this->index_namespace;
		$title = $editpage->mTitle;

		// check that pages listed on an index are unique.
		if ( preg_match( "/^$index_namespace:(.*)$/", $title->getPrefixedText() ) ) {
			$text = $editpage->textbox1;
			list( $links, $params, $attributes ) = $this->parse_index_text( $text );
			if( $links != null && count( $links[1] ) != count( array_unique( $links[1] ) ) ) {
				$wgOut->showErrorPage( 'proofreadpage_indexdupe', 'proofreadpage_indexdupetext' );
				return false;
			};
			return true;
		}

		// abort if we are not a page
		if ( !preg_match( "/^$page_namespace:(.*)$/", $title->getPrefixedText() ) ) {
			return true;
		}

		$text = $editpage->textbox1;
		// parse the page
		list( $q, $username, $ptext ) = $this->parse_page( $text );
		if( $q == -1 ) {
			$editpage->textbox1 = $ptext;
			$q = 1;
		}

		// read previous revision, so that I know how much I need to add to pr_index
		$rev = Revision::newFromTitle( $title );
		if( $rev ) {
			$old_text = $rev->getText();
			list( $old_q, $old_username, $old_ptext ) = $this->parse_page( $old_text );
			if( $old_q != -1 ) {
				// check usernames
				if( ( $old_q != $q ) && !$wgUser->isAllowed( 'pagequality' ) ) {
					$wgOut->showErrorPage( 'proofreadpage_nologin', 'proofreadpage_nologintext' );
					return false;
				}
				if ( ( ( $old_username != $username ) || ( $old_q != $q ) ) && ( $wgUser->getName() != $username ) ) {
					$wgOut->showErrorPage( 'proofreadpage_notallowed', 'proofreadpage_notallowedtext' );
					return false;
				}
				if( ( ( $q == 4 ) && ( $old_q < 3 ) ) || ( ( $q == 4 ) && ( $old_q == 3 ) && ( $old_username == $username ) ) ) {
					$wgOut->showErrorPage( 'proofreadpage_notallowed', 'proofreadpage_notallowedtext' );
					return false;
				}
			} else {
				$old_q = 1;
			}
		} else {
			if( $q == 4 ) {
				$wgOut->showErrorPage( 'proofreadpage_notallowed', 'proofreadpage_notallowedtext' );
				return false;
			}
			$old_q = -1;
		}

		$editpage->mArticle->new_q = $q;
		$editpage->mArticle->old_q = $old_q;

		return true;
	}

	/**
	 * if I delete a page, I need to update the index table
	 * if I delete an index page too...
	 *
	 * @param $article Object: Article object
	 * @return Boolean: true
	 */
	function articleDelete( $article ) {
		$page_namespace = $this->page_namespace;
		$index_namespace = $this->index_namespace;
		$title = $article->mTitle;

		if ( preg_match( "/^$index_namespace:(.*)$/", $title->getPrefixedText() ) ) {
			$id = $article->getID();
			$dbw = wfGetDB( DB_MASTER );
			$pr_index = $dbw->tableName( 'pr_index' );
			$dbw->query( "DELETE FROM $pr_index WHERE pr_page_id=$id", __METHOD__ );
			$dbw->commit();
			return true;
		}

		if ( preg_match( "/^$page_namespace:(.*)$/", $title->getPrefixedText() ) ) {
			$this->load_index( $title );
			if( $title->pr_index_title ) {
				$index_title = Title::newFromText( $title->pr_index_title );
				$index_title->invalidateCache();
				$index = new Article( $index_title );
				if( $index ) {
					$this->update_pr_index( $index, $title->getDBKey() );
				}
			}
			return true;
		}

		return true;
	}

	function articleSaveComplete( $article ) {
		$page_namespace = $this->page_namespace;
		$index_namespace = $this->index_namespace;
		$title = $article->mTitle;

		// if it's an index, update pr_index table
		if ( preg_match( "/^$index_namespace:(.*)$/", $title->getPrefixedText(), $m ) ) {
			$this->update_pr_index( $article );
			return true;
		}

		// return if it is not a page
		if ( !preg_match( "/^$page_namespace:(.*)$/", $title->getPrefixedText() ) ) {
			return true;
		}

		$dbw = wfGetDB( DB_MASTER );

		/* check if there is an index */
		if ( !isset( $title->pr_index_title ) ) {
			$this->load_index( $title );
		}
		if( ! $title->pr_index_title ) {
			return true;
		}

		/**
		 * invalidate the cache of the index page
		 */
		if ( $title->pr_index_title ) {
			$index_title = Title::newFromText( $title->pr_index_title );
			$index_title->invalidateCache();
		}

		/**
		 * update pr_index iteratively
		 */
		$index = new Article( $index_title );
		$index_id = $index->getID();
		$dbr = wfGetDB( DB_SLAVE );
		$pr_index = $dbr->tableName( 'pr_index' );
		$query = "SELECT * FROM $pr_index WHERE pr_page_id=" . $index_id;
		$res = $dbr->query( $query, __METHOD__ );
		if( $x = $dbr->fetchObject( $res ) ) {
			$n  = $x->pr_count;
			$n0 = $x->pr_q0;
			$n1 = $x->pr_q1;
			$n2 = $x->pr_q2;
			$n3 = $x->pr_q3;
			$n4 = $x->pr_q4;

			switch( $article->new_q ) {
				case 0:
					$n0 = $n0 + 1;
					break;
				case 1:
					$n1 = $n1 + 1;
					break;
				case 2:
					$n2 = $n2 + 1;
					break;
				case 3:
					$n3 = $n3 + 1;
					break;
				case 4:
					$n4 = $n4 + 1;
					break;
			}

			switch( $article->old_q ) {
				case 0:
					$n0 = $n0 - 1;
					break;
				case 1:
					$n1 = $n1 - 1;
					break;
				case 2:
					$n2 = $n2 - 1;
					break;
				case 3:
					$n3 = $n3 - 1;
					break;
				case 4:
					$n4 = $n4 - 1;
					break;
			}

			$query = "REPLACE INTO $pr_index (pr_page_id, pr_count, pr_q0, pr_q1, pr_q2, pr_q3, pr_q4) VALUES ({$index_id},$n,$n0,$n1,$n2,$n3,$n4)";
			$dbw->query( $query, __METHOD__ );
			$dbw->commit();

		}
		$dbr->freeResult( $res );

		return true;
	}

	/* Preload text layer from multipage formats */
	function preloadText( $textbox1, $mTitle ) {
		$page_namespace = $this->page_namespace;
		if ( preg_match( "/^$page_namespace:(.*?)\/([0-9]*)$/", $mTitle->getPrefixedText(), $m ) ) {
			$imageTitle = Title::makeTitleSafe( NS_IMAGE, $m[1] );
			if ( !$imageTitle ) {
				return true;
			}

			$image = wfFindFile( $imageTitle );
			if ( $image && $image->exists() ) {
				$text = $image->handler->getPageText( $image, $m[2] );
				if ( $text ) {
					$text = preg_replace( "/(\\\\n)/", "\n", $text );
					$text = preg_replace( "/(\\\\\d*)/", '', $text );
					$textbox1 = $text;
				}
			}
		}
		return true;
	}

	function movePage( $form, $ot, $nt ) {
		$page_namespace = $this->page_namespace;
		if ( preg_match( "/^$page_namespace:(.*)$/", $ot->getPrefixedText() ) ) {
			$this->load_index( $ot );
			if( $ot->pr_index_title ) {
				$index_title = Title::newFromText( $ot->pr_index_title );
				$index_title->invalidateCache();
				$index = new Article( $index_title );
				if( $index ) {
					$this->update_pr_index( $index );
				}
			}
			return true;
		}

		if ( preg_match( "/^$page_namespace:(.*)$/", $nt->getPrefixedText() ) ) {
			$this->load_index( $nt );
			if( $nt->pr_index_title && ( $nt->pr_index_title != $ot->pr_index_title ) ) {
				$index_title = Title::newFromText( $nt->pr_index_title );
				$index_title->invalidateCache();
				$index = new Article( $index_title );
				if( $index ) {
					$this->update_pr_index( $index );
				}
			}
			return true;
		}
		return true;
	}

	/**
	 * When an index page is created or purged, recompute pr_index values
	 */
	function articlePurge( $article ) {
		$index_namespace = $this->index_namespace;
		$title = $article->mTitle;
		if ( preg_match( "/^$index_namespace:(.*)$/", $title->getPrefixedText() ) ) {
			$this->update_pr_index( $article );
			return true;
		}
		return true;
	}

	function query_count( $dbr, $query, $cat ) {
		$q = $dbr->strencode( str_replace( ' ' , '_' , wfMsgForContent( $cat ) ) );
		$res = $dbr->query( str_replace( '###', $q, $query ), __METHOD__ );
		if( $res && $dbr->numRows( $res ) > 0 ) {
			$row = $dbr->fetchObject( $res );
			$n = $row->count;
			$dbr->freeResult( $res );
			return $n;
		}
		return 0;
	}

	/**
	 * Update the pr_index entry of an article
	 */
	function update_pr_index( $index, $deletedpage = null ) {
		$page_namespace = $this->page_namespace;
		$index_namespace = $this->index_namespace;
		$page_ns_index = MWNamespace::getCanonicalIndex( strtolower( $page_namespace ) );
		if ( $page_ns_index == null ) {
			return;
		}

		$index_title = $index->mTitle;
		$index_id = $index->getID();
		$dbr = wfGetDB( DB_SLAVE );

		// read the list of pages
		$pages = array();
		list( $links, $params, $attributes ) = $this->parse_index( $index_title );
		if( $links == null ) {
			$imageTitle = Title::makeTitleSafe( NS_IMAGE, $index_title->getText() );
			if ( $imageTitle ) {
				$image = wfFindFile( $imageTitle );
				if ( $image && $image->isMultiPage() && $image->pageCount() ) {
					$n = $image->pageCount();
					for ( $i = 1; $i <= $n; $i++ ) {
						$page = $dbr->strencode( $index_title->getDBKey() . '/' . $i );
						if( $page != $deletedpage ) {
							array_push( $pages, $page );
						}
					}
				}
			}
		} else {
			$n = count( $links[1] );
			for ( $i = 0; $i < $n; $i++ ) {
				$page = $dbr->strencode( str_replace( ' ' , '_' , $links[1][$i] ) );
				if( $page != $deletedpage ) {
					array_push( $pages, $page );
				}
			}
		}

		if( $n == 0 ) {
			return;
		}

		$catlinks = $dbr->tableName( 'categorylinks' );
		$page = $dbr->tableName( 'page' );
		$pagelist = "'" . implode( "', '", $pages ) . "'";
		$res = $dbr->select(
			array( 'page' ),
			array( 'COUNT(page_id) AS count'),
			array( "page_namespace=$page_ns_index", "page_title IN ( $pagelist )" ),
			__METHOD__
		);
		if( $res && $dbr->numRows( $res ) > 0 ) {
			$row = $dbr->fetchObject( $res );
			$total = $row->count;
			$dbr->freeResult( $res );
		} else {
			return;
		}

		// proofreading status of pages
		$query = "SELECT COUNT(page_id) AS count FROM $page LEFT JOIN $catlinks ON cl_from=page_id WHERE cl_to='###' AND page_namespace=$page_ns_index AND page_title IN ( $pagelist )" ;
		$n0 = $this->query_count( $dbr, $query, 'proofreadpage_quality0_category' );
		$n2 = $this->query_count( $dbr, $query, 'proofreadpage_quality2_category' );
		$n3 = $this->query_count( $dbr, $query, 'proofreadpage_quality3_category' );
		$n4 = $this->query_count( $dbr, $query, 'proofreadpage_quality4_category' );
		$n1 = $total - $n0 - $n2 - $n3 - $n4;

		$dbw = wfGetDB( DB_MASTER );
		$pr_index = $dbw->tableName( 'pr_index' );
		$query = "REPLACE INTO $pr_index (pr_page_id, pr_count, pr_q0, pr_q1, pr_q2, pr_q3, pr_q4) VALUES ({$index_id},$n,$n0,$n1,$n2,$n3,$n4)";
		$dbw->query( $query, __METHOD__ );
		$dbw->commit();
	}

	/**
	 * In main namespace, display the proofreading status of transcluded pages.
	 *
	 * @param $out Object: OutputPage object
	 */
	function prepareArticle( $out ) {
		global $wgTitle, $wgUser;

		$id = $wgTitle->mArticleID;
		if( $id == -1 ) {
			return true;
		}
		$page_namespace = $this->page_namespace;
		$index_namespace = $this->index_namespace;
		$page_ns_index = MWNamespace::getCanonicalIndex( strtolower( $page_namespace ) );
		$index_ns_index = MWNamespace::getCanonicalIndex( strtolower( $index_namespace ) );
		if( $page_ns_index == null || $index_ns_index == null ) {
			return true;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$page = $dbr->tableName( 'page' );
		$templatelinks = $dbr->tableName( 'templatelinks' );
		$catlinks = $dbr->tableName( 'categorylinks' );

		// find the index page
		$indextitle = null;
		$res = $dbr->select(
			array( 'templatelinks' ),
			array( 'tl_title AS title' ),
			array( "tl_from=$id", "tl_namespace=$page_ns_index" ),
			__METHOD__,
			array( 'LIMIT' => 1 )
		);
		if( $res && $dbr->numRows( $res ) > 0 ) {
			$row = $dbr->fetchObject( $res );
			$title = $dbr->strencode( $row->title );
			$dbr->freeResult( $res );
			$res2 = $dbr->select(
				array( 'pagelinks', 'page' ),
				array( 'page_title AS title' ),
				array(
					"pl_title='$title'",
					"pl_namespace=$page_ns_index",
					"page_namespace=$index_ns_index"
				),
				__METHOD__,
				array( 'LIMIT' => 1 ),
				array( 'page' => array( 'LEFT JOIN', 'page_id=pl_from' ) )
			);
			if( $res2 && $dbr->numRows( $res2 ) > 0 ) {
				$row = $dbr->fetchObject( $res2 );
				$indextitle = $row->title;
				$dbr->freeResult( $res2 );
			}
		}

		if( isset( $out->is_toc ) && $out->is_toc ) {
			if ( $indextitle ) {
				$res = $dbr->select(
					array( 'pr_index', 'page' ),
					array( 'pr_count', 'pr_q0', 'pr_q1', 'pr_q2', 'pr_q3', 'pr_q4' ),
					array( "page_title='$indextitle'", "page_namespace=$index_ns_index" ),
					__METHOD__,
					null,
					array( 'page' => array( 'LEFT JOIN', 'page_id=pr_page_id' ) )
				);
				$row = $dbr->fetchObject( $res );
				if( $row ) {
					$n0 = $row->pr_q0;
					$n1 = $row->pr_q1;
					$n2 = $row->pr_q2;
					$n3 = $row->pr_q3;
					$n4 = $row->pr_q4;
					$n = $row->pr_count;
					$ne = $n - ( $n0 + $n1 + $n2 + $n3 + $n4 );
				}
			}
		} else {
			// count transclusions from page namespace
			$res = $dbr->select(
				array( 'templatelinks', 'page' ),
				array( 'COUNT(page_id) AS count' ),
				array( "tl_from=$id", "tl_namespace=$page_ns_index" ),
				__METHOD__,
				null,
				array( 'page' => array( 'LEFT JOIN', 'page_title=tl_title AND page_namespace=tl_namespace' ) )
			);
			if( $res && $dbr->numRows( $res ) > 0 ) {
				$row = $dbr->fetchObject( $res );
				$n = $row->count;
				$dbr->freeResult( $res );
			}
			// find the proofreading status of transclusions
			$query = "SELECT COUNT(page_id) AS count FROM $templatelinks LEFT JOIN $page ON page_title=tl_title AND page_namespace=tl_namespace LEFT JOIN $catlinks ON cl_from=page_id WHERE tl_from=$id AND tl_namespace=$page_ns_index AND cl_to='###'";
			$n0 = $this->query_count( $dbr, $query, 'proofreadpage_quality0_category' );
			$n2 = $this->query_count( $dbr, $query, 'proofreadpage_quality2_category' );
			$n3 = $this->query_count( $dbr, $query, 'proofreadpage_quality3_category' );
			$n4 = $this->query_count( $dbr, $query, 'proofreadpage_quality4_category' );
			// quality1 is the default value
			$n1 = $n - $n0 - $n2 - $n3 - $n4;
			$ne = 0;
		}

		if( $n == 0 ) {
			return true;
		}

		if( $indextitle ) {
			$sk = $wgUser->getSkin();
			$nt = Title::makeTitleSafe( $index_ns_index, $indextitle );
			$indexlink = $sk->link( $nt, wfMsg( 'proofreadpage_source' ), 
						array( 'title' => wfMsg( 'proofreadpage_source_message' ) ) );
			$out->addInlineScript( ResourceLoader::makeConfigSetScript( array( 'proofreadpage_source_href' => $indexlink ) ) );
			$out->addModules( 'ext.proofreadpage.article' );
		}

		$q0 = $n0 * 100 / $n;
		$q1 = $n1 * 100 / $n;
		$q2 = $n2 * 100 / $n;
		$q3 = $n3 * 100 / $n;
		$q4 = $n4 * 100 / $n;
		$qe = $ne * 100 / $n;
		$void_cell = $ne ? "<td align=center style='border-style:dotted;border-width:1px;' width=\"{$qe}\"></td>" : '';
		$output = "<table class=\"pr_quality\" style=\"line-height:40%;\" border=0 cellpadding=0 cellspacing=0 ><tr>
<td align=center >&nbsp;</td>
<td align=center class='quality4' width=\"$q4\"></td>
<td align=center class='quality3' width=\"$q3\"></td>
<td align=center class='quality2' width=\"$q2\"></td>
<td align=center class='quality1' width=\"$q1\"></td>
<td align=center class='quality0' width=\"$q0\"></td>
$void_cell
</tr></table>";
		$out->setSubtitle( $out->getSubtitle() . $output );
		return true;
	}

}
