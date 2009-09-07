<?php

// LiquidThreads API Query module

// Data that can be returned:
// - ID
// - Subject
// - "host page"
// - parent
// - ancestor
// - creation time
// - modification time
// - author
// - summary article ID
// - "root" page ID
// - type

class ApiQueryLQTThreads extends ApiQueryBase {

	// Property definitions
	static $propRelations = array(
			'id' => 'thread_id',
			'subject' => 'thread_subject',
			'page' => array( 'namespace' => 'thread_article_namespace',
								'title' => 'thread_article_title' ),
			'parent' => 'thread_parent',
			'ancestor' => 'thread_ancestor',
			'created' => 'thread_created',
			'modified' => 'thread_modified',
			'author' => array( 'id' => 'thread_author_id',
								'name' => 'thread_author_name'),
			'summaryid' => 'thread_summary_page',
			'rootid' => 'thread_root',
			'type' => 'thread_type',
		);

	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName, 'lqt');
	}

	public function execute() {
		global $wgUser;
			
		$params = $this->extractRequestParams();
		$prop = array_flip($params['prop']);
		
		$result = $this->getResult();

		$this->addTables('thread');
		
		$this->addFields('thread_id');
		
		foreach( self::$propRelations as $name => $fields ) {
			$addFields = $fields;
			
			if ( is_array($addFields) ) $addFields = array_values($addFields);

			$this->addFieldsIf( $addFields, isset($prop[$name]) );
		}
		
		// Check for conditions
		$conditionFields = array( 'page', 'root', 'summary', 'author', 'id' );
		
		foreach( $conditionFields as $field ) {
			if ( isset($params[$field]) ) {
				$this->handleCondition( $field, $params[$field] );
			}
		}

		$this->addOption('LIMIT', $params['limit'] + 1);
		
		$this->addWhereRange('thread_id', $params['dir'],
								$params['startid'], $params['endid']);
		
		if (!is_null($params['show'])) {		
			$show = array_flip($params['show']);
			$delType = $this->getDB()->addQuotes( Threads::TYPE_DELETED );
			
			$this->addWhereIf( 'thread_type != '.$delType, isset($show['deleted']) );
		}
		
		$res = $this->select( __METHOD__ );
		
		$count = 0;
		while($row = $res->fetchObject())
		{
			if( ++$count > $params['limit'] ) {
				// We've had enough
				$this->setContinueEnumParameter('startid', $row->thread_id);
				break;
			}
			
			$entry = array();
			
			foreach( $prop as $name => $nothing ) {
				$fields = self::$propRelations[$name];
				$entry[$name] = self::formatProperty( $name, $fields, $row );
			}
			
			if ($entry) {
				$fit = $result->addValue(array( 'query', $this->getModuleName() ), null,
											$entry);
											
				if(!$fit) {
					$this->setContinueEnumParameter('startid', $row->thread_id);
					break;
				}
			}
		}
		$result->setIndexedTagName_internal(array('query', $this->getModuleName()), 'thread');
	}
	
	static function formatProperty( $name, $fields, $row ) {
		// Common case.
		if ( !is_array($fields) ) {
			return $row->$fields;
		}
		
		// Special cases
		if ($name == 'page') {
			$nsField = $fields['namespace'];
			$tField = $fields['title'];
			$title = Title::makeTitleSafe( $row->$nsField, $row->$tField );
			return $title->getPrefixedText();
		}
		
		// Complicated case.
		$result = array();
		foreach( $fields as $part => $field ) {
			$result[$part] = $row->$field;
		}
		
		return $result;
	}
	
	function addPageCond( $prop, $value ) {
	
		$value = explode( '|', $value );
		
		if ( count($value) === 1 ) {
			$cond = $this->getPageCond($prop, $value[0]);
			$this->addWhere( $cond );
		} else {
			$conds = array();
			
			foreach( $value as $page ) {
				$cond = $this->getPageCond( $prop, $page );
				$conds[] = $this->getDB()->makeList( $cond, LIST_AND );
			}
			
			$cond = $this->getDB()->makeList( $conds, LIST_OR );
			
			$this->addWhere( $cond );
		}
	}
	
	function getPageCond( $prop, $value ) {
		$fieldMappings = array( 'page' =>
								array( 'namespace' => 'thread_article_namespace',
										'title' => 'thread_article_title',
									),
								'root' => array( 'id' => 'thread_root' ),
								'summary' => array( 'id' => 'thread_summary_id' ),
							);
		// Split.
		$t = Title::newFromText( $value );
		
		$cond = array();
		
		foreach( $fieldMappings[$prop] as $type => $field ) {
			switch($type) {
				case 'namespace':
					$cond[$field] = $t->getNamespace();
					break;
				case 'title':
					$cond[$field] = $t->getDBkey();
					break;
				case 'id':
					$cond[$field] = $t->getArticleID();
					break;
				default:
					throw new MWException( "Unknown condition type $type" );
			}
		}
		
		return $cond;
	}
	
	function handleCondition( $prop, $value ) {
		// Special cases
		$titleParams = array( 'page', 'root', 'summary' );
		
		if ( in_array( $prop, $titleParams ) ) {
			return $this->addPageCond( $prop, $value );
		}
		
		$fields = self::$propRelations[$prop];
		
		// Some cases where we can pull more than one
		$multiParams = array( 'id', 'author' );
		if ( in_array( $prop, $multiParams ) ) {
			$value = explode( '|', $value );
		}
		
		// Common case
		if ( !is_array( $fields ) ) {
			return $this->addWhere( array( $fields => $value ) );
		}
		
		// Other special cases.
		if ( $prop == 'author' ) {
			$this->addWhere( array( 'thread_author_name' => $value ) );
		}
	}

	public function getAllowedParams() {
		return array (
			'startid' => array(
				ApiBase :: PARAM_TYPE => 'integer'
			),
			'endid' => array(
				ApiBase :: PARAM_TYPE => 'integer',
			),
			'dir' => array(
				ApiBase :: PARAM_TYPE => array(
					'older',
					'newer'
				),
				ApiBase :: PARAM_DFLT => 'newer'
			),
			'show' => array(
				ApiBase :: PARAM_ISMULTI => true,
				ApiBase :: PARAM_TYPE => array (
					'deleted',
				),
			),
			'limit' => array(
				ApiBase :: PARAM_DFLT => 10,
				ApiBase :: PARAM_TYPE => 'limit',
				ApiBase :: PARAM_MIN => 1,
				ApiBase :: PARAM_MAX => ApiBase :: LIMIT_BIG1,
				ApiBase :: PARAM_MAX2 => ApiBase :: LIMIT_BIG2
			),
			'prop' => array(
				ApiBase :: PARAM_DFLT => 'id|subject|page|parent|author',
				ApiBase :: PARAM_TYPE => array_keys(self::$propRelations),
				ApiBase :: PARAM_ISMULTI => true
			),
			
			'page' => null,
			'author' => null,
			'root' => null,
			'summary' => null,
			'id' => null,
		);
	}	
	
	public function getParamDescription() {
		return array (
			'startid' => 'The thread id to start enumerating from',
			'endid' => 'The thread id to stop enumerating at',
			'dir' => 'The direction in which to enumerate',
			'show' => 'Also show threads which meet these criteria',
			'limit' => 'The maximum number of threads to list',
			'prop' => 'Which properties to get',
			'page' => 'Limit results to threads on a particular page(s)',
			'author' => 'Limit results to threads by a particular author(s)',
			'root' => 'Limit results to threads with the given root(s)',
			'summary' => 'Limit results to threads corresponding to the given summary page(s)',
			'id' => 'Get threads with the given ID(s)',
		);
	}

	public function getDescription() {
		return 'Show details of LiquidThreads threads.';
	}

	protected function getExamples() {
 		return array(
 			'api.php?action=query&list=threads&lqtpage=Talk:Main_Page',
 			'api.php?action=query&list=threads&lqtid=1|2|3|4&lqtprop=id|subject|modified'
 		);
	}

	public function getVersion() {
		return __CLASS__;
	}
}
