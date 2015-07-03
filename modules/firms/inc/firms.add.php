<?php
/**
 * Add firms.
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

if (!empty($c) && !isset($structure['firms'][$c]))
{
	$c = '';
}

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('firms', 'any');

/* === Hook === */
foreach (cot_getextplugins('firms.add.first') as $pl)
{
	include $pl;
}
/* ===== */
cot_block($usr['auth_write']);

if ($structure['firms'][$c]['locked'])
{
	cot_die_message(602, TRUE);
}

$sys['parser'] = $cfg['firms']['parser'];
$parser_list = cot_get_parsers();

if ($a == 'add')
{
	cot_shield_protect();

	/* === Hook === */
	foreach (cot_getextplugins('firms.add.add.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$rfirm = cot_firms_import('POST', array(), $usr);

	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('firms', $rfirm['firm_cat']);
	cot_block($usr['auth_write']);

	/* === Hook === */
	foreach (cot_getextplugins('firms.add.add.import') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_firms_validate($rfirm);

	/* === Hook === */
	foreach (cot_getextplugins('firms.add.add.error') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!cot_error_found())
	{
		$id = cot_firms_add($rfirm, $usr);

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
				cot_message('firm_savedasdraft');
				$r_url = cot_url('firms', 'm=edit&id='.$id, '', true);
				break;
		}
		cot_redirect($r_url);
	}
	else
	{
		$c = ($c != $rfirm['firm_cat']) ? $rfirm['firm_cat'] : $c;
		cot_redirect(cot_url('firms', 'm=add&c='.$c, '', true));
	}
}

// Firm cloning support
$clone = cot_import('clone', 'G', 'INT');
if ($clone > 0)
{
	$rfirm = $db->query("SELECT * FROM $db_firms WHERE firm_id = ?", $clone)->fetch();
}

if (empty($rfirm['firm_cat']) && !empty($c))
{
	$rfirm['firm_cat'] = $c;
	$usr['isadmin'] = cot_auth('firms', $rfirm['firm_cat'], 'A');
}

$out['subtitle'] = $L['firm_addsubtitle'];
$out['head'] .= $R['code_noindex'];
$sys['sublocation'] = $structure['firms'][$c]['title'];

$mskin = cot_tplfile(array('firms', 'add', $structure['firms'][$rfirm['firm_cat']]['tpl']));

/* === Hook === */
foreach (cot_getextplugins('firms.add.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'].'/header.php';
$t = new XTemplate($mskin);

$firmsadd_array = array(
	'FIRMADD_FIRMTITLE' => $L['firm_addtitle'],
	'FIRMADD_SUBTITLE' => $L['firm_addsubtitle'],
	'FIRMADD_ADMINEMAIL' => "mailto:".$cfg['adminemail'],
	'FIRMADD_FORM_SEND' => cot_url('firms', 'm=add&a=add&c='.$c),
	'FIRMADD_FORM_CAT' => cot_selectbox_structure('firms', $rfirm['firm_cat'], 'rfirmcat'),
	'FIRMADD_FORM_CAT_SHORT' => cot_selectbox_structure('firms', $rfirm['firm_cat'], 'rfirmcat', $c),
	'FIRMADD_FORM_KEYWORDS' => cot_inputbox('text', 'rfirmkeywords', $rfirm['firm_keywords'], array('size' => '32', 'maxlength' => '255')),
	'FIRMADD_FORM_METATITLE' => cot_inputbox('text', 'rfirmmetatitle', $rfirm['firm_metatitle'], array('size' => '64', 'maxlength' => '255')),
	'FIRMADD_FORM_METADESC' => cot_textarea('rfirmmetadesc', $rfirm['firm_metadesc'], 2, 64, array('maxlength' => '255')),
	'FIRMADD_FORM_ALIAS' => cot_inputbox('text', 'rfirmalias', $rfirm['firm_alias'], array('size' => '32', 'maxlength' => '255')),
	'FIRMADD_FORM_LOGO' => cot_filebox('rfirmlogo'),
	'FIRMADD_FORM_TITLE' => cot_inputbox('text', 'rfirmtitle', $rfirm['firm_title'], array('size' => '64', 'maxlength' => '255')),
	'FIRMADD_FORM_DESC' => cot_textarea('rfirmdesc', $rfirm['firm_desc'], 2, 64, '', 'input_textarea_editor'),
	'FIRMADD_FORM_OWNER' => cot_build_user($usr['id'], htmlspecialchars($usr['name'])),
	'FIRMADD_FORM_OWNERID' => $usr['id'],
	'FIRMADD_FORM_TEXT' => cot_textarea('rfirmtext', $rfirm['firm_text'], 12, 80, '', 'input_textarea_editor'),
	'FIRMADD_FORM_ADDR' => cot_inputbox('text', 'rfirmaddr', $rfirm['firm_addr'], array('size' => '64', 'maxlength' => '255')),
	'FIRMADD_FORM_PHONE' => cot_inputbox('text', 'rfirmphone', $rfirm['firm_phone'], array('size' => '64', 'maxlength' => '255')),
	'FIRMADD_FORM_SKYPE' => cot_inputbox('text', 'rfirmskype', $rfirm['firm_skype'], array('size' => '64', 'maxlength' => '255')),
	'FIRMADD_FORM_SITE' => cot_inputbox('text', 'rfirmsite', $rfirm['firm_site'], array('size' => '64', 'maxlength' => '255')),
	'FIRMADD_FORM_EMAIL' => cot_inputbox('text', 'rfirmemail', $rfirm['firm_email'], array('size' => '64', 'maxlength' => '255')),
	'FIRMADD_FORM_PARSER' => cot_selectbox($cfg['firms']['parser'], 'rfirmparser', $parser_list, $parser_list, false)
);

$t->assign($firmsadd_array);

// Extra fields
foreach($cot_extrafields[$db_firms] as $exfld)
{
	$uname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields('rfirm'.$exfld['field_name'], $exfld, $rfirm[$exfld['field_name']]);
	$exfld_title = isset($L['firm_'.$exfld['field_name'].'_title']) ?  $L['firm_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
	$t->assign(array(
		'FIRMADD_FORM_'.$uname => $exfld_val,
		'FIRMADD_FORM_'.$uname.'_TITLE' => $exfld_title,
		'FIRMADD_FORM_EXTRAFLD' => $exfld_val,
		'FIRMADD_FORM_EXTRAFLD_TITLE' => $exfld_title
		));
	$t->parse('MAIN.EXTRAFLD');
}

// Error and message handling
cot_display_messages($t);

/* === Hook === */
foreach (cot_getextplugins('firms.add.tags') as $pl)
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
