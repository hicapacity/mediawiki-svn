<?php

class CategoryIntersection extends SpecialPage {
	var $max_categories;
	var $max_hash_results;
	var $max_real_results;
	var $second_check;

	# Constructor
	function __construct() {
		parent::__construct( "CategoryIntersection" );
		wfLoadExtensionMessages( 'CategoryIntersection' );

		# Limits
		$this->max_categories = 5;
		$this->max_hash_results = 500;
		$this->max_real_results = $this->max_hash_results;
		$this->second_check = false;
	}

	# Here plays the music
	function execute( $par ) {
		global $wgRequest, $wgOut;

		$this->setHeaders();

		# Get request data
		$lines = $wgRequest->getText( 'lines' );
		$doit = $wgRequest->getText( 'doit' );

		if ( $doit == '' ) {
			$output = $this->getForm();
		} else {
			$output = $this->run( $lines );
		}

		# Output
		$wgOut->addHTML( $output );
	}

	# Generate the submission form
	function getForm() {
		$ret = '';
		$ret .= "<form method='post'>";
		$ret .= "<textarea name='lines' rows='10' cols='50' style='width:100%'></textarea><br />";
		$ret .= '<input type="submit" name="doit" value="' . wfMsgHtml( 'categoryintersection-doit' ) . '" />';
		$ret .= "</form>";
		return $ret;
	}

	# Do the actual work
	function run( $lines ) {
		global $wgOut;

		$fname = 'CategoryIntersection::run';

		$dbr = wfGetDB ( DB_SLAVE );
		$table_categoryintersections = $dbr->tableName ( 'categoryintersections' );
		$table_categorylinks = $dbr->tableName ( 'categorylinks' );

		# Parse list of categories
		$lines = explode ( "\n", $lines );
		$arr = array();
		foreach ( $lines AS $l ) {
			$l = trim ( $l );
			if ( $l == '' ) continue;
			$t = Title::newFromText ( $l );
			if ( $t ) { // in case of invalid input
				$arr[] = $t->getDBkey();
			}
		}

		$numb_categories = count( $arr );
		if ( $numb_categories > $this->max_categories ) {
			return wfMsgExt( 'categoryintersection-maxcategories', 'parsemag', $this->max_categories );
		}

		if ( $numb_categories < 2 ) {
			return wfMsgExt( 'categoryintersection-mincategories', 'parsemag' );
		}

		# Generate hash values for all combinations
		$hashes = CategoryIntersectionGetHashValues ( $arr );

		if ( empty( $hashes ) ) {
			// Could potentially happen if user tries to do the 
			// intersection of a category with itself.
			return wfMsgExt( 'categoryintersection-mincategories', 'parsemag' );
		}

		# Generate (sub)query chain
		# TODO : Do we really need all combinations?
		$query = "";
		foreach ( $hashes AS $hash ) {
			$q2 = "SELECT ci_page FROM {$table_categoryintersections} WHERE ci_hash = \"{$hash}\""; # FIXME : table/field name
			if ( $query != "" ) $q2 .= " AND ci_page IN ({$query})";
			$query = $q2;
		}
		$query .= " LIMIT " . $this->max_hash_results; # Max number of hash results

		# This is safe, as the only parameters used are hash values generated by CategoryIntersectionGetHashValues()
		$res = $dbr->query( $query, $fname );

		if ( !$res ) {
			return '';
		}

		# page_ids will contain the /candidates/ for results. Remember: Hashes are not necessarily unique!
		$page_ids = array ();
		while ( $row = $dbr->fetchObject( $res ) ) {
			$page_ids[] = $row->ci_page;
		}

		# Now check which of these are real - or don't
		$titles = array ();
		if ( $this->second_check ) {
			$carr = count ( $arr );
			foreach ( $page_ids AS $id ) {
				# This is safe; $arr contains only DB keys generated by Title; $id is a number from the last query
				$query = "SELECT count(cl_to) AS x FROM {$table_categorylinks} WHERE cl_from = {$id} AND cl_to IN (\"" . implode ( "\",\"", $arr ) . "\") LIMIT $carr";
				$res = $dbr->query( $query, $fname );
				if ( !$res ) {
					continue;
				}
				$row = $dbr->fetchObject( $res );
				$count = $row->x;
				if ( $count < $carr ) {
					continue; # This is not the article you are looking for...
				}
				$titles[] = Title::newFromID ( $id );
				if ( count ( $titles ) >= $this->max_real_results ) {
					break;
				}
			}
		} else {
			foreach ( $page_ids AS $id ) {
				$titles[] = Title::newFromID ( $id ) ;
			}
		}

		# Generate title list in wiki markup
		$wiki = '';
		foreach ( $titles AS $t ) {
			$ft = $t->getFullText();
			$wiki .= "# [[:{$ft}|{$ft}]]\n";
		}
		$wgOut->addWikiText ( $wiki );

		# Final message
		global $wgLang;
		$count = $wgLang->formatNum( count( $titles ) );
		return '<hr/>' . wfMsgExt( 'categoryintersection-results', 'parse', $count );
	}
}
