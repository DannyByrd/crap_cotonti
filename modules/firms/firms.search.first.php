<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=search.first
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

$rs['firmtitle'] = cot_import($rs['firmtitle'], 'D', 'INT');
$rs['firmdesc'] = cot_import($rs['firmdesc'], 'D', 'INT');
$rs['firmtext'] = cot_import($rs['firmtext'], 'D', 'INT');
$rs['firmfile'] = cot_import($rs['firmfile'], 'D', 'INT');
$rs['firmsort'] = cot_import($rs['firmsort'], 'D', 'ALP');
$rs['firmsort'] = (empty($rs['firmsort'])) ? 'date' : $rs['firmsort'];
$rs['firmsort2'] = (cot_import($rs['firmsort2'], 'D', 'ALP') == 'DESC') ? 'DESC' : 'ASC';
$rs['firmsub'] = cot_import($rs['firmsub'], 'D', 'ARR');
$rs['firmsubcat'] = cot_import($rs['firmsubcat'], 'D', 'BOL') ? 1 : 0;

if ($rs['firmtitle'] < 1 && $rs['firmdesc'] < 1 && $rs['firmtext'] < 1)
{
	$rs['firmtitle'] = 1;
	$rs['firmdesc'] = 1;
	$rs['firmtext'] = 1;
}

if (($tab == 'firms' || empty($tab)) && cot_module_active('firms'))
{
	require_once cot_incfile('firms', 'module');

	// Making the category list
	$firms_cat_list['all'] = $L['plu_allcategories'];
	foreach ($structure['firms'] as $cat => $x)
	{
		if ($cat != 'all' && $cat != 'system' && cot_auth('firms', $cat, 'R') && $x['group'] == 0)
		{
			$firms_cat_list[$cat] = $x['tpath'];
			$firm_catauth[] = $db->prep($cat);
		}
	}
	if ($rs['firmsub'][0] == 'all' || !is_array($rs['firmsub']))
	{
		$rs['firmsub'] = array();
		$rs['firmsub'][] = 'all';
	}

	/* === Hook === */
	foreach (cot_getextplugins('search.firms.catlist') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->assign(array(
		'PLUGIN_FIRM_SEC_LIST' => cot_selectbox($rs['firmsub'], 'rs[firmsub][]', array_keys($firms_cat_list), array_values($firms_cat_list), false, 'multiple="multiple" style="width:50%"'),
		'PLUGIN_FIRM_RES_SORT' => cot_selectbox($rs['firmsort'], 'rs[firmsort]', array('date', 'title', 'count', 'cat'), array($L['plu_firm_res_sort1'], $L['plu_firm_res_sort2'], $L['plu_firm_res_sort3'], $L['plu_firm_res_sort4']), false),
		'PLUGIN_FIRM_RES_SORT_WAY' => cot_radiobox($rs['firmsort2'], 'rs[firmsort2]', array('DESC', 'ASC'), array($L['plu_sort_desc'], $L['plu_sort_asc'])),
		'PLUGIN_FIRM_SEARCH_NAMES' => cot_checkbox(($rs['firmtitle'] == 1 || count($rs['firmsub']) == 0), 'rs[firmtitle]', $L['plu_firm_search_names']),
		'PLUGIN_FIRM_SEARCH_DESC' => cot_checkbox(($rs['firmdesc'] == 1 || count($rs['firmsub']) == 0), 'rs[firmdesc]', $L['plu_firm_search_desc']),
		'PLUGIN_FIRM_SEARCH_TEXT' => cot_checkbox(($rs['firmtext'] == 1 || count($rs['firmsub']) == 0), 'rs[firmtext]', $L['plu_firm_search_text']),
		'PLUGIN_FIRM_SEARCH_SUBCAT' => cot_checkbox($rs['firmsubcat'], 'rs[firmsubcat]', $L['plu_firm_set_subsec']),
	));
	if ($tab == 'firms' || (empty($tab) && $cfg['plugin']['search']['extrafilters']))
	{
		$t->parse('MAIN.FIRMS_OPTIONS');
	}
}

?>