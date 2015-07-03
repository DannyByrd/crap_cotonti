<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=search.first
 * [END_COT_EXT]
 */

/**
 * Board module
 *
 * @package vac
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

$rs['vactitle'] = cot_import($rs['vactitle'], 'D', 'INT');
$rs['vacdesc'] = cot_import($rs['vacdesc'], 'D', 'INT');
$rs['vacduty'] = cot_import($rs['vacduty'], 'D', 'INT');
$rs['vacterm'] = cot_import($rs['vacterm'], 'D', 'INT');
$rs['vacqua'] = cot_import($rs['vacqua'], 'D', 'INT');
$rs['vacsort'] = cot_import($rs['vacsort'], 'D', 'ALP');
$rs['vacsort'] = (empty($rs['vacsort'])) ? 'date' : $rs['vacsort'];
$rs['vacsort2'] = (cot_import($rs['vacsort2'], 'D', 'ALP') == 'DESC') ? 'DESC' : 'ASC';
$rs['vacsub'] = cot_import($rs['vacsub'], 'D', 'ARR');
$rs['vacsubcat'] = cot_import($rs['vacsubcat'], 'D', 'BOL') ? 1 : 0;

if ($rs['vactitle'] < 1 && $rs['vacdesc'] < 1 && $rs['vacduty'] < 1 && $rs['vacterm'] < 1 && $rs['vacqua'] < 1)
{
	$rs['vactitle'] = 1;
	$rs['vacdesc'] = 1;
	$rs['vacduty'] = 1;
	$rs['vacterm'] = 1;
	$rs['vacqua'] = 1;
}

if (($tab == 'vac' || empty($tab)) && cot_module_active('vacancies'))
{
	require_once cot_incfile('vacancies', 'module');

	// Making the category list
	$vac_cat_list['all'] = $L['plu_allcategories'];
	foreach ($structure['vacancies'] as $cat => $x)
	{
		if ($cat != 'all' && $cat != 'system' && cot_auth('vacancies', $cat, 'R') && $x['group'] == 0)
		{
			$vac_cat_list[$cat] = $x['tpath'];
			$vac_catauth[] = $db->prep($cat);
		}
	}
	if ($rs['vacsub'][0] == 'all' || !is_array($rs['vacsub']))
	{
		$rs['vacsub'] = array();
		$rs['vacsub'][] = 'all';
	}

	/* === Hook === */
	foreach (cot_getextplugins('search.vacancies.catlist') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->assign(array(
		'PLUGIN_VAC_SEC_LIST' => cot_selectbox($rs['vacsub'], 'rs[vacsub][]', array_keys($vac_cat_list), array_values($vac_cat_list), false, 'multiple="multiple" style="width:50%"'),
		'PLUGIN_VAC_RES_SORT' => cot_selectbox($rs['vacsort'], 'rs[vacsort]', array('date', 'title', 'count', 'cat'), array($L['plu_vac_res_sort1'], $L['plu_vac_res_sort2'], $L['plu_vac_res_sort3'], $L['plu_vac_res_sort4']), false),
		'PLUGIN_VAC_RES_SORT_WAY' => cot_radiobox($rs['vacsort2'], 'rs[vacsort2]', array('DESC', 'ASC'), array($L['plu_sort_desc'], $L['plu_sort_asc'])),
		'PLUGIN_VAC_SEARCH_NAMES' => cot_checkbox(($rs['vactitle'] == 1 || count($rs['vacsub']) == 0), 'rs[vactitle]', $L['plu_vac_search_names']),
		'PLUGIN_VAC_SEARCH_DESC' => cot_checkbox(($rs['vacdesc'] == 1 || count($rs['vacsub']) == 0), 'rs[vacdesc]', $L['plu_vac_search_desc']),
		'PLUGIN_VAC_SEARCH_DUTY' => cot_checkbox(($rs['vacduty'] == 1 || count($rs['vacsub']) == 0), 'rs[vacduty]', $L['plu_vac_search_duty']),
		'PLUGIN_VAC_SEARCH_TERM' => cot_checkbox(($rs['vacterm'] == 1 || count($rs['vacsub']) == 0), 'rs[vacterm]', $L['plu_vac_search_term']),
		'PLUGIN_VAC_SEARCH_QUA' => cot_checkbox(($rs['vacqua'] == 1 || count($rs['vacsub']) == 0), 'rs[vacqua]', $L['plu_vac_search_qua']),
		'PLUGIN_VAC_SEARCH_SUBCAT' => cot_checkbox($rs['vacsubcat'], 'rs[vacsubcat]', $L['plu_vac_set_subsec']),
	));
	if ($tab == 'vac' || (empty($tab) && $cfg['plugin']['search']['extrafilters']))
	{
		$t->parse('MAIN.VAC_OPTIONS');
	}
}

?>