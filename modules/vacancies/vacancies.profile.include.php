<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=profile.include
 * [END_COT_EXT]
 */

/**
 * Vacancies module
 *
 * @package vacancies
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('vacancies', 'any');
cot_block($usr['auth_write']);

require_once cot_incfile('vacancies', 'module');

$profilemenu['vacancies']['title'] = $L['Vacancies'];
$profilemenu['vacancies']['url'] = cot_url('profile', 'm=vacancies');

if($m == 'all')
{
	$user_id = $usr['isadmin'] ? '1' : $usr['id'];
	
	$sql_vac_string = "SELECT f.*, u.*
		FROM $db_vacancies as f
		LEFT JOIN $db_users AS u ON u.user_id=f.vac_ownerid
		WHERE f.vac_ownerid = $user_id AND f.vac_state = 0
		ORDER BY f.vac_date DESC LIMIT 0, 2";

	$vac_set = $db->query($sql_vac_string)->fetchAll();

	$t1 = new XTemplate(cot_tplfile(array('vacancies', 'profile', 'all'), 'module'));

	foreach ($vac_set as $vacancy)
	{
		$jj++;
		$t1->assign(cot_generate_vactags($vacancy, 'LIST_ROW_', $cfg['vacancies']['truncatetext'], $usr['isadmin']));
		$t1->assign(array(
			'LIST_ROW_OWNER' => cot_build_user($vacancy['vac_ownerid'], htmlspecialchars($vacancy['user_name'])),
			'LIST_ROW_ODDEVEN' => cot_build_oddeven($jj),
			'LIST_ROW_NUM' => $jj
		));
		$t1->assign(cot_generate_usertags($vacancy, 'LIST_ROW_OWNER_'));

		$t1->parse('MAIN.LIST_ROW');
	}
	
	$t1->parse('MAIN');
	$all_text .= $t1->text('MAIN');
}
elseif($m == 'vacancies')
{
	$t1 = new XTemplate(cot_tplfile(array('vacancies', 'profile'), 'module'));

	
	$s = cot_import('s', 'G', 'ALP'); // order field name without 'vac_'
	$w = cot_import('w', 'G', 'ALP', 4); // order way (asc, desc)
	$c = cot_import('c', 'G', 'TXT'); // cat code
	$o = cot_import('ord', 'G', 'ARR'); // filter field names without 'vac_'
	$p = cot_import('p', 'G', 'ARR'); // filter values
	$maxrowsperpage = ($cfg['vacancies']['cat_' . $c]['maxrowsperpage']) ? $cfg['vacancies']['cat_' . $c]['maxrowsperpage'] : $cfg['vacancies']['cat___default']['maxrowsperpage'];
	list($pg, $d, $durl) = cot_import_pagenav('d', $maxrowsperpage); //vacancies number for vacancies list
	list($pgc, $dc, $dcurl) = cot_import_pagenav('dc', $cfg['vacancies']['maxlistsperpage']);// vacancies number for cats list

	if (empty($c))
	{
		list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('vacancies', 'any');
		cot_block($usr['auth_read']);
	}
	elseif ($c == 'unvalidated' || $c == 'saved_drafts')
	{
		list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('vacancies', 'any');
		cot_block($usr['auth_write']);
	}
	elseif (!isset($structure['vacancies'][$c]))
	{
		cot_die_message(404, TRUE);
	}
	else
	{
		list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('vacancies', $c);
		cot_block($usr['auth_read']);
	}

	/* === Hook === */
	foreach (cot_getextplugins('vacancies.profile.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$cat = &$structure['vacancies'][$c];

	if (empty($s))
	{
		$s = $cfg['vacancies']['cat_' . $c]['order'];
	}
	elseif (!$db->fieldExists($db_vacancies, "vac_$s"))
	{
		$s = 'date';
	}
	$w = empty($w) ? $cfg['vacancies']['cat_' . $c]['way'] : $w;

	$s = empty($s) ? $cfg['vacancies']['cat___default']['order'] : $s;
	$w = (empty($w) || !in_array($w, array('asc', 'desc'))) ? $cfg['vacancies']['cat___default']['way'] : $w;

	$cfg['vacancies']['maxrowsperpage'] = (empty($c) || $c == 'unvalidated' || $c == 'saved_drafts') ?
		$cfg['vacancies']['cat___default']['maxrowsperpage'] :
		$cfg['vacancies']['cat_' . $c]['maxrowsperpage'];
	$cfg['vacancies']['maxrowsperpage'] = $cfg['vacancies']['maxrowsperpage'] > 0 ? $cfg['vacancies']['maxrowsperpage'] : 1;

	$cfg['vacancies']['truncatefirmtext'] = (empty($c) || $c == 'unvalidated' || $c == 'saved_drafts') ?
		$cfg['vacancies']['cat___default']['truncatefirmtext'] :
		$cfg['vacancies']['cat_' . $c]['truncatefirmtext'];

	$where = array();
	$params = array();

	$where['ownerid'] = "vac_ownerid=".$urr['user_id'];
	//$where['state'] = "vac_state=0";
	
	if(empty($c))
	{
		$cat['title'] = $L['Firms'];
		$cat['desc'] = '';
	}
	elseif ($c == 'unvalidated')
	{
		$cat['tpl'] = 'unvalidated';
		$where['state'] = 'vac_state = 1';
		$where['ownerid'] = $usr['isadmin'] ? '1' : 'vac_ownerid = ' . $usr['id'];
		$cat['title'] = $L['vac_validation'];
		$cat['desc'] = $L['vac_validation_desc'];
		$s = 'date';
		$w = 'desc';
	}
	elseif ($c == 'saved_drafts')
	{
		$cat['tpl'] = 'unvalidated';
		$where['state'] = 'vac_state = 2';
		$where['ownerid'] = $usr['isadmin'] ? '1' : 'vac_ownerid = ' . $usr['id'];
		$cat['title'] = $L['vac_drafts'];
		$cat['desc'] = $L['vac_drafts_desc'];
		$s = 'date';
		$w = 'desc';
	}
	else
	{
		$catsub = cot_structure_children('vacancies', $c);
		$where['cat'] = "vac_cat IN ('".implode("','", $catsub)."')";
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
			if ($key && $val && $db->fieldExists($db_vacancies, "vac_$key"))
			{
				$params[$key] = $val;
				$where['filter'][] = "vac_$key = :$key";
			}
		}
		empty($where['filter']) || $where['filter'] = implode(' AND ', $where['filter']);
	}

	$orderby = "vac_$s $w";

	$list_url_path = array('m' => 'vacancies', 'c' => $c, 'ord' => $o, 'p' => $p);
	
	if ($s != $cfg['vacancies']['cat_' . $c]['order'])
	{
		$list_url_path['s'] = $s;
	}
	if ($w != $cfg['vacancies']['cat_' . $c]['way'])
	{
		$list_url_path['w'] = $w;
	}
	$list_url = cot_url('profile', $list_url_path);

	// Building the canonical URL
	$vacanciesurl_params = array('c' => $c, 'ord' => $o, 'p' => $p);
	if ($durl > 1)
	{
		$vacanciesurl_params['d'] = $durl;
	}
	if ($dcurl > 1)
	{
		$vacanciesurl_params['dc'] = $dcurl;
	}

	/* === Hook === */
	foreach (cot_getextplugins('vacancies.profile.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if(empty($sql_vac_string))
	{
		$where = array_filter($where);
		$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
		$sql_vac_count = "SELECT COUNT(*) FROM $db_vacancies as f $join_condition $where";
		$sql_vac_string = "SELECT f.*, u.* $join_columns
			FROM $db_vacancies as f $join_condition
			LEFT JOIN $db_users AS u ON u.user_id=f.vac_ownerid
			$where
			ORDER BY $orderby LIMIT $d, ".$cfg['vacancies']['maxrowsperpage'];
	}
	$totallines = $db->query($sql_vac_count, $params)->fetchColumn();
	$sqllist = $db->query($sql_vac_string, $params);

	if ((!$cfg['easypagenav'] && $durl > 0 && $cfg['vacancies']['maxrowsperpage'] > 0 && $durl % $cfg['vacancies']['maxrowsperpage'] > 0)
		|| ($d > 0 && $d >= $totallines))
	{
		cot_redirect(cot_url('profile', $list_url_path + array('dc' => $dcurl)));
	}

	$pagenav = cot_pagenav('profile', $list_url_path + array('dc' => $dcurl), $d, $totallines, $cfg['vacancies']['maxrowsperpage']);


	$t->assign(array(
		'LIST_TOP_PAGINATION' => $pagenav['main'],
		'LIST_TOP_PAGEPREV' => $pagenav['prev'],
		'LIST_TOP_PAGENEXT' => $pagenav['next'],
		'LIST_TOP_CURRENTPAGE' => $pagenav['current'],
		'LIST_TOP_TOTALLINES' => $totallines,
		'LIST_TOP_MAXPERPAGE' => $cfg['vacancies']['maxrowsperpage'],
		'LIST_TOP_TOTALPAGES' => $pagenav['total']
	));

	if ($usr['auth_write'])
	{
		$t1->assign(array(
			'LIST_SUBMITNEWVAC' => cot_rc('vac_submitnewvac', array('sub_url' => cot_url('vacancies', 'm=add'))),
			'LIST_SUBMITNEWVAC_URL' => cot_url('vacancies', 'm=add')
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
	foreach ($cot_extrafields[$db_vacancies] + array('title' => 'title', 'key' => 'key', 'date' => 'date', 'owner' => 'owner', 'count' => 'count') as $row_k => $row_p)
	{
		$uname = strtoupper($row_k);
		$url_asc = cot_url('vacancies',  array('s' => $row_k, 'w' => 'asc') + $list_url_path);
		$url_desc = cot_url('vacancies', array('s' => $row_k, 'w' => 'desc') + $list_url_path);
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
			$extratitle = isset($L['vac_'.$row_k.'_title']) ?	$L['vac_'.$row_k.'_title'] : $row_p['field_description'];
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

	$pagenav_cat = cot_pagenav('profile', $list_url_path + array('d' => $durl), $dc, count($allsub), $cfg['vacancies']['maxlistsperpage'], 'dc');

	$t1->assign(array(
		'LISTCAT_PAGEPREV' => $pagenav_cat['prev'],
		'LISTCAT_PAGENEXT' => $pagenav_cat['next'],
		'LISTCAT_PAGNAV' => $pagenav_cat['main']
	));

	$jj = 0;
	/* === Hook - Part1 : Set === */
	$extp = cot_getextplugins('vacancies.profile.loop');
	/* ===== */
	$sqllist_rowset = $sqllist->fetchAll();

	$sqllist_rowset_other = false;
	/* === Hook === */
	foreach (cot_getextplugins('vacancies.profile.before_loop') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if(!$sqllist_rowset_other)
	{
		foreach ($sqllist_rowset as $vac)
		{
			$jj++;
			$t1->assign(cot_generate_vactags($vac, 'LIST_ROW_', $cfg['vacancies']['truncatetext'], $usr['isadmin']));
			$t1->assign(array(
				'LIST_ROW_OWNER' => cot_build_user($vac['vac_ownerid'], htmlspecialchars($vac['user_name'])),
				'LIST_ROW_ODDEVEN' => cot_build_oddeven($jj),
				'LIST_ROW_NUM' => $jj
			));
			$t1->assign(cot_generate_usertags($vac, 'LIST_ROW_OWNER_'));

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
	foreach (cot_getextplugins('vacancies.profile.tags') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t1->parse('MAIN');
	$t->assign('PROFILE_CONTENT', $t1->text('MAIN'));
}

?>