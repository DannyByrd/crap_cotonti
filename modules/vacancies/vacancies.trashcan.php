<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=trashcan.api
[END_COT_EXT]
==================== */

/**
 * Trash can support for vacancies
 *
 * @package vacancies
 * @version 0.9.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('vacancies', 'module');

// Register restoration table
$trash_types['vacancies'] = $db_vacancies;

/**
 * Sync vacancies action
 *
 * @param array $data trashcan item data
 * @return bool
 * @global Cache $cache
 */
function cot_trash_vac_sync($data)
{
	global $cache, $cfg, $db_structure;

	cot_vacancies_sync($data['vac_cat']);
	($cache && $cfg['cache_vacancies']) && $cache->vacancies->clear('vacancies');
	return true;
}
