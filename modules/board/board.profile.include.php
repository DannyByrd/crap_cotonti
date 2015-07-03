<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=profile.include
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

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('board', 'any');
cot_block($usr['auth_write']);

require_once cot_incfile('board', 'module');

$profilemenu['board']['title'] = $L['Board'];
$profilemenu['board']['url'] = cot_url('profile', 'm=board');

if($m == 'all')
{
	$user_id = $usr['isadmin'] ? '1' : $usr['id'];
	
	$sql_adv_string = "SELECT f.*, u.*
		FROM $db_board as f $join_condition
		LEFT JOIN $db_users AS u ON u.user_id=f.adv_ownerid
		WHERE f.adv_ownerid = $user_id AND f.adv_state = 0
		ORDER BY f.adv_date DESC LIMIT 0, 2";

	$adv_set = $db->query($sql_adv_string)->fetchAll();

	$t1 = new XTemplate(cot_tplfile(array('board', 'profile', 'all'), 'module'));

	foreach ($adv_set as $adv)
	{
		$jj++;
		$t1->assign(cot_generate_advtags($adv, 'LIST_ROW_', $cfg['board']['truncatetext'], $usr['isadmin']));
		$t1->assign(array(
			'LIST_ROW_OWNER' => cot_build_user($adv['adv_ownerid'], htmlspecialchars($adv['user_name'])),
			'LIST_ROW_ODDEVEN' => cot_build_oddeven($jj),
			'LIST_ROW_NUM' => $jj
		));
		$t1->assign(cot_generate_usertags($adv, 'LIST_ROW_OWNER_'));

		$t1->parse('MAIN.LIST_ROW');
	}
	
	$t1->parse('MAIN');
	$all_text .= $t1->text('MAIN');
}
elseif($m == 'board')
{
	$t1 = new XTemplate(cot_tplfile(array('board', 'profile'), 'module'));

	
	$s = cot_import('s', 'G', 'ALP'); // order field name without 'adv_'
	$w = cot_import('w', 'G', 'ALP', 4); // order way (asc, desc)
	$c = cot_import('c', 'G', 'TXT'); // cat code
	$o = cot_import('ord', 'G', 'ARR'); // filter field names without 'adv_'
	$p = cot_import('p', 'G', 'ARR'); // filter values
	$maxrowsperpage = ($cfg['board']['cat_' . $c]['maxrowsperpage']) ? $cfg['board']['cat_' . $c]['maxrowsperpage'] : $cfg['board']['cat___default']['maxrowsperpage'];
	list($pg, $d, $durl) = cot_import_pagenav('d', $maxrowsperpage); //board number for board list
	list($pgc, $dc, $dcurl) = cot_import_pagenav('dc', $cfg['board']['maxlistsperpage']);// board number for cats list

	if (empty($c))
	{
		list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('board', 'any');
		cot_block($usr['auth_read']);
	}
	elseif ($c == 'unvalidated' || $c == 'saved_drafts')
	{
		list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('board', 'any');
		cot_block($usr['auth_write']);
	}
	elseif (!isset($structure['board'][$c]))
	{
		cot_die_message(404, TRUE);
	}
	else
	{
		list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('board', $c);
		cot_block($usr['auth_read']);
	}

	/* === Hook === */
	foreach (cot_getextplugins('board.profile.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$cat = &$structure['board'][$c];

	if (empty($s))
	{
		$s = $cfg['board']['cat_' . $c]['order'];
	}
	elseif (!$db->fieldExists($db_board, "adv_$s"))
	{
		$s = 'date';
	}
	$w = empty($w) ? $cfg['board']['cat_' . $c]['way'] : $w;

	$s = empty($s) ? $cfg['board']['cat___default']['order'] : $s;
	$w = (empty($w) || !in_array($w, array('asc', 'desc'))) ? $cfg['board']['cat___default']['way'] : $w;

	$cfg['board']['maxrowsperpage'] = (empty($c) || $c == 'unvalidated' || $c == 'saved_drafts') ?
		$cfg['board']['cat___default']['maxrowsperpage'] :
		$cfg['board']['cat_' . $c]['maxrowsperpage'];
	$cfg['board']['maxrowsperpage'] = $cfg['board']['maxrowsperpage'] > 0 ? $cfg['board']['maxrowsperpage'] : 1;

	$cfg['board']['truncatefirmtext'] = (empty($c) || $c == 'unvalidated' || $c == 'saved_drafts') ?
		$cfg['board']['cat___default']['truncatefirmtext'] :
		$cfg['board']['cat_' . $c]['truncatefirmtext'];

	$where = array();
	$params = array();

	$where['ownerid'] = "adv_ownerid=".$urr['user_id'];
	//$where['state'] = "adv_state=0";
	
	if(empty($c))
	{
		$cat['title'] = $L['Firms'];
		$cat['desc'] = '';
	}
	elseif ($c == 'unvalidated')
	{
		$cat['tpl'] = 'unvalidated';
		$where['state'] = 'adv_state = 1';
		$where['ownerid'] = $usr['isadmin'] ? '1' : 'adv_ownerid = ' . $usr['id'];
		$cat['title'] = $L['adv_validation'];
		$cat['desc'] = $L['adv_validation_desc'];
		$s = 'date';
		$w = 'desc';
	}
	elseif ($c == 'saved_drafts')
	{
		$cat['tpl'] = 'unvalidated';
		$where['state'] = 'adv_state = 2';
		$where['ownerid'] = $usr['isadmin'] ? '1' : 'adv_ownerid = ' . $usr['id'];
		$cat['title'] = $L['adv_drafts'];
		$cat['desc'] = $L['adv_drafts_desc'];
		$s = 'date';
		$w = 'desc';
	}
	else
	{
		$catsub = cot_structure_children('board', $c);
		$where['cat'] = "adv_cat IN ('".implode("','", $catsub)."')";
	}

	if ($o && $p)
	{
		if (!is_array($o)) $o = array($o);
		if (!is_array($p)) $p = array($p);
		$filters = array_combine($o, $p);
		foreach ($filters as $key => $val)
		{
			$key = cot_import($key, 'D', 'ALP', 16);
			$val = cot_import($val, 'D', 'TXT', 16);
			if ($key && $val && $db->fieldExists($db_board, "adv_$key"))
			{
				$params[$key] = $val;
				$where['filter'][] = "adv_$key = :$key";
			}
		}
		empty($where['filter']) || $where['filter'] = implode(' AND ', $where['filter']);
	}

	$orderby = "adv_$s $w";

	$list_url_path = array('m' => 'board', 'c' => $c, 'ord' => $o, 'p' => $p);
	
	if ($s != $cfg['board']['cat_' . $c]['order'])
	{
		$list_url_path['s'] = $s;
	}
	if ($w != $cfg['board']['cat_' . $c]['way'])
	{
		$list_url_path['w'] = $w;
	}
	$list_url = cot_url('profile', $list_url_path);

	// Building the canonical URL
	$boardurl_params = array('c' => $c, 'ord' => $o, 'p' => $p);
	if ($durl > 1)
	{
		$boardurl_params['d'] = $durl;
	}
	if ($dcurl > 1)
	{
		$boardurl_params['dc'] = $dcurl;
	}

	/* === Hook === */
	foreach (cot_getextplugins('board.profile.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if(empty($sql_adv_string))
	{
		$where = array_filter($where);
		$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
		$sql_adv_count = "SELECT COUNT(*) FROM $db_board as f $join_condition $where";
		$sql_adv_string = "SELECT f.*, u.* $join_columns
			FROM $db_board as f $join_condition
			LEFT JOIN $db_users AS u ON u.user_id=f.adv_ownerid
			$where
			ORDER BY $orderby LIMIT $d, ".$cfg['board']['maxrowsperpage'];
	}
	$totallines = $db->query($sql_adv_count, $params)->fetchColumn();
	$sqllist = $db->query($sql_adv_string, $params);

	if ((!$cfg['easypagenav'] && $durl > 0 && $cfg['board']['maxrowsperpage'] > 0 && $durl % $cfg['board']['maxrowsperpage'] > 0)
		|| ($d > 0 && $d >= $totallines))
	{
		cot_redirect(cot_url('profile', $list_url_path + array('dc' => $dcurl)));
	}

	$pagenav = cot_pagenav('profile', $list_url_path + array('dc' => $dcurl), $d, $totallines, $cfg['board']['maxrowsperpage']);


	$t->assign(array(
		'LIST_TOP_PAGINATION' => $pagenav['main'],
		'LIST_TOP_PAGEPREV' => $pagenav['prev'],
		'LIST_TOP_PAGENEXT' => $pagenav['next'],
		'LIST_TOP_CURRENTPAGE' => $pagenav['current'],
		'LIST_TOP_TOTALLINES' => $totallines,
		'LIST_TOP_MAXPERPAGE' => $cfg['board']['maxrowsperpage'],
		'LIST_TOP_TOTALPAGES' => $pagenav['total']
	));

	if ($usr['auth_write'])
	{
		$t1->assign(array(
			'LIST_SUBMITNEWADV' => cot_rc('adv_submitnewadv', array('sub_url' => cot_url('board', 'm=add'))),
			'LIST_SUBMITNEWADV_URL' => cot_url('board', 'm=add')
		));
	}

	// Extra fields for structure
	foreach ($cot_extrafields[$db_structure] as $exfld)
	{
		$uname = strtoupper($exfld['field_name']);
		$t1->assign(array(
			'LIST_CAT_'.$uname.'_TITLE' => isset($L['structure_'.$exfld['field_name'].'_title']) ?
				$L['structure_'.$exfld['field_name'].'_title'] : $exfld['field_description'],
			'LIST_CAT_'.$uname => cot_build_extrafields_data('structure', $exfld, $cat[$exfld['field_name']]),
			'LIST_CAT_'.$uname.'_VALUE' => $cat[$exfld['field_name']],
		));
	}

	$arrows = array();
	foreach ($cot_extrafields[$db_board] + array('title' => 'title', 'key' => 'key', 'date' => 'date', 'owner' => 'owner', 'count' => 'count') as $row_k => $row_p)
	{
		$uname = strtoupper($row_k);
		$url_asc = cot_url('board',  array('s' => $row_k, 'w' => 'asc') + $list_url_path);
		$url_desc = cot_url('board', array('s' => $row_k, 'w' => 'desc') + $list_url_path);
		$arrows[$row_k]['asc']  = $R['icon_down'];
		$arrows[$row_k]['desc'] = $R['icon_up'];
		if ($s == $val)
		{
			$arrows[$s][$w] = $R['icon_vert_active'][$w];
		}
		if(in_array($row_k, array('title', 'key', 'date', 'owner', 'count')))
		{
			$t1->assign(array(
			'LIST_TOP_'.$uname => cot_rc("list_link_$row_k", array(
				'cot_img_down' => $arrows[$col]['asc'], 'cot_img_up' => $arrows[$col]['desc'],
				'list_link_url_down' => $url_asc, 'list_link_url_up' => $url_desc
			))));
		}
		else
		{
			$extratitle = isset($L['adv_'.$row_k.'_title']) ?	$L['adv_'.$row_k.'_title'] : $row_p['field_description'];
			$t1->assign(array(
				'LIST_TOP_'.$uname => cot_rc('list_link_field_name', array(
					'cot_img_down' => $arrows[$row_k]['asc'],
					'cot_img_up' => $arrows[$row_k]['desc'],
					'list_link_url_down' => $url_asc,
					'list_link_url_up' => $url_desc
			))));
		}
		$t1->assign(array(
			'LIST_TOP_'.$uname.'_URL_ASC' => $url_asc,
			'LIST_TOP_'.$uname.'_URL_DESC' => $url_desc
		));
	}

	$pagenav_cat = cot_pagenav('profile', $list_url_path + array('d' => $durl), $dc, count($allsub), $cfg['board']['maxlistsperpage'], 'dc');

	$t1->assign(array(
		'LISTCAT_PAGEPREV' => $pagenav_cat['prev'],
		'LISTCAT_PAGENEXT' => $pagenav_cat['next'],
		'LISTCAT_PAGNAV' => $pagenav_cat['main']
	));

	$jj = 0;
	/* === Hook - Part1 : Set === */
	$extp = cot_getextplugins('board.profile.loop');
	/* ===== */
	$sqllist_rowset = $sqllist->fetchAll();

	$sqllist_rowset_other = false;
	/* === Hook === */
	foreach (cot_getextplugins('board.profile.before_loop') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if(!$sqllist_rowset_other)
	{
		foreach ($sqllist_rowset as $adv)
		{
			$jj++;
			$t1->assign(cot_generate_advtags($adv, 'LIST_ROW_', $cfg['board']['truncatetext'], $usr['isadmin']));
			$t1->assign(array(
				'LIST_ROW_OWNER' => cot_build_user($adv['adv_ownerid'], htmlspecialchars($adv['user_name'])),
				'LIST_ROW_ODDEVEN' => cot_build_oddeven($jj),
				'LIST_ROW_NUM' => $jj
			));
			$t1->assign(cot_generate_usertags($adv, 'LIST_ROW_OWNER_'));

			/* === Hook - Part2 : Include === */
			foreach ($extp as $pl)
			{
				include $pl;
			}
			/* ===== */
			$t1->parse('MAIN.LIST_ROW');
		}
	}

	/* === Hook === */
	foreach (cot_getextplugins('board.profile.tags') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t1->parse('MAIN');
	$t->assign('PROFILE_CONTENT', $t1->text('MAIN'));
}

?>