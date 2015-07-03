<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=search.first
 * [END_COT_EXT]
 */

/**
 * Blogs module
 *
 * @package blogs
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

$rs['blgtitle'] = cot_import($rs['blgtitle'], 'D', 'INT');
$rs['blgdesc'] = cot_import($rs['blgdesc'], 'D', 'INT');
$rs['blgtext'] = cot_import($rs['blgtext'], 'D', 'INT');
$rs['blgfile'] = cot_import($rs['blgfile'], 'D', 'INT');
$rs['blgsort'] = cot_import($rs['blgsort'], 'D', 'ALP');
$rs['blgsort'] = (empty($rs['blgsort'])) ? 'date' : $rs['blgsort'];
$rs['blgsort2'] = (cot_import($rs['blgsort2'], 'D', 'ALP') == 'DESC') ? 'DESC' : 'ASC';
$rs['blgsub'] = cot_import($rs['blgsub'], 'D', 'ARR');
$rs['blgsubcat'] = cot_import($rs['blgsubcat'], 'D', 'BOL') ? 1 : 0;

if ($rs['blgtitle'] < 1 && $rs['blgdesc'] < 1 && $rs['blgtext'] < 1)
{
	$rs['blgtitle'] = 1;
	$rs['blgdesc'] = 1;
	$rs['blgtext'] = 1;
}

if (($tab == 'blogs' || empty($tab)) && cot_module_active('blogs'))
{
	require_once cot_incfile('blogs', 'module');

	// Making the category list
	$blogs_cat_list['all'] = $L['plu_allcategories'];
	foreach ($structure['blogs'] as $cat => $x)
	{
		if ($cat != 'all' && $cat != 'system' && cot_auth('blogs', $cat, 'R') && $x['group'] == 0)
		{
			$blogs_cat_list[$cat] = $x['tpath'];
			$blg_catauth[] = $db->prep($cat);
		}
	}
	if ($rs['blgsub'][0] == 'all' || !is_array($rs['blgsub']))
	{
		$rs['blgsub'] = array();
		$rs['blgsub'][] = 'all';
	}

	/* === Hook === */
	foreach (cot_getextplugins('search.blogs.catlist') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->assign(array(
		'PLUGIN_BLOGS_SEC_LIST' => cot_selectbox($rs['blgsub'], 'rs[blgsub][]', array_keys($blogs_cat_list), array_values($blogs_cat_list), false, 'multiple="multiple" style="width:50%"'),
		'PLUGIN_BLOGS_RES_SORT' => cot_selectbox($rs['blgsort'], 'rs[blgsort]', array('date', 'title', 'count', 'cat'), array($L['plu_blogs_res_sort1'], $L['plu_blogs_res_sort2'], $L['plu_blogs_res_sort3'], $L['plu_blogs_res_sort4']), false),
		'PLUGIN_BLOGS_RES_SORT_WAY' => cot_radiobox($rs['blgsort2'], 'rs[blgsort2]', array('DESC', 'ASC'), array($L['plu_sort_desc'], $L['plu_sort_asc'])),
		'PLUGIN_BLOGS_SEARCH_NAMES' => cot_checkbox(($rs['blgtitle'] == 1 || count($rs['blgsub']) == 0), 'rs[blgtitle]', $L['plu_blogs_search_names']),
		'PLUGIN_BLOGS_SEARCH_DESC' => cot_checkbox(($rs['blgdesc'] == 1 || count($rs['blgsub']) == 0), 'rs[blgdesc]', $L['plu_blogs_search_desc']),
		'PLUGIN_BLOGS_SEARCH_TEXT' => cot_checkbox(($rs['blgtext'] == 1 || count($rs['blgsub']) == 0), 'rs[blgtext]', $L['plu_blogs_search_text']),
		'PLUGIN_BLOGS_SEARCH_SUBCAT' => cot_checkbox($rs['blgsubcat'], 'rs[blgsubcat]', $L['plu_blogs_set_subsec']),
	));
	if ($tab == 'blogs' || (empty($tab) && $cfg['plugin']['search']['extrafilters']))
	{
		$t->parse('MAIN.BLOGS_OPTIONS');
	}
}

?>