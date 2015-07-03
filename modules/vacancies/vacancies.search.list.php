<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=search.list
 * [END_COT_EXT]
 */

/**
 * Vacancies module
 *
 * @package vacancies
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

if (($tab == 'vac' || empty($tab)) && cot_module_active('vacancies') && !cot_error_found())
{
	$where_and = array();
	$where_or = array();
	
	if ($rs['vacsub'][0] != 'all' && count($rs['vacsub']) > 0)
	{
		if ($rs['vacsubcat'])
		{
			$tempcat = array();
			foreach ($rs['vacsub'] as $scat)
			{
				$tempcat = array_merge(cot_structure_children('vacancies', $scat), $tempcat);
			}
			$tempcat = array_unique($tempcat);
			$where_and['cat'] = "vac_cat IN ('".implode("','", $tempcat)."')";
		}
		else
		{
			$tempcat = array();
			foreach ($rs['vacsub'] as $scat)
			{
				$tempcat[] = $db->prep($scat);
			}
			$where_and['cat'] = "vac_cat IN ('".implode("','", $tempcat)."')";
		}
	}
	else
	{
		$where_and['cat'] = "vac_cat IN ('".implode("','", $vac_catauth)."')";
	}
	$where_and['state'] = "vac_state = 0";
	$where_and['date'] = ($rs['setlimit'] > 0) ? "vac_date >= ".$rs['setfrom']." AND vac_date <= ".$rs['setto'] : "";
	$where_and['users'] = (!empty($touser)) ? "vac_ownerid ".$touser_ids : "";

	$where_or['title'] = ($rs['vactitle'] == 1) ? "vac_title LIKE '".$db->prep($sqlsearch)."'" : "";
	$where_or['desc'] = (($rs['vacdesc'] == 1)) ? "vac_desc LIKE '".$db->prep($sqlsearch)."'" : "";
	$where_or['duty'] = (($rs['vacduty'] == 1)) ? "vac_duty LIKE '".$db->prep($sqlsearch)."'" : "";
	$where_or['term'] = (($rs['vacterm'] == 1)) ? "vac_term LIKE '".$db->prep($sqlsearch)."'" : "";
	$where_or['qua'] = (($rs['vacqua'] == 1)) ? "vac_qua LIKE '".$db->prep($sqlsearch)."'" : "";
	// String query for addition vac fields.
	foreach (explode(',', trim($cfg['plugin']['search']['addfields'])) as $addfields_el)
	{
		$addfields_el = trim($addfields_el);
		$where_or[$addfields_el] .= ( (!empty($addfields_el))) ? $addfields_el." LIKE '".$sqlsearch."'" : "";
	}
	$where_or = array_diff($where_or, array(''));
	count($where_or) || $where_or['title'] = "vac_title LIKE '".$db->prep($sqlsearch)."'";
	$where_and['or'] = '('.implode(' OR ', $where_or).')';
	$where_and = array_diff($where_and, array(''));
	$where = implode(' AND ', $where_and);

	/* === Hook === */
	foreach (cot_getextplugins('search.vac.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!$db->fieldExists($db_vacancies, 'vac_'.$rs['vacsort']))
	{
		$rs['vacsort'] = 'date';
	}

	$sql = $db->query("SELECT SQL_CALC_FOUND_ROWS v.* $search_join_columns
		FROM $db_vacancies AS v $search_join_condition
		WHERE $where
		ORDER BY vac_".$rs['vacsort']." ".$rs['vacsort2']."
		LIMIT $d, ".$cfg_maxitems
			.$search_union_query);

	$items = $sql->rowCount();
	$totalitems[] = $db->query('SELECT FOUND_ROWS()')->fetchColumn();
	$jj = 0;
	/* === Hook - Part 1 === */
	$extp = cot_getextplugins('search.vac.loop');
	/* ===== */
	foreach ($sql->fetchAll() as $row)
	{
		$url_cat = cot_url('vacancies', 'c='.$row['vac_cat']);
		$url_vac = empty($row['vac_alias']) ? cot_url('vacancies', 'c='.$row['vac_cat'].'&id='.$row['vac_id'].'&highlight='.$hl) : cot_url('vacancies', 'c='.$row['vac_cat'].'&al='.$row['vac_alias'].'&highlight='.$hl);
		$t->assign(cot_generate_vactags($row, 'PLUGIN_VACRES_'));
		$t->assign(array(
			'PLUGIN_VACRES_CATEGORY' => cot_rc_link($url_cat, $structure['vacancies'][$row['vac_cat']]['tpath']),
			'PLUGIN_VACRES_CATEGORY_URL' => $url_cat,
			'PLUGIN_VACRES_TITLE' => cot_rc_link($url_vac, htmlspecialchars($row['vac_title'])),
			'PLUGIN_VACRES_DESC' => cot_clear_mark($row['vac_desc'], $words),
			'PLUGIN_VACRES_DUTY' => cot_clear_mark($row['vac_duty'], $words),
			'PLUGIN_VACRES_TERM' => cot_clear_mark($row['vac_term'], $words),
			'PLUGIN_VACRES_QUA' => cot_clear_mark($row['vac_qua'], $words),
			'PLUGIN_VACRES_TIME' => cot_date('datetime_medium', $row['vac_date']),
			'PLUGIN_VACRES_TIMESTAMP' => $row['vac_date'],
			'PLUGIN_VACRES_ODDEVEN' => cot_build_oddeven($jj),
			'PLUGIN_VACRES_NUM' => $jj
		));
		/* === Hook - Part 2 === */
		foreach ($extp as $pl)
		{
			include $pl;
		}
		/* ===== */
		$t->parse('MAIN.RESULTS.VAC.ITEM');
		$jj++;
	}
	if ($jj > 0)
	{
		$t->parse('MAIN.RESULTS.VAC');
	}
	unset($where_and, $where_or, $where);
}

?>