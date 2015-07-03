<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=trashcan.api
[END_COT_EXT]
==================== */

/**
 * Trash can support for afisha
 *
 * @package afisha
 * @version 0.9.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('afisha', 'module');

// Register restoration table
$trash_types['afisha'] = $db_afisha;

/**
 * Sync afisha action
 *
 * @param array $data trashcan item data
 * @return bool
 * @global Cache $cache
 */
function cot_trash_event_sync($data)
{
	global $cache, $cfg, $db_structure;

	cot_afisha_sync($data['event_cat']);
	($cache && $cfg['cache_afisha']) && $cache->afisha->clear('afisha');
	return true;
}
