<?php
/**
 * Edit board.
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

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('board', 'any');

/* === Hook === */
foreach (cot_getextplugins('board.edit.first') as $pl)
{
	include $pl;
}
/* ===== */

cot_block($usr['auth_read']);

if (!$id || $id < 0)
{
	cot_die_message(404);
}
$sql_board = $db->query("SELECT * FROM $db_board WHERE adv_id=$id LIMIT 1");
if($sql_board->rowCount() == 0)
{
	cot_die_message(404);
}
$row_adv = $sql_board->fetch();

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('board', $row_adv['adv_cat']);

$parser_list = cot_get_parsers();
$sys['parser'] = $row_adv['adv_parser'];

if ($a == 'update')
{
	/* === Hook === */
	foreach (cot_getextplugins('board.edit.update.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_block($usr['isadmin'] || $usr['auth_write'] && $usr['id'] == $row_adv['adv_ownerid']);

	$radv = cot_board_import('POST', $row_adv, $usr);

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$radvdelete = cot_import('radvdelete', 'P', 'BOL');
	}
	else
	{
		$radvdelete = cot_import('delete', 'G', 'BOL');
		cot_check_xg();
	}

	if ($radvdelete)
	{
		cot_board_delete($id, $row_adv);
		cot_redirect(cot_url('board', "c=" . $row_adv['adv_cat'], '', true));
	}

	/* === Hook === */
	foreach (cot_getextplugins('board.edit.update.import') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_board_validate($radv);

	/* === Hook === */
	foreach (cot_getextplugins('board.edit.update.error') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!cot_error_found())
	{
		cot_board_update($id, $radv);

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
				cot_message($L['adv_savedasdraft']);
				$r_url = cot_url('board', 'm=edit&id=' . $id, '', true);
				break;
		}
		cot_redirect($r_url);
	}
	else
	{
		cot_redirect(cot_url('board', "m=edit&id=$id", '', true));
	}
}

$adv = $row_adv;

$adv['adv_status'] = cot_board_status($adv['adv_state'], $adv['adv_expire']);

cot_block($usr['isadmin'] || $usr['auth_write'] && $usr['id'] == $adv['adv_ownerid']);

$out['subtitle'] = $L['adv_edittitle'];
$out['head'] .= $R['code_noindex'];
$sys['sublocation'] = $structure['board'][$adv['adv_cat']]['title'];

$mskin = cot_tplfile(array('board', 'edit', $structure['board'][$adv['adv_cat']]['tpl']));

/* === Hook === */
foreach (cot_getextplugins('board.edit.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'].'/header.php';
$t = new XTemplate($mskin);

$boardedit_array = array(
	'ADVEDIT_FIRMTITLE' => $L['adv_edittitle'],
	'ADVEDIT_SUBTITLE' => $L['adv_editsubtitle'],
	'ADVEDIT_FORM_SEND' => cot_url('board', "m=edit&a=update&id=".$adv['adv_id']),
	'ADVEDIT_FORM_ID' => $adv['adv_id'],
	'ADVEDIT_FORM_STATE' => $adv['adv_state'],
	'ADVEDIT_FORM_STATUS' => $adv['adv_status'],
	'ADVEDIT_FORM_LOCALSTATUS' => $L['adv_status_'.$adv['adv_status']],
	'ADVEDIT_FORM_CAT' => cot_selectbox_structure('board', $adv['adv_cat'], 'radvcat'),
	'ADVEDIT_FORM_CAT_SHORT' => cot_selectbox_structure('board', $adv['adv_cat'], 'radvcat', $c),
	'ADVEDIT_FORM_KEYWORDS' => cot_inputbox('text', 'radvkeywords', $adv['adv_keywords'], array('size' => '32', 'maxlength' => '255')),
	'ADVEDIT_FORM_METATITLE' => cot_inputbox('text', 'radvmetatitle', $adv['adv_metatitle'], array('size' => '64', 'maxlength' => '255')),
	'ADVEDIT_FORM_METADESC' => cot_textarea('radvmetadesc', $adv['adv_metadesc'], 2, 64, array('maxlength' => '255')),
	'ADVEDIT_FORM_ALIAS' => cot_inputbox('text', 'radvalias', $adv['adv_alias'], array('size' => '32', 'maxlength' => '255')),
	'ADVEDIT_FORM_TITLE' => cot_inputbox('text', 'radvtitle', $adv['adv_title'], array('size' => '64', 'maxlength' => '255')),
	'ADVEDIT_FORM_DESC' => cot_textarea('radvdesc', $adv['adv_desc'], 2, 64, '', 'input_textarea_editor'),
	'ADVEDIT_FORM_DATE' => cot_selectbox_date($adv['adv_date'], 'long', 'radvdate').' '.$usr['timetext'],
	'ADVEDIT_FORM_DATENOW' => cot_checkbox(0, 'radvdatenow'),
	'ADVEDIT_FORM_UPDATED' => cot_date('datetime_full', $adv['adv_updated']).' '.$usr['timetext'],
	'ADVEDIT_FORM_EXPIRE' => cot_selectbox_date($adv['adv_expire'], 'long', 'radvexpire').' '.$usr['timetext'],
	'ADVEDIT_FORM_COST' => cot_inputbox('text', 'radvcost', $adv['adv_cost'], array('size' => '24', 'maxlength' => '100')),
	'ADVEDIT_FORM_TEXT' => cot_textarea('radvtext', $adv['adv_text'], 12, 80, '', 'input_textarea_editor'),
	'ADVEDIT_FORM_ADDR' => cot_inputbox('text', 'radvaddr', $adv['adv_addr'], array('size' => '64', 'maxlength' => '255')),
	'ADVEDIT_FORM_PHONE' => cot_inputbox('text', 'radvphone', $adv['adv_phone'], array('size' => '64', 'maxlength' => '255')),
	'ADVEDIT_FORM_SKYPE' => cot_inputbox('text', 'radvskype', $adv['adv_skype'], array('size' => '64', 'maxlength' => '255')),
	'ADVEDIT_FORM_SITE' => cot_inputbox('text', 'radvsite', $adv['adv_site'], array('size' => '64', 'maxlength' => '255')),
	'ADVEDIT_FORM_EMAIL' => cot_inputbox('text', 'radvemail', $adv['adv_email'], array('size' => '64', 'maxlength' => '255')),
	'ADVEDIT_FORM_HIDEMAIL' => cot_checkbox($adv['adv_hidemail'], 'radvhidemail', $L['adv_hidemail'], 'class="checkbox"', 1),
	'ADVEDIT_FORM_DELETE' => cot_radiobox(0, 'radvdelete', array(1, 0), array($L['Yes'], $L['No'])),
	'ADVEDIT_FORM_PARSER' => cot_selectbox($adv['adv_parser'], 'radvparser', cot_get_parsers(), cot_get_parsers(), false),
);
if ($usr['isadmin'])
{
	$boardedit_array += array(
		'ADVEDIT_FORM_OWNERID' => cot_inputbox('text', 'radvownerid', $adv['adv_ownerid'], array('size' => '24', 'maxlength' => '24')),
		'ADVEDIT_FORM_ADVCOUNT' => cot_inputbox('text', 'radvcount', $adv['adv_count'], array('size' => '8', 'maxlength' => '8')),
	);
}

$t->assign($boardedit_array);

// Extra fields
foreach($cot_extrafields[$db_board] as $exfld)
{
	$uname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields('radv'.$exfld['field_name'], $exfld, $adv['adv_'.$exfld['field_name']]);
	$exfld_title = isset($L['adv_'.$exfld['field_name'].'_title']) ?  $L['adv_'.$exfld['field_name'].'_title'] : $exfld['field_description'];

	$t->assign(array(
		'ADVEDIT_FORM_'.$uname => $exfld_val,
		'ADVEDIT_FORM_'.$uname.'_TITLE' => $exfld_title,
		'ADVEDIT_FORM_EXTRAFLD' => $exfld_val,
		'ADVEDIT_FORM_EXTRAFLD_TITLE' => $exfld_title
	));
	$t->parse('MAIN.EXTRAFLD');
}

// Error and message handling
cot_display_messages($t);

/* === Hook === */
foreach (cot_getextplugins('board.edit.tags') as $pl)
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
