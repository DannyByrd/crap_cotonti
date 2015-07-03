<?php
/**
 * Afisha API
 *
 * @package afisha
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

// Requirements
require_once cot_langfile('afisha', 'module');
require_once cot_incfile('afisha', 'module', 'resources');
require_once cot_incfile('forms');
require_once cot_incfile('extrafields');

// Tables and extras
cot::$db->registerTable('afisha');

cot_extrafields_register_table('afisha');

is_array(cot::$structure['afisha']) or cot::$structure['afisha'] = array();


function cot_build_structure_afisha_tree($c = '', $sub_cat = true, $allsublev = true, $custom_tpl = '', $col = 'all')
{
	global $cot_extrafields, $db_structure, $structure, $cfg, $db, $db_x, $sys;
	$t1 = new XTemplate(cot_tplfile(array('afisha', 'tree', $custom_tpl), 'module'));
	$kk = 0;


	if(!$sub_cat){
	  $c = '';
	 }
	$allsub = (empty($c)) ? cot_structure_children('afisha', '', $allsublev, false, true, false) : cot_structure_children('afisha', $c, $allsublev, false, true, false);
	$subcat = array_slice($allsub, $dc, $cfg['afisha']['maxlistsperpage']);
	
	/* === Hook - Part1 : Set === */
	$extp = cot_getextplugins('afisha.tree.rowcat.loop');
	/* ===== */
	foreach ($subcat as $x)
	{	
		$mtch = $structure['afisha'][$x]['path'].'.';
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

			$cat_childs = cot_structure_children('afisha', $cat);
			$sub_count = 0;
			foreach ($cat_childs as $cat_child)
			{
				$sub_count += (int)$structure['afisha'][$cat_child]['count'];
			}

			$sub_url_path = $list_url_path;
			$sub_url_path['c'] = $cat;
			$t1->assign(array(
				'LIST_ROWCAT_URL' => cot_url('afisha', $sub_url_path),
				'LIST_ROWCAT_TITLE' => $structure['afisha'][$cat]['title'],
				'LIST_ROWCAT_DESC' => $structure['afisha'][$cat]['desc'],
				'LIST_ROWCAT_ICON' => $structure['afisha'][$cat]['icon'],
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
					'LIST_ROWCAT_'.$uname => cot_build_extrafields_data('structure', $exfld, $structure['afisha'][$cat][$exfld['field_name']]),
					'LIST_ROWCAT_'.$uname.'_VALUE' => $structure['afisha'][$cat][$exfld['field_name']],
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
 * Builds afisha category path
 *
 * @param string $cat Category code
 * @param bool $afishalink Include afishas main link
 * @return array
 * @see cot_breadcrumbs()
 */
function cot_afisha_buildpath($cat, $afishalink = true)
{
	global $structure, $cfg, $L;
	$tmp = array();
	if ($afishalink)
	{
		$tmp[] = array(cot_url('afisha'), $L['Afisha']);
	}
	if(!empty($cat) && $cat != 'all')
	{	
		$pathcodes = explode('.', $structure['afisha'][$cat]['path']);
		foreach ($pathcodes as $k => $x)
		{
			$tmp[] = array(cot_url('afisha', 'c=' . $x), $structure['afisha'][$x]['title']);
		}
	}
	return $tmp;
}


/**
 * Returns all event tags for coTemplate
 *
 * @param mixed $event_data Adv Info Array or ID
 * @param string $tag_prefix Prefix for tags
 * @param int $textlength Text truncate
 * @param bool $admin_rights Adv Admin Rights
 * @param bool $afishapath_home Add home link for afisha path
 * @param string $emptytitle Adv title text if afisha does not exist
 * @return array
 * @global CotDB $db
 */
function cot_generate_eventtags($event_data, $tag_prefix = '', $textlength = 0, $admin_rights = null, $afishapath_home = false, $emptytitle = '')
{
	global $db, $cot_extrafields, $cfg, $L, $Ls, $R, $db_afisha, $usr, $sys, $cot_yesno, $structure, $db_structure;

	static $extp_first = null, $extp_main = null;
	static $pag_auth = array();

	if (is_null($extp_first))
	{
		$extp_first = cot_getextplugins('afishatags.first');
		$extp_main = cot_getextplugins('afishatags.main');
	}

	/* === Hook === */
	foreach ($extp_first as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!is_array($event_data))
	{
		$sql = $db->query("SELECT * FROM $db_afisha WHERE event_id = '" . (int) $event_data . "' LIMIT 1");
		$event_data = $sql->fetch();
	}

	if ($event_data['event_id'] > 0 && !empty($event_data['event_title']))
	{
		if (is_null($admin_rights))
		{
			if (!isset($pag_auth[$event_data['event_cat']]))
			{
				$pag_auth[$event_data['event_cat']] = cot_auth('afisha', $event_data['event_cat'], 'RWA1');
			}
			$admin_rights = (bool) $pag_auth[$event_data['event_cat']][2];
		}
		$afishapath = cot_afisha_buildpath($event_data['event_cat']);
		$catpath = cot_breadcrumbs($afishapath, $afishapath_home, true);
		$event_data['event_pageurl'] = (empty($event_data['event_alias'])) ? cot_url('afisha', 'c='.$event_data['event_cat'].'&id='.$event_data['event_id']) : cot_url('afisha', 'c='.$event_data['event_cat'].'&al='.$event_data['event_alias']);
		$event_link[] = array($event_data['event_pageurl'], $event_data['event_title']);
		$event_data['event_fulltitle'] = cot_breadcrumbs(array_merge($afishapath, $event_link), $afishapath_home);

		$date_format = 'datetime_medium';

		$text = cot_parse($event_data['event_text'], $cfg['afisha']['markup'], $event_data['event_parser']);
		$text_cut = ((int)$textlength > 0) ? cot_string_truncate($text, $textlength) : $text;
		$cutted = (mb_strlen($text) > mb_strlen($text_cut)) ? true : false;

		$cat_url = cot_url('afisha', 'c=' . $event_data['event_cat']);
		$validate_url = cot_url('admin', "m=afisha&a=validate&id={$event_data['event_id']}&x={$sys['xk']}");
		$unvalidate_url = cot_url('admin', "m=afisha&a=unvalidate&id={$event_data['event_id']}&x={$sys['xk']}");
		$edit_url = cot_url('afisha', "m=edit&id={$event_data['event_id']}");
		$delete_url = cot_url('afisha', "m=edit&a=update&delete=1&id={$event_data['event_id']}&x={$sys['xk']}");

		$event_data['event_status'] = cot_afisha_status(
			$event_data['event_state'],
			$event_data['event_expire']
		);

		$temp_array = array(
			'URL' => $event_data['event_pageurl'],
			'ID' => $event_data['event_id'],
			'TITLE' => $event_data['event_fulltitle'],
			'ALIAS' => $event_data['event_alias'],
			'STATE' => $event_data['event_state'],
			'STATUS' => $event_data['event_status'],
			'LOCALSTATUS' => $L['event_status_'.$event_data['event_status']],
			'SHORTTITLE' => htmlspecialchars($event_data['event_title'], ENT_COMPAT, 'UTF-8', false),
			'CAT' => $event_data['event_cat'],
			'CATURL' => $cat_url,
			'CATTITLE' => htmlspecialchars($structure['afisha'][$event_data['event_cat']]['title']),
			'CATPATH' => $catpath,
			'CATPATH_SHORT' => cot_rc_link($cat_url, htmlspecialchars($structure['afisha'][$event_data['event_cat']]['title'])),
			//'CATDESC' => htmlspecialchars($structure['afisha'][$event_data['event_cat']]['desc']),
			'CATDESC' => $structure['afisha'][$event_data['event_cat']]['desc'],
			'CATICON' => $structure['afisha'][$event_data['event_cat']]['icon'],
			'KEYWORDS' => htmlspecialchars($event_data['event_keywords']),
			'DESC' => $event_data['event_desc'],
			'TEXT' => $text,
			'TEXT_CUT' => $text_cut,
			'TEXT_IS_CUT' => $cutted,
			'DESC_OR_TEXT' => (!empty($event_data['event_desc'])) ? htmlspecialchars($event_data['event_desc']) : $text,
			'MORE' => ($cutted) ? cot_rc('event_more', array('event_url' => $event_data['event_pageurl'])) : '',
			'HIDEMAIL' => $event_data['event_hidemail'],
			'OWNERID' => $event_data['event_ownerid'],
			'OWNERNAME' => htmlspecialchars($event_data['user_name']),
			'DATE' => cot_date($date_format, $event_data['event_date']),
			'UPDATED' => cot_date($date_format, $event_data['event_updated']),
			'EXPIRE' => cot_date($date_format, $event_data['event_expire']),
			'DATE_STAMP' => $event_data['event_date'],
			'UPDATED_STAMP' => $event_data['event_updated'],
			'EXPIRE_STAMP' => $event_data['page_expire'],
			'COUNT' => $event_data['event_count'],
			'ADMIN' => $admin_rights ? cot_rc('list_row_admin', array('unvalidate_url' => $unvalidate_url, 'edit_url' => $edit_url)) : '',
		);

		// Admin tags
		if ($admin_rights)
		{
			$validate_confirm_url = cot_confirm_url($validate_url, 'afisha', 'event_confirm_validate');
			$unvalidate_confirm_url = cot_confirm_url($unvalidate_url, 'afisha', 'event_confirm_unvalidate');
			$delete_confirm_url = cot_confirm_url($delete_url, 'afisha', 'event_confirm_delete');
			$temp_array['ADMIN_EDIT'] = cot_rc_link($edit_url, $L['Edit']);
			$temp_array['ADMIN_EDIT_URL'] = $edit_url;
			$temp_array['ADMIN_UNVALIDATE'] = $event_data['event_state'] == 1 ?
				cot_rc_link($validate_confirm_url, $L['Validate'], 'class="confirmLink"') :
				cot_rc_link($unvalidate_confirm_url, $L['Putinvalidationqueue'], 'class="confirmLink"');
			$temp_array['ADMIN_UNVALIDATE_URL'] = $event_data['event_state'] == 1 ?
				$validate_confirm_url : $unvalidate_confirm_url;
			$temp_array['ADMIN_DELETE'] = cot_rc_link($delete_confirm_url, $L['Delete'], 'class="confirmLink"');
			$temp_array['ADMIN_DELETE_URL'] = $delete_confirm_url;
		}
		else if ($usr['id'] == $event_data['event_ownerid'])
		{
			$temp_array['ADMIN_EDIT'] = cot_rc_link($edit_url, $L['Edit']);
			$temp_array['ADMIN_EDIT_URL'] = $edit_url;
		}

		if (cot_auth('afisha', 'any', 'W'))
		{
			$clone_url = cot_url('afisha', "m=add&c={$event_data['event_cat']}&clone={$event_data['event_id']}");
			$temp_array['ADMIN_CLONE'] = cot_rc_link($clone_url, $L['event_clone']);
			$temp_array['ADMIN_CLONE_URL'] = $clone_url;
		}

		// Extrafields
		if (isset($cot_extrafields[$db_afisha]))
		{
			foreach ($cot_extrafields[$db_afisha] as $exfld)
			{
				$tag = mb_strtoupper($exfld['field_name']);
				$temp_array[$tag.'_TITLE'] = isset($L['event_'.$exfld['field_name'].'_title']) ?  $L['event_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
				$temp_array[$tag] = cot_build_extrafields_data('afisha', $exfld, $event_data['event_'.$exfld['field_name']], $event_data['event_parser']);
				$temp_array[$tag.'_VALUE'] = $event_data['event_'.$exfld['field_name']];
			}
		}

		// Extra fields for structure
		if (isset($cot_extrafields[$db_structure]))
		{
			foreach ($cot_extrafields[$db_structure] as $exfld)
			{
				$tag = mb_strtoupper($exfld['field_name']);
				$temp_array['CAT_'.$tag.'_TITLE'] = isset($L['structure_'.$exfld['field_name'].'_title']) ?  $L['structure_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
				$temp_array['CAT_'.$tag] = cot_build_extrafields_data('structure', $exfld, $structure['afisha'][$event_data['event_cat']][$exfld['field_name']]);
				$temp_array['CAT_'.$tag.'_VALUE'] = $structure['afisha'][$event_data['event_cat']][$exfld['field_name']];
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
function cot_afisha_config_order()
{
	global $cot_extrafields, $L, $db_afisha;

	$options_sort = array(
		'id' => $L['Id'],
		'type' => $L['Type'],
		'key' => $L['Key'],
		'title' => $L['Title'],
		'desc' => $L['Description'],
		'text' => $L['Body'],
		'ownerid' => $L['Owner'],
		'date' => $L['Date'],
		'update' => $L['Update'],
		'expire' => $L['Expire']
	);

	foreach($cot_extrafields[$db_afisha] as $exfld)
	{
		$options_sort[$exfld['field_name']] = isset($L['event_'.$exfld['field_name'].'_title']) ? $L['event_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
	}

	$L['cfg_order_params'] = array_values($options_sort);
	return array_keys($options_sort);
}

/**
 * Determines event status
 *
 * @param int $event_state
 * @return string 'draft', 'pending', 'published'
 */
function cot_afisha_status($event_state, $event_expire)
{
	global $sys;

	if ($event_state == 0)
	{
		if ($event_expire > 0 && $event_expire <= $sys['now'])
		{
			return 'expired';
		}
		return 'published';
	}
	elseif ($event_state == 2)
	{
		return 'draft';
	}
	return 'pending';
}

/**
 * Recalculates afisha category counters
 *
 * @param string $cat Cat code
 * @return int
 * @global CotDB $db
 */
function cot_afisha_sync($cat)
{
	global $db, $db_structure, $db_afisha, $cache, $sys;
	
	$parent = cot_structure_parents('afisha', $cat, 'first');
	$cats = cot_structure_children('afisha', $parent, true, true);
	foreach($cats as $c)
	{
		$subcats = cot_structure_children('afisha', $c, true, true);
		$count = $db->query("SELECT COUNT(*) FROM $db_afisha WHERE event_cat IN ('".implode("','", $subcats)."') AND event_state = 0 AND (event_expire = 0 OR event_expire > {$sys['now']})")->fetchColumn();		
		$db->query("UPDATE $db_structure SET structure_count=".(int)$count." WHERE structure_area='afisha' AND structure_code = ?", $c);
		$summcount += $count;
		if($cat == $c) $catcount = $count;
	}
	$cache && $cache->db->remove('structure', 'system');
	
	return $catcount;
}

/**
 * Update afisha category code
 *
 * @param string $oldcat Old Cat code
 * @param string $newcat New Cat code
 * @return bool
 * @global CotDB $db
 */
function cot_afisha_updatecat($oldcat, $newcat)
{
	global $db, $db_structure, $db_afisha;
	return (bool) $db->update($db_afisha, array("event_cat" => $newcat), "event_cat='".$db->prep($oldcat)."'");
}

/**
 * Returns permissions for a event category.
 * @param  string $cat Category code
 * @return array       Permissions array with keys: 'auth_read', 'auth_write', 'isadmin', 'auth_download'
 */
function cot_afisha_auth($cat = null)
{
	if (empty($cat))
	{
		$cat = 'any';
	}
	$auth = array();
	list($auth['auth_read'], $auth['auth_write'], $auth['isadmin'], $auth['auth_download']) = cot_auth('afisha', $cat, 'RWA1');
	return $auth;
}

/**
 * Imports event data from request parameters.
 * @param  string $source Source request method for parameters
 * @param  array  $revent  Existing event data from database
 * @param  array  $auth   Permissions array
 * @return array          Adv data
 */
function cot_afisha_import($source = 'POST', $revent = array(), $auth = array())
{
	global $cfg, $db_afisha, $cot_extrafields, $usr, $sys;

	if (count($auth) == 0)
	{
		$auth = cot_afisha_auth($revent['event_cat']);
	}

	if ($source == 'D' || $source == 'DIRECT')
	{
		// A trick so we don't have to affect every line below
		global $_PATCH;
		$_PATCH = $revent;
		$source = 'PATCH';
	}

	$revent['event_cat']      = cot_import('reventcat', $source, 'TXT');
	$revent['event_keywords'] = cot_import('reventkeywords', $source, 'TXT');
	$revent['event_alias']    = cot_import('reventalias', $source, 'TXT');
	$revent['event_title']    = cot_import('reventtitle', $source, 'TXT');
	$revent['event_desc']     = cot_import('reventdesc', $source, 'HTM');
	$revent['event_text']     = cot_import('reventtext', $source, 'HTM');
	$revent['event_parser']   = cot_import('reventparser', $source, 'ALP');
	
	$reventdatenow           = cot_import('reventdatenow', $source, 'BOL');
	$revent['event_date']     = cot_import_date('reventdate', true, false, $source);
	$revent['event_date']     = ($reventdatenow || is_null($revent['event_date'])) ? $sys['now'] : (int)$revent['event_date'];
	$revent['event_updated']  = $sys['now'];
	$revent['event_expire']   = (int)cot_import_date('reventexpire');
	$revent['event_expire']   = ($revent['event_expire'] <= $revent['event_begin']) ? 0 : $revent['event_expire'];

	$revent['event_keywords'] = cot_import('reventkeywords', $source, 'TXT');
	$revent['event_metatitle'] = cot_import('reventmetatitle', $source, 'TXT');
	$revent['event_metadesc'] = cot_import('reventmetadesc', $source, 'TXT');

	$rpublish               = cot_import('rpublish', $source, 'ALP'); // For backwards compatibility
	$revent['event_state']    = ($rpublish == 'OK') ? 0 : cot_import('reventtate', $source, 'INT');

	if ($auth['isadmin'] && isset($revent['event_ownerid']))
	{
		$revent['event_count']     = cot_import('reventcount', $source, 'INT');
		$revent['event_ownerid']   = cot_import('reventownerid', $source, 'INT');
	}
	else
	{
		$revent['event_ownerid'] = $usr['id'];
	}

	$parser_list = cot_get_parsers();

	if (empty($revent['event_parser']) || !in_array($revent['event_parser'], $parser_list) || $revent['event_parser'] != 'none' && !cot_auth('plug', $revent['event_parser'], 'W'))
	{
		$revent['event_parser'] = isset($sys['parser']) ? $sys['parser'] : $cfg['afisha']['parser'];
	}

	// Extra fields
	foreach ($cot_extrafields[$db_afisha] as $exfld)
	{
		$revent['event_'.$exfld['field_name']] = cot_import_extrafields('revent'.$exfld['field_name'], $exfld, $source, $revent['event_'.$exfld['field_name']]);
	}

	return $revent;
}

/**
 * Validates event data.
 * @param  array   $revent Imported event data
 * @return boolean        TRUE if validation is passed or FALSE if errors were found
 */
function cot_afisha_validate($revent)
{
	global $db, $db_users, $cfg, $structure, $usr;
	cot_check(empty($revent['event_cat']), 'event_catmissing', 'reventcat');
	if ($structure['afisha'][$revent['event_cat']]['locked'])
	{
		global $L;
		require_once cot_langfile('message', 'core');
		cot_error('msg602_body', 'reventcat');
	}
	cot_check(mb_strlen($revent['event_title']) < 2, 'event_titletooshort', 'reventtitle');

	cot_check(!empty($revent['event_alias']) && preg_match('`[+/?%#&]`', $revent['event_alias']), 'event_aliascharacters', 'reventalias');

	$allowemptyeventtext = isset($cfg['afisha']['cat_' . $revent['event_cat']]['allowemptyeventtext']) ?
							$cfg['afisha']['cat_' . $revent['event_cat']]['allowemptyeventtext'] : $cfg['afisha']['cat___default']['allowemptytext'];
	cot_check(!$allowemptyeventtext && empty($revent['event_text']), 'event_textmissing', 'reventtext');
	
	if (!empty($revent['event_cost']) && !is_numeric($revent['event_cost']))	cot_error('event_error_wrongcost', 'reventcost');
	
	//if (empty($revent['event_phone']))	cot_error('event_error_emptyphone', 'reventphone');
	
		
	if($usr['id'] == 0)
	{
		if (!cot_check_email($revent['event_email']))	cot_error('aut_emailtooshort', 'reventemail');
		$email_exists = (bool)$db->query("SELECT user_id FROM $db_users WHERE user_id!=".$usr['id']." AND user_email = ? LIMIT 1", array($revent['event_email']))->fetch();
		if ($email_exists) cot_error('aut_emailalreadyindb', 'reventemail');
	}
	else
	{
		if(!empty($revent['event_email']))
		{
			if (!cot_check_email($revent['event_email']))	cot_error('aut_emailtooshort', 'reventemail');
			$email_exists = (bool)$db->query("SELECT user_id FROM $db_users WHERE user_id!=".$usr['id']." AND user_email = ? LIMIT 1", array($revent['event_email']))->fetch();
			if ($email_exists) cot_error('aut_emailalreadyindb', 'reventemail');
		}
	}
	
	return !cot_error_found();
}

/**
 * Add a new event to the CMS.
 * @param  array   $revent Adv data
 * @param  array   $auth  Permissions array
 * @return integer        New afisha ID or FALSE on error
 */
function cot_afisha_add(&$revent, $auth = array())
{
	global $cache, $cfg, $db, $db_afisha, $db_structure, $structure, $L;
	if (cot_error_found())
	{
		return false;
	}

	if (count($auth) == 0)
	{
		$auth = cot_afisha_auth($revent['event_cat']);
	}

	if (!empty($revent['event_alias']))
	{
		$event_count = $db->query("SELECT COUNT(*) FROM $db_afisha WHERE event_alias = ? AND event_cat = ?", array($revent['event_alias'], $revent['event_cat']))->fetchColumn();
		if ($event_count > 0)
		{
			$revent['event_alias'] = $revent['event_alias'].rand(1000, 9999);
		}
	}

	if ($revent['event_state'] == 0)
	{
		if ($auth['isadmin'] && $cfg['afisha']['autovalidateevent'])
		{
			$db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_area='afisha' AND structure_code = ?", $revent['event_cat']);
			$cache && $cache->db->remove('structure', 'system');
		}
		else
		{
			$revent['event_state'] = 1;
		}
	}

	/* === Hook === */
	foreach (cot_getextplugins('afisha.add.add.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($db->insert($db_afisha, $revent))
	{
		$id = $db->lastInsertId();

		cot_extrafield_movefiles();
	}
	else
	{
		$id = false;
	}

	/* === Hook === */
	foreach (cot_getextplugins('afisha.add.add.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($revent['event_state'] == 0 && $cache)
	{
		if ($cfg['cache_afisha'])
		{
			$cache->afisha->clear('afisha/' . str_replace('.', '/', $structure['afisha'][$revent['event_cat']]['path']));
		}
		if ($cfg['cache_index'])
		{
			$cache->afisha->clear('index');
		}
	}
	cot_shield_update(30, "r afisha");
	cot_log("Add afisha #".$id, 'adm');

	return $id;
}

/**
 * Removes a event from the CMS.
 * @param  int     $id    Adv ID
 * @param  array   $revent event data
 * @return boolean        TRUE on success, FALSE on error
 */
function cot_afisha_delete($id, $revent = array())
{
	global $db, $db_afisha, $db_structure, $cache, $cfg, $cot_extrafields, $structure, $L;
	if (!is_numeric($id) || $id <= 0)
	{
		return false;
	}
	$id = (int)$id;
	if (count($revent) == 0)
	{
		$revent = $db->query("SELECT * FROM $db_afisha WHERE event_id = ?", $id)->fetch();
		if (!$revent)
		{
			return false;
		}
	}

	if ($revent['event_state'] == 0)
	{
		$db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE  structure_area='afisha' AND structure_code = ?", $revent['event_cat']);
	}

	foreach ($cot_extrafields[$db_afisha] as $exfld)
	{
		cot_extrafield_unlinkfiles($revent['event_' . $exfld['field_name']], $exfld);
	}

	$db->delete($db_afisha, "event_id = ?", $id);
	cot_log("Deleted afisha #" . $id, 'adm');

	/* === Hook === */
	foreach (cot_getextplugins('afisha.edit.delete.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($cache)
	{
		if ($cfg['cache_afisha'])
		{
			$cache->afisha->clear('afisha/' . str_replace('.', '/', $structure['afisha'][$revent['event_cat']]['path']));
		}
		if ($cfg['cache_index'])
		{
			$cache->afisha->clear('index');
		}
	}

	return true;
}

/**
 * Updates a event in the CMS.
 * @param  integer $id    Adv ID
 * @param  array   $revent Adv data
 * @param  array   $auth  Permissions array
 * @return boolean        TRUE on success, FALSE on error
 */
function cot_afisha_update($id, &$revent, $auth = array())
{
	global $cache, $cfg, $db, $db_afisha, $db_structure, $structure, $L;
	if (cot_error_found())
	{
		return false;
	}

	if (count($auth) == 0)
	{
		$auth = cot_afisha_auth($revent['event_cat']);
	}

	if (!empty($revent['event_alias']))
	{
		$event_count = $db->query("SELECT COUNT(*) FROM $db_afisha WHERE event_alias = ? AND event_id != ? AND event_cat = ?", array($revent['event_alias'], $id, $revent['event_cat']))->fetchColumn();
		if ($event_count > 0)
		{
			$revent['event_alias'] = $revent['event_alias'].rand(1000, 9999);
		}
	}

	$row_afisha = $db->query("SELECT * FROM $db_afisha WHERE event_id = ?", $id)->fetch();

	if ($row_afisha['event_cat'] != $revent['event_cat'] && $row_afisha['event_state'] == 0)
	{
		$db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code = ? AND structure_area = 'afisha'", $row_afisha['event_cat']);
	}

	//$usr['isadmin'] = cot_auth('afisha', $revent['event_cat'], 'A');
	if ($revent['event_state'] == 0)
	{
		if ($auth['isadmin'] && $cfg['afisha']['autovalidateevent'])
		{
			if ($row_afisha['event_state'] != 0 || $row_afisha['event_cat'] != $revent['event_cat'])
			{
				$db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code = ? AND structure_area = 'afisha'", $revent['event_cat']);
			}
		}
		else
		{
			$revent['event_state'] = 1;
		}
	}

	if ($revent['event_state'] != 0 && $row_afisha['event_state'] == 0)
	{
		$db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code = ?", $revent['event_cat']);
	}
	$cache && $cache->db->remove('structure', 'system');

	if (!$db->update($db_afisha, $revent, 'event_id = ?', $id))
	{
		return false;
	}

	cot_extrafield_movefiles();

	/* === Hook === */
	foreach (cot_getextplugins('afisha.edit.update.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (($revent['event_state'] == 0  || $revent['event_cat'] != $row_afisha['event_cat']) && $cache)
	{
		if ($cfg['cache_afisha'])
		{
			$cache->afisha->clear('afisha/' . str_replace('.', '/', $structure['afisha'][$revent['event_cat']]['path']));
			if ($revent['event_cat'] != $row_afisha['event_cat'])
			{
				$cache->afisha->clear('afisha/' . str_replace('.', '/', $structure['afisha'][$row_afisha['event_cat']]['path']));
			}
		}
		if ($cfg['cache_index'])
		{
			$cache->afisha->clear('index');
		}
	}

	return true;
}


function cot_afisha_list($limit, $c = '', $template = 'index', $sqlsearch = '', $order = "event_date DESC")
{
	global $db, $db_afisha, $db_users, $cfg;
	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('afisha', 'any', 'RWA');

	$t = new XTemplate(cot_tplfile(array('afisha', 'list', $template), 'module'));
	
	$sqlsearch = !empty($sqlsearch) ? "event_state=0 AND " . $sqlsearch : 'event_state=0';
	
	if(!empty($c))
	{
		$categories = implode("','", cot_structure_children('afisha', $c));
		$sqlsearch .= " AND event_cat IN ('$categories')";
	}
	
	$totalitems = $db->query("SELECT COUNT(*) FROM $db_afisha WHERE " . $sqlsearch)->fetchColumn();

	$sql = $db->query("SELECT * FROM $db_afisha AS b LEFT JOIN $db_users AS u ON u.user_id=b.event_ownerid 
	WHERE " . $sqlsearch . " ORDER BY $order LIMIT " . (int)$limit);

	while ($event = $sql->fetch())
	{
		$jj++;
		$t->assign(cot_generate_usertags($event, 'EVT_ROW_OWNER_'));
		$t->assign(cot_generate_eventtags($event, 'EVT_ROW_', $cfg['afisha']['cat___default']['truncateeventtext'], $usr['isadmin'],
										 $cfg['homebreadcrumb']));

		$t->assign(array(
			"EVT_ROW_ODDEVEN" => cot_build_oddeven($jj),
		));
		$t->parse("MAIN.EVT_ROW");
	}
	
	$t->assign(array(
		"TOTALITEMS" => $totalitems,
	));

	$t->parse("MAIN");
	return $t->text('MAIN');
}