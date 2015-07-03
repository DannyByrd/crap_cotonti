<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=sitemap.main
 * [END_COT_EXT]
 */

/**
 * Blogs module
 *
 * @package blogs
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

if ($cfg['blogs']['blogssitemap'])
{
	
	// Sitemap for blogs module
	require_once cot_incfile('blogs', 'module');

	// Projects categories
	$auth_cache = array();

	$category_list = $structure['blogs'];

	/* === Hook === */
	foreach (cot_getextplugins('sitemap.blogs.categorylist') as $pl)
	{
		include $pl;
	}
	/* ===== */

	foreach ($category_list as $c => $cat)
	{
		$auth_cache[$c] = cot_auth('blogs', $c, 'R');
		if (!$auth_cache[$c]) continue;
		// Pagination support
		$maxrowsperpage = ($cfg['blogs']['cat_' . $c]['maxrowsperpage']) ? $cfg['blogs']['cat_' . $c]['maxrowsperpage'] : $cfg['blogs']['cat___default']['maxrowsperpage'];
		$subs = floor($cat['count'] / $maxrowsperpage) + 1;
		foreach (range(1, $subs) as $pg)
		{
			$d = $cfg['easypagenav'] ? $pg : ($pg - 1) * $maxrowsperpage;
			$urlp = $pg > 1 ? "c=$c&d=$d" : "c=$c";
			sitemap_parse($t, $items, array(
				'url'  => cot_url('blogs', $urlp),
				'date' => '',
				'freq' => $cfg['blogs']['blogssitemap_freq'],
				'prio' => $cfg['blogs']['blogssitemap_prio']
			));
		}
	}

	// Projects
	$sitemap_join_columns = '';
	$sitemap_join_tables = '';
	$sitemap_where = array();
	$sitemap_where['state'] = 'post_state = 0';

	/* === Hook === */
	foreach (cot_getextplugins('sitemap.blogs.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sitemap_where = count($sitemap_where) > 0 ? 'WHERE ' . join(' AND ', $sitemap_where) : '';
	$res = $db->query("SELECT f.post_id, f.post_cat $sitemap_join_columns
		FROM $db_blogs AS f $sitemap_join_tables
		$sitemap_where
		ORDER BY f.post_cat, f.post_id");
	foreach ($res->fetchAll() as $row)
	{
		if (!$auth_cache[$row['post_cat']]) continue;
		$urlp = array('c' => $row['post_cat']);
		empty($row['post_alias']) ? $urlp['id'] = $row['post_id'] : $urlp['al'] = $row['post_alias'];
		sitemap_parse($t, $items, array(
			'url'  => cot_url('blogs', $urlp),
			'date' => $row['post_date'],
			'freq' => $cfg['blogs']['blogssitemap_freq'],
			'prio' => $cfg['blogs']['blogssitemap_prio']
		));
	}
}

?>