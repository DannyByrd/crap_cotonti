<?php
/**
 * Board API
 *
 * @package board
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

// Requirements
require_once cot_langfile('board', 'module');
require_once cot_incfile('board', 'module', 'resources');
require_once cot_incfile('forms');
require_once cot_incfile('extrafields');

// Tables and extras
cot::$db->registerTable('board');

cot_extrafields_register_table('board');

is_array(cot::$structure['board']) or cot::$structure['board'] = array();

// добавил вывод категорий 

function cot_build_structure_board_tree($c = '', $allsublev = true, $custom_tpl = '', $col = 'all')
{
	global $cot_extrafields, $db_structure, $structure, $cfg, $db, $sys;
	$t1 = new XTemplate(cot_tplfile(array('board', 'tree', $custom_tpl), 'module'));
	
	$kk = 0;
	
	
	$allsub = (empty($c)) ? cot_structure_children('board', '', $allsublev, false, true, false,$new_col) : cot_structure_children('board', $c, $allsublev, false, true, false,$new_col);
	$subcat = array_slice($allsub, $dc, $cfg['board']['maxlistsperpage']);
	
	/* === Hook - Part1 : Set === */
	$extp = cot_getextplugins('board.tree.rowcat.loop');
	/* ===== */
	foreach ($subcat as $x)
	{	
		$mtch = $structure['board'][$x]['path'].'.';
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
			$kk++;

			$cat_childs = cot_structure_children('board', $cat);
			$sub_count = 0;
			foreach ($cat_childs as $cat_child)
			{
				$sub_count += (int)$structure['board'][$cat_child]['count'];
			}

			$sub_url_path = $list_url_path;
			$sub_url_path['c'] = $cat;
			$t1->assign(array(
				'LIST_ROWCAT_URL' => cot_url('board', $sub_url_path),
				'LIST_ROWCAT_TITLE' => $structure['board'][$cat]['title'],
				'LIST_ROWCAT_DESC' => $structure['board'][$cat]['desc'],
				'LIST_ROWCAT_ICON' => $structure['board'][$cat]['icon'],
				'LIST_ROWCAT_COUNT' => $sub_count,
				'LIST_ROWCAT_ODDEVEN' => cot_build_oddeven($kk),
				'LIST_ROWCAT_NUM' => $kk,
				'LIST_ROWCAT_COL' => ($kk % $colcount == 0) ? 1 : 0,
				'LIST_ROWCAT_COUNT_VIEW' =>$new_col
			));

			// Extra fields for structure
			foreach ($cot_extrafields[$db_structure] as $exfld)
			{
				$uname = strtoupper($exfld['field_name']);
				$t1->assign(array(
					'LIST_ROWCAT_'.$uname.'_TITLE' => isset($L['structure_'.$exfld['field_name'].'_title']) ?  $L['structure_'.$exfld['field_name'].'_title'] : $exfld['field_description'],
					'LIST_ROWCAT_'.$uname => cot_build_extrafields_data('structure', $exfld, $structure['board'][$cat][$exfld['field_name']]),
					'LIST_ROWCAT_'.$uname.'_VALUE' => $structure['board'][$cat][$exfld['field_name']],
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
 * Builds board category path
 *
 * @param string $cat Category code
 * @param bool $boardlink Include boards main link
 * @return array
 * @see cot_breadcrumbs()
 */
function cot_board_buildpath($cat, $boardlink = true)
{
	global $structure, $cfg, $L;
	$tmp = array();
	if ($boardlink)
	{
		$tmp[] = array(cot_url('board'), $L['Board']);
	}
	if(!empty($cat) && $cat != 'all')
	{	
		$pathcodes = explode('.', $structure['board'][$cat]['path']);
		foreach ($pathcodes as $k => $x)
		{
			$tmp[] = array(cot_url('board', 'c=' . $x), $structure['board'][$x]['title']);
		}
	}
	return $tmp;
}


/**
 * Returns all adv tags for coTemplate
 *
 * @param mixed $adv_data Adv Info Array or ID
 * @param string $tag_prefix Prefix for tags
 * @param int $textlength Text truncate
 * @param bool $admin_rights Adv Admin Rights
 * @param bool $boardpath_home Add home link for board path
 * @param string $emptytitle Adv title text if board does not exist
 * @return array
 * @global CotDB $db
 */
function cot_generate_advtags($adv_data, $tag_prefix = '', $textlength = 0, $admin_rights = null, $boardpath_home = false, $emptytitle = '')
{
	global $db, $cot_extrafields, $cfg, $L, $Ls, $R, $db_board, $usr, $sys, $cot_yesno, $structure, $db_structure;

	static $extp_first = null, $extp_main = null;
	static $pag_auth = array();

	if (is_null($extp_first))
	{
		$extp_first = cot_getextplugins('boardtags.first');
		$extp_main = cot_getextplugins('boardtags.main');
	}

	/* === Hook === */
	foreach ($extp_first as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!is_array($adv_data))
	{
		$sql = $db->query("SELECT * FROM $db_board WHERE adv_id = '" . (int) $adv_data . "' LIMIT 1");
		$adv_data = $sql->fetch();
	}

	if ($adv_data['adv_id'] > 0 && !empty($adv_data['adv_title']))
	{
		if (is_null($admin_rights))
		{
			if (!isset($pag_auth[$adv_data['adv_cat']]))
			{
				$pag_auth[$adv_data['adv_cat']] = cot_auth('board', $adv_data['adv_cat'], 'RWA1');
			}
			$admin_rights = (bool) $pag_auth[$adv_data['adv_cat']][2];
		}
		$boardpath = cot_board_buildpath($adv_data['adv_cat']);
		$catpath = cot_breadcrumbs($boardpath, $boardpath_home);
		$adv_data['adv_pageurl'] = (empty($adv_data['adv_alias'])) ? cot_url('board', 'c='.$adv_data['adv_cat'].'&id='.$adv_data['adv_id']) : cot_url('board', 'c='.$adv_data['adv_cat'].'&al='.$adv_data['adv_alias']);
		$adv_link[] = array($adv_data['adv_pageurl'], $adv_data['adv_title']);
		$adv_data['adv_fulltitle'] = cot_breadcrumbs(array_merge($boardpath, $adv_link), $boardpath_home);

		$date_format = 'datetime_medium';

		$text = cot_parse($adv_data['adv_text'], $cfg['board']['markup'], $adv_data['adv_parser']);
		$text_cut = ((int)$textlength > 0) ? cot_string_truncate($text, $textlength) : $text;
		$cutted = (mb_strlen($text) > mb_strlen($text_cut)) ? true : false;

		$cat_url = cot_url('board', 'c=' . $adv_data['adv_cat']);
		$validate_url = cot_url('admin', "m=board&a=validate&id={$adv_data['adv_id']}&x={$sys['xk']}");
		$unvalidate_url = cot_url('admin', "m=board&a=unvalidate&id={$adv_data['adv_id']}&x={$sys['xk']}");
		$edit_url = cot_url('board', "m=edit&id={$adv_data['adv_id']}");
		$delete_url = cot_url('board', "m=edit&a=update&delete=1&id={$adv_data['adv_id']}&x={$sys['xk']}");

		$adv_data['adv_status'] = cot_board_status(
			$adv_data['adv_state'],
			$adv_data['adv_expire']
		);

		$temp_array = array(
			'URL' => $adv_data['adv_pageurl'],
			'ID' => $adv_data['adv_id'],
			'TITLE' => $adv_data['adv_fulltitle'],
			'ALIAS' => $adv_data['adv_alias'],
			'STATE' => $adv_data['adv_state'],
			'STATUS' => $adv_data['adv_status'],
			'LOCALSTATUS' => $L['adv_status_'.$adv_data['adv_status']],
			'SHORTTITLE' => htmlspecialchars($adv_data['adv_title'], ENT_COMPAT, 'UTF-8', false),
			'CAT' => $adv_data['adv_cat'],
			'CATURL' => $cat_url,
			'CATTITLE' => htmlspecialchars($structure['board'][$adv_data['adv_cat']]['title']),
			'CATPATH' => $catpath,
			'CATPATH_SHORT' => cot_rc_link($cat_url, htmlspecialchars($structure['board'][$adv_data['adv_cat']]['title'])),
			'CATDESC' => htmlspecialchars($structure['board'][$adv_data['adv_cat']]['desc']),
			'CATICON' => $structure['board'][$adv_data['adv_cat']]['icon'],
			'KEYWORDS' => htmlspecialchars($adv_data['adv_keywords']),
			'DESC' => $adv_data['adv_desc'],
			'TEXT' => $text,
			'TEXT_CUT' => $text_cut,
			'TEXT_IS_CUT' => $cutted,
			'DESC_OR_TEXT' => (!empty($adv_data['adv_desc'])) ? htmlspecialchars($adv_data['adv_desc']) : $text,
			'MORE' => ($cutted) ? cot_rc('adv_more', array('adv_url' => $adv_data['adv_pageurl'])) : '',
			'ADDR' => htmlspecialchars($adv_data['adv_addr']),
			'PHONE' => htmlspecialchars($adv_data['adv_phone']),
			'SKYPE' => htmlspecialchars($adv_data['adv_skype']),
			'SITE' => htmlspecialchars($adv_data['adv_site']),
			'EMAIL' => htmlspecialchars($adv_data['adv_email']),
			'HIDEMAIL' => $adv_data['adv_hidemail'],
			'OWNERID' => $adv_data['adv_ownerid'],
			'OWNERNAME' => htmlspecialchars($adv_data['user_name']),
			'DATE' => cot_date($date_format, $adv_data['adv_date']),
			'UPDATED' => cot_date($date_format, $adv_data['adv_updated']),
			'EXPIRE' => cot_date($date_format, $adv_data['adv_expire']),
			'DATE_STAMP' => $adv_data['adv_date'],
			'UPDATED_STAMP' => $adv_data['adv_updated'],
			'EXPIRE_STAMP' => $adv_data['page_expire'],
			'COUNT' => $adv_data['adv_count'],
			'COST' => $adv_data['adv_cost'],
			'ADMIN' => $admin_rights ? cot_rc('list_row_admin', array('unvalidate_url' => $unvalidate_url, 'edit_url' => $edit_url)) : '',
		);

		// Admin tags
		if ($admin_rights)
		{
			$validate_confirm_url = cot_confirm_url($validate_url, 'board', 'adv_confirm_validate');
			$unvalidate_confirm_url = cot_confirm_url($unvalidate_url, 'board', 'adv_confirm_unvalidate');
			$delete_confirm_url = cot_confirm_url($delete_url, 'board', 'adv_confirm_delete');
			$temp_array['ADMIN_EDIT'] = cot_rc_link($edit_url, $L['Edit']);
			$temp_array['ADMIN_EDIT_URL'] = $edit_url;
			$temp_array['ADMIN_UNVALIDATE'] = $adv_data['adv_state'] == 1 ?
				cot_rc_link($validate_confirm_url, $L['Validate'], 'class="confirmLink"') :
				cot_rc_link($unvalidate_confirm_url, $L['Putinvalidationqueue'], 'class="confirmLink"');
			$temp_array['ADMIN_UNVALIDATE_URL'] = $adv_data['adv_state'] == 1 ?
				$validate_confirm_url : $unvalidate_confirm_url;
			$temp_array['ADMIN_DELETE'] = cot_rc_link($delete_confirm_url, $L['Delete'], 'class="confirmLink"');
			$temp_array['ADMIN_DELETE_URL'] = $delete_confirm_url;
		}
		else if ($usr['id'] == $adv_data['adv_ownerid'])
		{
			$temp_array['ADMIN_EDIT'] = cot_rc_link($edit_url, $L['Edit']);
			$temp_array['ADMIN_EDIT_URL'] = $edit_url;
		}

		if (cot_auth('board', 'any', 'W'))
		{
			$clone_url = cot_url('board', "m=add&c={$adv_data['adv_cat']}&clone={$adv_data['adv_id']}");
			$temp_array['ADMIN_CLONE'] = cot_rc_link($clone_url, $L['adv_clone']);
			$temp_array['ADMIN_CLONE_URL'] = $clone_url;
		}

		// Extrafields
		if (isset($cot_extrafields[$db_board]))
		{
			foreach ($cot_extrafields[$db_board] as $exfld)
			{
				$tag = mb_strtoupper($exfld['field_name']);
				$temp_array[$tag.'_TITLE'] = isset($L['adv_'.$exfld['field_name'].'_title']) ?  $L['adv_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
				$temp_array[$tag] = cot_build_extrafields_data('board', $exfld, $adv_data['adv_'.$exfld['field_name']], $adv_data['adv_parser']);
				$temp_array[$tag.'_VALUE'] = $adv_data['adv_'.$exfld['field_name']];
			}
		}

		// Extra fields for structure
		if (isset($cot_extrafields[$db_structure]))
		{
			foreach ($cot_extrafields[$db_structure] as $exfld)
			{
				$tag = mb_strtoupper($exfld['field_name']);
				$temp_array['CAT_'.$tag.'_TITLE'] = isset($L['structure_'.$exfld['field_name'].'_title']) ?  $L['structure_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
				$temp_array['CAT_'.$tag] = cot_build_extrafields_data('structure', $exfld, $structure['board'][$adv_data['adv_cat']][$exfld['field_name']]);
				$temp_array['CAT_'.$tag.'_VALUE'] = $structure['board'][$adv_data['adv_cat']][$exfld['field_name']];
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
function cot_board_config_order()
{
	global $cot_extrafields, $L, $db_board;

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

	foreach($cot_extrafields[$db_board] as $exfld)
	{
		$options_sort[$exfld['field_name']] = isset($L['adv_'.$exfld['field_name'].'_title']) ? $L['adv_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
	}

	$L['cfg_order_params'] = array_values($options_sort);
	return array_keys($options_sort);
}

/**
 * Determines adv status
 *
 * @param int $adv_state
 * @return string 'draft', 'pending', 'published'
 */
function cot_board_status($adv_state, $adv_expire)
{
	global $sys;

	if ($adv_state == 0)
	{
		if ($adv_expire > 0 && $adv_expire <= $sys['now'])
		{
			return 'expired';
		}
		return 'published';
	}
	elseif ($adv_state == 2)
	{
		return 'draft';
	}
	return 'pending';
}

/**
 * Recalculates board category counters
 *
 * @param string $cat Cat code
 * @return int
 * @global CotDB $db
 */
function cot_board_sync($cat)
{
	global $db, $db_structure, $db_board, $cache, $sys;
	
	$parent = cot_structure_parents('board', $cat, 'first');
	$cats = cot_structure_children('board', $parent, true, true);
	foreach($cats as $c)
	{
		$subcats = cot_structure_children('board', $c, true, true);
		$count = $db->query("SELECT COUNT(*) FROM $db_board WHERE adv_cat IN ('".implode("','", $subcats)."') AND adv_state = 0 AND (adv_expire = 0 OR adv_expire > {$sys['now']})")->fetchColumn();		
		$db->query("UPDATE $db_structure SET structure_count=".(int)$count." WHERE structure_area='board' AND structure_code = ?", $c);
		$summcount += $count;
		if($cat == $c) $catcount = $count;
	}
	$cache && $cache->db->remove('structure', 'system');
	
	return $catcount;
}

/**
 * Update board category code
 *
 * @param string $oldcat Old Cat code
 * @param string $newcat New Cat code
 * @return bool
 * @global CotDB $db
 */
function cot_board_updatecat($oldcat, $newcat)
{
	global $db, $db_structure, $db_board;
	return (bool) $db->update($db_board, array("adv_cat" => $newcat), "adv_cat='".$db->prep($oldcat)."'");
}

/**
 * Returns permissions for a adv category.
 * @param  string $cat Category code
 * @return array       Permissions array with keys: 'auth_read', 'auth_write', 'isadmin', 'auth_download'
 */
function cot_board_auth($cat = null)
{
	if (empty($cat))
	{
		$cat = 'any';
	}
	$auth = array();
	list($auth['auth_read'], $auth['auth_write'], $auth['isadmin'], $auth['auth_download']) = cot_auth('board', $cat, 'RWA1');
	return $auth;
}

/**
 * Imports adv data from request parameters.
 * @param  string $source Source request method for parameters
 * @param  array  $radv  Existing adv data from database
 * @param  array  $auth   Permissions array
 * @return array          Adv data
 */
function cot_board_import($source = 'POST', $radv = array(), $auth = array())
{
	global $cfg, $db_board, $cot_extrafields, $usr, $sys;

	if (count($auth) == 0)
	{
		$auth = cot_board_auth($radv['adv_cat']);
	}

	if ($source == 'D' || $source == 'DIRECT')
	{
		// A trick so we don't have to affect every line below
		global $_PATCH;
		$_PATCH = $radv;
		$source = 'PATCH';
	}

	$radv['adv_cat']      = cot_import('radvcat', $source, 'TXT');
	$radv['adv_keywords'] = cot_import('radvkeywords', $source, 'TXT');
	$radv['adv_alias']    = cot_import('radvalias', $source, 'TXT');
	$radv['adv_title']    = cot_import('radvtitle', $source, 'TXT');
	$radv['adv_desc']     = cot_import('radvdesc', $source, 'HTM');
	$radv['adv_text']     = cot_import('radvtext', $source, 'HTM');
	$radv['adv_parser']   = cot_import('radvparser', $source, 'ALP');
	
	$radv['adv_cost']   = cot_import('radvcost', $source, 'TXT');
	$radv['adv_addr']    = cot_import('radvaddr', $source, 'TXT');
	$radv['adv_phone']    = cot_import('radvphone', $source, 'TXT');
	$radv['adv_skype']    = cot_import('radvskype', $source, 'TXT');
	$radv['adv_site']    = cot_import('radvsite', $source, 'TXT');
	$radv['adv_email']    = cot_import('radvemail', $source, 'TXT',64, TRUE);
	$radv['adv_hidemail']    = cot_import('radvhidemail', $source, 'INT');
	
	$radvdatenow           = cot_import('radvdatenow', $source, 'BOL');
	$radv['adv_date']     = cot_import_date('radvdate', true, false, $source);
	$radv['adv_date']     = ($radvdatenow || is_null($radv['adv_date'])) ? $sys['now'] : (int)$radv['adv_date'];
	$radv['adv_updated']  = $sys['now'];
	$radv['adv_expire']   = (int)cot_import_date('radvexpire');
	$radv['adv_expire']   = ($radv['adv_expire'] <= $radv['adv_begin']) ? 0 : $radv['adv_expire'];

	$radv['adv_keywords'] = cot_import('radvkeywords', $source, 'TXT');
	$radv['adv_metatitle'] = cot_import('radvmetatitle', $source, 'TXT');
	$radv['adv_metadesc'] = cot_import('radvmetadesc', $source, 'TXT');

	$rpublish               = cot_import('rpublish', $source, 'ALP'); // For backwards compatibility
	$radv['adv_state']    = ($rpublish == 'OK') ? 0 : cot_import('radvtate', $source, 'INT');

	if ($auth['isadmin'] && isset($radv['adv_ownerid']))
	{
		$radv['adv_count']     = cot_import('radvcount', $source, 'INT');
		$radv['adv_ownerid']   = cot_import('radvownerid', $source, 'INT');
	}
	else
	{
		$radv['adv_ownerid'] = $usr['id'];
	}

	$parser_list = cot_get_parsers();

	if (empty($radv['adv_parser']) || !in_array($radv['adv_parser'], $parser_list) || $radv['adv_parser'] != 'none' && !cot_auth('plug', $radv['adv_parser'], 'W'))
	{
		$radv['adv_parser'] = isset($sys['parser']) ? $sys['parser'] : $cfg['board']['parser'];
	}

	// Extra fields
	foreach ($cot_extrafields[$db_board] as $exfld)
	{
		$radv['adv_'.$exfld['field_name']] = cot_import_extrafields('radv'.$exfld['field_name'], $exfld, $source, $radv['adv_'.$exfld['field_name']]);
	}

	return $radv;
}

/**
 * Validates adv data.
 * @param  array   $radv Imported adv data
 * @return boolean        TRUE if validation is passed or FALSE if errors were found
 */
function cot_board_validate($radv)
{
	global $db, $db_users, $cfg, $structure, $usr;
	cot_check(empty($radv['adv_cat']), 'adv_catmissing', 'radvcat');
	if ($structure['board'][$radv['adv_cat']]['locked'])
	{
		global $L;
		require_once cot_langfile('message', 'core');
		cot_error('msg602_body', 'radvcat');
	}
	cot_check(mb_strlen($radv['adv_title']) < 2, 'adv_titletooshort', 'radvtitle');

	cot_check(!empty($radv['adv_alias']) && preg_match('`[+/?%#&]`', $radv['adv_alias']), 'adv_aliascharacters', 'radvalias');

	$allowemptyadvtext = isset($cfg['board']['cat_' . $radv['adv_cat']]['allowemptyadvtext']) ?
							$cfg['board']['cat_' . $radv['adv_cat']]['allowemptyadvtext'] : $cfg['board']['cat___default']['allowemptytext'];
	cot_check(!$allowemptyadvtext && empty($radv['adv_text']), 'adv_textmissing', 'radvtext');
	
	if (!empty($radv['adv_cost']) && !is_numeric($radv['adv_cost']))	cot_error('adv_error_wrongcost', 'radvcost');
	
	//if (empty($radv['adv_phone']))	cot_error('adv_error_emptyphone', 'radvphone');
	
		
	if($usr['id'] == 0)
	{
		if (!cot_check_email($radv['adv_email']))	cot_error('aut_emailtooshort', 'radvemail');
		$email_exists = (bool)$db->query("SELECT user_id FROM $db_users WHERE user_id!=".$usr['id']." AND user_email = ? LIMIT 1", array($radv['adv_email']))->fetch();
		if ($email_exists) cot_error('aut_emailalreadyindb', 'radvemail');
	}
	else
	{
		if(!empty($radv['adv_email']))
		{
			if (!cot_check_email($radv['adv_email']))	cot_error('aut_emailtooshort', 'radvemail');
			$email_exists = (bool)$db->query("SELECT user_id FROM $db_users WHERE user_id!=".$usr['id']." AND user_email = ? LIMIT 1", array($radv['adv_email']))->fetch();
			if ($email_exists) cot_error('aut_emailalreadyindb', 'radvemail');
		}
	}
	
	return !cot_error_found();
}

/**
 * Adds a new adv to the CMS.
 * @param  array   $radv Adv data
 * @param  array   $auth  Permissions array
 * @return integer        New board ID or FALSE on error
 */
function cot_board_add(&$radv, $auth = array())
{
	global $cache, $cfg, $db, $db_board, $db_structure, $structure, $L;
	if (cot_error_found())
	{
		return false;
	}

	if (count($auth) == 0)
	{
		$auth = cot_board_auth($radv['adv_cat']);
	}

	if (!empty($radv['adv_alias']))
	{
		$adv_count = $db->query("SELECT COUNT(*) FROM $db_board WHERE adv_alias = ?", $radv['adv_alias'])->fetchColumn();
		if ($adv_count > 0)
		{
			$radv['adv_alias'] = $radv['adv_alias'].rand(1000, 9999);
		}
	}

	if ($radv['adv_state'] == 0)
	{
		if ($auth['isadmin'] && $cfg['board']['autovalidateadv'])
		{
			$db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_area='board' AND structure_code = ?", $radv['adv_cat']);
			$cache && $cache->db->remove('structure', 'system');
		}
		else
		{
			$radv['adv_state'] = 1;
		}
	}

	/* === Hook === */
	foreach (cot_getextplugins('board.add.add.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($db->insert($db_board, $radv))
	{
		$id = $db->lastInsertId();

		cot_extrafield_movefiles();
	}
	else
	{
		$id = false;
	}

	/* === Hook === */
	foreach (cot_getextplugins('board.add.add.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($radv['adv_state'] == 0 && $cache)
	{
		if ($cfg['cache_board'])
		{
			$cache->board->clear('board/' . str_replace('.', '/', $structure['board'][$radv['adv_cat']]['path']));
		}
		if ($cfg['cache_index'])
		{
			$cache->board->clear('index');
		}
	}
	cot_shield_update(30, "r board");
	cot_log("Add board #".$id, 'adm');

	return $id;
}

/**
 * Removes a adv from the CMS.
 * @param  int     $id    Adv ID
 * @param  array   $radv adv data
 * @return boolean        TRUE on success, FALSE on error
 */
function cot_board_delete($id, $radv = array())
{
	global $db, $db_board, $db_structure, $cache, $cfg, $cot_extrafields, $structure, $L;
	if (!is_numeric($id) || $id <= 0)
	{
		return false;
	}
	$id = (int)$id;
	if (count($radv) == 0)
	{
		$radv = $db->query("SELECT * FROM $db_board WHERE adv_id = ?", $id)->fetch();
		if (!$radv)
		{
			return false;
		}
	}

	if ($radv['adv_state'] == 0)
	{
		$db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE  structure_area='board' AND structure_code = ?", $radv['adv_cat']);
	}

	foreach ($cot_extrafields[$db_board] as $exfld)
	{
		cot_extrafield_unlinkfiles($radv['adv_' . $exfld['field_name']], $exfld);
	}

	$db->delete($db_board, "adv_id = ?", $id);
	cot_log("Deleted board #" . $id, 'adm');

	/* === Hook === */
	foreach (cot_getextplugins('board.edit.delete.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($cache)
	{
		if ($cfg['cache_board'])
		{
			$cache->board->clear('board/' . str_replace('.', '/', $structure['board'][$radv['adv_cat']]['path']));
		}
		if ($cfg['cache_index'])
		{
			$cache->board->clear('index');
		}
	}

	return true;
}

/**
 * Updates a adv in the CMS.
 * @param  integer $id    Adv ID
 * @param  array   $radv Adv data
 * @param  array   $auth  Permissions array
 * @return boolean        TRUE on success, FALSE on error
 */
function cot_board_update($id, &$radv, $auth = array())
{
	global $cache, $cfg, $db, $db_board, $db_structure, $structure, $L;
	if (cot_error_found())
	{
		return false;
	}

	if (count($auth) == 0)
	{
		$auth = cot_board_auth($radv['adv_cat']);
	}

	if (!empty($radv['adv_alias']))
	{
		$adv_count = $db->query("SELECT COUNT(*) FROM $db_board WHERE adv_alias = ? AND adv_id != ?", array($radv['adv_alias'], $id))->fetchColumn();
		if ($adv_count > 0)
		{
			$radv['adv_alias'] = $radv['adv_alias'].rand(1000, 9999);
		}
	}

	$row_board = $db->query("SELECT * FROM $db_board WHERE adv_id = ?", $id)->fetch();

	if ($row_board['adv_cat'] != $radv['adv_cat'] && $row_board['adv_state'] == 0)
	{
		$db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code = ? AND structure_area = 'board'", $row_board['adv_cat']);
	}

	//$usr['isadmin'] = cot_auth('board', $radv['adv_cat'], 'A');
	if ($radv['adv_state'] == 0)
	{
		if ($auth['isadmin'] && $cfg['board']['autovalidateadv'])
		{
			if ($row_board['adv_state'] != 0 || $row_board['adv_cat'] != $radv['adv_cat'])
			{
				$db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code = ? AND structure_area = 'board'", $radv['adv_cat']);
			}
		}
		else
		{
			$radv['adv_state'] = 1;
		}
	}

	if ($radv['adv_state'] != 0 && $row_board['adv_state'] == 0)
	{
		$db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code = ?", $radv['adv_cat']);
	}
	$cache && $cache->db->remove('structure', 'system');

	if (!$db->update($db_board, $radv, 'adv_id = ?', $id))
	{
		return false;
	}

	cot_extrafield_movefiles();

	/* === Hook === */
	foreach (cot_getextplugins('board.edit.update.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (($radv['adv_state'] == 0  || $radv['adv_cat'] != $row_board['adv_cat']) && $cache)
	{
		if ($cfg['cache_board'])
		{
			$cache->board->clear('board/' . str_replace('.', '/', $structure['board'][$radv['adv_cat']]['path']));
			if ($radv['adv_cat'] != $row_board['adv_cat'])
			{
				$cache->board->clear('board/' . str_replace('.', '/', $structure['board'][$row_board['adv_cat']]['path']));
			}
		}
		if ($cfg['cache_index'])
		{
			$cache->board->clear('index');
		}
	}

	return true;
}


function cot_board_list($limit, $c = '', $template = 'index', $sqlsearch = '', $order = "adv_date DESC")
{
	global $db, $db_board, $db_users, $cfg;
	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('board', 'any', 'RWA');

	$t = new XTemplate(cot_tplfile(array('board', 'list', $template), 'module'));
	
	$sqlsearch = !empty($sqlsearch) ? "adv_state=0 AND " . $sqlsearch : 'adv_state=0';
	
	if(!empty($c))
	{
		$categories = implode("','", cot_structure_children('board', $c));
		$sqlsearch .= " AND adv_cat IN ('$categories')";
	}
	
	$totalitems = $db->query("SELECT COUNT(*) FROM $db_board WHERE " . $sqlsearch)->fetchColumn();

	$sql = $db->query("SELECT * FROM $db_board AS b LEFT JOIN $db_users AS u ON u.user_id=b.adv_ownerid 
	WHERE " . $sqlsearch . " ORDER BY $order LIMIT " . (int)$limit);

	while ($adv = $sql->fetch())
	{
		$jj++;
		$t->assign(cot_generate_usertags($adv, 'ADV_ROW_OWNER_'));
		$t->assign(cot_generate_advtags($adv, 'ADV_ROW_', $cfg['board']['cat___default']['truncateadvtext'], $usr['isadmin'],
										 $cfg['homebreadcrumb']));

		$t->assign(array(
			"ADV_ROW_ODDEVEN" => cot_build_oddeven($jj),
		));
		$t->parse("MAIN.ADV_ROW");
	}
	
	$t->assign(array(
		"TOTALITEMS" => $totalitems,
	));

	$t->parse("MAIN");
	return $t->text('MAIN');
}