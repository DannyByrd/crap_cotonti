<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=trashcan.api
[END_COT_EXT]
==================== */

/**
 * Trash can support for rezume
 *
 * @package rezume
 * @version 0.9.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('rezume', 'module');

// Register restoration table
$trash_types['rezume'] = $db_rezume;

/**
 * Sync rezume action
 *
 * @param array $data trashcan item data
 * @return bool
 * @global Cache $cache
 */
function cot_trash_rez_sync($data)
{
	global $cache, $cfg, $db_structure;

	cot_rezume_sync($data['rez_cat']);
	($cache && $cfg['cache_rezume']) && $cache->rezume->clear('rezume');
	return true;
}
