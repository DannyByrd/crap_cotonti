<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=search.first
 * [END_COT_EXT]
 */

/**
 * Board module
 *
 * @package rez
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

$rs['reztitle'] = cot_import($rs['reztitle'], 'D', 'INT');
$rs['rezworks'] = cot_import($rs['rezworks'], 'D', 'INT');
$rs['rezstudy'] = cot_import($rs['rezstufy'], 'D', 'INT');
$rs['rezqua'] = cot_import($rs['rezqua'], 'D', 'INT');
$rs['rezsort'] = cot_import($rs['rezsort'], 'D', 'ALP');
$rs['rezsort'] = (empty($rs['rezsort'])) ? 'date' : $rs['rezsort'];
$rs['rezsort2'] = (cot_import($rs['rezsort2'], 'D', 'ALP') == 'DESC') ? 'DESC' : 'ASC';
$rs['rezsub'] = cot_import($rs['rezsub'], 'D', 'ARR');
$rs['rezsubcat'] = cot_import($rs['rezsubcat'], 'D', 'BOL') ? 1 : 0;

if ($rs['reztitle'] < 1 && $rs['rezworks'] < 1 && $rs['rezstudy'] < 1 && $rs['rezqua'] < 1)
{
	$rs['reztitle'] = 1;
	$rs['rezworks'] = 1;
	$rs['rezstudy'] = 1;
	$rs['rezqua'] = 1;
}

if (($tab == 'rez' || empty($tab)) && cot_module_active('rezume'))
{
	require_once cot_incfile('rezume', 'module');

	// Making the category list
	$rez_cat_list['all'] = $L['plu_allcategories'];
	foreach ($structure['rezume'] as $cat => $x)
	{
		if ($cat != 'all' && $cat != 'system' && cot_auth('rezume', $cat, 'R') && $x['group'] == 0)
		{
			$rez_cat_list[$cat] = $x['tpath'];
			$rez_catauth[] = $db->prep($cat);
		}
	}
	if ($rs['rezsub'][0] == 'all' || !is_array($rs['rezsub']))
	{
		$rs['rezsub'] = array();
		$rs['rezsub'][] = 'all';
	}

	/* === Hook === */
	foreach (cot_getextplugins('search.rezume.catlist') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->assign(array(
		'PLUGIN_REZUME_SEC_LIST' => cot_selectbox($rs['rezsub'], 'rs[rezsub][]', array_keys($rez_cat_list), array_values($rez_cat_list), false, 'multiple="multiple" style="width:50%"'),
		'PLUGIN_REZUME_RES_SORT' => cot_selectbox($rs['rezsort'], 'rs[rezsort]', array('date', 'title', 'count', 'cat'), array($L['plu_rez_res_sort1'], $L['plu_rez_res_sort2'], $L['plu_rez_res_sort3'], $L['plu_rez_res_sort4']), false),
		'PLUGIN_REZUME_RES_SORT_WAY' => cot_radiobox($rs['rezsort2'], 'rs[rezsort2]', array('DESC', 'ASC'), array($L['plu_sort_desc'], $L['plu_sort_asc'])),
		'PLUGIN_REZUME_SEARCH_NAMES' => cot_checkbox(($rs['reztitle'] == 1 || count($rs['rezsub']) == 0), 'rs[reztitle]', $L['plu_rez_search_names']),
		'PLUGIN_REZUME_SEARCH_WORKS' => cot_checkbox(($rs['rezworks'] == 1 || count($rs['rezsub']) == 0), 'rs[rezworks]', $L['plu_rez_search_works']),
		'PLUGIN_REZUME_SEARCH_STUDY' => cot_checkbox(($rs['rezstudy'] == 1 || count($rs['rezsub']) == 0), 'rs[rezstudy]', $L['plu_rez_search_study']),
		'PLUGIN_REZUME_SEARCH_QUA' => cot_checkbox(($rs['rezqua'] == 1 || count($rs['rezsub']) == 0), 'rs[rezqua]', $L['plu_rez_search_qua']),
		'PLUGIN_REZUME_SEARCH_SUBCAT' => cot_checkbox($rs['rezsubcat'], 'rs[rezsubcat]', $L['plu_rez_set_subsec']),
	));
	if ($tab == 'rez' || (empty($tab) && $cfg['plugin']['search']['extrafilters']))
	{
		$t->parse('MAIN.REZUME_OPTIONS');
	}
}

?>