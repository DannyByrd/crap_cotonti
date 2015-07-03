<?php
/**
 * Edit firms.
 *
 * @package firms
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

cot_rc_link_file('http://api-maps.yandex.ru/2.1/?lang=ru_RU');

require_once cot_incfile('forms');

$id = cot_import('id', 'G', 'INT');
$c = cot_import('c', 'G', 'TXT');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('firms', 'any');

/* === Hook === */
foreach (cot_getextplugins('firms.edit.first') as $pl)
{
	include $pl;
}
/* ===== */

cot_block($usr['auth_read']);

if (!$id || $id < 0)
{
	cot_die_message(404);
}
$sql_firms = $db->query("SELECT * FROM $db_firms WHERE firm_id=$id LIMIT 1");
if($sql_firms->rowCount() == 0)
{
	cot_die_message(404);
}
$row_firms = $sql_firms->fetch();

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('firms', $row_firms['firm_cat']);

$parser_list = cot_get_parsers();
$sys['parser'] = $row_firms['firm_parser'];

if ($a == 'update')
{
	/* === Hook === */
	foreach (cot_getextplugins('firms.edit.update.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_block($usr['isadmin'] || $usr['auth_write'] && $usr['id'] == $row_firms['firm_ownerid']);

	$rfirm = cot_firms_import('POST', $row_firms, $usr);

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$rfirmdelete = cot_import('rfirmdelete', 'P', 'BOL');
	}
	else
	{
		$rfirmdelete = cot_import('delete', 'G', 'BOL');
		cot_check_xg();
	}

	if ($rfirmdelete)
	{
		cot_firms_delete($id, $row_firms);
		cot_redirect(cot_url('firms', "c=" . $row_firms['firm_cat'], '', true));
	}

	/* === Hook === */
	foreach (cot_getextplugins('firms.edit.update.import') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_firms_validate($rfirm);

	/* === Hook === */
	foreach (cot_getextplugins('firms.edit.update.error') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!cot_error_found())
	{
		cot_firms_update($id, $rfirm);

		switch ($rfirm['firm_state'])
		{
			case 0:
				$urlparams = empty($rfirm['firm_alias']) ?
					array('c' => $rfirm['firm_cat'], 'id' => $id) :
					array('c' => $rfirm['firm_cat'], 'al' => $rfirm['firm_alias']);
				$r_url = cot_url('firms', $urlparams, '', true);
				break;
			case 1:
				$r_url = cot_url('message', 'msg=300', '', true);
				break;
			case 2:
				cot_message($L['firm_savedasdraft']);
				$r_url = cot_url('firms', 'm=edit&id=' . $id, '', true);
				break;
		}
		cot_redirect($r_url);
	}
	else
	{
		cot_redirect(cot_url('firms', "m=edit&id=$id", '', true));
	}
}

$firm = $row_firms;

$firm['firm_status'] = cot_firms_status($firm['firm_state']);

cot_block($usr['isadmin'] || $usr['auth_write'] && $usr['id'] == $firm['firm_ownerid']);

$out['subtitle'] = $L['firm_edittitle'];
$out['head'] .= $R['code_noindex'];
$sys['sublocation'] = $structure['firms'][$firm['firm_cat']]['title'];

$mskin = cot_tplfile(array('firms', 'edit', $structure['firms'][$firm['firm_cat']]['tpl']));

/* === Hook === */
foreach (cot_getextplugins('firms.edit.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'].'/header.php';
$t = new XTemplate($mskin);

$firmsedit_array = array(
	'FIRMEDIT_FIRMTITLE' => $L['firm_edittitle'],
	'FIRMEDIT_SUBTITLE' => $L['firm_editsubtitle'],
	'FIRMEDIT_FORM_SEND' => cot_url('firms', "m=edit&a=update&id=".$firm['firm_id']),
	'FIRMEDIT_FORM_ID' => $firm['firm_id'],
	'FIRMEDIT_FORM_STATE' => $firm['firm_state'],
	'FIRMEDIT_FORM_STATUS' => $firm['firm_status'],
	'FIRMEDIT_FORM_LOCALSTATUS' => $L['firm_status_'.$firm['firm_status']],
	'FIRMEDIT_FORM_CAT' => cot_selectbox_structure('firms', $firm['firm_cat'], 'rfirmcat'),
	'FIRMEDIT_FORM_CAT_SHORT' => cot_selectbox_structure('firms', $firm['firm_cat'], 'rfirmcat', $c),
	'FIRMEDIT_FORM_KEYWORDS' => cot_inputbox('text', 'rfirmkeywords', $firm['firm_keywords'], array('size' => '32', 'maxlength' => '255')),
	'FIRMEDIT_FORM_METATITLE' => cot_inputbox('text', 'rfirmmetatitle', $firm['firm_metatitle'], array('size' => '64', 'maxlength' => '255')),
	'FIRMEDIT_FORM_METADESC' => cot_textarea('rfirmmetadesc', $firm['firm_metadesc'], 2, 64, array('maxlength' => '255')),
	'FIRMEDIT_FORM_ALIAS' => cot_inputbox('text', 'rfirmalias', $firm['firm_alias'], array('size' => '32', 'maxlength' => '255')),
	// 'FIRMEDIT_FORM_LOGO' => cot_filebox('rfirmlogo', $firm['firm_logo'], '', '', '', 'input_filebox_logo'),
	'FIRMEDIT_FORM_TITLE' => cot_inputbox('text', 'rfirmtitle', $firm['firm_title'], array('size' => '64', 'maxlength' => '255')),
	'FIRMEDIT_FORM_DESC' => cot_textarea('rfirmdesc', $firm['firm_desc'], 2, 64, '', 'input_textarea_editor'),
	'FIRMEDIT_FORM_DATE' => cot_selectbox_date($firm['firm_date'], 'long', 'rfirmdate').' '.$usr['timetext'],
	'FIRMEDIT_FORM_DATENOW' => cot_checkbox(0, 'rfirmdatenow'),
	'FIRMEDIT_FORM_UPDATED' => cot_date('datetime_full', $firm['firm_updated']).' '.$usr['timetext'],
	'FIRMEDIT_FORM_TEXT' => cot_textarea('rfirmtext', $firm['firm_text'], 12, 80, '', 'input_textarea_editor'),
	'FIRMEDIT_FORM_ADDR' => cot_inputbox('text', 'rfirmaddr', $firm['firm_addr'], array('size' => '64', 'maxlength' => '255')),
	'FIRMEDIT_FORM_PHONE' => cot_inputbox('text', 'rfirmphone', $firm['firm_phone'], array('size' => '64', 'maxlength' => '255')),
	'FIRMEDIT_FORM_SKYPE' => cot_inputbox('text', 'rfirmskype', $firm['firm_skype'], array('size' => '64', 'maxlength' => '255')),
	'FIRMEDIT_FORM_SITE' => cot_inputbox('text', 'rfirmsite', $firm['firm_site'], array('size' => '64', 'maxlength' => '255')),
	'FIRMEDIT_FORM_EMAIL' => cot_inputbox('text', 'rfirmemail', $firm['firm_email'], array('size' => '64', 'maxlength' => '255')),
	'FIRMEDIT_FORM_DELETE' => cot_radiobox(0, 'rfirmdelete', array(1, 0), array($L['Yes'], $L['No'])),
	'FIRMEDIT_FORM_PARSER' => cot_selectbox($firm['firm_parser'], 'rfirmparser', cot_get_parsers(), cot_get_parsers(), false),
);
if ($usr['isadmin'])
{
	$firmsedit_array += array(
		'FIRMEDIT_FORM_OWNERID' => cot_inputbox('text', 'rfirmownerid', $firm['firm_ownerid'], array('size' => '24', 'maxlength' => '24')),
		'FIRMEDIT_FORM_FIRMCOUNT' => cot_inputbox('text', 'rfirmcount', $firm['firm_count'], array('size' => '8', 'maxlength' => '8')),
	);
}

$t->assign($firmsedit_array);

// Extra fields
foreach($cot_extrafields[$db_firms] as $exfld)
{
	$uname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields('rfirm'.$exfld['field_name'], $exfld, $firm['firm_'.$exfld['field_name']]);
	$exfld_title = isset($L['firm_'.$exfld['field_name'].'_title']) ?  $L['firm_'.$exfld['field_name'].'_title'] : $exfld['field_description'];

	$t->assign(array(
		'FIRMEDIT_FORM_'.$uname => $exfld_val,
		'FIRMEDIT_FORM_'.$uname.'_TITLE' => $exfld_title,
		'FIRMEDIT_FORM_EXTRAFLD' => $exfld_val,
		'FIRMEDIT_FORM_EXTRAFLD_TITLE' => $exfld_title
	));
	$t->parse('MAIN.EXTRAFLD');
}

// Error and message handling
cot_display_messages($t);

/* === Hook === */
foreach (cot_getextplugins('firms.edit.tags') as $pl)
{
	include $pl;
}
/* ===== */

if ($usr['isadmin'])
{
	if ($cfg['firms']['autovalidatefirm']) $usr_can_publish = TRUE;
	$t->parse('MAIN.ADMIN');
}

$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'].'/footer.php';
