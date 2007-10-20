<?php
/**
 * A querypage to list the most wanted categories - implements Special:Wantedcategories
 *
 * @addtogroup SpecialPage
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class WantedCategoriesPage extends QueryPage {

	function getName() { return 'Wantedcategories'; }
	function isExpensive() { return true; }
	function isSyndicated() { return false; }

	function getSQL() {
		$dbr = wfGetDB( DB_SLAVE );
		list( $categorylinks, $page ) = $dbr->tableNamesN( 'categorylinks', 'page' );
		$name = $dbr->addQuotes( $this->getName() );

		global $wgLanguageTag; $cl_language=$wgLanguageTag?',cl_language':'';
		$pl_grp=$wgLanguageTag?',5':'';

		return
			"
			SELECT
				$name as type,
				" . NS_CATEGORY . " as namespace,
				cl_to as title,
				COUNT(*) as value
				$cl_language
			FROM $categorylinks
			LEFT JOIN $page ON cl_to = page_title AND page_namespace = ". NS_CATEGORY ."
			WHERE page_title IS NULL
			GROUP BY 1,2,3
			$pl_grp
			";
	}

	function sortDescending() { return true; }

	/**
	 * Fetch user page links and cache their existence
	 */
	function preprocessResults( &$db, &$res ) {
		global $wgLanguageTag;
		$batch = new LinkBatch;
		while ( $row = $db->fetchObject( $res ) )
			$batch->addObj( $wgLanguageTag ? Title::makeTitleSafe( $row->namespace, $row->title, $row->cl_language ) :
				Title::makeTitleSafe( $row->namespace, $row->title ) );
		$batch->execute();

		// Back to start for display
		if ( $db->numRows( $res ) > 0 )
			// If there are no rows we get an error seeking.
			$db->dataSeek( $res, 0 );
	}

	function formatResult( $skin, $result ) {
		global $wgLang, $wgContLang, $wgLanguageTag;

		$nt = $wgLanguageTag ? Title::makeTitle( $result->namespace, $result->title, $result->cl_language ) :
			Title::makeTitle( $result->namespace, $result->title );
		$text = $wgContLang->convert( $nt->getText() );

		$plink = $this->isCached() ?
			$skin->makeLinkObj( $nt, htmlspecialchars( $text ) ) :
			$skin->makeBrokenLinkObj( $nt, htmlspecialchars( $text ) );

		$nlinks = wfMsgExt( 'nmembers', array( 'parsemag', 'escape'),
			$wgLang->formatNum( $result->value ) );
		return wfSpecialList($plink, $nlinks);
	}
}

/**
 * constructor
 */
function wfSpecialWantedCategories() {
	list( $limit, $offset ) = wfCheckLimits();

	$wpp = new WantedCategoriesPage();

	$wpp->doQuery( $offset, $limit );
}


