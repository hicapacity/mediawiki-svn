<?
function upload () {
	global $THESCRIPT ;
	global $removeFile , $xtitle , $removeFile , $Upload , $Upload_name , $no_copyright ;
	global $user , $vpage , $wikiUploadTitle , $wikiUploadText , $wikiUploadDenied ;
	global $wikiUploadDeleted , $wikiUploadDelMsg1 , $wikiUploadDelMsg2 ;
	global $wikiUploadAffirm , $wikiUploadFull ;
	global $wikiUploadSuccess , $wikiUploadSuccess1 , $wikiUploadSuccess2 ;
	global $wikiUploadAffirmText , $wikiUploadButton ;
	$vpage->special ( $wikiUploadTitle ) ;
	$isSysop = in_array ( "is_sysop" , $user->rights ) ;
	$xtitle = $wikiUploadPage ;
	$ret = "<nowiki>" ;

	$message = "" ;

	if (isset($removeFile)) {
		if ( !$isSysop ) return $wikiUploadDenied ;
		if (is_file("./upload/$removeFile") ) unlink ("./upload/$removeFile");
		$message = str_replace ( "$1" , $removeFile , $wikiUploadDeleted ) ;

		# Appending log page "log:Uploads"
		$now = date ( "Y-m-d H:i:s" , time () ) ;
		$logText = str_replace ( "$1" , $user->name , str_replace ( "$2" , $removeFile , $wikiUploadDelMsg1 ) ) ;
		makeLog ( "log:Uploads" , $logText , str_replace ( "$1" , $removeFile , $wikiUploadDelMsg2 ) ) ;

		unset ( $removeFile ) ;
	} else if (isset($Upload_name) or isset($Upload)) {
		if ( $no_copyright != "AFFIRMED" ) return $wikiUploadAffirm ;
#		$Upload_name = ereg_replace(" ", "_", $Upload_name);
		$abc = split("\.", $Upload_name);

		$num = exec ("df");
		$readata = substr($num,(strpos($num, "%")-2),2);

		if ($readata > 96) {
			$ret .= "<body bgcolor=white>\n";
			$ret .= "<br><b>$wikiUploadFull</b>\n";
			return $ret ;
			}

		copy ( $Upload , "./upload/$Upload_name" ) ;
		chmod ( "./upload/$Upload_name" , 0777 ) ;
		$message = str_replace ( "$1" , htmlspecialchars ( $Upload_name ) , $wikiUploadSuccess ) ;

		# Appending log page "log:Uploads"
		global $REMODE_ADDR ;
		$now = date ( "Y-m-d H:i:s" , time () ) ;
		$userText = "[[user:$user->name|$user->name]]" ;
		if ( $user->name == "" ) $userText = $REMODE_ADDR ;
		$logText = str_replace ( "$1" , $now , str_replace ( "$2" , $userText , str_replace ( "$3" , htmlspecialchars ( $Upload_name ) , $wikiUploadSuccess1 ) ) ) ;
		makeLog ( "log:Uploads" , $logText , str_replace ( "$1" , $Upload_name , $wikiUploadSuccess2 ) ) ;

		unset ( $Upload_name ) ;
	}

	if ( $message != "" ) $ret .= "<font color=red>$message</font><br>\n" ;
	$ret .= $wikiUploadText ;
	$ret .= " <form enctype=\"multipart/form-data\" action=\"".wikiLink("special:upload")."\" method=post>\n";
	$ret .= " <input type=hidden name=max value=20096>\n";
	$ret .= " <input name=Upload type=\"file\"><br>\n";
	$ret .= " <input type=hidden name=update value=1>\n";
	$ret .= " <input type=hidden name=step value=$step>\n";
	$ret .= "<INPUT TYPE=checkbox NAME=\"no_copyright\" VALUE=\"AFFIRMED\">$wikiUploadAffirmText<br>\n" ;
	$ret .= " <input type=submit name=Upload value=$wikiUploadButton>\n";
	$ret .= "</form>\n";

	global $wikiUploadPrev , $wikiUploadSize , $wikiFileRemoval , $wikiUploadRemove, $THESCRIPT ;

	if (is_dir("upload")) {
		$mydir = dir("upload");
			while ($entry = $mydir->read()) {
			if ($entry != "." and $entry != "..")
				$file = "yes";
			}
		$mydir->close();
		$uploaddir = ereg_replace("[A-Za-z0-9_.]+$", "upload", $THESCRIPT);

		if ($file == "yes") {
			$ret .= "<h2>$wikiUploadPrev</h2>";
			$mydir = opendir("upload");
			$i = 0;
			$ret .= "<table border=1 width=\"100%\">\n";
			$ret .= "<tr><th>File</th><th>$wikiUploadSize</th>";
			if ( $isSysop )
				$ret .= "<th>$wikiFileRemoval</th>";
			$ret .= "</tr>\n" ;
			while ($entry = readdir($mydir)) {
				if ($entry != '.' && $entry != '..') {
					$ret .= "<tr><td align=center>" ;
					$ret .= "<a href=\"$uploaddir/".rawurlencode($entry)."\">".htmlspecialchars($entry)."</a></td>";
					$ret .= "<td align=center>".filesize("upload/$entry")." bytes</td>";
					if ( $isSysop )  {
						$ret .= "<td align=center><a href=\"".wikiLink("special:upload&removeFile=".urlencode($entry))."\">" ;
						$ret .= str_replace ( "$1" , $entry , $wikiUploadRemove ) ;
						$ret .= "</a></td>" ;
						}
					$ret .= "</tr>" ;
					$i++;
				}
			}
		$ret .= "</table>\n";
		closedir($mydir);
		}
	}
	$ret .= "</nowiki>" ;
	return $ret ;
	}

?>