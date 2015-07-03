<?php
/**
 * Add post.
 *
 * @package blogs
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forms');

$id = cot_import('id', 'G', 'INT');
$c = cot_import('c', 'G', 'TXT');

if (!empty($c) && !isset($structure['blogs'][$c]))
{
	$c = '';
}

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('blogs', 'any');

/* === Hook === */
foreach (cot_getextplugins('blogs.add.first') as $pl)
{
	include $pl;
}
/* ===== */
cot_block($usr['auth_write']);

if ($structure['blogs'][$c]['locked'])
{
	cot_die_message(602, TRUE);
}

$sys['parser'] = $cfg['blogs']['parser'];
$parser_list = cot_get_parsers();

if ($a == 'add')
{
	cot_shield_protect();

	/* === Hook === */
	foreach (cot_getextplugins('blogs.add.add.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$rpost = cot_blogs_import('POST', array(), $usr);

	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('blogs', $rpost['post_cat']);
	cot_block($usr['auth_write']);

	/* === Hook === */
	foreach (cot_getextplugins('blogs.add.add.import') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_blogs_validate($rpost);

	/* === Hook === */
	foreach (cot_getextplugins('blogs.add.add.error') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!cot_error_found())
	{
		$id = cot_blogs_add($rpost, $usr);

		if(cot_plugin_active('mavatars'))
		{

			$mavatar = new mavatar('blogs', $rpost['post_cat'], $id);
			$mavatar->ajax_upload();
			
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
				cot_message('post_savedasdraft');
				$r_url = cot_url('blogs', 'm=edit&id='.$id, '', true);
				break;
		}
		cot_redirect($r_url);
	}
	else
	{
		$c = ($c != $rpost['post_cat']) ? $rpost['post_cat'] : $c;
		cot_redirect(cot_url('blogs', 'm=add&c='.$c, '', true));
	}
}

// Adv cloning support
$clone = cot_import('clone', 'G', 'INT');
if ($clone > 0)
{
	$rpost = $db->query("SELECT * FROM $db_blogs WHERE post_id = ?", $clone)->fetch();
}

if (empty($rpost['post_cat']) && !empty($c))
{
	$rpost['post_cat'] = $c;
	$usr['isadmin'] = cot_auth('blogs', $rpost['post_cat'], 'A');
}

$out['subtitle'] = $L['post_addsubtitle'];
$out['head'] .= $R['code_noindex'];
$sys['sublocation'] = $structure['blogs'][$c]['title'];

$mskin = cot_tplfile(array('blogs', 'add', $structure['blogs'][$rpost['post_cat']]['tpl']));

/* === Hook === */
foreach (cot_getextplugins('blogs.add.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'].'/header.php';
$t = new XTemplate($mskin);

$blogsadd_array = array(
	'POSTADD_FIRMTITLE' => $L['post_addtitle'],
	'POSTADD_SUBTITLE' => $L['post_addsubtitle'],
	'POSTADD_ADMINEMAIL' => "mailto:".$cfg['adminemail'],
	'POSTADD_FORM_SEND' => cot_url('blogs', 'm=add&a=add&c='.$c),
	'POSTADD_FORM_CAT' => cot_selectbox_structure('blogs', $rpost['post_cat'], 'rpostcat'),
	'POSTADD_FORM_CAT_SHORT' => cot_selectbox_structure('blogs', $rpost['post_cat'], 'rpostcat', $c),
	'POSTADD_FORM_KEYWORDS' => cot_inputbox('text', 'rpostkeywords', $rpost['post_keywords'], array('size' => '32', 'maxlength' => '255')),
	'POSTADD_FORM_METATITLE' => cot_inputbox('text', 'rpostmetatitle', $rpost['post_metatitle'], array('size' => '64', 'maxlength' => '255')),
	'POSTADD_FORM_METADESC' => cot_textarea('rpostmetadesc', $rpost['post_metadesc'], 2, 64, array('maxlength' => '255')),
	'POSTADD_FORM_ALIAS' => cot_inputbox('text', 'rpostalias', $rpost['post_alias'], array('size' => '32', 'maxlength' => '255')),
	'POSTADD_FORM_TITLE' => cot_inputbox('text', 'rposttitle', $rpost['post_title'], array('size' => '64', 'maxlength' => '255')),
	'POSTADD_FORM_DESC' => cot_textarea('rpostdesc', $rpost['post_desc'], 2, 64, '', 'input_textarea_editor'),
	'POSTADD_FORM_OWNER' => cot_build_user($usr['id'], htmlspecialchars($usr['name'])),
	'POSTADD_FORM_OWNERID' => $usr['id'],
	'POSTADD_FORM_TEXT' => cot_textarea('rposttext', $rpost['post_text'], 12, 80, '', 'input_textarea_editor'),
	'POSTADD_FORM_PARSER' => cot_selectbox($cfg['blogs']['parser'], 'rpostparser', $parser_list, $parser_list, false)
);

$t->assign($blogsadd_array);

// Extra fields
foreach($cot_extrafields[$db_blogs] as $exfld)
{
	$uname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields('rpost'.$exfld['field_name'], $exfld, $rpost[$exfld['field_name']]);
	$exfld_title = isset($L['post_'.$exfld['field_name'].'_title']) ?  $L['post_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
	$t->assign(array(
		'POSTADD_FORM_'.$uname => $exfld_val,
		'POSTADD_FORM_'.$uname.'_TITLE' => $exfld_title,
		'POSTADD_FORM_EXTRAFLD' => $exfld_val,
		'POSTADD_FORM_EXTRAFLD_TITLE' => $exfld_title
		));
	$t->parse('MAIN.EXTRAFLD');
}

if(cot_plugin_active('mavatars'))
{

	$mavatar = new mavatar('blogs', $rpost['post_cat'], 'new');
	$t->assign('POSTADD_FORM_MAVATAR', $mavatar->generate_upload_form());
}


// Error and message handling
cot_display_messages($t);

/* === Hook === */
foreach (cot_getextplugins('blogs.add.tags') as $pl)
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
