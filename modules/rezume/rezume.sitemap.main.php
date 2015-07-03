<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=sitemap.main
 * [END_COT_EXT]
 */

/**
 * rezume module
 *
 * @package rezume
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

if ($cfg['rezume']['rezumesitemap'])
{
	
	// Sitemap for rezume module
	require_once cot_incfile('rezume', 'module');

	// Projects categories
	$auth_cache = array();

	$category_list = $structure['rezume'];

	/* === Hook === */
	foreach (cot_getextplugins('sitemap.rezume.categorylist') as $pl)
	{
		include $pl;
	}
	/* ===== */

	foreach ($category_list as $c => $cat)
	{
		$auth_cache[$c] = cot_auth('rezume', $c, 'R');
		if (!$auth_cache[$c]) continue;
		// Pagination support
		$maxrowsperpage = ($cfg['rezume']['cat_' . $c]['maxrowsperpage']) ? $cfg['rezume']['cat_' . $c]['maxrowsperpage'] : $cfg['rezume']['cat___default']['maxrowsperpage'];
		$subs = floor($cat['count'] / $maxrowsperpage) + 1;
		foreach (range(1, $subs) as $pg)
		{
			$d = $cfg['easypagenav'] ? $pg : ($pg - 1) * $maxrowsperpage;
			$urlp = $pg > 1 ? "c=$c&d=$d" : "c=$c";
			sitemap_parse($t, $items, array(
				'url'  => cot_url('rezume', $urlp),
				'date' => '',
				'freq' => $cfg['rezume']['rezumesitemap_freq'],
				'prio' => $cfg['rezume']['rezumesitemap_prio']
			));
		}
	}

	// Projects
	$sitemap_join_columns = '';
	$sitemap_join_tables = '';
	$sitemap_where = array();
	$sitemap_where['state'] = 'rez_state = 0 AND (rez_expire = 0 OR rez_expire > '.$sys['now'].')';

	/* === Hook === */
	foreach (cot_getextplugins('sitemap.rezume.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sitemap_where = count($sitemap_where) > 0 ? 'WHERE ' . join(' AND ', $sitemap_where) : '';
	$res = $db->query("SELECT f.rez_id, f.rez_cat $sitemap_join_columns
		FROM $db_rezume AS f $sitemap_join_tables
		$sitemap_where
		ORDER BY f.rez_cat, f.rez_id");
	foreach ($res->fetchAll() as $row)
	{
		if (!$auth_cache[$row['rez_cat']]) continue;
		$urlp = array('c' => $row['rez_cat']);
		empty($row['rez_alias']) ? $urlp['id'] = $row['rez_id'] : $urlp['al'] = $row['rez_alias'];
		sitemap_parse($t, $items, array(
			'url'  => cot_url('rezume', $urlp),
			'date' => $row['rez_date'],
			'freq' => $cfg['rezume']['rezumesitemap_freq'],
			'prio' => $cfg['rezume']['rezumesitemap_prio']
		));
	}
}

?>