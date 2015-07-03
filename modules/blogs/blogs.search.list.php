<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=search.list
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

if (($tab == 'blogs' || empty($tab)) && cot_module_active('blogs') && !cot_error_found())
{
	$where_and = array();
	$where_or = array();
	
	if ($rs['blgsub'][0] != 'all' && count($rs['blgsub']) > 0)
	{
		if ($rs['blgsubcat'])
		{
			$tempcat = array();
			foreach ($rs['blgsub'] as $scat)
			{
				$tempcat = array_merge(cot_structure_children('blogs', $scat), $tempcat);
			}
			$tempcat = array_unique($tempcat);
			$where_and['cat'] = "post_cat IN ('".implode("','", $tempcat)."')";
		}
		else
		{
			$tempcat = array();
			foreach ($rs['blgsub'] as $scat)
			{
				$tempcat[] = $db->prep($scat);
			}
			$where_and['cat'] = "post_cat IN ('".implode("','", $tempcat)."')";
		}
	}
	else
	{
		$where_and['cat'] = "post_cat IN ('".implode("','", $blg_catauth)."')";
	}
	$where_and['state'] = "post_state = 0";
	$where_and['date'] = ($rs['setlimit'] > 0) ? "post_date >= ".$rs['setfrom']." AND post_date <= ".$rs['setto'] : "";
	$where_and['users'] = (!empty($touser)) ? "post_ownerid ".$touser_ids : "";

	$where_or['title'] = ($rs['blgtitle'] == 1) ? "post_title LIKE '".$db->prep($sqlsearch)."'" : "";
	$where_or['desc'] = (($rs['blgdesc'] == 1)) ? "post_desc LIKE '".$db->prep($sqlsearch)."'" : "";
	$where_or['text'] = (($rs['blgtext'] == 1)) ? "post_text LIKE '".$db->prep($sqlsearch)."'" : "";
	// String query for addition blogs fields.
	foreach (explode(',', trim($cfg['plugin']['search']['addfields'])) as $addfields_el)
	{
		$addfields_el = trim($addfields_el);
		$where_or[$addfields_el] .= ( (!empty($addfields_el))) ? $addfields_el." LIKE '".$sqlsearch."'" : "";
	}
	$where_or = array_diff($where_or, array(''));
	count($where_or) || $where_or['title'] = "post_title LIKE '".$db->prep($sqlsearch)."'";
	$where_and['or'] = '('.implode(' OR ', $where_or).')';
	$where_and = array_diff($where_and, array(''));
	$where = implode(' AND ', $where_and);

	/* === Hook === */
	foreach (cot_getextplugins('search.blogs.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!$db->fieldExists($db_blogs, 'post_'.$rs['blgsort']))
	{
		$rs['blgsort'] = 'date';
	}

	$sql = $db->query("SELECT SQL_CALC_FOUND_ROWS p.* $search_join_columns
		FROM $db_blogs AS p $search_join_condition
		WHERE $where
		ORDER BY post_".$rs['blgsort']." ".$rs['blgsort2']."
		LIMIT $d, ".$cfg_maxitems
			.$search_union_query);

	$items = $sql->rowCount();
	$totalitems[] = $db->query('SELECT FOUND_ROWS()')->fetchColumn();
	$jj = 0;
	/* === Hook - Part 1 === */
	$extp = cot_getextplugins('search.blogs.loop');
	/* ===== */
	foreach ($sql->fetchAll() as $row)
	{
		$url_cat = cot_url('blogs', 'c='.$row['post_cat']);
		$url_blg = empty($row['post_alias']) ? cot_url('blogs', 'c='.$row['post_cat'].'&id='.$row['post_id'].'&highlight='.$hl) : cot_url('blg', 'c='.$row['post_cat'].'&al='.$row['post_alias'].'&highlight='.$hl);
		$t->assign(cot_generate_blogposttags($row, 'PLUGIN_BLOGSRES_'));
		$t->assign(array(
			'PLUGIN_BLOGSRES_CATEGORY' => cot_rc_link($url_cat, $structure['blogs'][$row['post_cat']]['tpath']),
			'PLUGIN_BLOGSRES_CATEGORY_URL' => $url_cat,
			'PLUGIN_BLOGSRES_TITLE' => cot_rc_link($url_blg, htmlspecialchars($row['post_title'])),
			'PLUGIN_BLOGSRES_TEXT' => cot_clear_mark($row['post_text'], $words),
			'PLUGIN_BLOGSRES_TIME' => cot_date('datetime_medium', $row['post_date']),
			'PLUGIN_BLOGSRES_TIMESTAMP' => $row['post_date'],
			'PLUGIN_BLOGSRES_ODDEVEN' => cot_build_oddeven($jj),
			'PLUGIN_BLOGSRES_NUM' => $jj
		));
		/* === Hook - Part 2 === */
		foreach ($extp as $pl)
		{
			include $pl;
		}
		/* ===== */
		$t->parse('MAIN.RESULTS.BLOGS.ITEM');
		$jj++;
	}
	if ($jj > 0)
	{
		$t->parse('MAIN.RESULTS.BLOGS');
	}
	unset($where_and, $where_or, $where);
}

?>