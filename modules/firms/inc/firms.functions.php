<?php
/**
 * Firms API
 *
 * @package firms
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

// Requirements
require_once cot_langfile('firms', 'module');
require_once cot_incfile('firms', 'module', 'resources');
require_once cot_incfile('forms');
require_once cot_incfile('extrafields');

// Tables and extras
cot::$db->registerTable('firms');

cot_extrafields_register_table('firms');

is_array(cot::$structure['firms']) or cot::$structure['firms'] = array();


function cot_build_structure_firms_tree($c = '', $allsublev = true, $template = '', $col = 'all')
{
	global $cot_extrafields, $db_structure, $structure, $cfg, $db, $db_x,  $sys;

	$t1 = new XTemplate(cot_tplfile(array('firms', 'tree', $template), 'module'));

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
	
	$colcount = floor(count($cats)/((int)$col + 1)) + 1;


	if($col === 'all'){
		$new_col = count($cats);
	}else{
		$new_col = $col;
	}
	
	if(is_array($cats))
	{
		foreach($cats as $cat)
		{
			$query = $db->query("SELECT mav_code AS id FROM $db_x"."mavatars WHERE mav_extension = 'structure' AND mav_category = '".$cat."'");
		  	$mav_code = $query->fetch();
		  	if($mav_code){

		  		$mavatar = new mavatar('structure', $cat, $mav_code['id']);
		  		$mavatars_tags = $mavatar->generate_mavatars_tags();
		  		
		  		$t1->assign(array(
			  	'LIST_ROWCAT_MAVATAR'		=> $mavatars_tags,
			  	'LIST_ROWCAT_MAVATARCOUNT'	=> count($mavatars_tags),
			  	'LIST_ROWCAT_CATEGORY_AVATAR' => $cat
			  ));

		  	}

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
				'LIST_ROWCAT_URL' => cot_url('firms', $sub_url_path),
				'LIST_ROWCAT_TITLE' => $structure['firms'][$cat]['title'],
				'LIST_ROWCAT_DESC' => $structure['firms'][$cat]['desc'],
				'LIST_ROWCAT_ICON' => $structure['firms'][$cat]['icon'],
				'LIST_ROWCAT_COUNT' => $sub_count,
				'LIST_ROWCAT_ODDEVEN' => cot_build_oddeven($kk),
				'LIST_ROWCAT_NUM' => $kk,
				'LIST_ROWCAT_COL' => ($kk % $colcount == 0) ? 1 : 0,
				'LIST_ROWCAT_COUNT_VIEW' =>$new_col,
				'LIST_ROWCAT_CATEGORY' => $cat
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


/**
 * Builds forum category path
 *
 * @param string $cat Category code
 * @param bool $forumslink Include forums main link
 * @return array
 * @see cot_breadcrumbs()
 */
function cot_firms_buildpath($cat, $firmslink = true)
{
	global $structure, $cfg, $L;
	$tmp = array();
	if ($firmslink)
	{
		$tmp[] = array(cot_url('firms'), $L['Firms']);
	}
	if(!empty($cat) && $cat != 'all')
	{	
		$pathcodes = explode('.', $structure['firms'][$cat]['path']);
		foreach ($pathcodes as $k => $x)
		{
			$tmp[] = array(cot_url('firms', 'c=' . $x), $structure['firms'][$x]['title']);
		}
	}
	return $tmp;
}


/**
 * Returns all firms tags for coTemplate
 *
 * @param mixed $firm_data Firm Info Array or ID
 * @param string $tag_prefix Prefix for tags
 * @param int $textlength Text truncate
 * @param bool $admin_rights Firm Admin Rights
 * @param bool $firmspath_home Add home link for firms path
 * @param string $emptytitle Firm title text if firms does not exist
 * @return array
 * @global CotDB $db
 */
function cot_generate_firmtags($firm_data, $tag_prefix = '', $textlength = 0, $admin_rights = null, $firmspath_home = false, $emptytitle = '')
{
	global $db, $cot_extrafields, $cfg, $L, $Ls, $R, $db_firms, $usr, $sys, $cot_yesno, $structure, $db_structure;

	static $extp_first = null, $extp_main = null;
	static $pag_auth = array();

	if (is_null($extp_first))
	{
		$extp_first = cot_getextplugins('firmstags.first');
		$extp_main = cot_getextplugins('firmstags.main');
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
		$firmspath = cot_firms_buildpath($firm_data['firm_cat']);
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

		$cat_url = cot_url('firms', 'c=' . $firm_data['firm_cat']);
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
			$clone_url = cot_url('firms', "m=add&c={$firm_data['firm_cat']}&clone={$firm_data['firm_id']}");
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

/**
 * Returns possible values for category sorting order
 */
function cot_firms_config_order()
{
	global $cot_extrafields, $L, $db_firms;

	$options_sort = array(
		'id' => $L['Id'],
		'type' => $L['Type'],
		'key' => $L['Key'],
		'title' => $L['Title'],
		'desc' => $L['Description'],
		'text' => $L['Body'],
		'ownerid' => $L['Owner'],
		'date' => $L['Date']
	);

	foreach($cot_extrafields[$db_firms] as $exfld)
	{
		
		$options_sort[$exfld['field_name']] = isset($L['firm_'.$exfld['field_name'].'_title']) ? $L['firm_'.$exfld['field_name'].'_title'] : $exfld['field_description'];

	}

	$L['cfg_order_params'] = array_values($options_sort);
	return array_keys($options_sort);
}

/**
 * Determines firms status
 *
 * @param int $firm_state
 * @return string 'draft', 'pending', 'published
 */
function cot_firms_status($firm_state)
{
	global $sys;

	if ($firm_state == 0)
	{
		return 'published';
	}
	elseif ($firm_state == 2)
	{
		return 'draft';
	}
	return 'pending';
}

/**
 * Recalculates firms category counters
 *
 * @param string $cat Cat code
 * @return int
 * @global CotDB $db
 */
function cot_firms_sync($cat)
{
	global $db, $db_structure, $db_firms, $cache;
	
	$parent = cot_structure_parents('firms', $cat, 'first');
	$cats = cot_structure_children('firms', $parent, true, true);
	foreach($cats as $c)
	{
		$subcats = cot_structure_children('firms', $c, true, true);
		$count = $db->query("SELECT COUNT(*) FROM $db_firms WHERE firm_cat IN ('".implode("','", $subcats)."') AND firm_state = 0")->fetchColumn();		
		$db->query("UPDATE $db_structure SET structure_count=".(int)$count." WHERE structure_area='firms' AND structure_code = ?", $c);
		$summcount += $count;
		if($cat == $c) $catcount = $count;
	}
	$cache && $cache->db->remove('structure', 'system');
	
	return $catcount;
}

/**
 * Update firms category code
 *
 * @param string $oldcat Old Cat code
 * @param string $newcat New Cat code
 * @return bool
 * @global CotDB $db
 */
function cot_firms_updatecat($oldcat, $newcat)
{
	global $db, $db_structure, $db_firms;
	return (bool) $db->update($db_firms, array("firm_cat" => $newcat), "firm_cat='".$db->prep($oldcat)."'");
}

/**
 * Returns permissions for a firms category.
 * @param  string $cat Category code
 * @return array       Permissions array with keys: 'auth_read', 'auth_write', 'isadmin', 'auth_download'
 */
function cot_firms_auth($cat = null)
{
	if (empty($cat))
	{
		$cat = 'any';
	}
	$auth = array();
	list($auth['auth_read'], $auth['auth_write'], $auth['isadmin'], $auth['auth_download']) = cot_auth('firms', $cat, 'RWA1');
	return $auth;
}

/**
 * Imports firms data from request parameters.
 * @param  string $source Source request method for parameters
 * @param  array  $rfirm  Existing firms data from database
 * @param  array  $auth   Permissions array
 * @return array          Firm data
 */
function cot_firms_import($source = 'POST', $rfirm = array(), $auth = array())
{
	global $cfg, $db_firms, $cot_extrafields, $usr, $sys;

	if (count($auth) == 0)
	{
		$auth = cot_firms_auth($rfirm['firm_cat']);
	}

	if ($source == 'D' || $source == 'DIRECT')
	{
		// A trick so we don't have to affect every line below
		global $_PATCH;
		$_PATCH = $rfirm;
		$source = 'PATCH';
	}

	$rfirm['firm_cat']      = cot_import('rfirmcat', $source, 'TXT');
	$rfirm['firm_keywords'] = cot_import('rfirmkeywords', $source, 'TXT');
	$rfirm['firm_alias']    = cot_import('rfirmalias', $source, 'TXT');
	$rfirm['firm_title']    = cot_import('rfirmtitle', $source, 'TXT');
	$rfirm['firm_desc']     = cot_import('rfirmdesc', $source, 'HTM');
	$rfirm['firm_text']     = cot_import('rfirmtext', $source, 'HTM');
	$rfirm['firm_parser']   = cot_import('rfirmparser', $source, 'ALP');
	
	$rfirm['firm_addr']    = cot_import('rfirmaddr', $source, 'TXT');
	$rfirm['firm_phone']    = cot_import('rfirmphone', $source, 'TXT');
	$rfirm['firm_skype']    = cot_import('rfirmskype', $source, 'TXT');
	$rfirm['firm_site']    = cot_import('rfirmsite', $source, 'TXT');
	$rfirm['firm_email']    = cot_import('rfirmemail', $source, 'TXT');
	
	$rfirmdatenow           = cot_import('rfirmdatenow', $source, 'BOL');
	$rfirm['firm_date']     = cot_import_date('rfirmdate', true, false, $source);
	$rfirm['firm_date']     = ($rfirmdatenow || is_null($rfirm['firm_date'])) ? $sys['now'] : (int)$rfirm['firm_date'];
	$rfirm['firm_updated']  = $sys['now'];

	$rfirm['firm_keywords'] = cot_import('rfirmkeywords', $source, 'TXT');
	$rfirm['firm_metatitle'] = cot_import('rfirmmetatitle', $source, 'TXT');
	$rfirm['firm_metadesc'] = cot_import('rfirmmetadesc', $source, 'TXT');

	$rpublish               = cot_import('rpublish', $source, 'ALP'); // For backwards compatibility
	$rfirm['firm_state']    = ($rpublish == 'OK') ? 0 : cot_import('rfirmtate', $source, 'INT');

	if ($auth['isadmin'] && isset($rfirm['firm_ownerid']))
	{
		$rfirm['firm_count']     = cot_import('rfirmcount', $source, 'INT');
		$rfirm['firm_ownerid']   = cot_import('rfirmownerid', $source, 'INT');
		$rfirm['firm_filecount'] = cot_import('rfirmfilecount', $source, 'INT');
	}
	else
	{
		$rfirm['firm_ownerid'] = $usr['id'];
	}

	$parser_list = cot_get_parsers();

	if (empty($rfirm['firm_parser']) || !in_array($rfirm['firm_parser'], $parser_list) || $rfirm['firm_parser'] != 'none' && !cot_auth('plug', $rfirm['firm_parser'], 'W'))
	{
		$rfirm['firm_parser'] = isset($sys['parser']) ? $sys['parser'] : $cfg['firms']['parser'];
	}

	// Extra fields
	foreach ($cot_extrafields[$db_firms] as $exfld)
	{
		$rfirm['firm_'.$exfld['field_name']] = cot_import_extrafields('rfirm'.$exfld['field_name'], $exfld, $source, $rfirm['firm_'.$exfld['field_name']]);
	}

	return $rfirm;
}

/**
 * Validates firms data.
 * @param  array   $rfirm Imported firms data
 * @return boolean        TRUE if validation is passed or FALSE if errors were found
 */
function cot_firms_validate($rfirm)
{
	global $cfg, $structure;
	cot_check(empty($rfirm['firm_cat']), 'firm_catmissing', 'rfirmcat');
	if ($structure['firms'][$rfirm['firm_cat']]['locked'])
	{
		global $L;
		require_once cot_langfile('message', 'core');
		cot_error('msg602_body', 'rfirmcat');
	}
	cot_check(mb_strlen($rfirm['firm_title']) < 2, 'firm_titletooshort', 'rfirmtitle');

	cot_check(!empty($rfirm['firm_alias']) && preg_match('`[+/?%#&]`', $rfirm['firm_alias']), 'firm_aliascharacters', 'rfirmalias');

	$allowemptyfirmtext = isset($cfg['firms']['cat_' . $rfirm['firm_cat']]['allowemptyfirmtext']) ?
							$cfg['firms']['cat_' . $rfirm['firm_cat']]['allowemptyfirmtext'] : $cfg['firms']['cat___default']['allowemptytext'];
	cot_check(!$allowemptyfirmtext && empty($rfirm['firm_text']), 'firm_textmissing', 'rfirmtext');

	/* --- Logo validate --- */
	
	if($_FILES['rfirmlogo'])
	{
		require_once cot_incfile('uploads');
		
		$logofile = $_FILES['rfirmlogo'];
		if (!empty($logofile['tmp_name']) && $logofile['size'] > 0 && is_uploaded_file($logofile['tmp_name']))
		{
			$gd_supported = array('jpg', 'jpeg', 'png', 'gif');
			$file_ext = strtolower(end(explode(".", $logofile['name'])));
			$fcheck = cot_file_check($file['tmp_name'], $logofile['name'], $file_ext);
			
			cot_check(!in_array($file_ext, $gd_supported) && $fcheck == 1, $L['firm_logo_notvalid'], 'rfirmlogo');
			//cot_check($fcheck == 2, sprintf($L['pfs_filemimemissing'], $file_ext), 'rfirmlogo');
		}
	}
	/* --- END Logo validate --- */
	
	return !cot_error_found();
}

/**
 * Adds a new firms to the CMS.
 * @param  array   $rfirm Firm data
 * @param  array   $auth  Permissions array
 * @return integer        New firms ID or FALSE on error
 */
function cot_firms_add(&$rfirm, $auth = array())
{
	global $cache, $cfg, $db, $db_firms, $db_structure, $structure, $L;
	if (cot_error_found())
	{
		return false;
	}

	if (count($auth) == 0)
	{
		$auth = cot_firms_auth($rfirm['firm_cat']);
	}

	if (!empty($rfirm['firm_alias']))
	{
		$firm_count = $db->query("SELECT COUNT(*) FROM $db_firms WHERE firm_alias = ? AND firm_cat = ?", array($rfirm['firm_alias'], $rfirm['firm_cat']))->fetchColumn();
		if ($firm_count > 0)
		{
			$rfirm['firm_alias'] = $rfirm['firm_alias'].rand(1000, 9999);
		}
	}

	if ($rfirm['firm_state'] == 0)
	{
		if ($auth['isadmin'] && $cfg['firms']['autovalidatefirm'])
		{
			$db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_area='firms' AND structure_code = ?", $rfirm['firm_cat']);
			$cache && $cache->db->remove('structure', 'system');
		}
		else
		{
			$rfirm['firm_state'] = 1;
		}
	}

	/* === Hook === */
	foreach (cot_getextplugins('firms.add.add.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($db->insert($db_firms, $rfirm))
	{
		$id = $db->lastInsertId();

		cot_extrafield_movefiles();
	}
	else
	{
		$id = false;
	}

	
	/* --- Logo upload --- */
	if(!empty($_FILES['rfirmlogo']['tmp_name']) && $id)
	{
		require_once cot_incfile('uploads');
		
		@clearstatcache();
		$logofile = $_FILES['rfirmlogo'];
		$file_ext = strtolower(end(explode(".", $logofile['name'])));

		$logofilepath = 'datas/firms/' . $id . '.' . $file_ext;

		move_uploaded_file($logofile['tmp_name'], $logofilepath);		
		cot_imageresize($logofilepath, $logofilepath, $cfg['firms']['logowidth'], $cfg['firms']['logoheight'], $cfg['firms']['logocrop'], '', 100);
		@chmod($logofilepath, $cfg['file_perms']);
		
		$rfirm['firm_logo'] = $logofilepath;
		
		$db->update($db_firms, $rfirm, 'firm_id = ?', $id);
	}
	
	/* === Hook === */
	foreach (cot_getextplugins('firms.add.add.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($rfirm['firm_state'] == 0 && $cache)
	{
		if ($cfg['cache_firms'])
		{
			$cache->firms->clear('firms/' . str_replace('.', '/', $structure['firms'][$rfirm['firm_cat']]['path']));
		}
		if ($cfg['cache_index'])
		{
			$cache->firms->clear('index');
		}
	}
	cot_shield_update(30, "r firms");
	cot_log("Add firms #".$id, 'adm');

	return $id;
}

/**
 * Removes a firm from the CMS.
 * @param  int     $id    Firm ID
 * @param  array   $rfirm Firm data
 * @return boolean        TRUE on success, FALSE on error
 */
function cot_firms_delete($id, $rfirm = array())
{
	global $db, $db_firms, $db_structure, $cache, $cfg, $cot_extrafields, $structure, $L;
	if (!is_numeric($id) || $id <= 0)
	{
		return false;
	}
	$id = (int)$id;
	if (count($rfirm) == 0)
	{
		$rfirm = $db->query("SELECT * FROM $db_firms WHERE firm_id = ?", $id)->fetch();
		if (!$rfirm)
		{
			return false;
		}
	}

	if ($rfirm['firm_state'] == 0)
	{
		$db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE  structure_area='firms' AND structure_code = ?", $rfirm['firm_cat']);
	}

	foreach ($cot_extrafields[$db_firms] as $exfld)
	{
		cot_extrafield_unlinkfiles($rfirm['firm_' . $exfld['field_name']], $exfld);
	}
	
	if (file_exists($rfirm['firm_logo']))
	{
		unlink($rfirm['firm_logo']);
	}
	
	$db->delete($db_firms, "firm_id = ?", $id);
	cot_log("Deleted firms #" . $id, 'adm');

	/* === Hook === */
	foreach (cot_getextplugins('firms.edit.delete.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($cache)
	{
		if ($cfg['cache_firms'])
		{
			$cache->firms->clear('firms/' . str_replace('.', '/', $structure['firms'][$rfirm['firm_cat']]['path']));
		}
		if ($cfg['cache_index'])
		{
			$cache->firms->clear('index');
		}
	}

	return true;
}

/**
 * Updates a firm in the CMS.
 * @param  integer $id    Firm ID
 * @param  array   $rfirm Firm data
 * @param  array   $auth  Permissions array
 * @return boolean        TRUE on success, FALSE on error
 */
function cot_firms_update($id, &$rfirm, $auth = array())
{
	global $cache, $cfg, $db, $db_firms, $db_structure, $structure, $L;
	if (cot_error_found())
	{
		return false;
	}

	if (count($auth) == 0)
	{
		$auth = cot_firms_auth($rfirm['firm_cat']);
	}

	if (!empty($rfirm['firm_alias']))
	{
		$firm_count = $db->query("SELECT COUNT(*) FROM $db_firms WHERE firm_alias = ? AND firm_id != ? AND firm_cat = ?", array($rfirm['firm_alias'], $id, $rfirm['firm_cat']))->fetchColumn();
		if ($firm_count > 0)
		{
			$rfirm['firm_alias'] = $rfirm['firm_alias'].rand(1000, 9999);
		}
	}

	$row_firms = $db->query("SELECT * FROM $db_firms WHERE firm_id = ?", $id)->fetch();

	if ($row_firms['firm_cat'] != $rfirm['firm_cat'] && $row_firms['firm_state'] == 0)
	{
		$db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code = ? AND structure_area = 'firms'", $row_firms['firm_cat']);
	}

	//$usr['isadmin'] = cot_auth('firms', $rfirm['firm_cat'], 'A');
	if ($rfirm['firm_state'] == 0)
	{
		if ($auth['isadmin'] && $cfg['firms']['autovalidatefirm'])
		{
			if ($row_firms['firm_state'] != 0 || $row_firms['firm_cat'] != $rfirm['firm_cat'])
			{
				$db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code = ? AND structure_area = 'firms'", $rfirm['firm_cat']);
			}
		}
		else
		{
			$rfirm['firm_state'] = 1;
		}
	}

	if ($rfirm['firm_state'] != 0 && $row_firms['firm_state'] == 0)
	{
		$db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code = ?", $rfirm['firm_cat']);
	}
	$cache && $cache->db->remove('structure', 'system');
	
	/* --- Logo deleted --- */
	$delrfirmlogo = cot_import('delrfirmlogo', 'P', 'BOL');
	if($delrfirmlogo)
	{
		if(file_exists($row_firms['firm_logo']))
		{
			unlink($row_firms['firm_logo']);
		}
		$rfirm['firm_logo'] = '';
	}
	/* --- END Logo deleted --- */
	
	
	/* --- Logo upload --- */
	if(!empty($_FILES['rfirmlogo']['tmp_name']))
	{
		require_once cot_incfile('uploads');
		
		@clearstatcache();
		$logofile = $_FILES['rfirmlogo'];
		$file_ext = strtolower(end(explode(".", $logofile['name'])));

		$logofilepath = 'datas/firms/' . $id . '.' . $file_ext;
		
		if(file_exists($logofilepath))
		{
			unlink($logofilepath);
		}
		
		if(file_exists($row_firms['firm_logo']))
		{
			unlink($row_firms['firm_logo']);
		}

		move_uploaded_file($logofile['tmp_name'], $logofilepath);		
		cot_imageresize($logofilepath, $logofilepath, $cfg['firms']['logowidth'], $cfg['firms']['logoheight'], $cfg['firms']['logocrop'], '', 100);
		@chmod($logofilepath, $cfg['file_perms']);
		
		$rfirm['firm_logo'] = $logofilepath;
	}
	
	/* --- END Logo upload --- */

	if (!$db->update($db_firms, $rfirm, 'firm_id = ?', $id))
	{
		return false;
	}

	cot_extrafield_movefiles();

	/* === Hook === */
	foreach (cot_getextplugins('firms.edit.update.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (($rfirm['firm_state'] == 0  || $rfirm['firm_cat'] != $row_firms['firm_cat']) && $cache)
	{
		if ($cfg['cache_firms'])
		{
			$cache->firms->clear('firms/' . str_replace('.', '/', $structure['firms'][$rfirm['firm_cat']]['path']));
			if ($rfirm['firm_cat'] != $row_firms['firm_cat'])
			{
				$cache->firms->clear('firms/' . str_replace('.', '/', $structure['firms'][$row_firms['firm_cat']]['path']));
			}
		}
		if ($cfg['cache_index'])
		{
			$cache->firms->clear('index');
		}
	}

	return true;
}


function cot_firms_list($limit, $c = '', $template = 'index', $sqlsearch = '', $order = "firm_date DESC")
{
	global $db, $db_firms, $db_users, $cfg;
	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('firms', 'any', 'RWA');

	$t = new XTemplate(cot_tplfile(array('firms', 'list', $template), 'module'));
	
	$sqlsearch = !empty($sqlsearch) ? "firm_state=0 AND " . $sqlsearch : 'firm_state=0';
	
	if(!empty($c))
	{
		$categories = implode("','", cot_structure_children('firms', $c));
		$sqlsearch .= " AND firm_cat IN ('$categories')";
	}

	$totalitems = $db->query("SELECT COUNT(*) FROM $db_firms WHERE " . $sqlsearch)->fetchColumn();

	$sql = $db->query("SELECT * FROM $db_firms AS f LEFT JOIN $db_users AS u ON u.user_id=f.firm_ownerid 
	WHERE " . $sqlsearch . " ORDER BY $order LIMIT " . (int)$limit);

	while ($firm = $sql->fetch())
	{
		$jj++;
		$t->assign(cot_generate_usertags($firm, 'FIRM_ROW_OWNER_'));
		$t->assign(cot_generate_firmtags($firm, 'FIRM_ROW_', $cfg['firms']['cat___default']['shorttextlen'], $usr['isadmin'],
										 $cfg['homebreadcrumb']));

		$t->assign(array(
			"FIRM_ROW_ODDEVEN" => cot_build_oddeven($jj),
		));
		$t->parse("MAIN.FIRM_ROW");
	}
	
	$t->assign(array(
		"TOTALITEMS" => $totalitems,
	));

	$t->parse("MAIN");
	return $t->text('MAIN');
}