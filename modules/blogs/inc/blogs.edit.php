<?php
/**
 * Edit blogs.
 *
 * @package blogs
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forms');
global $db;

$id = cot_import('id', 'G', 'INT');
$c = cot_import('c', 'G', 'TXT');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('blogs', 'any');

/* === Hook === */
foreach (cot_getextplugins('blogs.edit.first') as $pl)
{
	include $pl;
}
/* ===== */

cot_block($usr['auth_read']);

if (!$id || $id < 0)
{
	cot_die_message(404);
}
$sql_blogs = $db->query("SELECT * FROM $db_blogs WHERE post_id=$id LIMIT 1");
if($sql_blogs->rowCount() == 0)
{
	cot_die_message(404);
}
$row_post = $sql_blogs->fetch();

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('blogs', $row_post['post_cat']);

$parser_list = cot_get_parsers();
$sys['parser'] = $row_post['post_parser'];

if ($a == 'update')
{
	/* === Hook === */
	foreach (cot_getextplugins('blogs.edit.update.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_block($usr['isadmin'] || $usr['auth_write'] && $usr['id'] == $row_post['post_ownerid']);

	$rpost = cot_blogs_import('POST', $row_post, $usr);

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$rpostdelete = cot_import('rpostdelete', 'P', 'BOL');
	}
	else
	{
		$rpostdelete = cot_import('delete', 'G', 'BOL');
		cot_check_xg();
	}

	if ($rpostdelete)
	{
		cot_blogs_delete($id, $row_post);
		cot_redirect(cot_url('blogs', "c=" . $row_post['post_cat'], '', true));
	}

	/* === Hook === */
	foreach (cot_getextplugins('blogs.edit.update.import') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_blogs_validate($rpost);

	/* === Hook === */
	foreach (cot_getextplugins('blogs.edit.update.error') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!cot_error_found())
	{
		cot_blogs_update($id, $rpost);

		
		
		foreach ($_POST['mavatar_enabled'] as $key => $value) {
		
			
			if(!$value){

				$query = $db->query("SELECT * FROM cot_mavatars WHERE mav_id = '".$db->prep($key) ."' LIMIT 1");
				$res = $query->fetch();
				
				$file =$res['mav_filepath'].$res['mav_fileorigname'].'.'.$res['mav_fileext'];
				$db->delete('cot_mavatars', "mav_id=".$res['mav_id']);
				
				if (file_exists($file) && is_writable($file))
				{
					
					@unlink($file);
				}
				
	      
			}
		}
	

		

		switch ($rpost['post_state'])
		{
			case 0:
				$urlparams = empty($rpost['post_alias']) ?
					array('c' => $rpost['post_cat'], 'id' => $id) :
					array('c' => $rpost['post_cat'], 'al' => $rpost['post_alias']);
				$r_url = cot_url('blogs', $urlparams, '', true);
				break;
			case 1:
				$r_url = cot_url('message', 'msg=300', '', true);
				break;
			case 2:
				cot_message($L['post_savedasdraft']);
				$r_url = cot_url('blogs', 'm=edit&id=' . $id, '', true);
				break;
		}
		cot_redirect($r_url);
	}
	else
	{
		cot_redirect(cot_url('blogs', "m=edit&id=$id", '', true));
	}
}

$post = $row_post;

$post['post_status'] = cot_blogs_status($post['post_state']);

cot_block($usr['isadmin'] || $usr['auth_write'] && $usr['id'] == $post['post_ownerid']);

$out['subtitle'] = $L['post_edittitle'];
$out['head'] .= $R['code_noindex'];
$sys['sublocation'] = $structure['blogs'][$post['post_cat']]['title'];

$mskin = cot_tplfile(array('blogs', 'edit', $structure['blogs'][$post['post_cat']]['tpl']));

/* === Hook === */
foreach (cot_getextplugins('blogs.edit.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'].'/header.php';
$t = new XTemplate($mskin);

$blogsedit_array = array(
	'POSTEDIT_FIRMTITLE' => $L['post_edittitle'],
	'POSTEDIT_SUBTITLE' => $L['post_editsubtitle'],
	'POSTEDIT_FORM_SEND' => cot_url('blogs', "m=edit&a=update&id=".$post['post_id']),
	'POSTEDIT_FORM_ID' => $post['post_id'],
	'POSTEDIT_FORM_STATE' => $post['post_state'],
	'POSTEDIT_FORM_STATUS' => $post['post_status'],
	'POSTEDIT_FORM_LOCALSTATUS' => $L['post_status_'.$post['post_status']],
	'POSTEDIT_FORM_CAT' => cot_selectbox_structure('blogs', $post['post_cat'], 'rpostcat'),
	'POSTEDIT_FORM_CAT_SHORT' => cot_selectbox_structure('blogs', $post['post_cat'], 'rpostcat', $c),
	'POSTEDIT_FORM_KEYWORDS' => cot_inputbox('text', 'rpostkeywords', $post['post_keywords'], array('size' => '32', 'maxlength' => '255')),
	'POSTEDIT_FORM_METATITLE' => cot_inputbox('text', 'rpostmetatitle', $post['post_metatitle'], array('size' => '64', 'maxlength' => '255')),
	'POSTEDIT_FORM_METADESC' => cot_textarea('rpostmetadesc', $post['post_metadesc'], 2, 64, array('maxlength' => '255')),
	'POSTEDIT_FORM_ALIAS' => cot_inputbox('text', 'rpostalias', $post['post_alias'], array('size' => '32', 'maxlength' => '255')),
	'POSTEDIT_FORM_TITLE' => cot_inputbox('text', 'rposttitle', $post['post_title'], array('size' => '64', 'maxlength' => '255')),
	'POSTEDIT_FORM_DESC' => cot_textarea('rpostdesc', $post['post_desc'], 2, 64, '', 'input_textarea_editor'),
	'POSTEDIT_FORM_DATE' => cot_selectbox_date($post['post_date'], 'long', 'rpostdate').' '.$usr['timetext'],
	'POSTEDIT_FORM_DATENOW' => cot_checkbox(0, 'rpostdatenow'),
	'POSTEDIT_FORM_UPDATED' => cot_date('datetime_full', $post['post_updated']).' '.$usr['timetext'],
	'POSTEDIT_FORM_TEXT' => cot_textarea('rposttext', $post['post_text'], 12, 80, '', 'input_textarea_editor'),
	'POSTEDIT_FORM_DELETE' => cot_radiobox(0, 'rpostdelete', array(1, 0), array($L['Yes'], $L['No'])),
	'POSTEDIT_FORM_PARSER' => cot_selectbox($post['post_parser'], 'rpostparser', cot_get_parsers(), cot_get_parsers(), false),
);
if ($usr['isadmin'])
{
	$blogsedit_array += array(
		'POSTEDIT_FORM_OWNERID' => cot_inputbox('text', 'rpostownerid', $post['post_ownerid'], array('size' => '24', 'maxlength' => '24')),
		'POSTEDIT_FORM_POSTCOUNT' => cot_inputbox('text', 'rpostcount', $post['post_count'], array('size' => '8', 'maxlength' => '8')),
	);
}

$t->assign($blogsedit_array);

// Extra fields
foreach($cot_extrafields[$db_blogs] as $exfld)
{
	$uname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields('rpost'.$exfld['field_name'], $exfld, $post['post_'.$exfld['field_name']]);
	$exfld_title = isset($L['post_'.$exfld['field_name'].'_title']) ?  $L['post_'.$exfld['field_name'].'_title'] : $exfld['field_description'];

	$t->assign(array(
		'POSTEDIT_FORM_'.$uname => $exfld_val,
		'POSTEDIT_FORM_'.$uname.'_TITLE' => $exfld_title,
		'POSTEDIT_FORM_EXTRAFLD' => $exfld_val,
		'POSTEDIT_FORM_EXTRAFLD_TITLE' => $exfld_title
	));
	$t->parse('MAIN.EXTRAFLD');
}

if(cot_plugin_active('mavatars'))
{
	$mavatar = new mavatar('blogs', $rpost['post_cat'], $post['post_id']);
	//$mavatar->delete_all_mavatars();
	$t->assign('POSTEDIT_FORM_MAVATAR', $mavatar->generate_upload_form());
}

// Error and message handling
cot_display_messages($t);

/* === Hook === */
foreach (cot_getextplugins('blogs.edit.tags') as $pl)
{
	include $pl;
}
/* ===== */

if ($usr['isadmin'])
{
	if ($cfg['blogs']['autovalidatepost']) $usr_can_publish = TRUE;
	$t->parse('MAIN.ADMIN');
}

$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'].'/footer.php';
