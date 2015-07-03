<?php
/**
 * Add event.
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

if (!empty($c) && !isset($structure['afisha'][$c]))
{
	$c = '';
}

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('afisha', 'any');

/* === Hook === */
foreach (cot_getextplugins('afisha.add.first') as $pl)
{
	include $pl;
}
/* ===== */
cot_block($usr['auth_write']);

if ($structure['afisha'][$c]['locked'])
{
	cot_die_message(602, TRUE);
}

$sys['parser'] = $cfg['afisha']['parser'];
$parser_list = cot_get_parsers();

if ($a == 'add')
{
	cot_shield_protect();

	/* === Hook === */
	foreach (cot_getextplugins('afisha.add.add.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$revent = cot_afisha_import('POST', array(), $usr);

	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('afisha', $revent['event_cat']);
	cot_block($usr['auth_write']);

	/* === Hook === */
	foreach (cot_getextplugins('afisha.add.add.import') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_afisha_validate($revent);

	/* === Hook === */
	foreach (cot_getextplugins('afisha.add.add.error') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!cot_error_found())
	{
		$id = cot_afisha_add($revent, $usr);

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
				cot_message('event_savedasdraft');
				$r_url = cot_url('afisha', 'm=edit&id='.$id, '', true);
				break;
		}
		cot_redirect($r_url);
	}
	else
	{
		$c = ($c != $revent['event_cat']) ? $revent['event_cat'] : $c;
		cot_redirect(cot_url('afisha', 'm=add&c='.$c, '', true));
	}
}

// Adv cloning support
$clone = cot_import('clone', 'G', 'INT');
if ($clone > 0)
{
	$revent = $db->query("SELECT * FROM $db_afisha WHERE event_id = ?", $clone)->fetch();
}

if (empty($revent['event_cat']) && !empty($c))
{
	$revent['event_cat'] = $c;
	$usr['isadmin'] = cot_auth('afisha', $revent['event_cat'], 'A');
}

$out['subtitle'] = $L['event_addsubtitle'];
$out['head'] .= $R['code_noindex'];
$sys['sublocation'] = $structure['afisha'][$c]['title'];

$mskin = cot_tplfile(array('afisha', 'add', $structure['afisha'][$revent['event_cat']]['tpl']));

/* === Hook === */
foreach (cot_getextplugins('afisha.add.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'].'/header.php';
$t = new XTemplate($mskin);

$eventadd_array = array(
	'EVTADD_FIRMTITLE' => $L['event_addtitle'],
	'EVTADD_SUBTITLE' => $L['event_addsubtitle'],
	'EVTADD_ADMINEMAIL' => "mailto:".$cfg['adminemail'],
	'EVTADD_FORM_SEND' => cot_url('afisha', 'm=add&a=add&c='.$c),
	'EVTADD_FORM_CAT' => cot_selectbox_structure('afisha', $revent['event_cat'], 'reventcat'),
	'EVTADD_FORM_CAT_SHORT' => cot_selectbox_structure('afisha', $revent['event_cat'], 'reventcat', $c),
	'EVTADD_FORM_KEYWORDS' => cot_inputbox('text', 'reventkeywords', $revent['event_keywords'], array('size' => '32', 'maxlength' => '255')),
	'EVTADD_FORM_METATITLE' => cot_inputbox('text', 'reventmetatitle', $revent['event_metatitle'], array('size' => '64', 'maxlength' => '255')),
	'EVTADD_FORM_METADESC' => cot_textarea('reventmetadesc', $revent['event_metadesc'], 2, 64, array('maxlength' => '255')),
	'EVTADD_FORM_ALIAS' => cot_inputbox('text', 'reventalias', $revent['event_alias'], array('size' => '32', 'maxlength' => '255')),
	'EVTADD_FORM_TITLE' => cot_inputbox('text', 'reventtitle', $revent['event_title'], array('size' => '64', 'maxlength' => '255')),
	'EVTADD_FORM_DESC' => cot_textarea('reventdesc', $revent['event_desc'], 2, 64, '','input_textarea_editor'),
	'EVTADD_FORM_OWNER' => cot_build_user($usr['id'], htmlspecialchars($usr['name'])),
	'EVTADD_FORM_OWNERID' => $usr['id'],
	'EVTADD_FORM_EXPIRE' => cot_selectbox_date(0, 'long', 'reventexpire'),
	'EVTADD_FORM_TEXT' => cot_textarea('reventtext', $revent['event_text'], 12, 80, '', 'input_textarea_editor'),
	'EVTADD_FORM_HIDEMAIL' => cot_checkbox($revent['event_hidemail'], 'reventhidemail', $L['event_hidemail'], 'class="checkbox"', 1),
	'EVTADD_FORM_PARSER' => cot_selectbox($cfg['afisha']['parser'], 'reventparser', $parser_list, $parser_list, false)
);

$t->assign($eventadd_array);

// Extra fields
foreach($cot_extrafields[$db_afisha] as $exfld)
{
	$uname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields('revent'.$exfld['field_name'], $exfld, $revent[$exfld['field_name']]);
	$exfld_title = isset($L['event_'.$exfld['field_name'].'_title']) ?  $L['event_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
	$t->assign(array(
		'EVTADD_FORM_'.$uname => $exfld_val,
		'EVTADD_FORM_'.$uname.'_TITLE' => $exfld_title,
		'EVTADD_FORM_EXTRAFLD' => $exfld_val,
		'EVTADD_FORM_EXTRAFLD_TITLE' => $exfld_title
		));
	$t->parse('MAIN.EXTRAFLD');
}

// Error and message handling
cot_display_messages($t);

/* === Hook === */
foreach (cot_getextplugins('afisha.add.tags') as $pl)
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
