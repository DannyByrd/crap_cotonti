<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=search.first
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

$rs['advtitle'] = cot_import($rs['advtitle'], 'D', 'INT');
$rs['advdesc'] = cot_import($rs['advdesc'], 'D', 'INT');
$rs['advtext'] = cot_import($rs['advtext'], 'D', 'INT');
$rs['advfile'] = cot_import($rs['advfile'], 'D', 'INT');
$rs['advsort'] = cot_import($rs['advsort'], 'D', 'ALP');
$rs['advsort'] = (empty($rs['advsort'])) ? 'date' : $rs['advsort'];
$rs['advsort2'] = (cot_import($rs['advsort2'], 'D', 'ALP') == 'DESC') ? 'DESC' : 'ASC';
$rs['boardsub'] = cot_import($rs['boardsub'], 'D', 'ARR');
$rs['boardsubcat'] = cot_import($rs['boardsubcat'], 'D', 'BOL') ? 1 : 0;

if ($rs['advtitle'] < 1 && $rs['advdesc'] < 1 && $rs['advtext'] < 1)
{
	$rs['advtitle'] = 1;
	$rs['advdesc'] = 1;
	$rs['advtext'] = 1;
}

if (($tab == 'board' || empty($tab)) && cot_module_active('board'))
{
	require_once cot_incfile('board', 'module');

	// Making the category list
	$board_cat_list['all'] = $L['plu_allcategories'];
	foreach ($structure['board'] as $cat => $x)
	{
		if ($cat != 'all' && $cat != 'system' && cot_auth('board', $cat, 'R') && $x['group'] == 0)
		{
			$board_cat_list[$cat] = $x['tpath'];
			$adv_catauth[] = $db->prep($cat);
		}
	}
	if ($rs['boardsub'][0] == 'all' || !is_array($rs['boardsub']))
	{
		$rs['boardsub'] = array();
		$rs['boardsub'][] = 'all';
	}

	/* === Hook === */
	foreach (cot_getextplugins('search.board.catlist') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->assign(array(
		'PLUGIN_BOARD_SEC_LIST' => cot_selectbox($rs['boardsub'], 'rs[boardsub][]', array_keys($board_cat_list), array_values($board_cat_list), false, 'multiple="multiple" style="width:50%"'),
		'PLUGIN_BOARD_RES_SORT' => cot_selectbox($rs['advsort'], 'rs[advsort]', array('date', 'title', 'count', 'cat'), array($L['plu_board_res_sort1'], $L['plu_board_res_sort2'], $L['plu_board_res_sort3'], $L['plu_board_res_sort4']), false),
		'PLUGIN_BOARD_RES_SORT_WAY' => cot_radiobox($rs['advsort2'], 'rs[advsort2]', array('DESC', 'ASC'), array($L['plu_sort_desc'], $L['plu_sort_asc'])),
		'PLUGIN_BOARD_SEARCH_NAMES' => cot_checkbox(($rs['advtitle'] == 1 || count($rs['boardsub']) == 0), 'rs[advtitle]', $L['plu_board_search_names']),
		'PLUGIN_BOARD_SEARCH_DESC' => cot_checkbox(($rs['advdesc'] == 1 || count($rs['boardsub']) == 0), 'rs[advdesc]', $L['plu_board_search_desc']),
		'PLUGIN_BOARD_SEARCH_TEXT' => cot_checkbox(($rs['advtext'] == 1 || count($rs['boardsub']) == 0), 'rs[advtext]', $L['plu_board_search_text']),
		'PLUGIN_BOARD_SEARCH_SUBCAT' => cot_checkbox($rs['boardsubcat'], 'rs[boardsubcat]', $L['plu_board_set_subsec']),
	));
	if ($tab == 'board' || (empty($tab) && $cfg['plugin']['search']['extrafilters']))
	{
		$t->parse('MAIN.BOARD_OPTIONS');
	}
}

?>