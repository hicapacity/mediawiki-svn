<?

function wfSpecialRandompage()
{
	global $wgOut, $wgTitle, $wgArticle;

	$conn = wfGetDB();
	$sql = "SELECT cur_id FROM cur WHERE (cur_namespace=0 " .
	  "AND cur_is_redirect=0)";
	$res = wfQuery( $sql, $conn, "wfSpecialRandompage" );

	$n = mysql_num_rows( $res ) - 1;
	wfSeedRandom();
	mysql_data_seek( $res, mt_rand( 0, $n ) );

	$s = mysql_fetch_object( $res );
	$newid = $s->cur_id;

	$wgArticle = Article::newFromID( $newid );
	$wgOut->setArticleFlag( true );
	$wgArticle->view();
}

?>
