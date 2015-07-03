<?php

defined('COT_CODE') or die('Wrong URL.');

function cot_map_buildpath($cat, $firmslink = true)
{
	global $structure, $cfg, $L;
	$tmp = array();
	if ($firmslink)
	{
		$tmp[] = array(cot_url('map'), $L['map']);
	}
	if(!empty($cat) && $cat != 'all')
	{	
		$pathcodes = explode('.', $structure['firms'][$cat]['path']);
		foreach ($pathcodes as $k => $x)
		{
			$tmp[] = array(cot_url('map', 'c=' . $x), $structure['firms'][$x]['title']);
		}
	}
	return $tmp;
}

function cot_generate_marktags($mark_data, $tag_prefix = ''){
	global $db,$cot_plugins_active;

	if (!is_array($mark_data))
	{
		$sql = $db->query("SELECT * FROM $db_placemarks WHERE mark_id = '" . (int)$mark_data . "' LIMIT 1");
		$mark_data = $sql->fetch();
	}

	if($cot_plugins_active['autoalias2'] && isset($mark_data['firm_alias']) && !empty($mark_data['firm_alias'])){
		$firmlink = cot_url('firms', 'c=' . $mark_data['firm_cat'] . '&al='.$mark_data['firm_alias']);
	} else {
		$firmlink = cot_url('firms', 'c=' . $mark_data['firm_cat'] . '&id='.$mark_data['firm_id']);
	}

	$desc = strip_tags($mark_data['firm_desc']);
	$desc = trim($desc);

	$temp_array = array(
		'ID' => $mark_data['mark_id'],
		'AREA' => $mark_data['mark_area'],
		'CODE' => $mark_data['mark_code'],
		'COORD' => $mark_data['mark_coord'],
		'TITLE' => $mark_data['firm_title'],
		'DESC' => $desc,
	    'URL' => $firmlink,
	);

	$return_array = array();
	if(is_array($temp_array))
	{
		foreach ($temp_array as $key => $val)
		{
			$return_array[$tag_prefix . $key] = $val;
		}
	}
	return $return_array;
}

function cot_map_getmarks ($area, $parentcat, $action = 'placemarks')
{
	global $L, $cfg, $db, $db_x, $db_placemarks,$cot_plugins_active;
	$db_firms 		= $db_x . 'firms';
	$db_placemarks 	= $db_x . 'placemarks';

	$cats = cot_structure_children($area, $parentcat);
	$t1 = new XTemplate(cot_tplfile(array('map', $action, $area), 'plug'));
	foreach ($cats as $cat) {
		$query_select = "SELECT placemarks.mark_id, placemarks.mark_area, placemarks.mark_code, placemarks.mark_coord, placemarks.mark_zoom,firms.firm_cat, firms.firm_desc, firms.firm_title";
		if($cot_plugins_active['autoalias2']){
			$query_select .= ', firms.firm_alias';
		} else {
			$query_select .= ', firms.firm_id';
		}

		$placemarks = $db->query("$query_select
			FROM $db_placemarks AS placemarks
			LEFT JOIN $db_firms AS firms ON firms.firm_id=placemarks.mark_code
			WHERE mark_area='".$db->prep($area)."' AND firms.firm_cat='".$db->prep($cat)."'")->fetchAll();

		foreach ($placemarks as $firmmark) {
			$t1->assign(cot_generate_marktags($firmmark, 'MARK_'));
			$t1->parse('MAIN.MARKS');
		}		
	}

	$center_map = $db->query("SELECT * FROM $db_placemarks WHERE mark_area = 'map' LIMIT 1")->fetch();
	$t1->assign(array(
		'MARK_CENTERCOORD' => $center_map['mark_coord'],
		'MARK_CENTERZOOM' => $center_map['mark_zoom'],
	));

	$t1->parse('MAIN');

	return $t1->text('MAIN');
}

function cot_generate_maptags($firm_data, $tag_prefix = '', $textlength = 0, $admin_rights = null, $firmspath_home = false, $emptytitle = '')
{
	global $db, $cot_extrafields, $cfg, $L, $Ls, $R, $db_firms, $usr, $sys, $cot_yesno, $structure, $db_structure;

	static $extp_first = null, $extp_main = null;
	static $pag_auth = array();

	if (is_null($extp_first))
	{
		$extp_first = cot_getextplugins('maptags.first');
		$extp_main = cot_getextplugins('maptags.main');
	}

	/* === Hook === */
	foreach ($extp_first as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!is_array($firm_data))
	{
		$sql = $db->query("SELECT * FROM $db_firms WHERE firm_id = '" . (int) $firm_data . "' LIMIT 1");
		$firm_data = $sql->fetch();
	}

	if ($firm_data['firm_id'] > 0 && !empty($firm_data['firm_title']))
	{
		if (is_null($admin_rights))
		{
			if (!isset($pag_auth[$firm_data['firm_cat']]))
			{
				$pag_auth[$firm_data['firm_cat']] = cot_auth('firms', $firm_data['firm_cat'], 'RWA1');
			}
			$admin_rights = (bool) $pag_auth[$firm_data['firm_cat']][2];
		}
		$firmspath = cot_map_buildpath($firm_data['firm_cat']);
		$catpath = cot_breadcrumbs($firmspath, $firmspath_home);
		$firm_data['firm_firmsurl'] = (empty($firm_data['firm_alias'])) ? cot_url('firms', 'c='.$firm_data['firm_cat'].'&id='.$firm_data['firm_id']) : cot_url('firms', 'c='.$firm_data['firm_cat'].'&al='.$firm_data['firm_alias']);
		$firm_link[] = array($firm_data['firm_firmsurl'], $firm_data['firm_title']);
		$firm_data['firm_fulltitle'] = cot_breadcrumbs(array_merge($firmspath, $firm_link), $firmspath_home);
		if (!empty($firm_data['firm_url']) && $firm_data['firm_file'])
		{
			$dotpos = mb_strrpos($firm_data['firm_url'], ".") + 1;
			$type = mb_strtolower(mb_substr($firm_data['firm_url'], $dotpos, 5));
			$firm_data['firm_fileicon'] = cot_rc('firm_icon_file_path', array('type' => $type));
			if (!file_exists($firm_data['firm_fileicon']))
			{
				$firm_data['firm_fileicon'] = cot_rc('firm_icon_file_default');
			}
			$firm_data['firm_fileicon'] = cot_rc('firm_icon_file', array('icon' => $firm_data['firm_fileicon']));
		}
		else
		{
			$firm_data['firm_fileicon'] = '';
		}

		$date_format = 'datetime_medium';

		$text = cot_parse($firm_data['firm_text'], $cfg['firms']['markup'], $firm_data['firm_parser']);
		$text_cut = ((int)$textlength > 0) ? cot_string_truncate($text, $textlength) : $text;
		$cutted = (mb_strlen($text) > mb_strlen($text_cut)) ? true : false;

		$cat_url = cot_url('map', 'c=' . $firm_data['firm_cat']);
		$validate_url = cot_url('admin', "m=firms&a=validate&id={$firm_data['firm_id']}&x={$sys['xk']}");
		$unvalidate_url = cot_url('admin', "m=firms&a=unvalidate&id={$firm_data['firm_id']}&x={$sys['xk']}");
		$edit_url = cot_url('firms', "m=edit&id={$firm_data['firm_id']}");
		$delete_url = cot_url('firms', "m=edit&a=update&delete=1&id={$firm_data['firm_id']}&x={$sys['xk']}");

		$firm_data['firm_status'] = cot_firms_status($firm_data['firm_state']);

		$temp_array = array(
			'URL' => $firm_data['firm_firmsurl'],
			'ID' => $firm_data['firm_id'],
			'LOGO' => $firm_data['firm_logo'],
			'TITLE' => $firm_data['firm_fulltitle'],
			'ALIAS' => $firm_data['firm_alias'],
			'STATE' => $firm_data['firm_state'],
			'STATUS' => $firm_data['firm_status'],
			'LOCALSTATUS' => $L['firm_status_'.$firm_data['firm_status']],
			'SHORTTITLE' => htmlspecialchars($firm_data['firm_title'], ENT_COMPAT, 'UTF-8', false),
			'CAT' => $firm_data['firm_cat'],
			'CATURL' => $cat_url,
			'CATTITLE' => htmlspecialchars($structure['firms'][$firm_data['firm_cat']]['title']),
			'CATPATH' => $catpath,
			'CATPATH_SHORT' => cot_rc_link($cat_url, htmlspecialchars($structure['firms'][$firm_data['firm_cat']]['title'])),
			'CATDESC' => htmlspecialchars($structure['firms'][$firm_data['firm_cat']]['desc']),
			'CATICON' => $structure['firms'][$firm_data['firm_cat']]['icon'],
			'KEYWORDS' => htmlspecialchars($firm_data['firm_keywords']),
			'DESC' => $firm_data['firm_desc'],
			'TEXT' => $text,
			'TEXT_CUT' => $text_cut,
			'TEXT_IS_CUT' => $cutted,
			'DESC_OR_TEXT' => (!empty($firm_data['firm_desc'])) ? htmlspecialchars($firm_data['firm_desc']) : $text,
			'MORE' => ($cutted) ? cot_rc('firm_more', array('firm_url' => $firm_data['firm_firmsurl'])) : '',
			'ADDR' => htmlspecialchars($firm_data['firm_addr']),
			'PHONE' => htmlspecialchars($firm_data['firm_phone']),
			'SKYPE' => htmlspecialchars($firm_data['firm_skype']),
			'SITE' => htmlspecialchars($firm_data['firm_site']),
			'EMAIL' => htmlspecialchars($firm_data['firm_email']),
			'OWNERID' => $firm_data['firm_ownerid'],
			'OWNERNAME' => htmlspecialchars($firm_data['user_name']),
			'DATE' => cot_date($date_format, $firm_data['firm_date']),
			'UPDATED' => cot_date($date_format, $firm_data['firm_updated']),
			'DATE_STAMP' => $firm_data['firm_date'],
			'UPDATED_STAMP' => $firm_data['firm_updated'],
			'COUNT' => $firm_data['firm_count'],
			'ADMIN' => $admin_rights ? cot_rc('list_row_admin', array('unvalidate_url' => $unvalidate_url, 'edit_url' => $edit_url)) : '',
		);

		// Admin tags
		if ($admin_rights)
		{
			$validate_confirm_url = cot_confirm_url($validate_url, 'firms', 'firm_confirm_validate');
			$unvalidate_confirm_url = cot_confirm_url($unvalidate_url, 'firms', 'firm_confirm_unvalidate');
			$delete_confirm_url = cot_confirm_url($delete_url, 'firms', 'firm_confirm_delete');
			$temp_array['ADMIN_EDIT'] = cot_rc_link($edit_url, $L['Edit']);
			$temp_array['ADMIN_EDIT_URL'] = $edit_url;
			$temp_array['ADMIN_UNVALIDATE'] = $firm_data['firm_state'] == 1 ?
				cot_rc_link($validate_confirm_url, $L['Validate'], 'class="confirmLink"') :
				cot_rc_link($unvalidate_confirm_url, $L['Putinvalidationqueue'], 'class="confirmLink"');
			$temp_array['ADMIN_UNVALIDATE_URL'] = $firm_data['firm_state'] == 1 ?
				$validate_confirm_url : $unvalidate_confirm_url;
			$temp_array['ADMIN_DELETE'] = cot_rc_link($delete_confirm_url, $L['Delete'], 'class="confirmLink"');
			$temp_array['ADMIN_DELETE_URL'] = $delete_confirm_url;
		}
		else if ($usr['id'] == $firm_data['firm_ownerid'])
		{
			$temp_array['ADMIN_EDIT'] = cot_rc_link($edit_url, $L['Edit']);
			$temp_array['ADMIN_EDIT_URL'] = $edit_url;
		}

		if (cot_auth('firms', 'any', 'W'))
		{
			$clone_url = cot_url('map', "m=add&c={$firm_data['firm_cat']}&clone={$firm_data['firm_id']}");
			$temp_array['ADMIN_CLONE'] = cot_rc_link($clone_url, $L['firm_clone']);
			$temp_array['ADMIN_CLONE_URL'] = $clone_url;
		}

		// Extrafields
		if (isset($cot_extrafields[$db_firms]))
		{
			foreach ($cot_extrafields[$db_firms] as $exfld)
			{
				$tag = mb_strtoupper($exfld['field_name']);
				$temp_array[$tag.'_TITLE'] = isset($L['firm_'.$exfld['field_name'].'_title']) ?  $L['firm_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
				$temp_array[$tag] = cot_build_extrafields_data('firms', $exfld, $firm_data['firm_'.$exfld['field_name']], $firm_data['firm_parser']);
				$temp_array[$tag.'_VALUE'] = $firm_data['firm_'.$exfld['field_name']];
			}
		}

		// Extra fields for structure
		if (isset($cot_extrafields[$db_structure]))
		{
			foreach ($cot_extrafields[$db_structure] as $exfld)
			{
				$tag = mb_strtoupper($exfld['field_name']);
				$temp_array['CAT_'.$tag.'_TITLE'] = isset($L['structure_'.$exfld['field_name'].'_title']) ?  $L['structure_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
				$temp_array['CAT_'.$tag] = cot_build_extrafields_data('structure', $exfld, $structure['firms'][$firm_data['firm_cat']][$exfld['field_name']]);
				$temp_array['CAT_'.$tag.'_VALUE'] = $structure['firms'][$firm_data['firm_cat']][$exfld['field_name']];
			}
		}

		/* === Hook === */
		foreach ($extp_main as $pl)
		{
			include $pl;
		}
		/* ===== */

	}
	else
	{
		$temp_array = array(
			'TITLE' => (!empty($emptytitle)) ? $emptytitle : $L['Deleted'],
			'SHORTTITLE' => (!empty($emptytitle)) ? $emptytitle : $L['Deleted'],
		);
	}

	$return_array = array();
	foreach ($temp_array as $key => $val)
	{
		$return_array[$tag_prefix . $key] = $val;
	}

	return $return_array;
}

function cot_build_structure_map_tree($c = '', $allsublev = true, $template = '', $col = 1)
{
	global $cot_extrafields, $db_structure, $structure, $cfg, $db, $sys;

	$t1 = new XTemplate(cot_tplfile(array('map', 'tree', $template), 'plug'));

	$kk = 0;
	$allsub = (empty($c)) ? cot_structure_children('firms', '', $allsublev, false, true, false) : cot_structure_children('firms', $c, $allsublev, false, true, false);
	$subcat = array_slice($allsub, $dc, $cfg['firms']['maxlistsperpage']);

	/* === Hook - Part1 : Set === */
	$extp = cot_getextplugins('firms.tree.rowcat.loop');
	/* ===== */

	foreach ($subcat as $x)
	{
		$mtch = $structure['firms'][$x]['path'].'.';
		$mtchlen = mb_strlen($mtch);
		$mtchlvl = mb_substr_count($mtch,".");

		if(empty($c) && !$allsublev && $mtchlvl == 1 || !empty($c))
		{
			$cats[] = $x;
		}
	}
	
	$colcount = floor(count($cats)/$col) + 1;

	if(is_null($cats)){
		$parentcat = cot_structure_parents('firms', $c, 'first');
		$cats = cot_structure_children('firms', $parentcat, false, false);
	}

	if(is_array($cats)){

		foreach($cats as $cat)
		{
			$kk++;

			$cat_childs = cot_structure_children('firms', $cat);
			$sub_count = 0;
			foreach ($cat_childs as $cat_child)
			{
				$sub_count += (int)$structure['firms'][$cat_child]['count'];
			}

			$sub_url_path = $list_url_path;
			$sub_url_path['c'] = $cat;
			$t1->assign(array(
				'LIST_ROWCAT_URL' => cot_url('map', $sub_url_path),
				'LIST_ROWCAT_TITLE' => $structure['firms'][$cat]['title'],
				'LIST_ROWCAT_DESC' => $structure['firms'][$cat]['desc'],
				'LIST_ROWCAT_ICON' => $structure['firms'][$cat]['icon'],
				'LIST_ROWCAT_COUNT' => $sub_count,
				'LIST_ROWCAT_ODDEVEN' => cot_build_oddeven($kk),
				'LIST_ROWCAT_NUM' => $kk,
				'LIST_ROWCAT_ACTIVE' => $cat == $c,
				'LIST_ROWCAT_COL' => ($kk % $colcount == 0) ? 1 : 0,
			));

			// Extra fields for structure
			foreach ($cot_extrafields[$db_structure] as $exfld)
			{
				$uname = strtoupper($exfld['field_name']);
				$t1->assign(array(
					'LIST_ROWCAT_'.$uname.'_TITLE' => isset($L['structure_'.$exfld['field_name'].'_title']) ?  $L['structure_'.$exfld['field_name'].'_title'] : $exfld['field_description'],
					'LIST_ROWCAT_'.$uname => cot_build_extrafields_data('structure', $exfld, $structure['firms'][$cat][$exfld['field_name']]),
					'LIST_ROWCAT_'.$uname.'_VALUE' => $structure['firms'][$cat][$exfld['field_name']],
				));
			}

			/* === Hook - Part2 : Include === */
			foreach ($extp as $pl)
			{
				include $pl;
			}
			/* ===== */

			$t1->parse('MAIN.LIST_ROWCAT');
		}
	}
	
	$t1->parse("MAIN");
	return $t1->text("MAIN");
}

?>