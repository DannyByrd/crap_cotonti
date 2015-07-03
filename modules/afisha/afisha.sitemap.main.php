<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=sitemap.main
 * [END_COT_EXT]
 */

/**
 * Afisha module
 *
 * @package afisha
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

if ($cfg['afisha']['afishasitemap'])
{
	
	// Sitemap for afisha module
	require_once cot_incfile('afisha', 'module');

	// Projects categories
	$auth_cache = array();

	$category_list = $structure['afisha'];

	/* === Hook === */
	foreach (cot_getextplugins('sitemap.afisha.categorylist') as $pl)
	{
		include $pl;
	}
	/* ===== */

	foreach ($category_list as $c => $cat)
	{
		$auth_cache[$c] = cot_auth('afisha', $c, 'R');
		if (!$auth_cache[$c]) continue;
		// Pagination support
		$maxrowsperpage = ($cfg['afisha']['cat_' . $c]['maxrowsperpage']) ? $cfg['afisha']['cat_' . $c]['maxrowsperpage'] : $cfg['afisha']['cat___default']['maxrowsperpage'];
		$subs = floor($cat['count'] / $maxrowsperpage) + 1;
		foreach (range(1, $subs) as $pg)
		{
			$d = $cfg['easypagenav'] ? $pg : ($pg - 1) * $maxrowsperpage;
			$urlp = $pg > 1 ? "c=$c&d=$d" : "c=$c";
			sitemap_parse($t, $items, array(
				'url'  => cot_url('afisha', $urlp),
				'date' => '',
				'freq' => $cfg['afisha']['afishasitemap_freq'],
				'prio' => $cfg['afisha']['afishasitemap_prio']
			));
		}
	}

	// Projects
	$sitemap_join_columns = '';
	$sitemap_join_tables = '';
	$sitemap_where = array();
	$sitemap_where['state'] = 'event_state = 0';

	/* === Hook === */
	foreach (cot_getextplugins('sitemap.afisha.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sitemap_where = count($sitemap_where) > 0 ? 'WHERE ' . join(' AND ', $sitemap_where) : '';
	$res = $db->query("SELECT f.event_id, f.event_cat $sitemap_join_columns
		FROM $db_afisha AS f $sitemap_join_tables
		$sitemap_where
		ORDER BY f.event_cat, f.event_id");
	foreach ($res->fetchAll() as $row)
	{
		if (!$auth_cache[$row['event_cat']]) continue;
		$urlp = array('c' => $row['event_cat']);
		empty($row['event_alias']) ? $urlp['id'] = $row['event_id'] : $urlp['al'] = $row['event_alias'];
		sitemap_parse($t, $items, array(
			'url'  => cot_url('afisha', $urlp),
			'date' => $row['event_date'],
			'freq' => $cfg['afisha']['afishasitemap_freq'],
			'prio' => $cfg['afisha']['afishasitemap_prio']
		));
	}
}

?>