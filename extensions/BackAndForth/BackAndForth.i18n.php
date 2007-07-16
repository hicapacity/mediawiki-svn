<?php

/**
 * Internationalisation file for the BackAndForth extension
 *
 * @author Rob Church <robchur@gmail.com>
 */

/**
 * Fetch extension messages indexed per language
 *
 * @return array
 */
function efBackAndForthMessages() {
	$messages = array(

'en' => array(
	'backforth-next' => 'Next ($1)',
	'backforth-prev' => 'Previous ($1)',
),

'de' => array(
	'backforth-next' => 'Nächste ($1)',
	'backforth-prev' => 'Vorherige ($1)',
),

'yue' => array(
	'backforth-next' => '下一篇 ($1)',
	'backforth-prev' => '上一篇 ($1)',
),

'zh-hans' => array(
	'backforth-next' => '下一条 ($1)',
	'backforth-prev' => '上一条 ($1)',
),

'zh-hant' => array(
	'backforth-next' => '下一條 ($1)',
	'backforth-prev' => '上一條 ($1)',
),

	);

	/* Chinese defaults, fallback to zh-hans or zh-hant */
	$messages['zh-cn'] = $messages['zh-hans'];
	$messages['zh-hk'] = $messages['zh-hant'];
	$messages['zh-sg'] = $messages['zh-hans'];
	$messages['zh-tw'] = $messages['zh-hant'];
	/* Cantonese default, fallback to yue */
	$messages['zh-yue'] = $messages['yue'];

	return $messages;
}
