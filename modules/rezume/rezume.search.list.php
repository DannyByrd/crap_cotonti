<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=search.list
 * [END_COT_EXT]
 */

/**
 * rezume module
 *
 * @package rezume
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

if (($tab == 'rez' || empty($tab)) && cot_module_active('rezume') && !cot_error_found())
{
	$where_and = array();
	$where_or = array();
	
	if ($rs['rezsub'][0] != 'all' && count($rs['rezsub']) > 0)
	{
		if ($rs['rezsubcat'])
		{
			$tempcat = array();
			foreach ($rs['rezsub'] as $scat)
			{
				$tempcat = array_merge(cot_structure_children('rezume', $scat), $tempcat);
			}
			$tempcat = array_unique($tempcat);
			$where_and['cat'] = "rez_cat IN ('".implode("','", $tempcat)."')";
		}
		else
		{
			$tempcat = array();
			foreach ($rs['rezsub'] as $scat)
			{
				$tempcat[] = $db->prep($scat);
			}
			$where_and['cat'] = "rez_cat IN ('".implode("','", $tempcat)."')";
		}
	}
	else
	{
		$where_and['cat'] = "rez_cat IN ('".implode("','", $rez_catauth)."')";
	}
	$where_and['state'] = "rez_state = 0";
	$where_and['date'] = ($rs['setlimit'] > 0) ? "rez_date >= ".$rs['setfrom']." AND rez_date <= ".$rs['setto'] : "";
	$where_and['users'] = (!empty($touser)) ? "rez_ownerid ".$touser_ids : "";

	$where_or['title'] = ($rs['reztitle'] == 1) ? "rez_title LIKE '".$db->prep($sqlsearch)."'" : "";
	$where_or['works'] = (($rs['rezworks'] == 1)) ? "rez_works LIKE '".$db->prep($sqlsearch)."'" : "";
	$where_or['study'] = (($rs['rezstudy'] == 1)) ? "rez_study LIKE '".$db->prep($sqlsearch)."'" : "";
	$where_or['qua'] = (($rs['rezqua'] == 1)) ? "rez_qua LIKE '".$db->prep($sqlsearch)."'" : "";
	// String query for addition rez fields.
	foreach (explode(',', trim($cfg['plugin']['search']['addfields'])) as $addfields_el)
	{
		$addfields_el = trim($addfields_el);
		$where_or[$addfields_el] .= ( (!empty($addfields_el))) ? $addfields_el." LIKE '".$sqlsearch."'" : "";
	}
	$where_or = array_diff($where_or, array(''));
	count($where_or) || $where_or['title'] = "rez_title LIKE '".$db->prep($sqlsearch)."'";
	$where_and['or'] = '('.implode(' OR ', $where_or).')';
	$where_and = array_diff($where_and, array(''));
	$where = implode(' AND ', $where_and);

	/* === Hook === */
	foreach (cot_getextplugins('search.rez.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!$db->fieldExists($db_rezume, 'rez_'.$rs['rezsort']))
	{
		$rs['rezsort'] = 'date';
	}

	$sql = $db->query("SELECT SQL_CALC_FOUND_ROWS v.* $search_join_columns
		FROM $db_rezume AS v $search_join_condition
		WHERE $where
		ORDER BY rez_".$rs['rezsort']." ".$rs['rezsort2']."
		LIMIT $d, ".$cfg_maxitems
			.$search_union_query);

	$items = $sql->rowCount();
	$totalitems[] = $db->query('SELECT FOUND_ROWS()')->fetchColumn();
	$jj = 0;
	/* === Hook - Part 1 === */
	$extp = cot_getextplugins('search.rez.loop');
	/* ===== */
	foreach ($sql->fetchAll() as $row)
	{
		$url_cat = cot_url('rezume', 'c='.$row['rez_cat']);
		$url_rez = empty($row['rez_alias']) ? cot_url('rezume', 'c='.$row['rez_cat'].'&id='.$row['rez_id'].'&highlight='.$hl) : cot_url('rezume', 'c='.$row['rez_cat'].'&al='.$row['rez_alias'].'&highlight='.$hl);
		$t->assign(cot_generate_reztags($row, 'PLUGIN_REZUMERES_'));
		$t->assign(array(
			'PLUGIN_REZUMERES_CATEGORY' => cot_rc_link($url_cat, $structure['rezume'][$row['rez_cat']]['tpath']),
			'PLUGIN_REZUMERES_CATEGORY_URL' => $url_cat,
			'PLUGIN_REZUMERES_TIME' => cot_date('datetime_medium', $row['rez_date']),
			'PLUGIN_REZUMERES_ODDEVEN' => cot_build_oddeven($jj),
			'PLUGIN_REZUMERES_NUM' => $jj
		));
		/* === Hook - Part 2 === */
		foreach ($extp as $pl)
		{
			include $pl;
		}
		/* ===== */
		$t->parse('MAIN.RESULTS.REZUME.ITEM');
		$jj++;
	}
	if ($jj > 0)
	{
		$t->parse('MAIN.RESULTS.REZUME');
	}
	unset($where_and, $where_or, $where);
}

?>