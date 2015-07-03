<?php
/**
 * rezume API
 *
 * @package rezume
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

// Requirements
require_once cot_langfile('rezume', 'module');
require_once cot_incfile('rezume', 'module', 'resources');
require_once cot_incfile('forms');
require_once cot_incfile('extrafields');

// Tables and extras
cot::$db->registerTable('rezume');

cot_extrafields_register_table('rezume');

is_array(cot::$structure['rezume']) or cot::$structure['rezume'] = array();


/**
 * Generates sex dropdown
 *
 * @param string $check Checked sex
 * @param string $name Input name
 * @return string
 */
function cot_rezume_selectbox_sex($check, $name)
{
	global $L;

	$genlist = array('U', 'M', 'F');
	$titlelist = array();
	foreach ($genlist as $i)
	{
		$titlelist[] = $L['Gender_' . $i];
	}
	return cot_selectbox($check, $name, $genlist, $titlelist, false);
}


/**
 * Generates education dropdown
 *
 * @param string $check Checked edu
 * @param string $name Input name
 * @return string
 */
function cot_rezume_selectbox_edu($check, $name)
{
	global $L, $cot_educations;

	$titlelist = array();
	foreach ($cot_educations as $i => $val)
	{
		$valuelist[] = $i;
		$titlelist[] = $val;
	}
	return cot_selectbox($check, $name, $valuelist, $titlelist, true);
}


function cot_build_structure_rezume_tree($c = '', $sub_cat = true, $allsublev = true, $custom_tpl = '', $col = 'all')
{
	global $cot_extrafields, $db_structure, $structure, $cfg, $db, $db_x,$sys;
	$t1 = new XTemplate(cot_tplfile(array('rezume', 'tree', $custom_tpl), 'module'));
	
	$kk = 0;
	if(!$sub_cat){
	  $c = '';
	 }
	$allsub = (empty($c)) ? cot_structure_children('rezume', '', $allsublev, false, true, false) : cot_structure_children('rezume', $c, $allsublev, false, true, false);
	$subcat = array_slice($allsub, $dc, $cfg['rezume']['maxlistsperpage']);

	/* === Hook - Part1 : Set === */
	$extp = cot_getextplugins('rezume.tree.rowcat.loop');
	/* ===== */

	if($col === 'all'){
		$new_col = count($cats);
	}else{
		$new_col = $col;
	}
	foreach ($subcat as $x)
	{	
		$query = $db->query("SELECT mav_code AS id FROM $db_x"."mavatars WHERE mav_extension = 'structure' AND mav_category = '".$x."'");
		$mav_code = $query->fetch();
		  	if($mav_code){

		  		$mavatar = new mavatar('structure', $x, $mav_code['id']);
		  		$mavatars_tags = $mavatar->generate_mavatars_tags();
		  		
		  		$t1->assign(array(
			  	'LIST_ROWCAT_MAVATAR'		=> $mavatars_tags,
			  	'LIST_ROWCAT_MAVATARCOUNT'	=> count($mavatars_tags),
			  	'LIST_ROWCAT_CATEGORY_AVATAR' => $x
			  ));

		  	}

		$kk++;
		
		$mtch = $structure['rezume'][$x]['path'].'.';
		$mtchlen = mb_strlen($mtch);
		$mtchlvl = mb_substr_count($mtch,".");

		if(empty($c) && !$allsublev && $mtchlvl == 1 || !empty($c))
		{
			$cat_childs = cot_structure_children('rezume', $x);
			$sub_count = 0;
			foreach ($cat_childs as $cat_child)
			{
				$sub_count += (int)$structure['rezume'][$cat_child]['count'];
			}

			$sub_url_path = $list_url_path;
			$sub_url_path['c'] = $x;
			$t1->assign(array(
				'LIST_ROWCAT_URL' => cot_url('rezume', $sub_url_path),
				'LIST_ROWCAT_TITLE' => $structure['rezume'][$x]['title'],
				'LIST_ROWCAT_DESC' => $structure['rezume'][$x]['desc'],
				'LIST_ROWCAT_ICON' => $structure['rezume'][$x]['icon'],
				'LIST_ROWCAT_COUNT' => $sub_count,
				'LIST_ROWCAT_ODDEVEN' => cot_build_oddeven($kk),
				'LIST_ROWCAT_NUM' => $kk,
				'LIST_ROWCAT_COUNT_VIEW' =>$new_col,
				'LIST_ROWCAT_CATEGORY' => $x
			));

			// Extra fields for structure
			foreach ($cot_extrafields[$db_structure] as $exfld)
			{
				$uname = strtoupper($exfld['field_name']);
				$t1->assign(array(
					'LIST_ROWCAT_'.$uname.'_TITLE' => isset($L['structure_'.$exfld['field_name'].'_title']) ?  $L['structure_'.$exfld['field_name'].'_title'] : $exfld['field_description'],
					'LIST_ROWCAT_'.$uname => cot_build_extrafields_data('structure', $exfld, $structure['rezume'][$x][$exfld['field_name']]),
					'LIST_ROWCAT_'.$uname.'_VALUE' => $structure['rezume'][$x][$exfld['field_name']],
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
		
		$t1->assign(array(
			'CATSCOUNT' => $kk,
		));
	}
	$t1->parse("MAIN");
	return $t1->text("MAIN");
}


/**
 * Builds rezume category path
 *
 * @param string $cat Category code
 * @param bool $rezumelink Include rezumes main link
 * @return array
 * @see cot_breadcrumbs()
 */
function cot_rezume_buildpath($cat, $rezumelink = true)
{
	global $structure, $cfg, $L;
	$tmp = array();
	if ($rezumelink)
	{
		$tmp[] = array(cot_url('rezume'), $L['Rezume']);
	}
	if(!empty($cat) && $cat != 'all')
	{	
		$pathcodes = explode('.', $structure['rezume'][$cat]['path']);
		foreach ($pathcodes as $k => $x)
		{
			$tmp[] = array(cot_url('rezume', 'c=' . $x), $structure['rezume'][$x]['title']);
		}
	}
	return $tmp;
}


/**
 * Returns all rez tags for coTemplate
 *
 * @param mixed $rez_data Adv Info Array or ID
 * @param string $tag_prefix Prefix for tags
 * @param bool $admin_rights Adv Admin Rights
 * @param bool $rezumepath_home Add home link for rezume path
 * @param string $emptytitle rezume title desc if rezume does not exist
 * @return array
 * @global CotDB $db
 */
function cot_generate_reztags($rez_data, $tag_prefix = '', $admin_rights = null, $rezumepath_home = false, $emptytitle = '')
{
	global $db, $cot_extrafields, $cfg, $L, $Ls, $R, $db_rezume, $usr, $sys, $cot_yesno, $structure, $db_structure, $cot_educations;

	static $extp_first = null, $extp_main = null;
	static $pag_auth = array();

	if (is_null($extp_first))
	{
		$extp_first = cot_getextplugins('rezumetags.first');
		$extp_main = cot_getextplugins('rezumetags.main');
	}

	/* === Hook === */
	foreach ($extp_first as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!is_array($rez_data))
	{
		$sql = $db->query("SELECT * FROM $db_rezume WHERE rez_id = '" . (int) $rez_data . "' LIMIT 1");
		$rez_data = $sql->fetch();
	}

	if ($rez_data['rez_id'] > 0 && !empty($rez_data['rez_title']))
	{
		if (is_null($admin_rights))
		{
			if (!isset($pag_auth[$rez_data['rez_cat']]))
			{
				$pag_auth[$rez_data['rez_cat']] = cot_auth('rezume', $rez_data['rez_cat'], 'RWA1');
			}
			$admin_rights = (bool) $pag_auth[$rez_data['rez_cat']][2];
		}
		$rezumepath = cot_rezume_buildpath($rez_data['rez_cat']);
		$catpath = cot_breadcrumbs($rezumepath, $rezumepath_home);
		$rez_data['rez_pageurl'] = (empty($rez_data['rez_alias'])) ? cot_url('rezume', 'c='.$rez_data['rez_cat'].'&id='.$rez_data['rez_id']) : cot_url('rezume', 'c='.$rez_data['rez_cat'].'&al='.$rez_data['rez_alias']);
		$rez_link[] = array($rez_data['rez_pageurl'], $rez_data['rez_title']);
		$rez_data['rez_fulltitle'] = cot_breadcrumbs(array_merge($rezumepath, $rez_link), $rezumepath_home);

		$date_format = 'datetime_medium';

		$cat_url = cot_url('rezume', 'c=' . $rez_data['rez_cat']);
		$validate_url = cot_url('admin', "m=rezume&a=validate&id={$rez_data['rez_id']}&x={$sys['xk']}");
		$unvalidate_url = cot_url('admin', "m=rezume&a=unvalidate&id={$rez_data['rez_id']}&x={$sys['xk']}");
		$edit_url = cot_url('rezume', "m=edit&id={$rez_data['rez_id']}");
		$delete_url = cot_url('rezume', "m=edit&a=update&delete=1&id={$rez_data['rez_id']}&x={$sys['xk']}");

		$rez_data['rez_status'] = cot_rezume_status(
			$rez_data['rez_state'],
			$rez_data['rez_expire']
		);
		
		$mavatar = new mavatar('rezume',$rez_data['rez_cat'], $rez_data['rez_id']);
		$mavatars_tags = $mavatar->generate_mavatars_tags();

		$temp_array = array(
			'URL' => $rez_data['rez_pageurl'],
			'ID' => $rez_data['rez_id'],
			'TITLE' => $rez_data['rez_fulltitle'],
			'ALIAS' => $rez_data['rez_alias'],
			'STATE' => $rez_data['rez_state'],
			'STATUS' => $rez_data['rez_status'],
			'LOCALSTATUS' => $L['rez_status_'.$rez_data['rez_status']],
			'SHORTTITLE' => htmlspecialchars($rez_data['rez_title'], ENT_COMPAT, 'UTF-8', false),
			'CAT' => $rez_data['rez_cat'],
			'CATURL' => $cat_url,
			'CATTITLE' => htmlspecialchars($structure['rezume'][$rez_data['rez_cat']]['title']),
			'CATPATH' => $catpath,
			'CATPATH_SHORT' => cot_rc_link($cat_url, htmlspecialchars($structure['rezume'][$rez_data['rez_cat']]['title'])),
			'CATDESC' => htmlspecialchars($structure['rezume'][$rez_data['rez_cat']]['desc']),
			'CATICON' => $structure['rezume'][$rez_data['rez_cat']]['icon'],
			'KEYWORDS' => htmlspecialchars($rez_data['rez_keywords']),
			'QUA' => cot_parse($rez_data['rez_qua']),
			'ICON' => $mavatars_tags,
			'EDU' => $cot_educations[$rez_data['rez_edu']],
			'STUDY' => cot_parse($rez_data['rez_study']),
			'SALARY' => $rez_data['rez_salary'],
			'EXP' => $rez_data['rez_exp'],
			'WORKS' => cot_parse($rez_data['rez_works']),
			'AGE' => $rez_data['rez_age'],
			'SEX' => ($rez_data['rez_sex'] == '' || $rez_data['rez_sex'] == 'U') ? '' : $L['Gender_' . $rez_data['rez_sex']],
			'FIO' => htmlspecialchars($rez_data['rez_fio']),
			'ADDR' => htmlspecialchars($rez_data['rez_addr']),
			'PHONE' => htmlspecialchars($rez_data['rez_phone']),
			'SKYPE' => htmlspecialchars($rez_data['rez_skype']),
			'SITE' => htmlspecialchars($rez_data['rez_site']),
			'EMAIL' => htmlspecialchars($rez_data['rez_email']),
			'OWNERID' => $rez_data['rez_ownerid'],
			'OWNERNAME' => htmlspecialchars($rez_data['user_name']),
			'DATE' => cot_date($date_format, $rez_data['rez_date']),
			'UPDATED' => cot_date($date_format, $rez_data['rez_updated']),
			'EXPIRE' => cot_date($date_format, $rez_data['rez_expire']),
			'DATE_STAMP' => $rez_data['rez_date'],
			'UPDATED_STAMP' => $rez_data['rez_updated'],
			'COUNT' => $rez_data['rez_count'],
			'ADMIN' => $admin_rights ? cot_rc('list_row_admin', array('unvalidate_url' => $unvalidate_url, 'edit_url' => $edit_url)) : '',
		);

		// Admin tags
		if ($admin_rights)
		{
			$validate_confirm_url = cot_confirm_url($validate_url, 'rezume', 'rez_confirm_validate');
			$unvalidate_confirm_url = cot_confirm_url($unvalidate_url, 'rezume', 'rez_confirm_unvalidate');
			$delete_confirm_url = cot_confirm_url($delete_url, 'rezume', 'rez_confirm_delete');
			$temp_array['ADMIN_EDIT'] = cot_rc_link($edit_url, $L['Edit']);
			$temp_array['ADMIN_EDIT_URL'] = $edit_url;
			$temp_array['ADMIN_UNVALIDATE'] = $rez_data['rez_state'] == 1 ?
				cot_rc_link($validate_confirm_url, $L['Validate'], 'class="confirmLink"') :
				cot_rc_link($unvalidate_confirm_url, $L['Putinvalidationqueue'], 'class="confirmLink"');
			$temp_array['ADMIN_UNVALIDATE_URL'] = $rez_data['rez_state'] == 1 ?
				$validate_confirm_url : $unvalidate_confirm_url;
			$temp_array['ADMIN_DELETE'] = cot_rc_link($delete_confirm_url, $L['Delete'], 'class="confirmLink"');
			$temp_array['ADMIN_DELETE_URL'] = $delete_confirm_url;
		}
		else if ($usr['id'] == $rez_data['rez_ownerid'])
		{
			$temp_array['ADMIN_EDIT'] = cot_rc_link($edit_url, $L['Edit']);
			$temp_array['ADMIN_EDIT_URL'] = $edit_url;
		}

		if (cot_auth('rezume', 'any', 'W'))
		{
			$clone_url = cot_url('rezume', "m=add&c={$rez_data['rez_cat']}&clone={$rez_data['rez_id']}");
			$temp_array['ADMIN_CLONE'] = cot_rc_link($clone_url, $L['rez_clone']);
			$temp_array['ADMIN_CLONE_URL'] = $clone_url;
		}

		// Extrafields
		if (isset($cot_extrafields[$db_rezume]))
		{
			foreach ($cot_extrafields[$db_rezume] as $exfld)
			{
				$tag = mb_strtoupper($exfld['field_name']);
				$temp_array[$tag.'_TITLE'] = isset($L['rez_'.$exfld['field_name'].'_title']) ?  $L['rez_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
				$temp_array[$tag] = cot_build_extrafields_data('rezume', $exfld, $rez_data['rez_'.$exfld['field_name']], $rez_data['rez_parser']);
				$temp_array[$tag.'_VALUE'] = $rez_data['rez_'.$exfld['field_name']];
			}
		}

		// Extra fields for structure
		if (isset($cot_extrafields[$db_structure]))
		{
			foreach ($cot_extrafields[$db_structure] as $exfld)
			{
				$tag = mb_strtoupper($exfld['field_name']);
				$temp_array['CAT_'.$tag.'_TITLE'] = isset($L['structure_'.$exfld['field_name'].'_title']) ?  $L['structure_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
				$temp_array['CAT_'.$tag] = cot_build_extrafields_data('structure', $exfld, $structure['rezume'][$rez_data['rez_cat']][$exfld['field_name']]);
				$temp_array['CAT_'.$tag.'_VALUE'] = $structure['rezume'][$rez_data['rez_cat']][$exfld['field_name']];
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

/**
 * Returns possible values for category sorting order
 */
function cot_rezume_config_order()
{
	global $cot_extrafields, $L, $db_rezume;

	$options_sort = array(
		'id' => $L['Id'],
		'key' => $L['Key'],
		'title' => $L['Title'],
		'ownerid' => $L['Owner'],
		'date' => $L['Date'],
		'salary' => $L['rez_salary'],
		'edu' => $L['rez_edu'],
		'sex' => $L['rez_sex'],
		'expire' => $L['Expire']
	);

	foreach($cot_extrafields[$db_rezume] as $exfld)
	{
		$options_sort[$exfld['field_name']] = isset($L['rez_'.$exfld['field_name'].'_title']) ? $L['rez_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
	}

	$L['cfg_order_params'] = array_values($options_sort);
	return array_keys($options_sort);
}

/**
 * Determines rezume status
 *
 * @param int $rez_state
 * @return string 'draft', 'pending', 'published'
 */
function cot_rezume_status($rez_state, $rez_expire)
{
	global $sys;

	if ($rez_state == 0)
	{
		if ($rez_expire > 0 && $rez_expire <= $sys['now'])
		{
			return 'expired';
		}
		return 'published';
	}
	elseif ($rez_state == 2)
	{
		return 'draft';
	}
	return 'pending';
}

/**
 * Recalculates rezume category counters
 *
 * @param string $cat Cat code
 * @return int
 * @global CotDB $db
 */
function cot_rezume_sync($cat)
{
	global $db, $db_structure, $db_rezume, $cache;
	
	$parent = cot_structure_parents('rezume', $cat, 'first');
	$cats = cot_structure_children('rezume', $parent, true, true);
	foreach($cats as $c)
	{
		$subcats = cot_structure_children('rezume', $c, true, true);
		$count = $db->query("SELECT COUNT(*) FROM $db_rezume WHERE rez_cat IN ('".implode("','", $subcats)."') AND rez_state = 0")->fetchColumn();		
		$db->query("UPDATE $db_structure SET structure_count=".(int)$count." WHERE structure_area='rezume' AND structure_code = ?", $c);
		$summcount += $count;
		if($cat == $c) $catcount = $count;
	}
	$cache && $cache->db->remove('structure', 'system');
	
	return $catcount;
}

/**
 * Update rezume category code
 *
 * @param string $oldcat Old Cat code
 * @param string $newcat New Cat code
 * @return bool
 * @global CotDB $db
 */
function cot_rezume_updatecat($oldcat, $newcat)
{
	global $db, $db_structure, $db_rezume;
	return (bool) $db->update($db_rezume, array("rez_cat" => $newcat), "rez_cat='".$db->prep($oldcat)."'");
}

/**
 * Returns permissions for a rezume category.
 * @param  string $cat Category code
 * @return array       Permissions array with keys: 'auth_read', 'auth_write', 'isadmin', 'auth_download'
 */
function cot_rezume_auth($cat = null)
{
	if (empty($cat))
	{
		$cat = 'any';
	}
	$auth = array();
	list($auth['auth_read'], $auth['auth_write'], $auth['isadmin'], $auth['auth_download']) = cot_auth('rezume', $cat, 'RWA1');
	return $auth;
}

/**
 * Imports rezume data from request parameters.
 * @param  string $source Source request method for parameters
 * @param  array  $rrez  Existing rezume data from database
 * @param  array  $auth   Permissions array
 * @return array          Adv data
 */
function cot_rezume_import($source = 'POST', $rrez = array(), $auth = array())
{
	global $cfg, $db_rezume, $cot_extrafields, $usr, $sys;

	if (count($auth) == 0)
	{
		$auth = cot_rezume_auth($rrez['rez_cat']);
	}

	if ($source == 'D' || $source == 'DIRECT')
	{
		// A trick so we don't have to affect every line below
		global $_PATCH;
		$_PATCH = $rrez;
		$source = 'PATCH';
	}

	$rrez['rez_cat']      = cot_import('rrezcat', $source, 'TXT');
	$rrez['rez_keywords'] = cot_import('rrezkeywords', $source, 'TXT');
	$rrez['rez_alias']    = cot_import('rrezalias', $source, 'TXT');
	$rrez['rez_title']    = cot_import('rreztitle', $source, 'TXT');
	
	$rrez['rez_salary'] = cot_import('rrezsalary', $source, 'INT');
	
	$rrez['rez_age'] = cot_import('rrezage', $source, 'INT');
	
	$rrez['rez_exp']		= cot_import('rrezexp', $source, 'INT');
	$rrez['rez_works']	= cot_import('rrezworks', $source, 'HTM');
	
	$rrez['rez_edu']    = cot_import('rrezedu', $source, 'TXT');
	$rrez['rez_study']    = cot_import('rrezstudy', $source, 'HTM');
	
	$rrez['rez_qua']    = cot_import('rrezqua', $source, 'HTM');
	
	$rrez['rez_sex']    = cot_import('rrezsex', $source, 'ALP');
	
	$rrez['rez_fio']    = cot_import('rrezfio', $source, 'TXT');
	$rrez['rez_addr']    = cot_import('rrezaddr', $source, 'TXT');
	$rrez['rez_phone']    = cot_import('rrezphone', $source, 'TXT');
	$rrez['rez_skype']    = cot_import('rrezskype', $source, 'TXT');
	$rrez['rez_site']    = cot_import('rrezsite', $source, 'TXT');
	$rrez['rez_email']    = cot_import('rrezemail', $source, 'TXT');
	
	$rrezdatenow           = cot_import('rrezdatenow', $source, 'BOL');
	$rrez['rez_date']     = cot_import_date('rrezdate', true, false, $source);
	$rrez['rez_date']     = ($rrezdatenow || is_null($rrez['rez_date'])) ? $sys['now'] : (int)$rrez['rez_date'];
	$rrez['rez_updated']  = $sys['now'];
	$rrez['rez_expire']   = (int)cot_import_date('rrezxpire');
	$rrez['rez_expire']   = ($rrez['rez_expire'] <= $rrez['rez_begin']) ? 0 : $rrez['rez_expire'];
	
	$rrez['rez_keywords'] = cot_import('rrezkeywords', $source, 'TXT');
	$rrez['rez_metatitle'] = cot_import('rrezmetatitle', $source, 'TXT');
	$rrez['rez_metadesc'] = cot_import('rrezmetadesc', $source, 'TXT');

	$rpublish               = cot_import('rpublish', $source, 'ALP'); // For backwards compatibility
	$rrez['rez_state']    = ($rpublish == 'OK') ? 0 : cot_import('rreztate', $source, 'INT');

	if ($auth['isadmin'] && isset($rrez['rez_ownerid']))
	{
		$rrez['rez_count']     = cot_import('rrezcount', $source, 'INT');
		$rrez['rez_ownerid']   = cot_import('rrezownerid', $source, 'INT');
	}
	else
	{
		$rrez['rez_ownerid'] = $usr['id'];
	}

	// Extra fields
	foreach ($cot_extrafields[$db_rezume] as $exfld)
	{
		$rrez['rez_'.$exfld['field_name']] = cot_import_extrafields('rrez'.$exfld['field_name'], $exfld, $source, $rrez['rez_'.$exfld['field_name']]);
	}

	return $rrez;
}

/**
 * Validates rezume data.
 * @param  array   $rrez Imported rezume data
 * @return boolean        TRUE if validation is passed or FALSE if errors were found
 */
function cot_rezume_validate($rrez)
{
	global $cfg, $structure;
	
	cot_check(empty($rrez['rez_cat']), 'rez_catmissing', 'rrezcat');
	if ($structure['rezume'][$rrez['rez_cat']]['locked'])
	{
		global $L;
		require_once cot_langfile('message', 'core');
		cot_error('msg602_body', 'rrezcat');
	}
	cot_check(mb_strlen($rrez['rez_title']) < 2, 'rez_titletooshort', 'rreztitle');

	cot_check(!empty($rrez['rez_alias']) && preg_match('`[+/?%#&]`', $rrez['rez_alias']), 'rez_aliascharacters', 'rrezalias');
	
	cot_check(empty($rrez['rez_qua']), 'rez_error_quamissing', 'rrezqua');
	
	cot_check(empty($rrez['rez_salary']), 'rez_error_salarymissing', 'rrezsalary');
	
	cot_check(empty($rrez['rez_exp']), 'rez_error_expmissing', 'rrezexp');
	cot_check(empty($rrez['rez_works']), 'rez_error_worksmissing', 'rrezworks');
	
	cot_check(empty($rrez['rez_study']), 'rez_error_studymissing', 'rrezstudy');
	
	cot_check(empty($rrez['rez_age']), 'rez_error_agemissing', 'rrezage');
	
	cot_check(empty($rrez['rez_age']), 'rez_error_fiomissing', 'rrezage');
	
	return !cot_error_found();
}

/**
 * Adds a new rezume to the CMS.
 * @param  array   $rrez Adv data
 * @param  array   $auth  Permissions array
 * @return integer        New rezume ID or FALSE on error
 */
function cot_rezume_add(&$rrez, $auth = array())
{
	global $cache, $cfg, $db, $db_rezume, $db_structure, $structure, $L;
	if (cot_error_found())
	{
		return false;
	}

	if (count($auth) == 0)
	{
		$auth = cot_rezume_auth($rrez['rez_cat']);
	}

	if (!empty($rrez['rez_alias']))
	{
		$rez_count = $db->query("SELECT COUNT(*) FROM $db_rezume WHERE rez_alias = ? AND rez_cat = ?", array($rrez['rez_alias'],$rrez['rez_cat']))->fetchColumn();
		if ($rez_count > 0)
		{
			$rrez['rez_alias'] = $rrez['rez_alias'].rand(1000, 9999);
		}
	}

	if ($rrez['rez_state'] == 0)
	{
		if ($auth['isadmin'] && $cfg['rezume']['autovalidaterez'])
		{
			$db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_area='rezume' AND structure_code = ?", $rrez['rez_cat']);
			$cache && $cache->db->remove('structure', 'system');
		}
		else
		{
			$rrez['rez_state'] = 1;
		}
	}

	/* === Hook === */
	foreach (cot_getextplugins('rezume.add.add.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($db->insert($db_rezume, $rrez))
	{
		$id = $db->lastInsertId();

		cot_extrafield_movefiles();
	}
	else
	{
		$id = false;
	}

	/* === Hook === */
	foreach (cot_getextplugins('rezume.add.add.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($rrez['rez_state'] == 0 && $cache)
	{
		if ($cfg['cache_rezume'])
		{
			$cache->rezume->clear('rezume/' . str_replace('.', '/', $structure['rezume'][$rrez['rez_cat']]['path']));
		}
		if ($cfg['cache_index'])
		{
			$cache->rezume->clear('index');
		}
	}
	cot_shield_update(30, "r rezume");
	cot_log("Add rezume #".$id, 'adm');

	return $id;
}

/**
 * Removes a REZ from the CMS.
 * @param  int     $id    Adv ID
 * @param  array   $rrez REZ data
 * @return boolean        TRUE on success, FALSE on error
 */
function cot_rezume_delete($id, $rrez = array())
{
	global $db, $db_rezume, $db_structure, $cache, $cfg, $cot_extrafields, $structure, $L;
	if (!is_numeric($id) || $id <= 0)
	{
		return false;
	}
	$id = (int)$id;
	if (count($rrez) == 0)
	{
		$rrez = $db->query("SELECT * FROM $db_rezume WHERE rez_id = ?", $id)->fetch();
		if (!$rrez)
		{
			return false;
		}
	}

	if ($rrez['rez_state'] == 0)
	{
		$db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE  structure_area='rezume' AND structure_code = ?", $rrez['rez_cat']);
	}

	foreach ($cot_extrafields[$db_rezume] as $exfld)
	{
		cot_extrafield_unlinkfiles($rrez['rez_' . $exfld['field_name']], $exfld);
	}

	$db->delete($db_rezume, "rez_id = ?", $id);
	cot_log("Deleted rezume #" . $id, 'adm');

	/* === Hook === */
	foreach (cot_getextplugins('rezume.edit.delete.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($cache)
	{
		if ($cfg['cache_rezume'])
		{
			$cache->rezume->clear('rezume/' . str_replace('.', '/', $structure['rezume'][$rrez['rez_cat']]['path']));
		}
		if ($cfg['cache_index'])
		{
			$cache->rezume->clear('index');
		}
	}

	return true;
}

/**
 * Updates a REZ in the CMS.
 * @param  integer $id    Adv ID
 * @param  array   $rrez Adv data
 * @param  array   $auth  Permissions array
 * @return boolean        TRUE on success, FALSE on error
 */
function cot_rezume_update($id, &$rrez, $auth = array())
{
	global $cache, $cfg, $db, $db_rezume, $db_structure, $structure, $L;
	if (cot_error_found())
	{
		return false;
	}

	if (count($auth) == 0)
	{
		$auth = cot_rezume_auth($rrez['rez_cat']);
	}

	if (!empty($rrez['rez_alias']))
	{
		$rez_count = $db->query("SELECT COUNT(*) FROM $db_rezume WHERE rez_alias = ? AND rez_id != ? AND rez_cat = ?", array($rrez['rez_alias'], $id,$rrez['rez_cat']))->fetchColumn();
		if ($rez_count > 0)
		{
			$rrez['rez_alias'] = $rrez['rez_alias'].rand(1000, 9999);
		}
	}

	$row_rezume = $db->query("SELECT * FROM $db_rezume WHERE rez_id = ?", $id)->fetch();

	if ($row_rezume['rez_cat'] != $rrez['rez_cat'] && $row_rezume['rez_state'] == 0)
	{
		$db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code = ? AND structure_area = 'rezume'", $row_rezume['rez_cat']);
	}

	//$usr['isadmin'] = cot_auth('rezume', $rrez['rez_cat'], 'A');
	if ($rrez['rez_state'] == 0)
	{
		if ($auth['isadmin'] && $cfg['rezume']['autovalidaterez'])
		{
			if ($row_rezume['rez_state'] != 0 || $row_rezume['rez_cat'] != $rrez['rez_cat'])
			{
				$db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code = ? AND structure_area = 'rezume'", $rrez['rez_cat']);
			}
		}
		else
		{
			$rrez['rez_state'] = 1;
		}
	}

	if ($rrez['rez_state'] != 0 && $row_rezume['rez_state'] == 0)
	{
		$db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code = ?", $rrez['rez_cat']);
	}
	$cache && $cache->db->remove('structure', 'system');

	if (!$db->update($db_rezume, $rrez, 'rez_id = ?', $id))
	{
		return false;
	}

	cot_extrafield_movefiles();

	/* === Hook === */
	foreach (cot_getextplugins('rezume.edit.update.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (($rrez['rez_state'] == 0  || $rrez['rez_cat'] != $row_rezume['rez_cat']) && $cache)
	{
		if ($cfg['cache_rezume'])
		{
			$cache->rezume->clear('rezume/' . str_replace('.', '/', $structure['rezume'][$rrez['rez_cat']]['path']));
			if ($rrez['rez_cat'] != $row_rezume['rez_cat'])
			{
				$cache->rezume->clear('rezume/' . str_replace('.', '/', $structure['rezume'][$row_rezume['rez_cat']]['path']));
			}
		}
		if ($cfg['cache_index'])
		{
			$cache->rezume->clear('index');
		}
	}

	return true;
}


function cot_rezume_list($limit, $c = '', $template = 'index', $sqlsearch = '', $order = "rez_date DESC")
{
	global $db, $db_rezume, $db_users, $cfg;
	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('rezume', 'any', 'RWA');

	$t = new XTemplate(cot_tplfile(array('rezume', 'list', $template), 'module'));
	
	$sqlsearch = !empty($sqlsearch) ? "rez_state=0 AND " . $sqlsearch : 'rez_state=0';
	
	if(!empty($c))
	{
		$categories = implode("','", cot_structure_children('rezume', $c));
		$sqlsearch .= " AND rez_cat IN ('$categories')";
	}
	
	$totalitems = $db->query("SELECT COUNT(*) FROM $db_rezume WHERE " . $sqlsearch)->fetchColumn();

	$sql = $db->query("SELECT * FROM $db_rezume AS b LEFT JOIN $db_users AS u ON u.user_id=b.rez_ownerid 
	WHERE " . $sqlsearch . " ORDER BY $order LIMIT " . (int)$limit);

	while ($rez = $sql->fetch())
	{
		$jj++;
		$t->assign(cot_generate_usertags($rez, 'LIST_ROW_OWNER_'));
		$t->assign(cot_generate_reztags($rez, 'LIST_ROW_', $usr['isadmin'],
										 $cfg['homebreadcrumb']));

		$t->assign(array(
			"LIST_ROW_ODDEVEN" => cot_build_oddeven($jj),
		));
		$t->parse("MAIN.LIST_ROW");
	}
	
	$t->assign(array(
		"TOTALITEMS" => $totalitems,
	));

	$t->parse("MAIN");
	return $t->text('MAIN');
}