<?php
require_once( 'SearchEngineTest.php' );

class SearchMySQL4Test extends SearchEngineTest {
	var $db;

	function setUp() {
		$GLOBALS['wgContLang'] = new Language;
		$this->db = $this->buildTestDatabase(
			array( 'page', 'revision', 'text', 'searchindex' ) );
		if( $this->db ) {
			$this->insertSearchData();
		}
		$this->search = new SearchMySQL4( $this->db );
	}

	function tearDown() {
		if( !is_null( $this->db ) ) {
			wfGetLB()->closeConnecton( $this->db );
		}
		unset( $this->db );
		unset( $this->search );
	}

}


