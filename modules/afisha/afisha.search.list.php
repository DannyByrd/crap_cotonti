<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=search.list
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

if (($tab == 'afisha' || empty($tab)) && cot_module_active('afisha') && !cot_error_found())
{
	$where_and = array();
	$where_or = array();
	
	if ($rs['afishasub'][0] != 'all' && count($rs['afishasub']) > 0)
	{
		if ($rs['afishasubcat'])
		{
			$tempcat = array();
			foreach ($rs['afishasub'] as $scat)
			{
				$tempcat = array_merge(cot_structure_children('afisha', $scat), $tempcat);
			}
			$tempcat = array_unique($tempcat);
			$where_and['cat'] = "event_cat IN ('".implode("','", $tempcat)."')";
		}
		else
		{
			$tempcat = array();
			foreach ($rs['afishasub'] as $scat)
			{
				$tempcat[] = $db->prep($scat);
			}
			$where_and['cat'] = "event_cat IN ('".implode("','", $tempcat)."')";
		}
	}
	else
	{
		$where_and['cat'] = "event_cat IN ('".implode("','", $event_catauth)."')";
	}
	$where_and['state'] = "event_state = 0";
	$where_and['date'] = ($rs['setlimit'] > 0) ? "event_date >= ".$rs['setfrom']." AND event_date <= ".$rs['setto'] : "";
	$where_and['users'] = (!empty($touser)) ? "event_ownerid ".$touser_ids : "";

	$where_or['title'] = ($rs['eventtitle'] == 1) ? "event_title LIKE '".$db->prep($sqlsearch)."'" : "";
	$where_or['desc'] = (($rs['eventdesc'] == 1)) ? "event_desc LIKE '".$db->prep($sqlsearch)."'" : "";
	$where_or['text'] = (($rs['eventtext'] == 1)) ? "event_text LIKE '".$db->prep($sqlsearch)."'" : "";
	// String query for addition afisha fields.
	foreach (explode(',', trim($cfg['plugin']['search']['addfields'])) as $addfields_el)
	{
		$addfields_el = trim($addfields_el);
		$where_or[$addfields_el] .= ( (!empty($addfields_el))) ? $addfields_el." LIKE '".$sqlsearch."'" : "";
	}
	$where_or = array_diff($where_or, array(''));
	count($where_or) || $where_or['title'] = "event_title LIKE '".$db->prep($sqlsearch)."'";
	$where_and['or'] = '('.implode(' OR ', $where_or).')';
	$where_and = array_diff($where_and, array(''));
	$where = implode(' AND ', $where_and);

	/* === Hook === */
	foreach (cot_getextplugins('search.afisha.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!$db->fieldExists($db_afisha, 'event_'.$rs['eventsort']))
	{
		$rs['eventsort'] = 'date';
	}

	$sql = $db->query("SELECT SQL_CALC_FOUND_ROWS p.* $search_join_columns
		FROM $db_afisha AS p $search_join_condition
		WHERE $where
		ORDER BY event_".$rs['eventsort']." ".$rs['eventsort2']."
		LIMIT $d, ".$cfg_maxitems
			.$search_union_query);

	$items = $sql->rowCount();
	$totalitems[] = $db->query('SELECT FOUND_ROWS()')->fetchColumn();
	$jj = 0;
	/* === Hook - Part 1 === */
	$extp = cot_getextplugins('search.afisha.loop');
	/* ===== */
	foreach ($sql->fetchAll() as $row)
	{
		$url_cat = cot_url('afisha', 'c='.$row['event_cat']);
		$url_event = empty($row['event_alias']) ? cot_url('afisha', 'c='.$row['event_cat'].'&id='.$row['event_id'].'&highlight='.$hl) : cot_url('event', 'c='.$row['event_cat'].'&al='.$row['event_alias'].'&highlight='.$hl);
		$t->assign(cot_generate_eventtags($row, 'PLUGIN_BOARDRES_'));
		$t->assign(array(
			'PLUGIN_BOARDRES_CATEGORY' => cot_rc_link($url_cat, $structure['afisha'][$row['event_cat']]['tpath']),
			'PLUGIN_BOARDRES_CATEGORY_URL' => $url_cat,
			'PLUGIN_BOARDRES_TITLE' => cot_rc_link($url_event, htmlspecialchars($row['event_title'])),
			'PLUGIN_BOARDRES_TEXT' => cot_clear_mark($row['event_text'], $words),
			'PLUGIN_BOARDRES_TIME' => cot_date('datetime_medium', $row['event_date']),
			'PLUGIN_BOARDRES_TIMESTAMP' => $row['event_date'],
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