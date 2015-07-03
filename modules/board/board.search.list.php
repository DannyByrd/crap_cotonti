<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=search.list
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


if (($tab == 'board' || empty($tab)) && cot_module_active('board') && !cot_error_found())
{
	$where_and = array();
	$where_or = array();
	
	if ($rs['boardsub'][0] != 'all' && count($rs['boardsub']) > 0)
	{
		if ($rs['boardsubcat'])
		{
			$tempcat = array();
			foreach ($rs['boardsub'] as $scat)
			{
				$tempcat = array_merge(cot_structure_children('board', $scat), $tempcat);
			}
			$tempcat = array_unique($tempcat);
			$where_and['cat'] = "adv_cat IN ('".implode("','", $tempcat)."')";
		}
		else
		{
			$tempcat = array();
			foreach ($rs['boardsub'] as $scat)
			{
				$tempcat[] = $db->prep($scat);
			}
			$where_and['cat'] = "adv_cat IN ('".implode("','", $tempcat)."')";
		}
	}
	else
	{
		$where_and['cat'] = "adv_cat IN ('".implode("','", $adv_catauth)."')";
	}
	$where_and['state'] = "adv_state = 0";
	$where_and['date'] = ($rs['setlimit'] > 0) ? "adv_date >= ".$rs['setfrom']." AND adv_date <= ".$rs['setto'] : "";
	$where_and['users'] = (!empty($touser)) ? "adv_ownerid ".$touser_ids : "";

	$where_or['title'] = ($rs['advtitle'] == 1) ? "adv_title LIKE '".$db->prep($sqlsearch)."'" : "";
	$where_or['desc'] = (($rs['advdesc'] == 1)) ? "adv_desc LIKE '".$db->prep($sqlsearch)."'" : "";
	$where_or['text'] = (($rs['advtext'] == 1)) ? "adv_text LIKE '".$db->prep($sqlsearch)."'" : "";
	// String query for addition board fields.
	foreach (explode(',', trim($cfg['plugin']['search']['addfields'])) as $addfields_el)
	{
		$addfields_el = trim($addfields_el);
		$where_or[$addfields_el] .= ( (!empty($addfields_el))) ? $addfields_el." LIKE '".$sqlsearch."'" : "";
	}
	$where_or = array_diff($where_or, array(''));
	count($where_or) || $where_or['title'] = "adv_title LIKE '".$db->prep($sqlsearch)."'";
	$where_and['or'] = '('.implode(' OR ', $where_or).')';
	$where_and = array_diff($where_and, array(''));
	$where = implode(' AND ', $where_and);

	/* === Hook === */
	foreach (cot_getextplugins('search.board.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!$db->fieldExists($db_board, 'adv_'.$rs['advsort']))
	{
		$rs['advsort'] = 'date';
	}

	$sql = $db->query("SELECT SQL_CALC_FOUND_ROWS p.* $search_join_columns
		FROM $db_board AS p $search_join_condition
		WHERE $where
		ORDER BY adv_".$rs['advsort']." ".$rs['advsort2']."
		LIMIT $d, ".$cfg_maxitems
			.$search_union_query);

	$items = $sql->rowCount();
	$totalitems[] = $db->query('SELECT FOUND_ROWS()')->fetchColumn();
	$jj = 0;
	/* === Hook - Part 1 === */
	$extp = cot_getextplugins('search.board.loop');
	/* ===== */
	
	foreach ($sql->fetchAll() as $row)
	{
		
		$url_cat = cot_url('board', 'c='.$row['adv_cat']);
		$url_adv = empty($row['adv_alias']) ? cot_url('board', 'c='.$row['adv_cat'].'&id='.$row['adv_id'].'&highlight='.$hl) : cot_url('adv', 'c='.$row['adv_cat'].'&al='.$row['adv_alias'].'&highlight='.$hl);
		$t->assign(cot_generate_advtags($row, 'PLUGIN_BOARDRES_'));
		$t->assign(array(
			'PLUGIN_BOARDRES_CATEGORY' => cot_rc_link($url_cat, $structure['board'][$row['adv_cat']]['tpath']),
			'PLUGIN_BOARDRES_CATEGORY_URL' => $url_cat,
			'PLUGIN_BOARDRES_TITLE' => cot_rc_link($url_adv, htmlspecialchars($row['adv_title'])),
			'PLUGIN_BOARDRES_TEXT' => cot_clear_mark($row['adv_text'], $words),
			'PLUGIN_BOARDRES_TIME' => cot_date('datetime_medium', $row['adv_date']),
			'PLUGIN_BOARDRES_TIMESTAMP' => $row['adv_date'],
			'PLUGIN_BOARDRES_ODDEVEN' => cot_build_oddeven($jj),
			'PLUGIN_BOARDRES_NUM' => $jj
		));
		/* === Hook - Part 2 === */
		foreach ($extp as $pl)
		{
			include $pl;
		}
		/* ===== */
		$t->parse('MAIN.RESULTS.BOARD.ITEM');
		$jj++;
	}
	if ($jj > 0)
	{
		$t->parse('MAIN.RESULTS.BOARD');
	}
	unset($where_and, $where_or, $where);
}

?>