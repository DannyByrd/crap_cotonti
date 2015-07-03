<?php
/**
 * Vacancies API
 *
 * @package vacancies
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

// Requirements
require_once cot_langfile('vacancies', 'module');
require_once cot_incfile('vacancies', 'module', 'resources');
require_once cot_incfile('forms');
require_once cot_incfile('extrafields');

// Tables and extras
cot::$db->registerTable('vacancies');

cot_extrafields_register_table('vacancies');

is_array(cot::$structure['vacancies']) or cot::$structure['vacancies'] = array();

function cot_vacancies_get_minmax($rc = 'default', $value)
{
	$rc = (!empty($L['vac_rc_minmax_full_'.$rc])) ? $rc : 'default';
	
	list($min, $max) = explode('-', $value);
	
	if($max > 0 && $max > 0 && $min == $max)
	{
		return cot_rc('vac_rc_minmax_equ_'.$rc, array('max' => $max));
	}
	elseif($min > 0 && $max > 0)
	{
		return cot_rc('vac_rc_minmax_full_'.$rc, array('min' => $min, 'max' => $max));
	}
	elseif($min > 0 && $max == 0)
	{
		return cot_rc('vac_rc_minmax_min_'.$rc, array('min' => $min));
	}
	elseif($max > 0 && $min == 0)
	{
		return cot_rc('vac_rc_minmax_max_'.$rc, array('max' => $max));
	}
	else
	{
		return cot_rc('vac_rc_minmax_empty_'.$rc);
	}
}

function cot_vacancies_checkminmax($value)
{
	if(strpos($value, '-'))
	{
		list($min, $max) = explode('-', $value);
		if($max > 0 && $min > 0 && $max < $min)
		{
			return false;
		}
	}
	
	return true;
}



/**
 * Generates sex dropdown
 *
 * @param string $check Checked sex
 * @param string $name Input name
 * @return string
 */
if(!function_exists('cot_selectbox_sex')){
function cot_selectbox_sex($check, $name)
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
}


/**
 * Generates education dropdown
 *
 * @param string $check Checked edu
 * @param string $name Input name
 * @return string
 */
if(!function_exists('cot_selectbox_edu')){
function cot_selectbox_edu($check, $name)
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
}

function cot_build_structure_vacancies_tree($c = '',$sub_cat = true, $allsublev = true, $custom_tpl = '',$col = 'all')
{
	global $cot_extrafields, $db_structure, $structure, $cfg, $db, $db_x,  $sys;
	$t1 = new XTemplate(cot_tplfile(array('vacancies', 'tree', $custom_tpl), 'module'));
	
	$kk = 0;
	if(!$sub_cat){
	  $c = '';
	 }
	$allsub = (empty($c)) ? cot_structure_children('vacancies', '', $allsublev, false, true, false) : cot_structure_children('vacancies', $c, $allsublev, false, true, false);
	$subcat = array_slice($allsub, $dc, $cfg['vacancies']['maxlistsperpage']);

	/* === Hook - Part1 : Set === */
	$extp = cot_getextplugins('vacancies.tree.rowcat.loop');
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
		
		$mtch = $structure['vacancies'][$x]['path'].'.';
		$mtchlen = mb_strlen($mtch);
		$mtchlvl = mb_substr_count($mtch,".");

		if(empty($c) && !$allsublev && $mtchlvl == 1 || !empty($c))
		{
			$cat_childs = cot_structure_children('vacancies', $x);
			$sub_count = 0;
			foreach ($cat_childs as $cat_child)
			{
				$sub_count += (int)$structure['vacancies'][$cat_child]['count'];
			}

			$sub_url_path = $list_url_path;
			$sub_url_path['c'] = $x;
			$t1->assign(array(
				'LIST_ROWCAT_URL' => cot_url('vacancies', $sub_url_path),
				'LIST_ROWCAT_TITLE' => $structure['vacancies'][$x]['title'],
				'LIST_ROWCAT_DESC' => $structure['vacancies'][$x]['desc'],
				'LIST_ROWCAT_ICON' => $structure['vacancies'][$x]['icon'],
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
					'LIST_ROWCAT_'.$uname => cot_build_extrafields_data('structure', $exfld, $structure['vacancies'][$x][$exfld['field_name']]),
					'LIST_ROWCAT_'.$uname.'_VALUE' => $structure['vacancies'][$x][$exfld['field_name']],
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
 * Builds vacancies category path
 *
 * @param string $cat Category code
 * @param bool $vacancieslink Include vacanciess main link
 * @return array
 * @see cot_breadcrumbs()
 */
function cot_vacancies_buildpath($cat, $vacancieslink = true)
{
	global $structure, $cfg, $L;
	$tmp = array();
	if ($vacancieslink)
	{
		$tmp[] = array(cot_url('vacancies'), $L['Vacancies']);
	}
	if(!empty($cat) && $cat != 'all')
	{	
		$pathcodes = explode('.', $structure['vacancies'][$cat]['path']);
		foreach ($pathcodes as $k => $x)
		{
			$tmp[] = array(cot_url('vacancies', 'c=' . $x), $structure['vacancies'][$x]['title']);
		}
	}
	return $tmp;
}


/**
 * Returns all vac tags for coTemplate
 *
 * @param mixed $vac_data Adv Info Array or ID
 * @param string $tag_prefix Prefix for tags
 * @param bool $admin_rights Adv Admin Rights
 * @param bool $vacanciespath_home Add home link for vacancies path
 * @param string $emptytitle vacancy title desc if vacancies does not exist
 * @return array
 * @global CotDB $db
 */
function cot_generate_vactags($vac_data, $tag_prefix = '', $admin_rights = null, $vacanciespath_home = false, $emptytitle = '')
{
	global $db, $cot_extrafields, $cfg, $L, $Ls, $R, $db_vacancies, $usr, $sys, $cot_yesno, $structure, $db_structure, $cot_educations;

	static $extp_first = null, $extp_main = null;
	static $pag_auth = array();

	if (is_null($extp_first))
	{
		$extp_first = cot_getextplugins('vacanciestags.first');
		$extp_main = cot_getextplugins('vacanciestags.main');
	}

	/* === Hook === */
	foreach ($extp_first as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!is_array($vac_data))
	{
		$sql = $db->query("SELECT * FROM $db_vacancies WHERE vac_id = '" . (int) $vac_data . "' LIMIT 1");
		$vac_data = $sql->fetch();
	}

	if ($vac_data['vac_id'] > 0 && !empty($vac_data['vac_title']))
	{
		if (is_null($admin_rights))
		{
			if (!isset($pag_auth[$vac_data['vac_cat']]))
			{
				$pag_auth[$vac_data['vac_cat']] = cot_auth('vacancies', $vac_data['vac_cat'], 'RWA1');
			}
			$admin_rights = (bool) $pag_auth[$vac_data['vac_cat']][2];
		}
		$vacanciespath = cot_vacancies_buildpath($vac_data['vac_cat']);
		$catpath = cot_breadcrumbs($vacanciespath, $vacanciespath_home);
		$vac_data['vac_pageurl'] = (empty($vac_data['vac_alias'])) ? cot_url('vacancies', 'c='.$vac_data['vac_cat'].'&id='.$vac_data['vac_id']) : cot_url('vacancies', 'c='.$vac_data['vac_cat'].'&al='.$vac_data['vac_alias']);
		$vac_link[] = array($vac_data['vac_pageurl'], $vac_data['vac_title']);
		$vac_data['vac_fulltitle'] = cot_breadcrumbs(array_merge($vacanciespath, $vac_link), $vacanciespath_home);

		$date_format = 'datetime_medium';

		$cat_url = cot_url('vacancies', 'c=' . $vac_data['vac_cat']);
		$validate_url = cot_url('admin', "m=vacancies&a=validate&id={$vac_data['vac_id']}&x={$sys['xk']}");
		$unvalidate_url = cot_url('admin', "m=vacancies&a=unvalidate&id={$vac_data['vac_id']}&x={$sys['xk']}");
		$edit_url = cot_url('vacancies', "m=edit&id={$vac_data['vac_id']}");
		$delete_url = cot_url('vacancies', "m=edit&a=update&delete=1&id={$vac_data['vac_id']}&x={$sys['xk']}");

		$vac_data['vac_status'] = cot_vacancies_status(
			$vac_data['vac_state'],
			$vac_data['vac_expire']
		);
		
		list($vac_data['vac_salarymin'], $vac_data['vac_salarymax']) = explode('-', $vac_data['vac_salary']);
		list($vac_data['vac_agemin'], $vac_data['vac_agemax']) = explode('-', $vac_data['vac_age']);
		list($vac_data['vac_expmin'], $vac_data['vac_expmax']) = explode('-', $vac_data['vac_exp']);

		$mavatar = new mavatar('vacancies',$vac_data['vac_cat'], $vac_data['vac_id']);
		$mavatars_tags = $mavatar->generate_mavatars_tags();
		
		$temp_array = array(
			'URL' => $vac_data['vac_pageurl'],
			'ID' => $vac_data['vac_id'],
			'TITLE' => $vac_data['vac_fulltitle'],
			'ALIAS' => $vac_data['vac_alias'],
			'STATE' => $vac_data['vac_state'],
			'STATUS' => $vac_data['vac_status'],
			'LOCALSTATUS' => $L['vac_status_'.$vac_data['vac_status']],
			'SHORTTITLE' => htmlspecialchars($vac_data['vac_title'], ENT_COMPAT, 'UTF-8', false),
			'CAT' => $vac_data['vac_cat'],
			'CATURL' => $cat_url,
			'CATTITLE' => htmlspecialchars($structure['vacancies'][$vac_data['vac_cat']]['title']),
			'CATPATH' => $catpath,
			'CATPATH_SHORT' => cot_rc_link($cat_url, htmlspecialchars($structure['vacancies'][$vac_data['vac_cat']]['title'])),
			'CATDESC' => htmlspecialchars($structure['vacancies'][$vac_data['vac_cat']]['desc']),
			'CATICON' => $structure['vacancies'][$vac_data['vac_cat']]['icon'],
			'KEYWORDS' => htmlspecialchars($vac_data['vac_keywords']),
			'DESC' => $vac_data['vac_desc'],
			'DUTY' => htmlspecialchars($vac_data['vac_duty']),
			'TERM' => htmlspecialchars($vac_data['vac_term']),
			'QUA' => htmlspecialchars($vac_data['vac_qua']),
			'ICON' => $mavatars_tags,
			'EDU' => $cot_educations[$vac_data['vac_edu']],
			'SALARYMIN' => $vac_data['vac_salarymin'],
			'SALARYMAX' => $vac_data['vac_salarymax'],
			'SALARY_VALUE' => $vac_data['vac_salary'],
			'SALARY' => cot_vacancies_get_minmax('salary', $vac_data['vac_salary']),
			'EXPMIN' => $vac_data['vac_expmin'],
			'EXPMAX' => $vac_data['vac_expmax'],
			'EXP_VALUE' => $vac_data['vac_exp'],
			'EXP' => cot_vacancies_get_minmax('exp', $vac_data['vac_exp']),
			'AGEMIN' => $vac_data['vac_agemin'],
			'AGEMAX' => $vac_data['vac_agemax'],
			'AGE_VALUE' => $vac_data['vac_age'],
			'AGE' => cot_vacancies_get_minmax('age', $vac_data['vac_age']),
			'SEX' => ($vac_data['vac_sex'] == '' || $vac_data['vac_sex'] == 'U') ? '' : $L['Gender_' . $vac_data['vac_sex']],
			'ADDR' => htmlspecialchars($vac_data['vac_addr']),
			'PHONE' => htmlspecialchars($vac_data['vac_phone']),
			'SKYPE' => htmlspecialchars($vac_data['vac_skype']),
			'SITE' => htmlspecialchars($vac_data['vac_site']),
			'EMAIL' => htmlspecialchars($vac_data['vac_email']),
			'OWNERID' => $vac_data['vac_ownerid'],
			'OWNERNAME' => htmlspecialchars($vac_data['user_name']),
			'DATE' => cot_date($date_format, $vac_data['vac_date']),
			'UPDATED' => cot_date($date_format, $vac_data['vac_updated']),
			'EXPIRE' => cot_date($date_format, $vac_data['vac_expire']),
			'DATE_STAMP' => $vac_data['vac_date'],
			'UPDATED_STAMP' => $vac_data['vac_updated'],
			'COUNT' => $vac_data['vac_count'],
			'ADMIN' => $admin_rights ? cot_rc('list_row_admin', array('unvalidate_url' => $unvalidate_url, 'edit_url' => $edit_url)) : '',
		);

		// Admin tags
		if ($admin_rights)
		{
			$validate_confirm_url = cot_confirm_url($validate_url, 'vacancies', 'vac_confirm_validate');
			$unvalidate_confirm_url = cot_confirm_url($unvalidate_url, 'vacancies', 'vac_confirm_unvalidate');
			$delete_confirm_url = cot_confirm_url($delete_url, 'vacancies', 'vac_confirm_delete');
			$temp_array['ADMIN_EDIT'] = cot_rc_link($edit_url, $L['Edit']);
			$temp_array['ADMIN_EDIT_URL'] = $edit_url;
			$temp_array['ADMIN_UNVALIDATE'] = $vac_data['vac_state'] == 1 ?
				cot_rc_link($validate_confirm_url, $L['Validate'], 'class="confirmLink"') :
				cot_rc_link($unvalidate_confirm_url, $L['Putinvalidationqueue'], 'class="confirmLink"');
			$temp_array['ADMIN_UNVALIDATE_URL'] = $vac_data['vac_state'] == 1 ?
				$validate_confirm_url : $unvalidate_confirm_url;
			$temp_array['ADMIN_DELETE'] = cot_rc_link($delete_confirm_url, $L['Delete'], 'class="confirmLink"');
			$temp_array['ADMIN_DELETE_URL'] = $delete_confirm_url;
		}
		else if ($usr['id'] == $vac_data['vac_ownerid'])
		{
			$temp_array['ADMIN_EDIT'] = cot_rc_link($edit_url, $L['Edit']);
			$temp_array['ADMIN_EDIT_URL'] = $edit_url;
		}

		if (cot_auth('vacancies', 'any', 'W'))
		{
			$clone_url = cot_url('vacancies', "m=add&c={$vac_data['vac_cat']}&clone={$vac_data['vac_id']}");
			$temp_array['ADMIN_CLONE'] = cot_rc_link($clone_url, $L['vac_clone']);
			$temp_array['ADMIN_CLONE_URL'] = $clone_url;
		}

		// Extrafields
		if (isset($cot_extrafields[$db_vacancies]))
		{
			foreach ($cot_extrafields[$db_vacancies] as $exfld)
			{
				$tag = mb_strtoupper($exfld['field_name']);
				$temp_array[$tag.'_TITLE'] = isset($L['vac_'.$exfld['field_name'].'_title']) ?  $L['vac_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
				$temp_array[$tag] = cot_build_extrafields_data('vacancies', $exfld, $vac_data['vac_'.$exfld['field_name']], $vac_data['vac_parser']);
				$temp_array[$tag.'_VALUE'] = $vac_data['vac_'.$exfld['field_name']];
			}
		}

		// Extra fields for structure
		if (isset($cot_extrafields[$db_structure]))
		{
			foreach ($cot_extrafields[$db_structure] as $exfld)
			{
				$tag = mb_strtoupper($exfld['field_name']);
				$temp_array['CAT_'.$tag.'_TITLE'] = isset($L['structure_'.$exfld['field_name'].'_title']) ?  $L['structure_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
				$temp_array['CAT_'.$tag] = cot_build_extrafields_data('structure', $exfld, $structure['vacancies'][$vac_data['vac_cat']][$exfld['field_name']]);
				$temp_array['CAT_'.$tag.'_VALUE'] = $structure['vacancies'][$vac_data['vac_cat']][$exfld['field_name']];
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
function cot_vacancies_config_order()
{
	global $cot_extrafields, $L, $db_vacancies;

	$options_sort = array(
		'id' => $L['Id'],
		'key' => $L['Key'],
		'title' => $L['Title'],
		'desc' => $L['Description'],
		'ownerid' => $L['Owner'],
		'date' => $L['Date'],
		'salary' => $L['vac_salary'],
		'edu' => $L['vac_edu'],
		'sex' => $L['vac_sex'],
		'expire' => $L['Expire']
	);

	foreach($cot_extrafields[$db_vacancies] as $exfld)
	{
		$options_sort[$exfld['field_name']] = isset($L['vac_'.$exfld['field_name'].'_title']) ? $L['vac_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
	}

	$L['cfg_order_params'] = array_values($options_sort);
	return array_keys($options_sort);
}

/**
 * Determines vac status
 *
 * @param int $vac_state
 * @return string 'draft', 'pending', 'published'
 */
function cot_vacancies_status($vac_state, $vac_expire)
{
	global $sys;

	if ($vac_state == 0)
	{
		if ($vac_expire > 0 && $vac_expire <= $sys['now'])
		{
			return 'expired';
		}
		return 'published';
	}
	elseif ($vac_state == 2)
	{
		return 'draft';
	}
	return 'pending';
}

/**
 * Recalculates vacancies category counters
 *
 * @param string $cat Cat code
 * @return int
 * @global CotDB $db
 */
function cot_vacancies_sync($cat)
{
	global $db, $db_structure, $db_vacancies, $cache;
	
	$parent = cot_structure_parents('vacancies', $cat, 'first');
	$cats = cot_structure_children('vacancies', $parent, true, true);
	foreach($cats as $c)
	{
		$subcats = cot_structure_children('vacancies', $c, true, true);
		$count = $db->query("SELECT COUNT(*) FROM $db_vacancies WHERE vac_cat IN ('".implode("','", $subcats)."') AND vac_state = 0")->fetchColumn();		
		$db->query("UPDATE $db_structure SET structure_count=".(int)$count." WHERE structure_area='vacancies' AND structure_code = ?", $c);
		$summcount += $count;
		if($cat == $c) $catcount = $count;
	}
	$cache && $cache->db->remove('structure', 'system');
	
	return $catcount;
}

/**
 * Update vacancies category code
 *
 * @param string $oldcat Old Cat code
 * @param string $newcat New Cat code
 * @return bool
 * @global CotDB $db
 */
function cot_vacancies_updatecat($oldcat, $newcat)
{
	global $db, $db_structure, $db_vacancies;
	return (bool) $db->update($db_vacancies, array("vac_cat" => $newcat), "vac_cat='".$db->prep($oldcat)."'");
}

/**
 * Returns permissions for a vac category.
 * @param  string $cat Category code
 * @return array       Permissions array with keys: 'auth_read', 'auth_write', 'isadmin', 'auth_download'
 */
function cot_vacancies_auth($cat = null)
{
	if (empty($cat))
	{
		$cat = 'any';
	}
	$auth = array();
	list($auth['auth_read'], $auth['auth_write'], $auth['isadmin'], $auth['auth_download']) = cot_auth('vacancies', $cat, 'RWA1');
	return $auth;
}

/**
 * Imports vac data from request parameters.
 * @param  string $source Source request method for parameters
 * @param  array  $rvac  Existing vac data from database
 * @param  array  $auth   Permissions array
 * @return array          Adv data
 */
function cot_vacancies_import($source = 'POST', $rvac = array(), $auth = array())
{
	global $cfg, $db_vacancies, $cot_extrafields, $usr, $sys;

	if (count($auth) == 0)
	{
		$auth = cot_vacancies_auth($rvac['vac_cat']);
	}

	if ($source == 'D' || $source == 'DIRECT')
	{
		// A trick so we don't have to affect every line below
		global $_PATCH;
		$_PATCH = $rvac;
		$source = 'PATCH';
	}

	$rvac['vac_cat']      = cot_import('rvaccat', $source, 'TXT');
	$rvac['vac_keywords'] = cot_import('rvackeywords', $source, 'TXT');
	$rvac['vac_alias']    = cot_import('rvacalias', $source, 'TXT');
	$rvac['vac_title']    = cot_import('rvactitle', $source, 'TXT');
	$rvac['vac_desc']     = cot_import('rvacdesc', $source, 'HTM');
	
	$rvacsalarymin		= cot_import('rvacsalarymin', $source, 'INT');
	$rvacsalary['min']	= (!empty($rvacsalarymin)) ? $rvacsalarymin : 0;
	$rvacsalarymax		= cot_import('rvacsalarymax', $source, 'INT');
	$rvacsalary['max']  = (!empty($rvacsalarymax)) ? $rvacsalarymax : 0;
	
	if(!empty($rvacsalary['min']) || !empty($rvacsalary['max']))
	{
		$rvac['vac_salary'] = implode('-', $rvacsalary);
	}
	
	$rvacagemin		= cot_import('rvacagemin', $source, 'INT');
	$rvacage['min']	= (!empty($rvacagemin)) ? $rvacagemin : 0;
	$rvacagemax		= cot_import('rvacagemax', $source, 'INT');
	$rvacage['max']  = (!empty($rvacagemax)) ? $rvacagemax : 0;
	
	if(!empty($rvacage['min']) || !empty($rvacage['max']))
	{
		$rvac['vac_age'] = implode('-', $rvacage);
	}
	
	$rvacexpmin		= cot_import('rvacexpmin', $source, 'INT');
	$rvacexp['min']	= (!empty($rvacexpmin)) ? $rvacexpmin : 0;
	$rvacexpmax		= cot_import('rvacexpmax', $source, 'INT');
	$rvacexp['max']  = (!empty($rvacexpmax)) ? $rvacexpmax : 0;
	
	if(!empty($rvacexp['min']) || !empty($rvacexp['max']))
	{
		$rvac['vac_exp'] = implode('-', $rvacexp);
	}
	
	$rvac['vac_edu']    = cot_import('rvacedu', $source, 'TXT');
	
	$rvac['vac_duty']    = cot_import('rvacduty', $source, 'TXT');
	$rvac['vac_term']    = cot_import('rvacterm', $source, 'TXT');
	$rvac['vac_qua']    = cot_import('rvacqua', $source, 'TXT');
	
	$rvac['vac_sex']    = cot_import('rvacsex', $source, 'ALP');
	
	$rvac['vac_addr']    = cot_import('rvacaddr', $source, 'TXT');
	$rvac['vac_phone']    = cot_import('rvacphone', $source, 'TXT');
	$rvac['vac_skype']    = cot_import('rvacskype', $source, 'TXT');
	$rvac['vac_site']    = cot_import('rvacsite', $source, 'TXT');
	$rvac['vac_email']    = cot_import('rvacemail', $source, 'TXT');
	
	$rvacdatenow           = cot_import('rvacdatenow', $source, 'BOL');
	$rvac['vac_date']     = cot_import_date('rvacdate', true, false, $source);
	$rvac['vac_date']     = ($rvacdatenow || is_null($rvac['vac_date'])) ? $sys['now'] : (int)$rvac['vac_date'];
	$rvac['vac_updated']  = $sys['now'];
	$rvac['vac_expire']   = (int)cot_import_date('rvacxpire');
	$rvac['vac_expire']   = ($rvac['vac_expire'] <= $rvac['vac_begin']) ? 0 : $rvac['vac_expire'];
	
	$rvac['vac_keywords'] = cot_import('rvackeywords', $source, 'TXT');
	$rvac['vac_metatitle'] = cot_import('rvacmetatitle', $source, 'TXT');
	$rvac['vac_metadesc'] = cot_import('rvacmetadesc', $source, 'TXT');

	$rpublish               = cot_import('rpublish', $source, 'ALP'); // For backwards compatibility
	$rvac['vac_state']    = ($rpublish == 'OK') ? 0 : cot_import('rvactate', $source, 'INT');

	if ($auth['isadmin'] && isset($rvac['vac_ownerid']))
	{
		$rvac['vac_count']     = cot_import('rvaccount', $source, 'INT');
		$rvac['vac_ownerid']   = cot_import('rvacownerid', $source, 'INT');
	}
	else
	{
		$rvac['vac_ownerid'] = $usr['id'];
	}

	// Extra fields
	foreach ($cot_extrafields[$db_vacancies] as $exfld)
	{
		$rvac['vac_'.$exfld['field_name']] = cot_import_extrafields('rvac'.$exfld['field_name'], $exfld, $source, $rvac['vac_'.$exfld['field_name']]);
	}

	return $rvac;
}

/**
 * Validates vac data.
 * @param  array   $rvac Imported vac data
 * @return boolean        TRUE if validation is passed or FALSE if errors were found
 */
function cot_vacancies_validate($rvac)
{
	global $cfg, $structure;
	
	cot_check(empty($rvac['vac_cat']), 'vac_catmissing', 'rvaccat');
	if ($structure['vacancies'][$rvac['vac_cat']]['locked'])
	{
		global $L;
		require_once cot_langfile('message', 'core');
		cot_error('msg602_body', 'rvaccat');
	}
	cot_check(mb_strlen($rvac['vac_title']) < 2, 'vac_titletooshort', 'rvactitle');

	cot_check(!empty($rvac['vac_alias']) && preg_match('`[+/?%#&]`', $rvac['vac_alias']), 'vac_aliascharacters', 'rvacalias');
	
	cot_check(empty($rvac['vac_duty']), 'vac_error_dutymissing', 'rvacduty');
	cot_check(empty($rvac['vac_term']), 'vac_error_termmissing', 'rvacterm');
	cot_check(empty($rvac['vac_qua']), 'vac_error_quamissing', 'rvacqua');
	
	cot_check(empty($rvac['vac_salary']), 'vac_error_salarymissing', 'rvacsalary');
	cot_check(!empty($rvac['vac_salary']) && !cot_vacancies_checkminmax($rvac['vac_salary']), 'vac_error_salaryminmax', 'rvacsalary');
	
	//cot_check(empty($rvac['vac_exp']), 'vac_error_expmissing', 'rvacexp');
	cot_check(!empty($rvac['vac_exp']) && !cot_vacancies_checkminmax($rvac['vac_exp']), 'vac_error_expminmax', 'rvacexp');
	
	cot_check(empty($rvac['vac_age']), 'vac_error_agemissing', 'rvacage');
	cot_check(!empty($rvac['vac_age']) && !cot_vacancies_checkminmax($rvac['vac_age']), 'vac_error_ageminmax', 'rvacage');
	return !cot_error_found();
}

/**
 * Adds a new vac to the CMS.
 * @param  array   $rvac Adv data
 * @param  array   $auth  Permissions array
 * @return integer        New vacancies ID or FALSE on error
 */
function cot_vacancies_add(&$rvac, $auth = array())
{
	global $cache, $cfg, $db, $db_vacancies, $db_structure, $structure, $L;
	if (cot_error_found())
	{
		return false;
	}

	if (count($auth) == 0)
	{
		$auth = cot_vacancies_auth($rvac['vac_cat']);
	}

	if (!empty($rvac['vac_alias']))
	{
		$vac_count = $db->query("SELECT COUNT(*) FROM $db_vacancies WHERE vac_alias = ? AND vac_cat = ?", array($rvac['vac_alias'],$rvac['vac_cat']))->fetchColumn();
		if ($vac_count > 0)
		{
			$rvac['vac_alias'] = $rvac['vac_alias'].rand(1000, 9999);
		}
	}

	if ($rvac['vac_state'] == 0)
	{
		if ($auth['isadmin'] && $cfg['vacancies']['autovalidatevac'])
		{
			$db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_area='vacancies' AND structure_code = ?", $rvac['vac_cat']);
			$cache && $cache->db->remove('structure', 'system');
		}
		else
		{
			$rvac['vac_state'] = 1;
		}
	}

	/* === Hook === */
	foreach (cot_getextplugins('vacancies.add.add.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($db->insert($db_vacancies, $rvac))
	{
		$id = $db->lastInsertId();

		cot_extrafield_movefiles();
	}
	else
	{
		$id = false;
	}

	/* === Hook === */
	foreach (cot_getextplugins('vacancies.add.add.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($rvac['vac_state'] == 0 && $cache)
	{
		if ($cfg['cache_vacancies'])
		{
			$cache->vacancies->clear('vacancies/' . str_replace('.', '/', $structure['vacancies'][$rvac['vac_cat']]['path']));
		}
		if ($cfg['cache_index'])
		{
			$cache->vacancies->clear('index');
		}
	}
	cot_shield_update(30, "r vacancies");
	cot_log("Add vacancies #".$id, 'adm');

	return $id;
}

/**
 * Removes a vac from the CMS.
 * @param  int     $id    Adv ID
 * @param  array   $rvac vac data
 * @return boolean        TRUE on success, FALSE on error
 */
function cot_vacancies_delete($id, $rvac = array())
{
	global $db, $db_vacancies, $db_structure, $cache, $cfg, $cot_extrafields, $structure, $L;
	if (!is_numeric($id) || $id <= 0)
	{
		return false;
	}
	$id = (int)$id;
	if (count($rvac) == 0)
	{
		$rvac = $db->query("SELECT * FROM $db_vacancies WHERE vac_id = ?", $id)->fetch();
		if (!$rvac)
		{
			return false;
		}
	}

	if ($rvac['vac_state'] == 0)
	{
		$db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE  structure_area='vacancies' AND structure_code = ?", $rvac['vac_cat']);
	}

	foreach ($cot_extrafields[$db_vacancies] as $exfld)
	{
		cot_extrafield_unlinkfiles($rvac['vac_' . $exfld['field_name']], $exfld);
	}

	$db->delete($db_vacancies, "vac_id = ?", $id);
	cot_log("Deleted vacancies #" . $id, 'adm');

	/* === Hook === */
	foreach (cot_getextplugins('vacancies.edit.delete.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($cache)
	{
		if ($cfg['cache_vacancies'])
		{
			$cache->vacancies->clear('vacancies/' . str_replace('.', '/', $structure['vacancies'][$rvac['vac_cat']]['path']));
		}
		if ($cfg['cache_index'])
		{
			$cache->vacancies->clear('index');
		}
	}

	return true;
}

/**
 * Updates a vac in the CMS.
 * @param  integer $id    Adv ID
 * @param  array   $rvac Adv data
 * @param  array   $auth  Permissions array
 * @return boolean        TRUE on success, FALSE on error
 */
function cot_vacancies_update($id, &$rvac, $auth = array())
{
	global $cache, $cfg, $db, $db_vacancies, $db_structure, $structure, $L;
	if (cot_error_found())
	{
		return false;
	}

	if (count($auth) == 0)
	{
		$auth = cot_vacancies_auth($rvac['vac_cat']);
	}

	if (!empty($rvac['vac_alias']))
	{
		$vac_count = $db->query("SELECT COUNT(*) FROM $db_vacancies WHERE vac_alias = ? AND vac_id != ? AND vac_cat = ?", array($rvac['vac_alias'], $id, $rvac['vac_cat']))->fetchColumn();
		if ($vac_count > 0)
		{
			$rvac['vac_alias'] = $rvac['vac_alias'].rand(1000, 9999);
		}
	}

	$row_vacancies = $db->query("SELECT * FROM $db_vacancies WHERE vac_id = ?", $id)->fetch();

	if ($row_vacancies['vac_cat'] != $rvac['vac_cat'] && $row_vacancies['vac_state'] == 0)
	{
		$db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code = ? AND structure_area = 'vacancies'", $row_vacancies['vac_cat']);
	}

	//$usr['isadmin'] = cot_auth('vacancies', $rvac['vac_cat'], 'A');
	if ($rvac['vac_state'] == 0)
	{
		if ($auth['isadmin'] && $cfg['vacancies']['autovalidatevac'])
		{
			if ($row_vacancies['vac_state'] != 0 || $row_vacancies['vac_cat'] != $rvac['vac_cat'])
			{
				$db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code = ? AND structure_area = 'vacancies'", $rvac['vac_cat']);
			}
		}
		else
		{
			$rvac['vac_state'] = 1;
		}
	}

	if ($rvac['vac_state'] != 0 && $row_vacancies['vac_state'] == 0)
	{
		$db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code = ?", $rvac['vac_cat']);
	}
	$cache && $cache->db->remove('structure', 'system');

	if (!$db->update($db_vacancies, $rvac, 'vac_id = ?', $id))
	{
		return false;
	}

	cot_extrafield_movefiles();

	/* === Hook === */
	foreach (cot_getextplugins('vacancies.edit.update.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (($rvac['vac_state'] == 0  || $rvac['vac_cat'] != $row_vacancies['vac_cat']) && $cache)
	{
		if ($cfg['cache_vacancies'])
		{
			$cache->vacancies->clear('vacancies/' . str_replace('.', '/', $structure['vacancies'][$rvac['vac_cat']]['path']));
			if ($rvac['vac_cat'] != $row_vacancies['vac_cat'])
			{
				$cache->vacancies->clear('vacancies/' . str_replace('.', '/', $structure['vacancies'][$row_vacancies['vac_cat']]['path']));
			}
		}
		if ($cfg['cache_index'])
		{
			$cache->vacancies->clear('index');
		}
	}

	return true;
}


function cot_vacancies_list($limit, $c = '', $template = 'index', $sqlsearch = '', $order = "vac_date DESC")
{
	global $db, $db_vacancies, $db_users, $cfg;
	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('vacancies', 'any', 'RWA');

	$t = new XTemplate(cot_tplfile(array('vacancies', 'list', $template), 'module'));
	
	$sqlsearch = !empty($sqlsearch) ? "vac_state=0 AND " . $sqlsearch : 'vac_state=0';
	
	if(!empty($c))
	{
		$categories = implode("','", cot_structure_children('vacancies', $c));
		$sqlsearch .= " AND vac_cat IN ('$categories')";
	}
	
	$totalitems = $db->query("SELECT COUNT(*) FROM $db_vacancies WHERE " . $sqlsearch)->fetchColumn();

	$sql = $db->query("SELECT * FROM $db_vacancies AS b LEFT JOIN $db_users AS u ON u.user_id=b.vac_ownerid 
	WHERE " . $sqlsearch . " ORDER BY $order LIMIT " . (int)$limit);

	while ($vac = $sql->fetch())
	{
		$jj++;
		$t->assign(cot_generate_usertags($vac, 'VAC_ROW_OWNER_'));
		$t->assign(cot_generate_vactags($vac, 'VAC_ROW_', $usr['isadmin'],
										 $cfg['homebreadcrumb']));

		$t->assign(array(
			"VAC_ROW_ODDEVEN" => cot_build_oddeven($jj),
		));
		$t->parse("MAIN.VAC_ROW");
	}
	
	$t->assign(array(
		"TOTALITEMS" => $totalitems,
	));

	$t->parse("MAIN");
	return $t->text('MAIN');
}