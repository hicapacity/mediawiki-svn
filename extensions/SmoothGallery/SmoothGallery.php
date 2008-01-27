<?php
# Copyright (C) 2004 Ryan Lane <rlane32@gmail.com>
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
# 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
# http://www.gnu.org/copyleft/gpl.html

# SmoothGallery extension. Creates galleries of images that are in your wiki.
#
# SmoothGallery.php
#
# Extension info available at http://www.mediawiki.org/wiki/Extension:SmoothGallery
# SmoothGallery available at http://smoothgallery.jondesign.net/
#
# Version 1.0i / 2007-02-03
#

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

$wgExtensionFunctions[] = "wfSmoothGallery";

$wgHooks['OutputPageParserOutput'][] = 'smoothGalleryParserOutput';
$wgHooks['LoadAllMessages'][] = 'loadSmoothGalleryI18n';

$wgAutoloadClasses['SmoothGallery'] = dirname( __FILE__ ) . '/SmoothGalleryClass.php';
$wgAutoloadClasses['SpecialSmoothGallery'] = dirname( __FILE__ ) . '/SpecialSmoothGallery.php';
$wgSpecialPages['SmoothGallery'] = 'SpecialSmoothGallery';

//sane defaults. always initialize to avoid register_globals vulnerabilities
$wgSmoothGalleryDelimiter = "\n";
$wgSmoothGalleryExtensionPath = $wgScriptPath . '/extensions/SmoothGallery';

$wgSmoothGalleryArguments = array();

function wfSmoothGallery() {
	global $wgParser;

	$wgParser->setHook( 'sgallery', 'renderSmoothGallery' );
	$wgParser->setHook( 'sgalleryset', 'renderSmoothGallerySet' );
}

function smoothGalleryImagesByCat( $title ) {
	global $wgContLang;

	$name = $title->getDBkey();

	$dbr = wfGetDB( DB_SLAVE );

	list( $page, $categorylinks ) = $dbr->tableNamesN( 'page', 'categorylinks' );
	$sql = "SELECT page_namespace, page_title FROM $page " .
		"JOIN $categorylinks ON cl_from = page_id " .
		"WHERE cl_to = " . $dbr->addQuotes( $name ) . " " .
		"AND page_namespace = " . NS_IMAGE . " " .
		"ORDER BY cl_sortkey";

	$images = array();
	$res = $dbr->query( $sql, 'smoothGalleryImagesByCat' );
	while ( $row = $dbr->fetchObject( $res ) ) {
		$img = Title::makeTitle( $row->page_namespace, $row->page_title );

		$images[] = $img;
	}
	$dbr->freeResult($res);

	return $images;
}

function renderSmoothGallery( $input, $argv, &$parser, $calledFromSpecial=false, $calledAsSet=false ) {
	global $wgSmoothGalleryArguments;
	global $wgSmoothGalleryUseDatabase;

	parseArguments( $argv );

	$output = '';
	$fallbackOutput = '';

	if ( $calledAsSet ) {
		//Give this gallery a random name so that we can have more than one gallery
		//on a page. But don't do this on a special page, because it will cause
		//us problems with javascript that uses the css classname
		if ( $calledFromSpecial ) {
			$gallerySetName = "MediaWikiSGallerySet";
		} else {
			#$gallerySetName = "MediaWikiSGallerySet" . mt_rand();
			$gallerySetName = "MediaWikiSGallerySet";
		}

		//Open the div, and initialize any needed variables
		$output = '<div id="' . $gallerySetName . '" style="width: ' . $wgSmoothGalleryArguments["width"] . ';height: ' . $wgSmoothGalleryArguments["height"] . '; display: none;" >';
		$fallbackOutput = '';

		//parse set into seperate galleries
		preg_match_all( "/<sgallery([\w]+)?[^>]*>(.*)<\/sgallery>/smU", $input, $galleries, PREG_SET_ORDER );

		//iterate through galleries, call renderGallery on each, and
		//collect the fallback output
		$i = 1;
		foreach ( $galleries as $galleryInput ) {
			if ( $calledFromSpecial ) {
				$galleryName = "MediaWikiSGallery";
			} else {
				$galleryName = "MediaWikiSGallery" . $i;
			}

			$output .= renderGallery( $galleryName, $galleryInput[2], $parser, $calledFromSpecial, $calledAsSet, $fallbackArray );
			$fallbackOutput .= renderFallback( $fallbackArray );
			$i++;
		}

		$output .= '</div>';
		$output .= '<div id="' . $gallerySetName . '-fallback">' . $fallbackOutput . '</div>';
		$output .= renderJavascript( $gallerySetName, true );
	} else {
		if ( $calledFromSpecial ) {
			$name = "MediaWikiSGallery";
		} else {
			$name = "MediaWikiSGallery" . mt_rand();
		}

		$output = renderGallery( $name, $input, $parser, $calledFromSpecial, $calledAsSet, $fallbackArray );
		$output .= renderFallback( $fallbackArray );
		$output .= renderJavascript( $name );
	}

	//Save input and (cache) output to database if
	//the plugin is configured to use the database
	if ( $wgSmoothGalleryUseDatabase ) {
		$gId = addSGTextToDB( $input, $output );

		//Get a local link from the special page
		$sp = Title::newFromText( "Special:SmoothGallery" );
		$locallink = $sp->getLocalURL( "gallery=" . $gId );
		$linktext = htmlspecialchars( $wgSmoothGalleryArguments["special"] );
		if ( $linktext == '' ) {
			$linktext = 'link';
		}
		$link = '<a href="' . $locallink . '">' . $linktext . '</a>';

		if ( $wgSmoothGalleryArguments["special"] != '' ) {
			// We are only sending a special page link
			$output = $link;
		} else if ( !$wgSmoothGalleryArguments["nolink"] ) {
			// We want to send a link with the gallery
			$output = '<div class="MediaWikiSGalleryLink">' . $link . $output . '</div>';
		}
	}

	//Finished, let's send it out
	return $output;
}

function parseArguments( $argv ) {
	global $wgSmoothGalleryArguments;
	global $wgSmoothGalleryUseDatabase;

	//Parse arguments, set defaults, and do sanity checks
	if ( isset( $argv["height"] ) && is_numeric( $argv["height"] ) ) {
		if ( isset( $argv["special"] ) && !$wgSmoothGalleryUseDatabase ) {
			//Creating a link instead, the special page is going to call this
			//function again, so "px" will be appended.
			$wgSmoothGalleryArguments["height"] = $argv["height"];
		} else {
			$wgSmoothGalleryArguments["height"] = $argv["height"] . "px";
		}
	} else {
		$wgSmoothGalleryArguments["height"] = "300px";
	}

	if ( isset( $argv["width"] ) && is_numeric( $argv["width"] ) ) {
		if ( isset( $argv["special"] ) && !$wgSmoothGalleryUseDatabase ) {
			//Creating a link instead, the special page is going to call this
			//function again, so "px" will be appended.
			$wgSmoothGalleryArguments["width"] = $argv["width"];
		} else {
			$wgSmoothGalleryArguments["width"] = $argv["width"] . "px";
		}
	} else {
		$wgSmoothGalleryArguments["width"] = "400px";
	}

	if ( isset( $argv["showcarousel"] ) && $argv["showcarousel"] == "false" ) {
		$wgSmoothGalleryArguments["carousel"] = false;
	} else {
		$wgSmoothGalleryArguments["carousel"] = true;
	}

	if ( isset( $argv["timed"] ) && $argv["timed"] == "true" ) {
		$wgSmoothGalleryArguments["timed"] = true;
	} else {
		$wgSmoothGalleryArguments["timed"] = false;
	}

	if ( isset( $argv["delay"] ) && is_numeric($argv["delay"]) ) {
		$wgSmoothGalleryArguments["delay"] = $argv["delay"];
	} else {
		$wgSmoothGalleryArguments["delay"] = "9000";
	}

	if ( isset( $argv["showarrows"] ) && $argv["showarrows"] == "false" ) {
		$wgSmoothGalleryArguments["showarrows"] = false;
	} else {
		$wgSmoothGalleryArguments["showarrows"] = true;
	}

	if ( isset( $argv["showinfopane"] ) && $argv["showinfopane"] == "false" ) {
		$wgSmoothGalleryArguments["showinfopane"] = false;
	} else {
		$wgSmoothGalleryArguments["showinfopane"] = true;
	}

	if ( isset( $argv["fallback"] ) ) {
		$wgSmoothGalleryArguments["fallback"] = htmlspecialchars( $argv["fallback"] );
	} else {
		$wgSmoothGalleryArguments["fallback"] = "gallery";
	}

	if ( isset( $argv["special"] ) ) {
		$wgSmoothGalleryArguments["special"] = $argv["special"];
	} else {
		$wgSmoothGalleryArguments["special"] = '';
	}

	if ( isset( $argv["nolink"] ) && $argv["nolink"] == "true" ) {
		$wgSmoothGalleryArguments["nolink"] = true;
	} else {
		$wgSmoothGalleryArguments["nolink"] = false;
	}
}

function renderGallery ( $name, $input, $parser, $calledFromSpecial, $calledAsSet, &$fallbackArray ) {
	global $wgContLang, $wgUser, $wgTitle;
	global $wgSmoothGalleryDelimiter;
	global $wgSmoothGalleryArguments;
	global $wgSmoothGalleryUseDatabase;

	$skin = $wgUser->getSkin();

	//Sanity check
	if ( $input == "" ) {
		if ( $calledFromSpecial && $wgSmoothGalleryUseDatabase ) {
			//load input from database
		} else {
			loadSmoothGalleryI18n();
			$output = wfMsg("smoothgallery-error");
			$output .= wfMsg("smoothgallery-not-found");
			return $output;
		}
	}

	if ( $wgSmoothGalleryArguments["special"] ) {
		if ( !$wgSmoothGalleryUseDatabase ) {
			//The user wants a link to a special page instead. Let's provide a link with
			//the relevant info

			//sanity check
			$name = htmlspecialchars( $wgSmoothGalleryArguments["special"] );

			//This is a dirty, dirty hack that should be replaced. It works, and
			//it is safe, but there *MUST* be a better way to do this...
			$input = str_replace( $wgSmoothGalleryDelimiter, '|', $input );

			//Get a local link from the special page
			$sp = Title::newFromText( "Special:SmoothGallery" );
			$output = $sp->getLocalURL( "height=" . $wgSmoothGalleryArguments["height"]
				. "&width=" . $wgSmoothGalleryArguments["width"]
				. "&showcarousel=" . $wgSmoothGalleryArguments["carousel"]
				. "&timed=" . $wgSmoothGalleryArguments["timed"]
				. "&delay=" . $wgSmoothGalleryArguments["delay"]
				. "&showarrows=" . $wgSmoothGalleryArguments["showarrows"]
				. "&showinfopane=" . $wgSmoothGalleryArguments["showinfopane"]
				. "&fallback=" . $wgSmoothGalleryArguments["fallback"]
				. "&input=" . htmlspecialchars( $input ) );

			//Provide the link
			return '<a href="' . $output . '">' . $name . '</a>';
		}
	}

	$parser->mOutput->mSmoothGalleryTag = true; # flag for use by smoothGalleryParserOutput

	//Open the outer div of the gallery
	if ( $calledAsSet ) {
		$output = '<div id="' . $name . '" class="galleryElement">';
		$output .= '<h2>' . $name . '<h2>';
	} else {
		$output = '<div id="' . $name . '" style="width: ' . $wgSmoothGalleryArguments["width"] . ';height: ' . $wgSmoothGalleryArguments["height"] . '; display:none;">';
	}

	//We need a parser to pass to the render function, this
	//seems kinda dirty, but it works on MediaWiki 1.6-1.9...
	$local_parser = clone $parser;
	$local_parser_options = new ParserOptions();
	$local_parser->mOptions = $local_parser_options;
	$local_parser->Title( $wgTitle );
	$local_parser->mArgStack = array();

	//Expand templates in the input
	$local_parser->replaceVariables( $input );

	//The image array is a delimited list of images (strings)
	$line_arr = preg_split( "/$wgSmoothGalleryDelimiter/", $input, -1, PREG_SPLIT_NO_EMPTY );
	$img_count = count( $line_arr );

	//Initialize a string for images we can't find, so that we
	//can report them later
	$missing_img = '';

	$plain_gallery = new ImageGallery();
	$fallback_image = '';

	foreach ( $line_arr as $line ) {
		$img_arr = explode( "|", $line, 2 );
		$img = $img_arr[0];
		if ( count( $img_arr ) > 1 ) {
			$img_desc = $img_arr[1];
		} else {
			$img_desc = '';
		}

		$title = Title::newFromText( $img, NS_IMAGE );

		if ( is_null($title) ) {
			continue;
		}

		$ns = $title->getNamespace();

		if ( $ns == NS_IMAGE ) {
			$output .= renderImage ( $title, $img_count, $missing_img, $fallback_image, $plain_gallery, $skin, $local_parser, $img_desc );
		} else if ( $ns == NS_CATEGORY ) {
			//list images in category
			$cat_images = smoothGalleryImagesByCat( $title );
			if ( $cat_images ) {
				foreach ( $cat_images as $title ) {
					$output .= renderImage ( $title, $img_count, $missing_img, $fallback_image, $plain_gallery, $skin, $local_parser, $img_desc );
				}
			}
		}
	}

	//Make sure we have something to output
	if ( $img_count <= 0 ) {
		//The user requested images, but none of the ones requested
		//actually exist, let's inform the user
		loadSmoothGalleryI18n();

		$output = wfMsg("smoothgallery-error");

		//Sanity check
		if ( $missing_img != "" ) {
			$output .= wfMsg("smoothgallery-no-images", $missing_img);
		} else {
			$output .= wfMsg("smoothgallery-unexpected-error");
		}

		return $output;
	}

	//Close the outer div of the gallery
	$output .= '</div>';

	$fallbackArray = array( 'name'=>$name, 'fallback_image'=>$fallback_image, 'plain_gallery'=>$plain_gallery, 'img_desc'=>$image_desc );

	return $output;
}

function renderFallback ( $fallbackArray ) {
	global $wgSmoothGalleryArguments;
	global $wgSmoothGalleryUseDatabase;

	$output = '';

	if ( $wgSmoothGalleryArguments["special"] != "" && !$wgSmoothGalleryUseDatabase ) {
		return $output;
	}

	if ( $wgSmoothGalleryArguments["fallback"] == "image" ) {
		$output .= '<div id="' . $fallbackArray['name'] . '-fallback" class="MediaWikiSGallerySingleImage" style="width: ' . $wgSmoothGalleryArguments["width"] . ';height: ' . $wgSmoothGalleryArguments["height"] . ';" alt="' . $fallbackArray["img_desc"] . '">';
		$output .= $fallbackArray['fallback_image'];
		$output .= '</div>';
	} elseif ( $wgSmoothGalleryArguments["fallback"] == "image-warn" ) {
		loadSmoothGalleryI18n();
		$output .= '<div id="' . $fallbackArray['name'] . '-fallback" class="MediaWikiSGalleryWarning" style="width: ' . $wgSmoothGalleryArguments["width"] . ';height: ' . $wgSmoothGalleryArguments["height"] . ';" alt="' . $fallbackArray["img_desc"] . '">';
		$output .= wfMsg("smoothgallery-javascript-disabled");
		$output .= '<div class="MediaWikiSGallerySingleImage">';
		$output .= $fallbackArray['fallback_image'];
		$output .= '</div></div>';
	} else {
		$output .= renderPlainGallery ( $fallbackArray['name'], $fallbackArray['plain_gallery'] );
	}

	return $output;
}

function renderImage ( $title, &$img_count, &$missing_img, &$fallback_image, &$plain_gallery, $skin, $local_parser, $img_desc ) {
	global $wgVersion;
	global $wgSmoothGalleryArguments;

	//Get the image object from the database
	$img_obj = Image::newFromTitle( $title );

	if ( !$img_obj->exists() ) {
		//The user asked for an image that doesn't exist, let's
		//add this to the list of missing objects and not output
		//any html
		$img_count = $img_count - 1;
		$missing_img .= " " . htmlspecialchars( $title->getDBkey() );

		return '';
	}

	//check media type. Only images are supported
	$mtype = $img_obj->getMediaType();
	if ( $mtype != MEDIATYPE_DRAWING && $mtype != MEDIATYPE_BITMAP ) {
		$img_count = $img_count - 1;
		return '';
	}

	//Create a thumbnail the same size as our gallery so that
	//full images fit correctly
	$full_thumb_obj = $img_obj->getThumbnail( $wgSmoothGalleryArguments["width"], $wgSmoothGalleryArguments["height"] );
	if ( !is_null($full_thumb_obj) ) {
		$full_thumb = $full_thumb_obj->getUrl();
	} else {
		$img_count = $img_count - 1;
		return '';
	}

	if ( $full_thumb == '' ) {
		//The thumbnail we requested was larger than the image;
		//we need to just provide the image
		$full_thumb = $img_obj->getUrl();
	}

	if ( $fallback_image == '' ) {
		$fallback_image = '<img src="' . $full_thumb . '"  class="full" />';
	}

	if ( $wgSmoothGalleryArguments["carousel"] ) {
		//We are going to show a carousel to the user; we need
		//to make icon thumbnails
		//$thumb_obj = $img_obj->getThumbnail( 120, 120 ); //would be nice to reuse images already loaded...
		$thumb_obj = $img_obj->getThumbnail( 100, 75 );
		if ( $thumb_obj ) {
			$icon_thumb = $thumb_obj->getUrl();
		}
		else {
			//The thumbnail we requested was larger than the image;
			//we need to just provide the image
			$icon_thumb = $img_obj->getUrl();
		}
	}

	$fulldesc = '';

	if ( $wgSmoothGalleryArguments["showinfopane"] ) {
		if ( $img_desc == '' ) {
			//Load the image page from the database with the provided title from
			//the image object
			$db = wfGetDB( DB_SLAVE );
			$img_rev = Revision::loadFromTitle( $db, $title );

			//Get the text from the image page's description
			$fulldesc = $img_rev->getText();
		} else {
			$fulldesc = $img_desc;
		}

		if ( $local_parser ) { //convert wikitext to HTML
			$pout = $local_parser->recursiveTagParse( $fulldesc, $title, $local_parser->mOptions, true );
			$fulldesc =  strip_tags( $pout );
			#$fulldesc =  strip_tags( $pout->getText() );
		} else { //fall back to HTML-escaping
			$fulldesc = htmlspecialchars( $fulldesc );
		}
	}

	//Add the html for the image
	$output = '<div class="imageElement">';
	$output .= '<h3>' . $skin->makeKnownLinkObj($img_obj->getTitle(), $img_obj->getName()) . '</h3>';
	$output .= '<p>' . $fulldesc . '</p>';
	$output .=  '<a href="' . $title->getFullURL() . '" title="open image" class="open"></a>';
	$output .=  '<a href="' . $img_obj->getViewURL() . '" title="open image" class="open"></a>';
	$output .=  '<img src="' . $full_thumb . '"  class="full" alt="' . $fulldesc . '" />';

	if ( $wgSmoothGalleryArguments["carousel"] ) {
		$output .=  '<img src="' . $icon_thumb . '"  class="thumbnail" alt="' . $fulldesc . '" />';
	}

	$output .= '</div>';

	if ( version_compare( $wgVersion, "1.11", '<' ) ) {
		$plain_gallery->add( $img_obj, $fulldesc ); //TODO: use text
	} else {
		$plain_gallery->add( $img_obj->getTitle(), $fulldesc ); //TODO: use text
	}

	return $output;
}

function renderPlainGallery ( $name, $plain_gallery ) {
	//Wrapper div for plain old gallery, to be shown per default, if JS is off.
	$output = '<div id="' . $name . '-fallback">';

	$output .= $plain_gallery->toHTML();

	//Close the wrapper div for the plain old gallery
	$output .= '</div>';

	return $output;
}

function renderJavascript ( $name, $calledAsSet=false ) {
	global $wgSmoothGalleryArguments;

	//Output the javascript needed for the gallery with any
	//options the user requested
	$output = '<script type="text/javascript">';

	$output .= 'document.getElementById("' . $name . '-fallback").style.display = "none";'; //hide plain gallery
	$output .= 'document.getElementById("' . $name . '").style.display = "block";'; //show smooth gallery

	$output .= 'function startGallery_' . $name . '() {';
	if ( $calledAsSet ) {
		$output .= "var MediaWikiSGallerySet = new gallerySet($('" . $name . "'), {";
	} else {
		$output .= "var MediaWikiSGallery = new gallery($('" . $name . "'), {";
	}

	$output .= 'thumbWidth: 100, thumbHeight: 75'; //would be nice if we could change this to 120x120 to re-use thumbnails...

	//Add user provided options
	if ( $wgSmoothGalleryArguments["timed"] ) {
		$output .= ', timed: true';
		$output .= ', delay: ' . $wgSmoothGalleryArguments["delay"];
	}

	if ( !$wgSmoothGalleryArguments["carousel"] ) {
		$output .= ', showCarousel: false';
	}

	if ( !$wgSmoothGalleryArguments["showarrows"] ) {
		$output .= ', showArrows: false';
	}

	if ( !$wgSmoothGalleryArguments["showinfopane"] ) {
		$output .= ', showInfopane: false';
	}

	$output .= ', useHistoryManager: true';
	#$output .= ', preloader: true';
	#$output .= ', preloaderImage: true';
	#$output .= ', preloaderErrorImage: true';
	#$output .= ', carouselPreloader: true';
	#$output .= ", textPreloadingCarousel: '" . wfMsg("smoothgallery-loading") . "'";

	$output .= '});';
	$output .= 'HistoryManager.start();';
	$output .= '}';
	$output .= "window.addEvent('domready', startGallery_$name);";
	#$output .= 'addOnloadHook(startGallery_' . $name . ');';
	$output .= '</script>';

	return $output;
}

function addSGTextToDB($input, $cache) {
	global $wgSharedDB, $wgDBname;
	$dbw =& wfGetDB( DB_MASTER );

	if (isset($wgSharedDB)) {
		# It would be nicer to get the existing dbname
		# and save it, but it's not possible
		$dbw->selectDB($wgSharedDB);
	}

	$dbw->insert('text_sg', array('sg_text' => $dbw->addQuotes( $input ),
					  'sg_cache' => $cache));
	return $dbw->insertId();
}

function renderSmoothGallerySet( $input, $args, &$parser, $calledFromSpecial=false ) {
	$parser->mOutput->mSmoothGallerySetTag = true; # flag for use by smoothGalleryParserOutput

	$output = renderSmoothGallery( $input, $args, $parser, $calledFromSpecial, true );

	return $output;
}

/**
 * Hook callback that injects messages and things into the <head> tag
 * Does nothing if $parserOutput->mSmoothGalleryTag is not set
 */
function smoothGalleryParserOutput( &$outputPage, &$parserOutput )  {
	if ( !empty( $parserOutput->mSmoothGalleryTag ) ) {
		SmoothGallery::setGalleryHeaders( $outputPage );
	}
	if ( !empty( $parserOutput->mSmoothGallerySetTag ) ) {
		SmoothGallery::setGallerySetHeaders( $outputPage );
	}
	return true;
}

/**
 * Load the SmoothGallery internationalization file
 */
function loadSmoothGalleryI18n() {
	global $wgContLang, $wgMessageCache;

	static $initialized = false;

	if ( $initialized ) return true;

	$messages = array();

	$f = dirname( __FILE__ ) . '/SmoothGallery.i18n.php';
	include( $f );

	$f = dirname( __FILE__ ) . '/SmoothGallery.i18n.' . $wgContLang->getCode() . '.php';
	if ( file_exists( $f ) ) include( $f );

	$initialized = true;
	$wgMessageCache->addMessages( $messages );

	return true;
}


/**
 * Add extension information to Special:Version
 */
$wgExtensionCredits['other'][] = array(
	'name'        => 'SmoothGallery parser extension',
	'version'     => '1.1a',
	'author'      => 'Ryan Lane',
	'description' => 'Allows users to create galleries with images that have been uploaded. Allows most options of SmoothGallery',
	'url'         => 'http://www.mediawiki.org/wiki/Extension:SmoothGallery',
);
