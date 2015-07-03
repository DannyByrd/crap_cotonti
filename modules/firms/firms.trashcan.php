<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=trashcan.api
[END_COT_EXT]
==================== */

/**
 * Trash can support for firms
 *
 * @package firms
 * @version 0.9.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('firms', 'module');

// Register restoration table
$trash_types['firms'] = $db_firms;

/**
 * Sync firms action
 *
 * @param array $data trashcan item data
 * @return bool
 * @global Cache $cache
 */
function cot_trash_firm_sync($data)
{
	global $cache, $cfg, $db_structure;

	cot_firms_sync($data['firm_cat']);
	($cache && $cfg['cache_firms']) && $cache->firms->clear('firms');
	return true;
}
