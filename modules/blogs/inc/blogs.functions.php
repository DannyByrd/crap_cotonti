<?php
/**
 * Blogs API
 *
 * @package blogs
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

// Requirements
require_once cot_langfile('blogs', 'module');
require_once cot_incfile('blogs', 'module', 'resources');
require_once cot_incfile('forms');
require_once cot_incfile('extrafields');

// Tables and extras
cot::$db->registerTable('blogs');

cot_extrafields_register_table('blogs');

is_array(cot::$structure['blogs']) or cot::$structure['blogs'] = array();


function cot_build_structure_blogs_tree($c = '', $sub_cat = true, $allsublev = true, $custom_tpl = '',$col = 'all')
{
	global $cot_extrafields, $db_structure, $structure, $cfg, $db,  $db_x, $sys;
	$t1 = new XTemplate(cot_tplfile(array('blogs', 'tree', $custom_tpl), 'module'));
	
	$kk = 0;
	if(!$sub_cat){
	  $c = '';
	 }
	$allsub = (empty($c)) ? cot_structure_children('blogs', '', $allsublev, false, true, false) : cot_structure_children('blogs', $c, $allsublev, false, true, false);
	$subcat = array_slice($allsub, $dc, $cfg['blogs']['maxlistsperpage']);

	/* === Hook - Part1 : Set === */
	$extp = cot_getextplugins('blogs.tree.rowcat.loop');
	/* ===== */
	$colcount = floor(count($cats)/((int)$col + 1)) + 1;


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
		
		$mtch = $structure['blogs'][$x]['path'].'.';
		$mtchlen = mb_strlen($mtch);
		$mtchlvl = mb_substr_count($mtch,".");

		if(empty($c) && !$allsublev && $mtchlvl == 1 || !empty($c))
		{
			$cat_childs = cot_structure_children('blogs', $x);
			$sub_count = 0;
			foreach ($cat_childs as $cat_child)
			{
				$sub_count += (int)$structure['blogs'][$cat_child]['count'];
			}

			$sub_url_path = $list_url_path;
			$sub_url_path['c'] = $x;
			$t1->assign(array(
				'LIST_ROWCAT_URL' => cot_url('blogs', $sub_url_path),
				'LIST_ROWCAT_TITLE' => $structure['blogs'][$x]['title'],
				'LIST_ROWCAT_DESC' => $structure['blogs'][$x]['desc'],
				'LIST_ROWCAT_ICON' => $structure['blogs'][$x]['icon'],
				'LIST_ROWCAT_COUNT' => $sub_count,
				'LIST_ROWCAT_ODDEVEN' => cot_build_oddeven($kk),
				'LIST_ROWCAT_NUM' => $kk,
				'LIST_ROWCAT_COUNT_VIEW' =>$new_col,
				'LIST_ROWCAT_CATEGORY' => $cat,
			));

			// Extra fields for structure
			foreach ($cot_extrafields[$db_structure] as $exfld)
			{
				$uname = strtoupper($exfld['field_name']);
				$t1->assign(array(
					'LIST_ROWCAT_'.$uname.'_TITLE' => isset($L['structure_'.$exfld['field_name'].'_title']) ?  $L['structure_'.$exfld['field_name'].'_title'] : $exfld['field_description'],
					'LIST_ROWCAT_'.$uname => cot_build_extrafields_data('structure', $exfld, $structure['blogs'][$x][$exfld['field_name']]),
					'LIST_ROWCAT_'.$uname.'_VALUE' => $structure['blogs'][$x][$exfld['field_name']],
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
 * Builds blogs category path
 *
 * @param string $cat Category code
 * @param bool $blogslink Include blogss main link
 * @return array
 * @see cot_breadcrumbs()
 */
function cot_blogs_buildpath($cat, $blogslink = true)
{
	global $structure, $cfg, $L;
	$tmp = array();
	if ($blogslink)
	{
		$tmp[] = array(cot_url('blogs'), $L['Blogs']);
	}
	if(!empty($cat) && $cat != 'all')
	{	
		$pathcodes = explode('.', $structure['blogs'][$cat]['path']);
		foreach ($pathcodes as $k => $x)
		{
			$tmp[] = array(cot_url('blogs', 'c=' . $x), $structure['blogs'][$x]['title']);
		}
	}
	return $tmp;
}


/**
 * Returns all post tags for coTemplate
 *
 * @param mixed $post_data Adv Info Array or ID
 * @param string $tag_prefix Prefix for tags
 * @param int $textlength Text truncate
 * @param bool $admin_rights Adv Admin Rights
 * @param bool $blogspath_home Add home link for blogs path
 * @param string $emptytitle Adv title text if blogs does not exist
 * @return array
 * @global CotDB $db
 */
function cot_generate_blogposttags($post_data, $tag_prefix = '', $textlength = 0, $admin_rights = null, $blogspath_home = false, $emptytitle = '')
{
	global $db, $cot_extrafields, $cfg, $L, $Ls, $R, $db_blogs, $usr, $sys, $cot_yesno, $structure, $db_structure;

	static $extp_first = null, $extp_main = null;
	static $pag_auth = array();

	if (is_null($extp_first))
	{
		$extp_first = cot_getextplugins('blogstags.first');
		$extp_main = cot_getextplugins('blogstags.main');
	}

	/* === Hook === */
	foreach ($extp_first as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!is_array($post_data))
	{
		$sql = $db->query("SELECT * FROM $db_blogs WHERE post_id = '" . (int) $post_data . "' LIMIT 1");
		$post_data = $sql->fetch();
	}

	if ($post_data['post_id'] > 0 && !empty($post_data['post_title']))
	{
		if (is_null($admin_rights))
		{
			if (!isset($pag_auth[$post_data['post_cat']]))
			{
				$pag_auth[$post_data['post_cat']] = cot_auth('blogs', $post_data['post_cat'], 'RWA1');
			}
			$admin_rights = (bool) $pag_auth[$post_data['post_cat']][2];
		}
		$blogspath = cot_blogs_buildpath($post_data['post_cat']);
		$catpath = cot_breadcrumbs($blogspath, $blogspath_home);
		$post_data['post_pageurl'] = (empty($post_data['post_alias'])) ? cot_url('blogs', 'c='.$post_data['post_cat'].'&id='.$post_data['post_id']) : cot_url('blogs', 'c='.$post_data['post_cat'].'&al='.$post_data['post_alias']);
		$post_link[] = array($post_data['post_pageurl'], $post_data['post_title']);
		$post_data['post_fulltitle'] = cot_breadcrumbs(array_merge($blogspath, $post_link), $blogspath_home);

		$date_format = 'datetime_medium';

		$text = cot_parse($post_data['post_text'], $cfg['blogs']['markup'], $post_data['post_parser']);
		$text_cut = ((int)$textlength > 0) ? cot_string_truncate($text, $textlength) : $text;
		$cutted = (mb_strlen($text) > mb_strlen($text_cut)) ? true : false;

		$cat_url = cot_url('blogs', 'c=' . $post_data['post_cat']);
		$validate_url = cot_url('admin', "m=blogs&a=validate&id={$post_data['post_id']}&x={$sys['xk']}");
		$unvalidate_url = cot_url('admin', "m=blogs&a=unvalidate&id={$post_data['post_id']}&x={$sys['xk']}");
		$edit_url = cot_url('blogs', "m=edit&id={$post_data['post_id']}");
		$delete_url = cot_url('blogs', "m=edit&a=update&delete=1&id={$post_data['post_id']}&x={$sys['xk']}");

		$post_data['post_status'] = cot_blogs_status(
			$post_data['post_state']
		);

		
		

		$mavatar = new mavatar('blogs',$post_data['post_cat'], $post_data['post_id']);
		$mavatars_tags = $mavatar->generate_mavatars_tags();

		$temp_array = array(
			'URL' => $post_data['post_pageurl'],
			'ID' => $post_data['post_id'],
			'TITLE' => $post_data['post_fulltitle'],
			'ALIAS' => $post_data['post_alias'],
			'STATE' => $post_data['post_state'],
			'STATUS' => $post_data['post_status'],
			'LOCALSTATUS' => $L['post_status_'.$post_data['post_status']],
			'SHORTTITLE' => htmlspecialchars($post_data['post_title'], ENT_COMPAT, 'UTF-8', false),
			'CAT' => $post_data['post_cat'],
			'ICON' => $mavatars_tags,
			'CATURL' => $cat_url,
			'CATTITLE' => htmlspecialchars($structure['blogs'][$post_data['post_cat']]['title']),
			'CATPATH' => $catpath,
			'CATPATH_SHORT' => cot_rc_link($cat_url, htmlspecialchars($structure['blogs'][$post_data['post_cat']]['title'])),
			'CATDESC' => htmlspecialchars($structure['blogs'][$post_data['post_cat']]['desc']),
			'CATICON' => $structure['blogs'][$post_data['post_cat']]['icon'],
			'KEYWORDS' => htmlspecialchars($post_data['post_keywords']),
			'DESC' => $post_data['post_desc'],
			'TEXT' => $text,
			'TEXT_CUT' => $text_cut,
			'TEXT_IS_CUT' => $cutted,
			'DESC_OR_TEXT' => (!empty($post_data['post_desc'])) ? htmlspecialchars($post_data['post_desc']) : $text,
			'MORE' => ($cutted) ? cot_rc('post_more', array('post_url' => $post_data['post_pageurl'])) : '',
			'OWNERID' => $post_data['post_ownerid'],
			'OWNERNAME' => htmlspecialchars($post_data['user_name']),
			'DATE' => cot_date($date_format, $post_data['post_date']),
			'UPDATED' => cot_date($date_format, $post_data['post_updated']),
			'DATE_STAMP' => $post_data['post_date'],
			'UPDATED_STAMP' => $post_data['post_updated'],
			'COUNT' => $post_data['post_count'],
			'ADMIN' => $admin_rights ? cot_rc('list_row_admin', array('unvalidate_url' => $unvalidate_url, 'edit_url' => $edit_url)) : '',
		);

		// Admin tags
		if ($admin_rights)
		{
			$validate_confirm_url = cot_confirm_url($validate_url, 'blogs', 'post_confirm_validate');
			$unvalidate_confirm_url = cot_confirm_url($unvalidate_url, 'blogs', 'post_confirm_unvalidate');
			$delete_confirm_url = cot_confirm_url($delete_url, 'blogs', 'post_confirm_delete');
			$temp_array['ADMIN_EDIT'] = cot_rc_link($edit_url, $L['Edit']);
			$temp_array['ADMIN_EDIT_URL'] = $edit_url;
			$temp_array['ADMIN_UNVALIDATE'] = $post_data['post_state'] == 1 ?
				cot_rc_link($validate_confirm_url, $L['Validate'], 'class="confirmLink"') :
				cot_rc_link($unvalidate_confirm_url, $L['Putinvalidationqueue'], 'class="confirmLink"');
			$temp_array['ADMIN_UNVALIDATE_URL'] = $post_data['post_state'] == 1 ?
				$validate_confirm_url : $unvalidate_confirm_url;
			$temp_array['ADMIN_DELETE'] = cot_rc_link($delete_confirm_url, $L['Delete'], 'class="confirmLink"');
			$temp_array['ADMIN_DELETE_URL'] = $delete_confirm_url;
		}
		else if ($usr['id'] == $post_data['post_ownerid'])
		{
			$temp_array['ADMIN_EDIT'] = cot_rc_link($edit_url, $L['Edit']);
			$temp_array['ADMIN_EDIT_URL'] = $edit_url;
		}

		if (cot_auth('blogs', 'any', 'W'))
		{
			$clone_url = cot_url('blogs', "m=add&c={$post_data['post_cat']}&clone={$post_data['post_id']}");
			$temp_array['ADMIN_CLONE'] = cot_rc_link($clone_url, $L['post_clone']);
			$temp_array['ADMIN_CLONE_URL'] = $clone_url;
		}

		// Extrafields
		if (isset($cot_extrafields[$db_blogs]))
		{
			foreach ($cot_extrafields[$db_blogs] as $exfld)
			{
				$tag = mb_strtoupper($exfld['field_name']);
				$temp_array[$tag.'_TITLE'] = isset($L['post_'.$exfld['field_name'].'_title']) ?  $L['post_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
				$temp_array[$tag] = cot_build_extrafields_data('blogs', $exfld, $post_data['post_'.$exfld['field_name']], $post_data['post_parser']);
				$temp_array[$tag.'_VALUE'] = $post_data['post_'.$exfld['field_name']];
			}
		}

		// Extra fields for structure
		if (isset($cot_extrafields[$db_structure]))
		{
			foreach ($cot_extrafields[$db_structure] as $exfld)
			{
				$tag = mb_strtoupper($exfld['field_name']);
				$temp_array['CAT_'.$tag.'_TITLE'] = isset($L['structure_'.$exfld['field_name'].'_title']) ?  $L['structure_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
				$temp_array['CAT_'.$tag] = cot_build_extrafields_data('structure', $exfld, $structure['blogs'][$post_data['post_cat']][$exfld['field_name']]);
				$temp_array['CAT_'.$tag.'_VALUE'] = $structure['blogs'][$post_data['post_cat']][$exfld['field_name']];
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
function cot_blogs_config_order()
{
	global $cot_extrafields, $L, $db_blogs;

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

	foreach($cot_extrafields[$db_blogs] as $exfld)
	{
		$options_sort[$exfld['field_name']] = isset($L['post_'.$exfld['field_name'].'_title']) ? $L['post_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
	}

	$L['cfg_order_params'] = array_values($options_sort);
	return array_keys($options_sort);
}

/**
 * Determines post status
 *
 * @param int $post_state
 * @return string 'draft', 'pending', 'published'
 */
function cot_blogs_status($post_state)
{
	global $sys;

	if ($post_state == 0)
	{
		return 'published';
	}
	elseif ($post_state == 2)
	{
		return 'draft';
	}
	return 'pending';
}

/**
 * Recalculates blogs category counters
 *
 * @param string $cat Cat code
 * @return int
 * @global CotDB $db
 */
function cot_blogs_sync($cat)
{
	global $db, $db_structure, $db_blogs, $cache;
	
	$parent = cot_structure_parents('blogs', $cat, 'first');
	$cats = cot_structure_children('blogs', $parent, true, true);
	foreach($cats as $c)
	{
		$subcats = cot_structure_children('blogs', $c, true, true);
		$count = $db->query("SELECT COUNT(*) FROM $db_blogs WHERE post_cat IN ('".implode("','", $subcats)."') AND post_state = 0")->fetchColumn();		
		$db->query("UPDATE $db_structure SET structure_count=".(int)$count." WHERE structure_area='blogs' AND structure_code = ?", $c);
		$summcount += $count;
		if($cat == $c) $catcount = $count;
	}
	$cache && $cache->db->remove('structure', 'system');
	
	return $catcount;
}

/**
 * Update blogs category code
 *
 * @param string $oldcat Old Cat code
 * @param string $newcat New Cat code
 * @return bool
 * @global CotDB $db
 */
function cot_blogs_updatecat($oldcat, $newcat)
{
	global $db, $db_structure, $db_blogs;
	return (bool) $db->update($db_blogs, array("post_cat" => $newcat), "post_cat='".$db->prep($oldcat)."'");
}

/**
 * Returns permissions for a post category.
 * @param  string $cat Category code
 * @return array       Permissions array with keys: 'auth_read', 'auth_write', 'isadmin', 'auth_download'
 */
function cot_blogs_auth($cat = null)
{
	if (empty($cat))
	{
		$cat = 'any';
	}
	$auth = array();
	list($auth['auth_read'], $auth['auth_write'], $auth['isadmin'], $auth['auth_download']) = cot_auth('blogs', $cat, 'RWA1');
	return $auth;
}

/**
 * Imports post data from request parameters.
 * @param  string $source Source request method for parameters
 * @param  array  $rpost  Existing post data from database
 * @param  array  $auth   Permissions array
 * @return array          Adv data
 */
function cot_blogs_import($source = 'POST', $rpost = array(), $auth = array())
{
	global $cfg, $db_blogs, $cot_extrafields, $usr, $sys;

	if (count($auth) == 0)
	{
		$auth = cot_blogs_auth($rpost['post_cat']);
	}

	if ($source == 'D' || $source == 'DIRECT')
	{
		// A trick so we don't have to affect every line below
		global $_PATCH;
		$_PATCH = $rpost;
		$source = 'PATCH';
	}

	$rpost['post_cat']      = cot_import('rpostcat', $source, 'TXT');
	$rpost['post_keywords'] = cot_import('rpostkeywords', $source, 'TXT');
	$rpost['post_alias']    = cot_import('rpostalias', $source, 'TXT');
	$rpost['post_title']    = cot_import('rposttitle', $source, 'TXT');
	$rpost['post_desc']     = cot_import('rpostdesc', $source, 'HTM');
	$rpost['post_text']     = cot_import('rposttext', $source, 'HTM');
	$rpost['post_parser']   = cot_import('rpostparser', $source, 'ALP');
	
	$rpostdatenow           = cot_import('rpostdatenow', $source, 'BOL');
	$rpost['post_date']     = cot_import_date('rpostdate', true, false, $source);
	$rpost['post_date']     = ($rpostdatenow || is_null($rpost['post_date'])) ? $sys['now'] : (int)$rpost['post_date'];
	$rpost['post_updated']  = $sys['now'];

	$rpost['post_keywords'] = cot_import('rpostkeywords', $source, 'TXT');
	$rpost['post_metatitle'] = cot_import('rpostmetatitle', $source, 'TXT');
	$rpost['post_metadesc'] = cot_import('rpostmetadesc', $source, 'TXT');

	$rpublish               = cot_import('rpublish', $source, 'ALP'); // For backwards compatibility
	$rpost['post_state']    = ($rpublish == 'OK') ? 0 : cot_import('rposttate', $source, 'INT');

	if ($auth['isadmin'] && isset($rpost['post_ownerid']))
	{
		$rpost['post_count']     = cot_import('rpostcount', $source, 'INT');
		$rpost['post_ownerid']   = cot_import('rpostownerid', $source, 'INT');
	}
	else
	{
		$rpost['post_ownerid'] = $usr['id'];
	}

	$parser_list = cot_get_parsers();

	if (empty($rpost['post_parser']) || !in_array($rpost['post_parser'], $parser_list) || $rpost['post_parser'] != 'none' && !cot_auth('plug', $rpost['post_parser'], 'W'))
	{
		$rpost['post_parser'] = isset($sys['parser']) ? $sys['parser'] : $cfg['blogs']['parser'];
	}

	// Extra fields
	foreach ($cot_extrafields[$db_blogs] as $exfld)
	{
		$rpost['post_'.$exfld['field_name']] = cot_import_extrafields('rpost'.$exfld['field_name'], $exfld, $source, $rpost['post_'.$exfld['field_name']]);
	}

	return $rpost;
}

/**
 * Validates post data.
 * @param  array   $rpost Imported post data
 * @return boolean        TRUE if validation is passed or FALSE if errors were found
 */
function cot_blogs_validate($rpost)
{
	global $cfg, $structure;
	cot_check(empty($rpost['post_cat']), 'post_catmissing', 'rpostcat');
	if ($structure['blogs'][$rpost['post_cat']]['locked'])
	{
		global $L;
		require_once cot_langfile('message', 'core');
		cot_error('msg602_body', 'rpostcat');
	}
	cot_check(mb_strlen($rpost['post_title']) < 2, 'post_titletooshort', 'rposttitle');

	cot_check(!empty($rpost['post_alias']) && preg_match('`[+/?%#&]`', $rpost['post_alias']), 'post_aliascharacters', 'rpostalias');

	$allowemptyposttext = isset($cfg['blogs']['cat_' . $rpost['post_cat']]['allowemptyposttext']) ?
							$cfg['blogs']['cat_' . $rpost['post_cat']]['allowemptyposttext'] : $cfg['blogs']['cat___default']['allowemptytext'];
	cot_check(!$allowemptyposttext && empty($rpost['post_text']), 'post_textmissing', 'rposttext');
	
	return !cot_error_found();
}

/**
 * Adds a new post to the CMS.
 * @param  array   $rpost Adv data
 * @param  array   $auth  Permissions array
 * @return integer        New blogs ID or FALSE on error
 */
function cot_blogs_add(&$rpost, $auth = array())
{
	global $cache, $cfg, $db, $db_blogs, $db_structure, $structure, $L;
	if (cot_error_found())
	{
		return false;
	}

	if (count($auth) == 0)
	{
		$auth = cot_blogs_auth($rpost['post_cat']);
	}

	if (!empty($rpost['post_alias']))
	{
		$post_count = $db->query("SELECT COUNT(*) FROM $db_blogs WHERE post_alias = ? AND post_cat = ?", array($rpost['post_alias'],$rpost['post_cat']))->fetchColumn();
		if ($post_count > 0)
		{
			$rpost['post_alias'] = $rpost['post_alias'].rand(1000, 9999);
		}
	}

	if ($rpost['post_state'] == 0)
	{
		if ($auth['isadmin'] && $cfg['blogs']['autovalidatepost'])
		{
			$db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_area='blogs' AND structure_code = ?", $rpost['post_cat']);
			$cache && $cache->db->remove('structure', 'system');
		}
		else
		{
			$rpost['post_state'] = 1;
		}
	}

	/* === Hook === */
	foreach (cot_getextplugins('blogs.add.add.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($db->insert($db_blogs, $rpost))
	{
		$id = $db->lastInsertId();

		cot_extrafield_movefiles();
	}
	else
	{
		$id = false;
	}

	/* === Hook === */
	foreach (cot_getextplugins('blogs.add.add.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($rpost['post_state'] == 0 && $cache)
	{
		if ($cfg['cache_blogs'])
		{
			$cache->blogs->clear('blogs/' . str_replace('.', '/', $structure['blogs'][$rpost['post_cat']]['path']));
		}
		if ($cfg['cache_index'])
		{
			$cache->blogs->clear('index');
		}
	}
	cot_shield_update(30, "r blogs");
	cot_log("Add blogs #".$id, 'adm');

	return $id;
}

/**
 * Removes a post from the CMS.
 * @param  int     $id    Adv ID
 * @param  array   $rpost post data
 * @return boolean        TRUE on success, FALSE on error
 */
function cot_blogs_delete($id, $rpost = array())
{
	global $db, $db_blogs, $db_structure, $cache, $cfg, $cot_extrafields, $structure, $L;
	if (!is_numeric($id) || $id <= 0)
	{
		return false;
	}
	$id = (int)$id;
	if (count($rpost) == 0)
	{
		$rpost = $db->query("SELECT * FROM $db_blogs WHERE post_id = ?", $id)->fetch();
		if (!$rpost)
		{
			return false;
		}
	}

	if ($rpost['post_state'] == 0)
	{
		$db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE  structure_area='blogs' AND structure_code = ?", $rpost['post_cat']);
	}

	foreach ($cot_extrafields[$db_blogs] as $exfld)
	{
		cot_extrafield_unlinkfiles($rpost['post_' . $exfld['field_name']], $exfld);
	}

	$db->delete($db_blogs, "post_id = ?", $id);
	cot_log("Deleted blogs #" . $id, 'adm');

	/* === Hook === */
	foreach (cot_getextplugins('blogs.edit.delete.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($cache)
	{
		if ($cfg['cache_blogs'])
		{
			$cache->blogs->clear('blogs/' . str_replace('.', '/', $structure['blogs'][$rpost['post_cat']]['path']));
		}
		if ($cfg['cache_index'])
		{
			$cache->blogs->clear('index');
		}
	}

	return true;
}

/**
 * Updates a post in the CMS.
 * @param  integer $id    Adv ID
 * @param  array   $rpost Adv data
 * @param  array   $auth  Permissions array
 * @return boolean        TRUE on success, FALSE on error
 */
function cot_blogs_update($id, &$rpost, $auth = array())
{
	global $cache, $cfg, $db, $db_blogs, $db_structure, $structure, $L;
	if (cot_error_found())
	{
		return false;
	}

	if (count($auth) == 0)
	{
		$auth = cot_blogs_auth($rpost['post_cat']);
	}

	if (!empty($rpost['post_alias']))
	{
		$post_count = $db->query("SELECT COUNT(*) FROM $db_blogs WHERE post_alias = ? AND post_id != ? AND post_cat = ?", array($rpost['post_alias'], $id,$rpost['post_cat']))->fetchColumn();
		if ($post_count > 0)
		{
			$rpost['post_alias'] = $rpost['post_alias'].rand(1000, 9999);
		}
	}

	$row_blogs = $db->query("SELECT * FROM $db_blogs WHERE post_id = ?", $id)->fetch();

	if ($row_blogs['post_cat'] != $rpost['post_cat'] && $row_blogs['post_state'] == 0)
	{
		$db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code = ? AND structure_area = 'blogs'", $row_blogs['post_cat']);
	}

	//$usr['isadmin'] = cot_auth('blogs', $rpost['post_cat'], 'A');
	if ($rpost['post_state'] == 0)
	{
		if ($auth['isadmin'] && $cfg['blogs']['autovalidatepost'])
		{
			if ($row_blogs['post_state'] != 0 || $row_blogs['post_cat'] != $rpost['post_cat'])
			{
				$db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code = ? AND structure_area = 'blogs'", $rpost['post_cat']);
			}
		}
		else
		{
			$rpost['post_state'] = 1;
		}
	}

	if ($rpost['post_state'] != 0 && $row_blogs['post_state'] == 0)
	{
		$db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code = ?", $rpost['post_cat']);
	}
	$cache && $cache->db->remove('structure', 'system');

	if (!$db->update($db_blogs, $rpost, 'post_id = ?', $id))
	{
		return false;
	}

	cot_extrafield_movefiles();

	/* === Hook === */
	foreach (cot_getextplugins('blogs.edit.update.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (($rpost['post_state'] == 0  || $rpost['post_cat'] != $row_blogs['post_cat']) && $cache)
	{
		if ($cfg['cache_blogs'])
		{
			$cache->blogs->clear('blogs/' . str_replace('.', '/', $structure['blogs'][$rpost['post_cat']]['path']));
			if ($rpost['post_cat'] != $row_blogs['post_cat'])
			{
				$cache->blogs->clear('blogs/' . str_replace('.', '/', $structure['blogs'][$row_blogs['post_cat']]['path']));
			}
		}
		if ($cfg['cache_index'])
		{
			$cache->blogs->clear('index');
		}
	}

	return true;
}


function cot_blogs_list($limit, $c = '', $template = 'index', $sqlsearch = '', $order = "post_date DESC")
{
	global $db, $db_blogs, $db_users, $cfg;
	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('blogs', 'any', 'RWA');

	$t = new XTemplate(cot_tplfile(array('blogs', 'list', $template), 'module'));
	
	$sqlsearch = !empty($sqlsearch) ? "post_state=0 AND " . $sqlsearch : 'post_state=0';
	
	if(!empty($c))
	{
		$categories = implode("','", cot_structure_children('blogs', $c));
		$sqlsearch .= " AND post_cat IN ('$categories')";
	}
	
	$totalitems = $db->query("SELECT COUNT(*) FROM $db_blogs WHERE " . $sqlsearch)->fetchColumn();

	$sql = $db->query("SELECT * FROM $db_blogs AS b LEFT JOIN $db_users AS u ON u.user_id=b.post_ownerid 
	WHERE " . $sqlsearch . " ORDER BY $order LIMIT " . (int)$limit);

	while ($post = $sql->fetch())
	{
		$jj++;
		$t->assign(cot_generate_usertags($post, 'POST_ROW_OWNER_'));
		$t->assign(cot_generate_blogposttags($post, 'POST_ROW_', $cfg['blogs']['cat___default']['truncateposttext'], $usr['isadmin'],
										 $cfg['homebreadcrumb']));

		$t->assign(array(
			"POST_ROW_ODDEVEN" => cot_build_oddeven($jj),
		));
		$t->parse("MAIN.POST_ROW");
	}
	
	$t->assign(array(
		"TOTALITEMS" => $totalitems,
	));

	$t->parse("MAIN");
	return $t->text('MAIN');
}