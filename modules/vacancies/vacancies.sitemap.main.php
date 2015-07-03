<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=sitemap.main
 * [END_COT_EXT]
 */

/**
 * Vacancies module
 *
 * @package vacancies
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

if ($cfg['vacancies']['vacanciessitemap'])
{
	
	// Sitemap for vacancies module
	require_once cot_incfile('vacancies', 'module');

	// Projects categories
	$auth_cache = array();

	$category_list = $structure['vacancies'];

	/* === Hook === */
	foreach (cot_getextplugins('sitemap.vacancies.categorylist') as $pl)
	{
		include $pl;
	}
	/* ===== */

	foreach ($category_list as $c => $cat)
	{
		$auth_cache[$c] = cot_auth('vacancies', $c, 'R');
		if (!$auth_cache[$c]) continue;
		// Pagination support
		$maxrowsperpage = ($cfg['vacancies']['cat_' . $c]['maxrowsperpage']) ? $cfg['vacancies']['cat_' . $c]['maxrowsperpage'] : $cfg['vacancies']['cat___default']['maxrowsperpage'];
		$subs = floor($cat['count'] / $maxrowsperpage) + 1;
		foreach (range(1, $subs) as $pg)
		{
			$d = $cfg['easypagenav'] ? $pg : ($pg - 1) * $maxrowsperpage;
			$urlp = $pg > 1 ? "c=$c&d=$d" : "c=$c";
			sitemap_parse($t, $items, array(
				'url'  => cot_url('vacancies', $urlp),
				'date' => '',
				'freq' => $cfg['vacancies']['vacanciessitemap_freq'],
				'prio' => $cfg['vacancies']['vacanciessitemap_prio']
			));
		}
	}

	// Projects
	$sitemap_join_columns = '';
	$sitemap_join_tables = '';
	$sitemap_where = array();
	$sitemap_where['state'] = 'vac_state = 0 AND (vac_expire = 0 OR vac_expire > '.$sys['now'].')';

	/* === Hook === */
	foreach (cot_getextplugins('sitemap.vacancies.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sitemap_where = count($sitemap_where) > 0 ? 'WHERE ' . join(' AND ', $sitemap_where) : '';
	$res = $db->query("SELECT f.vac_id, f.vac_cat $sitemap_join_columns
		FROM $db_vacancies AS f $sitemap_join_tables
		$sitemap_where
		ORDER BY f.vac_cat, f.vac_id");
	foreach ($res->fetchAll() as $row)
	{
		if (!$auth_cache[$row['vac_cat']]) continue;
		$urlp = array('c' => $row['vac_cat']);
		empty($row['vac_alias']) ? $urlp['id'] = $row['vac_id'] : $urlp['al'] = $row['vac_alias'];
		sitemap_parse($t, $items, array(
			'url'  => cot_url('vacancies', $urlp),
			'date' => $row['vac_date'],
			'freq' => $cfg['vacancies']['vacanciessitemap_freq'],
			'prio' => $cfg['vacancies']['vacanciessitemap_prio']
		));
	}
}

?>