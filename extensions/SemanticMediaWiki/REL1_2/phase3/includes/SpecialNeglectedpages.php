<?php
# Suggestion from mailing list: lists pages in order
# least recently reviewed.
#

function wfSpecialNeglectedpages()
{
	global $wgUser, $wgOut;

	$wgOut->addHTML( "<p>(TODO: neglected pages)" );
}

?>
