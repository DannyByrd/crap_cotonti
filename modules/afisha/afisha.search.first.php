<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=search.first
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

$rs['eventtitle'] = cot_import($rs['eventtitle'], 'D', 'INT');
$rs['eventdesc'] = cot_import($rs['eventdesc'], 'D', 'INT');
$rs['eventtext'] = cot_import($rs['eventtext'], 'D', 'INT');
$rs['eventfile'] = cot_import($rs['eventfile'], 'D', 'INT');
$rs['eventsort'] = cot_import($rs['eventsort'], 'D', 'ALP');
$rs['eventsort'] = (empty($rs['eventsort'])) ? 'date' : $rs['eventsort'];
$rs['eventsort2'] = (cot_import($rs['eventsort2'], 'D', 'ALP') == 'DESC') ? 'DESC' : 'ASC';
$rs['afishasub'] = cot_import($rs['afishasub'], 'D', 'ARR');
$rs['afishasubcat'] = cot_import($rs['afishasubcat'], 'D', 'BOL') ? 1 : 0;

if ($rs['eventtitle'] < 1 && $rs['eventdesc'] < 1 && $rs['eventtext'] < 1)
{
	$rs['eventtitle'] = 1;
	$rs['eventdesc'] = 1;
	$rs['eventtext'] = 1;
}

if (($tab == 'afisha' || empty($tab)) && cot_module_active('afisha'))
{
	require_once cot_incfile('afisha', 'module');

	// Making the category list
	$afisha_cat_list['all'] = $L['plu_allcategories'];
	foreach ($structure['afisha'] as $cat => $x)
	{
		if ($cat != 'all' && $cat != 'system' && cot_auth('afisha', $cat, 'R') && $x['group'] == 0)
		{
			$afisha_cat_list[$cat] = $x['tpath'];
			$event_catauth[] = $db->prep($cat);
		}
	}
	if ($rs['afishasub'][0] == 'all' || !is_array($rs['afishasub']))
	{
		$rs['afishasub'] = array();
		$rs['afishasub'][] = 'all';
	}

	/* === Hook === */
	foreach (cot_getextplugins('search.afisha.catlist') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->assign(array(
		'PLUGIN_BOARD_SEC_LIST' => cot_selectbox($rs['afishasub'], 'rs[afishasub][]', array_keys($afisha_cat_list), array_values($afisha_cat_list), false, 'multiple="multiple" style="width:50%"'),
		'PLUGIN_BOARD_RES_SORT' => cot_selectbox($rs['eventsort'], 'rs[eventsort]', array('date', 'title', 'count', 'cat'), array($L['plu_afisha_res_sort1'], $L['plu_afisha_res_sort2'], $L['plu_afisha_res_sort3'], $L['plu_afisha_res_sort4']), false),
		'PLUGIN_BOARD_RES_SORT_WAY' => cot_radiobox($rs['eventsort2'], 'rs[eventsort2]', array('DESC', 'ASC'), array($L['plu_sort_desc'], $L['plu_sort_asc'])),
		'PLUGIN_BOARD_SEARCH_NAMES' => cot_checkbox(($rs['eventtitle'] == 1 || count($rs['afishasub']) == 0), 'rs[eventtitle]', $L['plu_afisha_search_names']),
		'PLUGIN_BOARD_SEARCH_DESC' => cot_checkbox(($rs['eventdesc'] == 1 || count($rs['afishasub']) == 0), 'rs[eventdesc]', $L['plu_afisha_search_desc']),
		'PLUGIN_BOARD_SEARCH_TEXT' => cot_checkbox(($rs['eventtext'] == 1 || count($rs['afishasub']) == 0), 'rs[eventtext]', $L['plu_afisha_search_text']),
		'PLUGIN_BOARD_SEARCH_SUBCAT' => cot_checkbox($rs['afishasubcat'], 'rs[afishasubcat]', $L['plu_afisha_set_subsec']),
	));
	if ($tab == 'afisha' || (empty($tab) && $cfg['plugin']['search']['extrafilters']))
	{
		$t->parse('MAIN.BOARD_OPTIONS');
	}
}

?>