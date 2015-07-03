<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=sitemap.main
 * [END_COT_EXT]
 */

/**
 * Board module
 *
 * @package board
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

if ($cfg['board']['boardsitemap'])
{
	
	// Sitemap for board module
	require_once cot_incfile('board', 'module');

	// Projects categories
	$auth_cache = array();

	$category_list = $structure['board'];

	/* === Hook === */
	foreach (cot_getextplugins('sitemap.board.categorylist') as $pl)
	{
		include $pl;
	}
	/* ===== */

	foreach ($category_list as $c => $cat)
	{
		$auth_cache[$c] = cot_auth('board', $c, 'R');
		if (!$auth_cache[$c]) continue;
		// Pagination support
		$maxrowsperpage = ($cfg['board']['cat_' . $c]['maxrowsperpage']) ? $cfg['board']['cat_' . $c]['maxrowsperpage'] : $cfg['board']['cat___default']['maxrowsperpage'];
		$subs = floor($cat['count'] / $maxrowsperpage) + 1;
		foreach (range(1, $subs) as $pg)
		{
			$d = $cfg['easypagenav'] ? $pg : ($pg - 1) * $maxrowsperpage;
			$urlp = $pg > 1 ? "c=$c&d=$d" : "c=$c";
			sitemap_parse($t, $items, array(
				'url'  => cot_url('board', $urlp),
				'date' => '',
				'freq' => $cfg['board']['boardsitemap_freq'],
				'prio' => $cfg['board']['boardsitemap_prio']
			));
		}
	}

	// Projects
	$sitemap_join_columns = '';
	$sitemap_join_tables = '';
	$sitemap_where = array();
	$sitemap_where['state'] = 'adv_state = 0';

	/* === Hook === */
	foreach (cot_getextplugins('sitemap.board.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sitemap_where = count($sitemap_where) > 0 ? 'WHERE ' . join(' AND ', $sitemap_where) : '';
	$res = $db->query("SELECT f.adv_id, f.adv_cat $sitemap_join_columns
		FROM $db_board AS f $sitemap_join_tables
		$sitemap_where
		ORDER BY f.adv_cat, f.adv_id");
	foreach ($res->fetchAll() as $row)
	{
		if (!$auth_cache[$row['adv_cat']]) continue;
		$urlp = array('c' => $row['adv_cat']);
		empty($row['adv_alias']) ? $urlp['id'] = $row['adv_id'] : $urlp['al'] = $row['adv_alias'];
		sitemap_parse($t, $items, array(
			'url'  => cot_url('board', $urlp),
			'date' => $row['adv_date'],
			'freq' => $cfg['board']['boardsitemap_freq'],
			'prio' => $cfg['board']['boardsitemap_prio']
		));
	}
}

?>