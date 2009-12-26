<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Statistic output classes.
 *
 * @file
 * @ingroup MaintenanceLanguage
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @author Ashar Voultoiz <thoane@altern.org>
 */

/** A general output object. Need to be overriden */
class statsOutput {
	function formatPercent( $subset, $total, $revert = false, $accuracy = 2 ) {
		return @sprintf( '%.' . $accuracy . 'f%%', 100 * $subset / $total );
	}

	# Override the following methods
	function heading() {
	}
	function footer() {
	}
	function blockstart() {
	}
	function blockend() {
	}
	function element( $in, $heading = false ) {
	}
}

/** Outputs WikiText */
class wikiStatsOutput extends statsOutput {
	function heading() {
		global $IP;
		$version = SpecialVersion::getVersion( 'nodb' );
		echo "'''Statistics are based on:''' <code>" . $version . "</code>\n\n";
		echo "'''Note:''' These statistics can be generated by running <code>php maintenance/language/transstat.php</code>.\n\n";
		echo "For additional information on specific languages (the message names, the actual problems, etc.), run <code>php maintenance/language/checkLanguage.php --lang=foo</code>.\n\n";
		echo '{| class="sortable wikitable" border="2" cellpadding="4" cellspacing="0" style="background-color: #F9F9F9; border: 1px #AAAAAA solid; border-collapse: collapse; clear:both;" width="100%"'."\n";
	}
	function footer() {
		echo "|}\n";
	}
	function blockstart() {
		echo "|-\n";
	}
	function blockend() {
		echo '';
	}
	function element( $in, $heading = false ) {
		echo ($heading ? '!' : '|') . "$in\n";
	}
	function formatPercent( $subset, $total, $revert = false, $accuracy = 2 ) {
		$v = @round(255 * $subset / $total);
		if ( $revert ) {
			$v = 255 - $v;
		}
		if ( $v < 128 ) {
			# Red to Yellow
			$red = 'FF';
			$green = sprintf( '%02X', 2 * $v );
		} else {
			# Yellow to Green
			$red = sprintf('%02X', 2 * ( 255 - $v ) );
			$green = 'FF';
		}
		$blue = '00';
		$color = $red . $green . $blue;

		$percent = statsOutput::formatPercent( $subset, $total, $revert, $accuracy );
		return 'bgcolor="#'. $color .'"|'. $percent;
	}
}

/** Output text. To be used on a terminal for example. */
class textStatsOutput extends statsOutput {
	function element( $in, $heading = false ) {
		echo $in."\t";
	}
	function blockend() {
		echo "\n";
	}
}

/** csv output. Some people love excel */
class csvStatsOutput extends statsOutput {
	function element( $in, $heading = false ) {
		echo $in . ";";
	}
	function blockend() {
		echo "\n";
	}
}
