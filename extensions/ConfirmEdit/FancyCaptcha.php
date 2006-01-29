<?php
/**
 * Experimental image-based captcha plugin, using images generated by an
 * external tool.
 *
 * Copyright (C) 2005, 2006 Brion Vibber <brion@pobox.com>
 * http://www.mediawiki.org/
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
 *
 * @package MediaWiki
 * @subpackage Extensions
 */

if ( defined( 'MEDIAWIKI' ) ) {

global $wgCaptchaDirectory;
$wgCaptchaDirectory = "$wgUploadDirectory/captcha"; // bad default :D

global $wgCaptchaSecret;
$wgCaptchaSecret = "CHANGE_THIS_SECRET!";


class FancyCaptcha extends SimpleCaptcha {
	/**
	 * Check if the submitted form matches the captcha session data provided
	 * by the plugin when the form was generated.
	 *
	 * @param WebRequest $request
	 * @param array $info
	 * @return bool
	 */
	function keyMatch( $request, $info ) {
		global $wgCaptchaSecret;
		
		$answer = $request->getVal( 'wpCaptchaWord' );
		$digest = $wgCaptchaSecret . $info['salt'] . $answer . $wgCaptchaSecret . $info['salt'];
		$answerHash = substr( md5( $digest ), 0, 16 );
		
		if( $answerHash == $info['hash'] ) {
			wfDebug( "FancyCaptcha: answer hash matches expected $hash\n" );
			return true;
		} else {
			wfDebug( "FancyCaptcha: answer hashes to $answerHash, expected {$info['hash']}\n" );
			return false;
		}
	}
	
	/**
	 * Insert the captcha prompt into the edit form.
	 */
	function formCallback( &$out ) {
		$info = $this->pickImage();
		if( !$info ) {
			die( "out of captcha images; this shouldn't happen" );
		}
		
		// Generate a random key for use of this captcha image in this session.
		// This is needed so multiple edits in separate tabs or windows can
		// go through without extra pain.
		$index = $this->storeCaptcha( $info );
		
		wfDebug( "Captcha id $index using hash ${info['hash']}, salt ${info['salt']}.\n" );
		
		$title = Title::makeTitle( NS_SPECIAL, 'Captcha/image' );
		
		$out->addWikiText( wfMsg( "captcha-short" ) );
		
		$out->addHTML( "<p>" . 
			wfElement( 'img', array(
				'src'    => $title->getLocalUrl( 'wpCaptchaId=' . urlencode( $index ) ),
				'width'  => $info['width'],
				'height' => $info['height'],
				'alt'    => '' ) ) .
			"</p>\n" .
			wfElement( 'input', array(
				'type'  => 'hidden',
				'name'  => 'wpCaptchaId',
				'id'    => 'wpCaptchaId',
				'value' => $index ) ) .
			"<p>" .
			wfElement( 'input', array(
				'name' => 'wpCaptchaWord',
				'id'   => 'wpCaptchaWord',
				'tabindex' => 1 ) ) . // tab in before the edit textarea
			"</p>\n" );
	}
	
	/**
	 * Select a previously generated captcha image from the queue.
	 * @fixme subject to race conditions if lots of files vanish
	 * @return mixed tuple of (salt key, text hash) or false if no image to find
	 */
	function pickImage() {
		global $wgCaptchaDirectory;
		$n = mt_rand( 0, $this->countFiles( $wgCaptchaDirectory ) );
		$dir = opendir( $wgCaptchaDirectory );
		
		$count = 0;
		
		$entry = readdir( $dir );
		$pick = false;
		while( false !== $entry ) {
			$entry = readdir( $dir );
			if( preg_match( '/^image_([0-9a-f]+)_([0-9a-f]+)\\.png$/', $entry, $matches ) ) {
				$size = getimagesize( "$wgCaptchaDirectory/$entry" );
				$pick = array(
					'salt' => $matches[1],
					'hash' => $matches[2],
					'width' => $size[0],
					'height' => $size[1],
					'viewed' => false,
				);
				if( $count++ == $n ) {
					break;
				}
			}
		}
		closedir( $dir );
		return $pick;
	}
	
	/**
	 * Count the number of files in a directory.
	 * @return int
	 */
	function countFiles( $dirname ) {
		$dir = opendir( $dirname );
		$count = 0;
		while( false !== ($entry = readdir( $dir ) ) ) {
			if( $dir != '.' && $dir != '..' ) {
				$count++;
			}
		}
		closedir( $dir );
		return $count;
	}
	
	function showImage() {
		global $wgOut, $wgRequest;
		global $wgCaptchaDirectory;
		
		$wgOut->disable();
		
		$info = $this->retrieveCaptcha();
		if( $info ) {
			if( $info['viewed'] ) {
				wfHttpError( 403, 'Access Forbidden', "Can't view captcha image a second time." );
				return false;
			}
			
			$info['viewed'] = wfTimestamp();
			$this->storeCaptcha( $info );
			
			$salt = $info['salt'];
			$hash = $info['hash'];
			$file = $wgCaptchaDirectory . DIRECTORY_SEPARATOR . "image_{$salt}_{$hash}.png";
			
			if( file_exists( $file ) ) {
				header( 'Content-type: image/png' );
				readfile( $file );
				return true;
			}
		}
		wfHttpError( 500, 'Internal Error', 'Requested bogus captcha image' );
		return false;
	}
}

} # End invocation guard

?>
