<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=sitemap.main
 * [END_COT_EXT]
 */

/**
 * Firms module
 *
 * @package firms
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

if ($cfg['firms']['firmssitemap'])
{
	
	// Sitemap for firms module
	require_once cot_incfile('firms', 'module');

	// Projects categories
	$auth_cache = array();

	$category_list = $structure['firms'];

	/* === Hook === */
	foreach (cot_getextplugins('sitemap.firms.categorylist') as $pl)
	{
		include $pl;
	}
	/* ===== */

	foreach ($category_list as $c => $cat)
	{
		$auth_cache[$c] = cot_auth('firms', $c, 'R');
		if (!$auth_cache[$c]) continue;
		// Pagination support
		$maxrowsperpage = ($cfg['firms']['cat_' . $c]['maxrowsperpage']) ? $cfg['firms']['cat_' . $c]['maxrowsperpage'] : $cfg['firms']['cat___default']['maxrowsperpage'];
		$subs = floor($cat['count'] / $maxrowsperpage) + 1;
		foreach (range(1, $subs) as $pg)
		{
			$d = $cfg['easypagenav'] ? $pg : ($pg - 1) * $maxrowsperpage;
			$urlp = $pg > 1 ? "c=$c&d=$d" : "c=$c";
			sitemap_parse($t, $items, array(
				'url'  => cot_url('firms', $urlp),
				'date' => '',
				'freq' => $cfg['firms']['firmssitemap_freq'],
				'prio' => $cfg['firms']['firmssitemap_prio']
			));
		}
	}

	// Projects
	$sitemap_join_columns = '';
	$sitemap_join_tables = '';
	$sitemap_where = array();
	$sitemap_where['state'] = 'firm_state = 0';

	/* === Hook === */
	foreach (cot_getextplugins('sitemap.firms.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sitemap_where = count($sitemap_where) > 0 ? 'WHERE ' . join(' AND ', $sitemap_where) : '';
	$res = $db->query("SELECT f.firm_id, f.firm_cat $sitemap_join_columns
		FROM $db_firms AS f $sitemap_join_tables
		$sitemap_where
		ORDER BY f.firm_cat, f.firm_id");
	foreach ($res->fetchAll() as $row)
	{
		if (!$auth_cache[$row['firm_cat']]) continue;
		$urlp = array('c' => $row['firm_cat']);
		empty($row['firm_alias']) ? $urlp['id'] = $row['firm_id'] : $urlp['al'] = $row['firm_alias'];
		sitemap_parse($t, $items, array(
			'url'  => cot_url('firms', $urlp),
			'date' => $row['firm_date'],
			'freq' => $cfg['firms']['firmssitemap_freq'],
			'prio' => $cfg['firms']['firmssitemap_prio']
		));
	}
}

?>