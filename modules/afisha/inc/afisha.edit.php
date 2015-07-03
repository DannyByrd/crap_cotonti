<?php
/**
 * Edit afisha.
 *
 * @package afisha
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forms');

$id = cot_import('id', 'G', 'INT');
$c = cot_import('c', 'G', 'TXT');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('afisha', 'any');

/* === Hook === */
foreach (cot_getextplugins('afisha.edit.first') as $pl)
{
	include $pl;
}
/* ===== */

cot_block($usr['auth_read']);

if (!$id || $id < 0)
{
	cot_die_message(404);
}
$sql_afisha = $db->query("SELECT * FROM $db_afisha WHERE event_id=$id LIMIT 1");
if($sql_afisha->rowCount() == 0)
{
	cot_die_message(404);
}
$row_event = $sql_afisha->fetch();

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('afisha', $row_event['event_cat']);

$parser_list = cot_get_parsers();
$sys['parser'] = $row_event['event_parser'];

if ($a == 'update')
{
	/* === Hook === */
	foreach (cot_getextplugins('afisha.edit.update.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_block($usr['isadmin'] || $usr['auth_write'] && $usr['id'] == $row_event['event_ownerid']);

	$revent = cot_afisha_import('POST', $row_event, $usr);

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$reventdelete = cot_import('reventdelete', 'P', 'BOL');
	}
	else
	{
		$reventdelete = cot_import('delete', 'G', 'BOL');
		cot_check_xg();
	}

	if ($reventdelete)
	{
		cot_afisha_delete($id, $row_event);
		cot_redirect(cot_url('afisha', "c=" . $row_event['event_cat'], '', true));
	}

	/* === Hook === */
	foreach (cot_getextplugins('afisha.edit.update.import') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_afisha_validate($revent);

	/* === Hook === */
	foreach (cot_getextplugins('afisha.edit.update.error') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!cot_error_found())
	{
		cot_afisha_update($id, $revent);

		switch ($revent['event_state'])
		{
			case 0:
				$urlparams = empty($revent['event_alias']) ?
					array('c' => $revent['event_cat'], 'id' => $id) :
					array('c' => $revent['event_cat'], 'al' => $revent['event_alias']);
				$r_url = cot_url('afisha', $urlparams, '', true);
				break;
			case 1:
				$r_url = cot_url('message', 'msg=300', '', true);
				break;
			case 2:
				cot_message($L['event_savedasdraft']);
				$r_url = cot_url('afisha', 'm=edit&id=' . $id, '', true);
				break;
		}
		cot_redirect($r_url);
	}
	else
	{
		cot_redirect(cot_url('afisha', "m=edit&id=$id", '', true));
	}
}

$event = $row_event;

$event['event_status'] = cot_afisha_status($event['event_state'], $event['event_expire']);

cot_block($usr['isadmin'] || $usr['auth_write'] && $usr['id'] == $event['event_ownerid']);

$out['subtitle'] = $L['event_edittitle'];
$out['head'] .= $R['code_noindex'];
$sys['sublocation'] = $structure['afisha'][$event['event_cat']]['title'];

$mskin = cot_tplfile(array('afisha', 'edit', $structure['afisha'][$event['event_cat']]['tpl']));

/* === Hook === */
foreach (cot_getextplugins('afisha.edit.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'].'/header.php';
$t = new XTemplate($mskin);

$afishaedit_array = array(
	'EVTEDIT_FIRMTITLE' => $L['event_edittitle'],
	'EVTEDIT_SUBTITLE' => $L['event_editsubtitle'],
	'EVTEDIT_FORM_SEND' => cot_url('afisha', "m=edit&a=update&id=".$event['event_id']),
	'EVTEDIT_FORM_ID' => $event['event_id'],
	'EVTEDIT_FORM_STATE' => $event['event_state'],
	'EVTEDIT_FORM_STATUS' => $event['event_status'],
	'EVTEDIT_FORM_LOCALSTATUS' => $L['event_status_'.$event['event_status']],
	'EVTEDIT_FORM_CAT' => cot_selectbox_structure('afisha', $event['event_cat'], 'reventcat'),
	'EVTEDIT_FORM_CAT_SHORT' => cot_selectbox_structure('afisha', $event['event_cat'], 'reventcat', $c),
	'EVTEDIT_FORM_KEYWORDS' => cot_inputbox('text', 'reventkeywords', $event['event_keywords'], array('size' => '32', 'maxlength' => '255')),
	'EVTEDIT_FORM_METATITLE' => cot_inputbox('text', 'reventmetatitle', $event['event_metatitle'], array('size' => '64', 'maxlength' => '255')),
	'EVTEDIT_FORM_METADESC' => cot_textarea('reventmetadesc', $event['event_metadesc'], 2, 64, array('maxlength' => '255')),
	'EVTEDIT_FORM_ALIAS' => cot_inputbox('text', 'reventalias', $event['event_alias'], array('size' => '32', 'maxlength' => '255')),
	'EVTEDIT_FORM_TITLE' => cot_inputbox('text', 'reventtitle', $event['event_title'], array('size' => '64', 'maxlength' => '255')),
	'EVTEDIT_FORM_DESC' => cot_textarea('reventdesc', $event['event_desc'], 2, 64, '','input_textarea_editor'),
	'EVTEDIT_FORM_DATE' => cot_selectbox_date($event['event_date'], 'long', 'reventdate').' '.$usr['timetext'],
	'EVTEDIT_FORM_DATENOW' => cot_checkbox(0, 'reventdatenow'),
	'EVTEDIT_FORM_UPDATED' => cot_date('datetime_full', $event['event_updated']).' '.$usr['timetext'],
	'EVTEDIT_FORM_EXPIRE' => cot_selectbox_date($event['event_expire'], 'long', 'reventexpire').' '.$usr['timetext'],
	'EVTEDIT_FORM_TEXT' => cot_textarea('reventtext', $event['event_text'], 12, 80, '', 'input_textarea_editor'),
	'EVTEDIT_FORM_DELETE' => cot_radiobox(0, 'reventdelete', array(1, 0), array($L['Yes'], $L['No'])),
	'EVTEDIT_FORM_PARSER' => cot_selectbox($event['event_parser'], 'reventparser', cot_get_parsers(), cot_get_parsers(), false),
);
if ($usr['isadmin'])
{
	$afishaedit_array += array(
		'EVTEDIT_FORM_OWNERID' => cot_inputbox('text', 'reventownerid', $event['event_ownerid'], array('size' => '24', 'maxlength' => '24')),
		'EVTEDIT_FORM_ADVCOUNT' => cot_inputbox('text', 'reventcount', $event['event_count'], array('size' => '8', 'maxlength' => '8')),
	);
}

$t->assign($afishaedit_array);

// Extra fields
foreach($cot_extrafields[$db_afisha] as $exfld)
{
	$uname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields('revent'.$exfld['field_name'], $exfld, $event['event_'.$exfld['field_name']]);
	$exfld_title = isset($L['event_'.$exfld['field_name'].'_title']) ?  $L['event_'.$exfld['field_name'].'_title'] : $exfld['field_description'];

	$t->assign(array(
		'EVTEDIT_FORM_'.$uname => $exfld_val,
		'EVTEDIT_FORM_'.$uname.'_TITLE' => $exfld_title,
		'EVTEDIT_FORM_EXTRAFLD' => $exfld_val,
		'EVTEDIT_FORM_EXTRAFLD_TITLE' => $exfld_title
	));
	$t->parse('MAIN.EXTRAFLD');
}

// Error and message handling
cot_display_messages($t);

/* === Hook === */
foreach (cot_getextplugins('afisha.edit.tags') as $pl)
{
	include $pl;
}
/* ===== */

if ($usr['isadmin'])
{
	if ($cfg['afisha']['autovalidateevent']) $usr_can_publish = TRUE;
	$t->parse('MAIN.ADMIN');
}

$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'].'/footer.php';
