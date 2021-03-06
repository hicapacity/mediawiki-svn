<?php
/**
 * SystemGifts class
 */
class SystemGifts {

	/**
	 * All member variables should be considered private
	 * Please use the accessor functions
	 */
	var $categories = array(
		'edit' => 1,
		'vote' => 2,
		'comment' => 3,
		'comment_plus' => 4,
		'opinions_created' => 5,
		'opinions_pub' => 6,
		'referral_complete' => 7,
		'friend' => 8,
		'foe' => 9,
		'challenges_won' => 10,
		'gift_rec' => 11,
		'points_winner_weekly' => 12,
		'points_winner_monthly' => 13,
		'quiz_points' => 14
	);

	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct() {

	}

	/**
	 * Adds awards for all registered users
	 * Special:PopulateAwards calls this function
	 */
	public function update_system_gifts() {
		global $wgOut, $wgMemc;

		$dbw = wfGetDB( DB_MASTER );
		$stats = new UserStatsTrack( 1, '' );
		$this->categories = array_flip( $this->categories );

		$res = $dbw->select(
			'system_gift',
			array( 'gift_id', 'gift_category', 'gift_threshold', 'gift_name' ),
			array(),
			__METHOD__,
			array( 'ORDER BY' => 'gift_category, gift_threshold ASC' )
		);

		$x = 1;
		foreach ( $res as $row ) {
			if ( $row->gift_category ) {
				$res2 = $dbw->select(
					'user_stats',
					array( 'stats_user_id', 'stats_user_name' ),
					array( $stats->stats_fields[$this->categories[$row->gift_category]] . " >= {$row->gift_threshold}", 'stats_user_id<>0' ),
					__METHOD__
				);

				foreach ( $res2 as $row2 ) {
					if ( $this->doesUserHaveGift( $row2->stats_user_id, $row->gift_id ) == false ) {
						$dbw->insert(
							'user_system_gift',
							array(
								'sg_gift_id' => $row->gift_id,
								'sg_user_id' => $row2->stats_user_id,
								'sg_user_name' => $row2->stats_user_name,
								'sg_status' => 0,
								'sg_date' => date( 'Y-m-d H:i:s', time() - ( 60 * 60 * 24 * 3 ) ),
							),
							__METHOD__
						);

						$sg_key = wfMemcKey( 'user', 'profile', 'system_gifts', "{$row2->stats_user_id}" );
						$wgMemc->delete( $sg_key );

						$wgOut->addHTML( $row2->stats_user_name . ' got ' . $row->gift_name . '<br />' );
						$x++;
					}
				}
			}
		}
		$wgOut->addHTML( "{$x} awards were given out" );
	}

	public function doesUserHaveGift( $user_id, $gift_id ) {
		$dbr = wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow(
			'user_system_gift',
			array( 'sg_gift_id' ),
			array( 'sg_gift_id' => $gift_id, 'sg_user_id' => $user_id ),
			__METHOD__
		);
		if ( $s === false ) {
			return false;
		} else {
			return $s->sg_gift_id;
		}
	}

	/**
	 * Adds a new system gift to the database
	 * @param $name Mixed: gift name
	 * @param $description Mixed: gift description
	 * @param $category
	 * @param $threshold
	 */
	public function addGift( $name, $description, $category, $threshold ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert(
			'system_gift',
			array(
				'gift_name' => $name,
				'gift_description' => $description,
				'gift_category' => $category,
				'gift_threshold' => $threshold,
				'gift_createdate' => date( 'Y-m-d H:i:s' ),
			),
			__METHOD__
		);
		return $dbw->insertId();
	}

	/**
	 * Updates data for a system gift
	 * @param $id Integer: system gift unique ID number
	 * @param $name Mixed: gift name
	 * @param $description Mixed: gift description
	 * @param $category
	 * @param $threshold
	 */
	public function updateGift( $id, $name, $description, $category, $threshold ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'system_gift',
			/* SET */array(
				'gift_name' => $name,
				'gift_description' => $description,
				'gift_category' => $category,
				'gift_threshold' => $threshold,
			),
			/* WHERE */array( 'gift_id' => $id ),
			__METHOD__
		);
	}

	public function doesGiftExistForThreshold( $category, $threshold ) {
		$dbr = wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow(
			'system_gift',
			array( 'gift_id' ),
			array(
				'gift_category' => $this->categories[$category],
				'gift_threshold' => $threshold
			),
			__METHOD__
		);
		if ( $s === false ) {
			return false;
		} else {
			return $s->gift_id;
		}
	}

	/**
	 * Fetches the system gift with the ID $id from the database
	 * @param $id Integer: ID number of the system gift to be fetched
	 */
	static function getGift( $id ) {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'system_gift',
			array(
				'gift_id', 'gift_name', 'gift_description', 'gift_category',
				'gift_threshold', 'gift_given_count'
			),
			array( 'gift_id' => $id ),
			__METHOD__,
			array( 'LIMIT' => 1 )
		);
		$row = $dbr->fetchObject( $res );
		if ( $row ) {
			$gift['gift_id'] = $row->gift_id;
			$gift['gift_name'] = $row->gift_name;
			$gift['gift_description'] = $row->gift_description;
			$gift['gift_category'] = $row->gift_category;
			$gift['gift_threshold'] = $row->gift_threshold;
			$gift['gift_given_count'] = $row->gift_given_count;
		}
		return $gift;
	}

	/**
	 * Gets the associated image for a system gift
	 * @param $id Integer: system gift ID number
	 * @param $size String: image size (s, m, ml or l)
	 */
	static function getGiftImage( $id, $size ) {
		global $wgUploadDirectory;
		$files = glob( $wgUploadDirectory . '/awards/sg_' . $id . '_' . $size . '*' );

		if ( !empty( $files[0] ) ) {
			$img = basename( $files[0] );
		} else {
			$img = 'default_' . $size . '.gif';
		}
		return $img . '?r=' . rand();
	}

	static function getGiftList( $limit = 0, $page = 0 ) {
		$dbr = wfGetDB( DB_SLAVE );

		$limitvalue = 0;
		if ( $limit > 0 ) {
			if ( $page ) {
				$limitvalue = $page * $limit - ( $limit );
			}
		}

		$res = $dbr->select(
			'system_gift',
			array(
				'gift_id', 'gift_createdate', 'gift_name', 'gift_description',
				'gift_category', 'gift_threshold', 'gift_given_count'
			),
			array(),
			__METHOD__,
			array(
				'ORDER BY' => 'gift_createdate DESC',
				'LIMIT' => $limit,
				'OFFSET' => $limitvalue
			)
		);

		$gifts = array();
		foreach ( $res as $row ) {
			$gifts[] = array(
				'id' => $row->gift_id,
				'timestamp' => ( $row->gift_createdate ),
				'gift_name' => $row->gift_name,
				'gift_description' => $row->gift_description,
				'gift_category' => $row->gift_category,
				'gift_threshold' => $row->gift_threshold,
				'gift_given_count' => $row->gift_given_count
			);
		}
		return $gifts;
	}

	/**
	 * Gets the amount of available system gifts from the database.
	 * @return integer
	 */
	static function getGiftCount() {
		$dbr = wfGetDB( DB_SLAVE );
		$gift_count = 0;
		$s = $dbr->selectRow(
			'system_gift',
			array( 'COUNT(*) AS count' ),
			__METHOD__
		);
		if ( $s !== false ) {
			$gift_count = $s->count;
		}
		return $gift_count;
	}
}
