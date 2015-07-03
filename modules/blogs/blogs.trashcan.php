<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=trashcan.api
[END_COT_EXT]
==================== */

/**
 * Trash can support for blogs
 *
 * @package blogs
 * @version 0.9.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('blogs', 'module');

// Register restoration table
$trash_types['blogs'] = $db_blogs;

/**
 * Sync blogs action
 *
 * @param array $data trashcan item data
 * @return bool
 * @global Cache $cache
 */
function cot_trash_post_sync($data)
{
	global $cache, $cfg, $db_structure;

	cot_blogs_sync($data['post_cat']);
	($cache && $cfg['cache_blogs']) && $cache->blogs->clear('blogs');
	return true;
}
