<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin.extrafields.first
  [END_COT_EXT]
  ==================== */

/**
 * Adv module
 *
 * @package board
 * @version 0.7.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('board', 'module');
$extra_whitelist[$db_board] = array(
	'name' => $db_board,
	'caption' => $L['Module'].' Board',
	'type' => 'module',
	'code' => 'board',
	'tags' => array(
		'board.list.tpl' => '{LIST_ROW_XXXXX}, {LIST_TOP_XXXXX}',
		'board.tpl' => '{ADV_XXXXX}, {ADV_XXXXX_TITLE}',
		'board.add.tpl' => '{ADVADD_FORM_XXXXX}, {ADVADD_FORM_XXXXX_TITLE}',
		'board.edit.tpl' => '{ADVEDIT_FORM_XXXXX}, {ADVEDIT_FORM_XXXXX_TITLE}',
		'news.tpl' => '{ADV_ROW_XXXXX}',
		'recentitems.board.tpl' => '{ADV_ROW_XXXXX}',
	)
);
