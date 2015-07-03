<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=search.list
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

if (($tab == 'firms' || empty($tab)) && cot_module_active('firms') && !cot_error_found())
{
	$where_and = array();
	$where_or = array();
	
	if ($rs['firmsub'][0] != 'all' && count($rs['firmsub']) > 0)
	{
		if ($rs['firmsubcat'])
		{
			$tempcat = array();
			foreach ($rs['firmsub'] as $scat)
			{
				$tempcat = array_merge(cot_structure_children('firms', $scat), $tempcat);
			}
			$tempcat = array_unique($tempcat);
			$where_and['cat'] = "firm_cat IN ('".implode("','", $tempcat)."')";
		}
		else
		{
			$tempcat = array();
			foreach ($rs['firmsub'] as $scat)
			{
				$tempcat[] = $db->prep($scat);
			}
			$where_and['cat'] = "firm_cat IN ('".implode("','", $tempcat)."')";
		}
	}
	else
	{
		$where_and['cat'] = "firm_cat IN ('".implode("','", $firm_catauth)."')";
	}
	$where_and['state'] = "firm_state = 0";
	$where_and['date'] = ($rs['setlimit'] > 0) ? "firm_date >= ".$rs['setfrom']." AND firm_date <= ".$rs['setto'] : "";
	$where_and['users'] = (!empty($touser)) ? "firm_ownerid ".$touser_ids : "";

	$where_or['title'] = ($rs['firmtitle'] == 1) ? "firm_title LIKE '".$db->prep($sqlsearch)."'" : "";
	$where_or['desc'] = (($rs['firmdesc'] == 1)) ? "firm_desc LIKE '".$db->prep($sqlsearch)."'" : "";
	$where_or['text'] = (($rs['firmtext'] == 1)) ? "firm_text LIKE '".$db->prep($sqlsearch)."'" : "";
	// String query for addition firms fields.
	foreach (explode(',', trim($cfg['plugin']['search']['addfields'])) as $addfields_el)
	{
		$addfields_el = trim($addfields_el);
		$where_or[$addfields_el] .= ( (!empty($addfields_el))) ? $addfields_el." LIKE '".$sqlsearch."'" : "";
	}
	$where_or = array_diff($where_or, array(''));
	count($where_or) || $where_or['title'] = "firm_title LIKE '".$db->prep($sqlsearch)."'";
	$where_and['or'] = '('.implode(' OR ', $where_or).')';
	$where_and = array_diff($where_and, array(''));
	$where = implode(' AND ', $where_and);

	/* === Hook === */
	foreach (cot_getextplugins('search.firms.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!$db->fieldExists($db_firms, 'firm_'.$rs['firmsort']))
	{
		$rs['firmsort'] = 'date';
	}

	$sql = $db->query("SELECT SQL_CALC_FOUND_ROWS p.* $search_join_columns
		FROM $db_firms AS p $search_join_condition
		WHERE $where
		ORDER BY firm_".$rs['firmsort']." ".$rs['firmsort2']."
		LIMIT $d, ".$cfg_maxitems
			.$search_union_query);

	$items = $sql->rowCount();
	$totalitems[] = $db->query('SELECT FOUND_ROWS()')->fetchColumn();
	$jj = 0;
	/* === Hook - Part 1 === */
	$extp = cot_getextplugins('search.firms.loop');
	/* ===== */
	foreach ($sql->fetchAll() as $row)
	{
		$url_cat = cot_url('firms', 'c='.$row['firm_cat']);
		$url_firm = empty($row['firm_alias']) ? cot_url('firms', 'c='.$row['firm_cat'].'&id='.$row['firm_id'].'&highlight='.$hl) : cot_url('firm', 'c='.$row['firm_cat'].'&al='.$row['firm_alias'].'&highlight='.$hl);
		$t->assign(cot_generate_firmtags($row, 'PLUGIN_FIRMSRES_'));
		$t->assign(array(
			'PLUGIN_FIRMSRES_CATEGORY' => cot_rc_link($url_cat, $structure['firms'][$row['firm_cat']]['tpath']),
			'PLUGIN_FIRMSRES_CATEGORY_URL' => $url_cat,
			'PLUGIN_FIRMSRES_TITLE' => cot_rc_link($url_firm, htmlspecialchars($row['firm_title'])),
			'PLUGIN_FIRMSRES_TEXT' => cot_clear_mark($row['firm_text'], $words),
			'PLUGIN_FIRMSRES_TIME' => cot_date('datetime_medium', $row['firm_date']),
			'PLUGIN_FIRMSRES_TIMESTAMP' => $row['firm_date'],
			'PLUGIN_FIRMSRES_ODDEVEN' => cot_build_oddeven($jj),
			'PLUGIN_FIRMSRES_NUM' => $jj
		));
		/* === Hook - Part 2 === */
		foreach ($extp as $pl)
		{
			include $pl;
		}
		/* ===== */
		$t->parse('MAIN.RESULTS.FIRMS.ITEM');
		$jj++;
	}
	if ($jj > 0)
	{
		$t->parse('MAIN.RESULTS.FIRMS');
	}
	unset($where_and, $where_or, $where);
}

?>