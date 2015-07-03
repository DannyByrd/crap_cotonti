<?php
/**
 * Add adv.
 *
 * @package board
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forms');

$id = cot_import('id', 'G', 'INT');
$c = cot_import('c', 'G', 'TXT');

if (!empty($c) && !isset($structure['board'][$c]))
{
	$c = '';
}

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('board', 'any');

/* === Hook === */
foreach (cot_getextplugins('board.add.first') as $pl)
{
	include $pl;
}
/* ===== */
cot_block($usr['auth_write']);

if ($structure['board'][$c]['locked'])
{
	cot_die_message(602, TRUE);
}

$sys['parser'] = $cfg['board']['parser'];
$parser_list = cot_get_parsers();

if ($a == 'add')
{
	cot_shield_protect();

	/* === Hook === */
	foreach (cot_getextplugins('board.add.add.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$radv = cot_board_import('POST', array(), $usr);

	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('board', $radv['adv_cat']);
	cot_block($usr['auth_write']);

	/* === Hook === */
	foreach (cot_getextplugins('board.add.add.import') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_board_validate($radv);

	/* === Hook === */
	foreach (cot_getextplugins('board.add.add.error') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!cot_error_found())
	{
		$id = cot_board_add($radv, $usr);

		switch ($radv['adv_state'])
		{
			case 0:
				$urlparams = empty($radv['adv_alias']) ?
					array('c' => $radv['adv_cat'], 'id' => $id) :
					array('c' => $radv['adv_cat'], 'al' => $radv['adv_alias']);
				$r_url = cot_url('board', $urlparams, '', true);
				break;
			case 1:
				$r_url = cot_url('message', 'msg=300', '', true);
				break;
			case 2:
				cot_message('adv_savedasdraft');
				$r_url = cot_url('board', 'm=edit&id='.$id, '', true);
				break;
		}
		cot_redirect($r_url);
	}
	else
	{
		$c = ($c != $radv['adv_cat']) ? $radv['adv_cat'] : $c;
		cot_redirect(cot_url('board', 'm=add&c='.$c, '', true));
	}
}

// Adv cloning support
$clone = cot_import('clone', 'G', 'INT');
if ($clone > 0)
{
	$radv = $db->query("SELECT * FROM $db_board WHERE adv_id = ?", $clone)->fetch();
}

if (empty($radv['adv_cat']) && !empty($c))
{
	$radv['adv_cat'] = $c;
	$usr['isadmin'] = cot_auth('board', $radv['adv_cat'], 'A');
}

$out['subtitle'] = $L['adv_addsubtitle'];
$out['head'] .= $R['code_noindex'];
$sys['sublocation'] = $structure['board'][$c]['title'];

$mskin = cot_tplfile(array('board', 'add', $structure['board'][$radv['adv_cat']]['tpl']));

/* === Hook === */
foreach (cot_getextplugins('board.add.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'].'/header.php';
$t = new XTemplate($mskin);

$advadd_array = array(
	'ADVADD_FIRMTITLE' => $L['adv_addtitle'],
	'ADVADD_SUBTITLE' => $L['adv_addsubtitle'],
	'ADVADD_ADMINEMAIL' => "mailto:".$cfg['adminemail'],
	'ADVADD_FORM_SEND' => cot_url('board', 'm=add&a=add&c='.$c),
	'ADVADD_FORM_CAT' => cot_selectbox_structure('board', $radv['adv_cat'], 'radvcat'),
	'ADVADD_FORM_CAT_SHORT' => cot_selectbox_structure('board', $radv['adv_cat'], 'radvcat', $c),
	'ADVADD_FORM_KEYWORDS' => cot_inputbox('text', 'radvkeywords', $radv['adv_keywords'], array('size' => '32', 'maxlength' => '255')),
	'ADVADD_FORM_METATITLE' => cot_inputbox('text', 'radvmetatitle', $radv['adv_metatitle'], array('size' => '64', 'maxlength' => '255')),
	'ADVADD_FORM_METADESC' => cot_textarea('radvmetadesc', $radv['adv_metadesc'], 2, 64, array('maxlength' => '255')),
	'ADVADD_FORM_ALIAS' => cot_inputbox('text', 'radvalias', $radv['adv_alias'], array('size' => '32', 'maxlength' => '255')),
	'ADVADD_FORM_TITLE' => cot_inputbox('text', 'radvtitle', $radv['adv_title'], array('size' => '64', 'maxlength' => '255')),
	'ADVADD_FORM_DESC' => cot_textarea('radvdesc', $radv['adv_desc'], 2, 64, '', 'input_textarea_editor'),
	'ADVADD_FORM_OWNER' => cot_build_user($usr['id'], htmlspecialchars($usr['name'])),
	'ADVADD_FORM_OWNERID' => $usr['id'],
	'ADVADD_FORM_EXPIRE' => cot_selectbox_date(0, 'long', 'radvexpire'),
	'ADVADD_FORM_COST' => cot_inputbox('text', 'radvcost', $radv['adv_cost'], array('size' => '24', 'maxlength' => '100')),
	'ADVADD_FORM_TEXT' => cot_textarea('radvtext', $radv['adv_text'], 12, 80, '', 'input_textarea_editor'),
	'ADVADD_FORM_ADDR' => cot_inputbox('text', 'radvaddr', $radv['adv_addr'], array('size' => '64', 'maxlength' => '255')),
	'ADVADD_FORM_PHONE' => cot_inputbox('text', 'radvphone', $radv['adv_phone'], array('size' => '64', 'maxlength' => '255')),
	'ADVADD_FORM_SKYPE' => cot_inputbox('text', 'radvskype', $radv['adv_skype'], array('size' => '64', 'maxlength' => '255')),
	'ADVADD_FORM_SITE' => cot_inputbox('text', 'radvsite', $radv['adv_site'], array('size' => '64', 'maxlength' => '255')),
	'ADVADD_FORM_EMAIL' => cot_inputbox('text', 'radvemail', $radv['adv_email'], array('size' => '64', 'maxlength' => '255')),
	'ADVADD_FORM_HIDEMAIL' => cot_checkbox($radv['adv_hidemail'], 'radvhidemail', $L['adv_hidemail'], 'class="checkbox"', 1),
	'ADVADD_FORM_PARSER' => cot_selectbox($cfg['board']['parser'], 'radvparser', $parser_list, $parser_list, false)
);

$t->assign($advadd_array);

// Extra fields
foreach($cot_extrafields[$db_board] as $exfld)
{
	$uname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields('radv'.$exfld['field_name'], $exfld, $radv[$exfld['field_name']]);
	$exfld_title = isset($L['adv_'.$exfld['field_name'].'_title']) ?  $L['adv_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
	$t->assign(array(
		'ADVADD_FORM_'.$uname => $exfld_val,
		'ADVADD_FORM_'.$uname.'_TITLE' => $exfld_title,
		'ADVADD_FORM_EXTRAFLD' => $exfld_val,
		'ADVADD_FORM_EXTRAFLD_TITLE' => $exfld_title
		));
	$t->parse('MAIN.EXTRAFLD');
}

// Error and message handling
cot_display_messages($t);

/* === Hook === */
foreach (cot_getextplugins('board.add.tags') as $pl)
{
	include $pl;
}
/* ===== */

if ($usr['isadmin'])
{
	if ($cfg['board']['autovalidateadv']) $usr_can_publish = TRUE;
	$t->parse('MAIN.ADMIN');
}

$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'].'/footer.php';
