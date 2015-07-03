<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=trashcan.api
[END_COT_EXT]
==================== */

/**
 * Trash can support for board
 *
 * @package board
 * @version 0.9.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('board', 'module');

// Register restoration table
$trash_types['board'] = $db_board;

/**
 * Sync board action
 *
 * @param array $data trashcan item data
 * @return bool
 * @global Cache $cache
 */
function cot_trash_adv_sync($data)
{
	global $cache, $cfg, $db_structure;

	cot_board_sync($data['adv_cat']);
	($cache && $cfg['cache_board']) && $cache->board->clear('board');
	return true;
}
