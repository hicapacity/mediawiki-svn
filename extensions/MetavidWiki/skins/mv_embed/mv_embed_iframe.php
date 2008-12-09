<?php
/*
mv_embed_iframe.php
this allows for remote embedding without exposing the hosting site to javascript. 
*/

mv_embed_iframe();

function mv_embed_iframe() {
	if(!function_exists('filter_input')){
		die('your version of php lacks <b>filter_input()</b> function</br>');
	}	
	//default to null media in not provided:	
	$query_ary = explode('&', $_SERVER['QUERY_STRING']);
	$row_url = $width = $height ='';
	//rejoin url (could not find the standard encoding for Get URL in requests)	
	foreach($query_ary as $get_pair_str){
		 list($key, $val) = explode('=' ,$get_pair_str,2);
		 if( $key=='width' )
		 	$width = (int) $val;
		 
		 if( $key == 'height' )
		 	$height = (int) $val;
		 	
		 if( $key == 'roe_url' )
		 	$roe_url = $val;	
		 
		 if( $key == 'size' ){
		 	list( $width, $height ) = explode('x', $val);
		 	$width = (int) $width;
		 	$height = (int) $height;
		 }
		 	
		 if( substr($get_pair_str, 0, 4) == 'amp;' )
		 	$roe_url.= '&' . str_replace('amp;','', $key) .'='. $val;
	}	
	if( $roe_url == '' ){
		die('not valid or missing roe url');
	}
		
	if( $width=='' ){
		$width=400;
	}	
	if( $height=='' ){
		$height=300;
	}
		
	//everything good output page: 
	output_page(array(
		'roe_url' => $roe_url,
		'width' => $width,
		'height' => $height,
	));
}

/**
 * JS escape function copied from MediaWiki's Xml::escapeJsString()
 */
function wfEscapeJsString( $string ) {
	// See ECMA 262 section 7.8.4 for string literal format
	$pairs = array(
		"\\" => "\\\\",
		"\"" => "\\\"",
		'\'' => '\\\'',
		"\n" => "\\n",
		"\r" => "\\r",

		# To avoid closing the element or CDATA section
		"<" => "\\x3c",
		">" => "\\x3e",

		# To avoid any complaints about bad entity refs
		"&" => "\\x26",

		# Work around https://bugzilla.mozilla.org/show_bug.cgi?id=274152
		# Encode certain Unicode formatting chars so affected
		# versions of Gecko don't misinterpret our strings;
		# this is a common problem with Farsi text.
		"\xe2\x80\x8c" => "\\u200c", // ZERO WIDTH NON-JOINER
		"\xe2\x80\x8d" => "\\u200d", // ZERO WIDTH JOINER
	);
	return strtr( $string, $pairs );
}

function error_out($error=''){
	output_page(array('error' => $error));
	exit();
}
function output_page($params){
	extract( $params );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>mv_embed iframe</title>	
	<style type="text/css"> 
	<!--
	body {
		margin-left: 0px;
		margin-top: 0px;
		margin-right: 0px;
		margin-bottom: 0px;
	}
	-->
	</style>
		<script type="text/javascript" src="mv_embed.js"></script>
	</head>
	<body>
		<video roe="<?php echo htmlspecialchars( $roe_url )?>" width="<?php echo htmlspecialchars( $width )?>"
			   height="<?php echo htmlspecialchars( $height )?>"></video>	
	</body>
	</html>
<?
}
?>
