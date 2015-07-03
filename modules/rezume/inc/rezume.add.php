<?php
/**
 * Add rezume.
 *
 * @package rezume
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forms');

$id = cot_import('id', 'G', 'INT');
$c = cot_import('c', 'G', 'TXT');

if (!empty($c) && !isset($structure['rezume'][$c]))
{
	$c = '';
}

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('rezume', 'any');

/* === Hook === */
foreach (cot_getextplugins('rezume.add.first') as $pl)
{
	include $pl;
}
/* ===== */
cot_block($usr['auth_write']);

if ($structure['rezume'][$c]['locked'])
{
	cot_die_message(602, TRUE);
}

$sys['parser'] = $cfg['rezume']['parser'];
$parser_list = cot_get_parsers();

if ($a == 'add')
{
	cot_shield_protect();

	/* === Hook === */
	foreach (cot_getextplugins('rezume.add.add.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$rrez = cot_rezume_import('POST', array(), $usr);
	
	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('rezume', $rrez['rez_cat']);
	cot_block($usr['auth_write']);

	/* === Hook === */
	foreach (cot_getextplugins('rezume.add.add.import') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_rezume_validate($rrez);

	/* === Hook === */
	foreach (cot_getextplugins('rezume.add.add.error') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
    

	if (!cot_error_found())
	{

		
		$id = cot_rezume_add($rrez, $usr);
		
		

		if(cot_plugin_active('mavatars'))
		{

			$mavatar = new mavatar('rezume', $rrez['rez_cat'], $id);
			$mavatar->ajax_upload();
			
		}

		switch ($rrez['rez_state'])
		{
			case 0:
				$urlparams = empty($rrez['rez_alias']) ?
					array('c' => $rrez['rez_cat'], 'id' => $id) :
					array('c' => $rrez['rez_cat'], 'al' => $rrez['rez_alias']);
				$r_url = cot_url('rezume', $urlparams, '', true);
				break;
			case 1:
				$r_url = cot_url('message', 'msg=300', '', true);
				break;
			case 2:
				cot_message('rez_savedasdraft');
				$r_url = cot_url('rezume', 'm=edit&id='.$id, '', true);
				break;
		}
		cot_redirect($r_url);
	}
	else
	{
		$c = ($c != $rrez['rez_cat']) ? $rrez['rez_cat'] : $c;
		cot_redirect(cot_url('rezume', 'm=add&c='.$c, '', true));
	}
}

// Adv cloning support
$clone = cot_import('clone', 'G', 'INT');
if ($clone > 0)
{
	$rrez = $db->query("SELECT * FROM $db_rezume WHERE rez_id = ?", $clone)->fetch();
}

if (empty($rrez['rez_cat']) && !empty($c))
{
	$rrez['rez_cat'] = $c;
	$usr['isadmin'] = cot_auth('rezume', $rrez['rez_cat'], 'A');
}

$out['subtitle'] = $L['rez_addsubtitle'];
$out['head'] .= $R['code_noindex'];
$sys['sublocation'] = $structure['rezume'][$c]['title'];

$mskin = cot_tplfile(array('rezume', 'add', $structure['rezume'][$rrez['rez_cat']]['tpl']));

/* === Hook === */
foreach (cot_getextplugins('rezume.add.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'].'/header.php';
$t = new XTemplate($mskin);

$rezumeadd_array = array(
	'REZADD_FIRMTITLE' => $L['rez_addtitle'],
	'REZADD_SUBTITLE' => $L['rez_addsubtitle'],
	'REZADD_ADMINEMAIL' => "mailto:".$cfg['adminemail'],
	'REZADD_FORM_SEND' => cot_url('rezume', 'm=add&a=add&c='.$c),
	'REZADD_FORM_CAT' => cot_selectbox_structure('rezume', $rrez['rez_cat'], 'rrezcat'),
	'REZADD_FORM_CAT_SHORT' => cot_selectbox_structure('rezume', $rrez['rez_cat'], 'rrezcat', $c),
	'REZADD_FORM_KEYWORDS' => cot_inputbox('text', 'rrezkeywords', $rrez['rez_keywords'], array('size' => '32', 'maxlength' => '255')),
	'REZADD_FORM_METATITLE' => cot_inputbox('text', 'rrezmetatitle', $rrez['rez_metatitle'], array('size' => '64', 'maxlength' => '255')),
	'REZADD_FORM_METADESC' => cot_textarea('rrezmetadesc', $rrez['rez_metadesc'], 2, 64, array('maxlength' => '255')),
	'REZADD_FORM_ALIAS' => cot_inputbox('text', 'rrezalias', $rrez['rez_alias'], array('size' => '32', 'maxlength' => '255')),
	'REZADD_FORM_TITLE' => cot_inputbox('text', 'rreztitle', $rrez['rez_title'], array('size' => '64', 'maxlength' => '255')),
	'REZADD_FORM_OWNER' => cot_build_user($usr['id'], htmlspecialchars($usr['name'])),
	'REZADD_FORM_OWNERID' => $usr['id'],
	'REZADD_FORM_EXPIRE' => cot_selectbox_date(0, 'long', 'rrezexpire'),
	'REZADD_FORM_QUA' => cot_textarea('rrezqua', $rrez['rez_qua'], 6, 80, '', ''),
	'REZADD_FORM_EXP' => cot_selectbox($rrez['rez_exp'], 'rrezexp', range(1, 60)),
	'REZADD_FORM_WORKS' => cot_textarea('rrezworks', $rrez['rez_works'], 6, 80, '', ''),
	'REZADD_FORM_EDU' => cot_selectbox_edu($rrez['rez_edu'], 'rrezedu'),
	'REZADD_FORM_STUDY' => cot_textarea('rrezstudy', $rrez['rez_study'], 6, 80, '', ''),
	'REZADD_FORM_AGE' => cot_selectbox($rrez['rez_age'], 'rrezage', range(14, 65)),
	'REZADD_FORM_SEX' => cot_selectbox_sex($rrez['rez_sex'], 'rrezsex'),
	'REZADD_FORM_SALARY' => cot_inputbox('text', 'rrezsalary', $rrez['rez_salary'], array('size' => '12', 'maxlength' => '10')),
	'REZADD_FORM_FIO' => cot_inputbox('text', 'rrezfio', $rrez['rez_fio'], array('size' => '64', 'maxlength' => '255')),
	'REZADD_FORM_ADDR' => cot_inputbox('text', 'rrezaddr', $rrez['rez_addr'], array('size' => '64', 'maxlength' => '255')),
	'REZADD_FORM_PHONE' => cot_inputbox('text', 'rrezphone', $rrez['rez_phone'], array('size' => '64', 'maxlength' => '255')),
	'REZADD_FORM_SKYPE' => cot_inputbox('text', 'rrezskype', $rrez['rez_skype'], array('size' => '64', 'maxlength' => '255')),
	'REZADD_FORM_SITE' => cot_inputbox('text', 'rrezsite', $rrez['rez_site'], array('size' => '64', 'maxlength' => '255')),
	'REZADD_FORM_EMAIL' => cot_inputbox('text', 'rrezemail', $rrez['rez_email'], array('size' => '64', 'maxlength' => '255')),
	'REZADD_FORM_HIDEMAIL' => cot_checkbox($rrez['rez_hidemail'], 'rrezhidemail', $L['rez_hidemail'], 'class="checkbox"', 1),
);

$t->assign($rezumeadd_array);

// Extra fields
foreach($cot_extrafields[$db_rezume] as $exfld)
{
	$uname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields('rrez'.$exfld['field_name'], $exfld, $rrez[$exfld['field_name']]);
	$exfld_title = isset($L['rez_'.$exfld['field_name'].'_title']) ?  $L['rez_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
	$t->assign(array(
		'REZADD_FORM_'.$uname => $exfld_val,
		'REZADD_FORM_'.$uname.'_TITLE' => $exfld_title,
		'REZADD_FORM_EXTRAFLD' => $exfld_val,
		'REZADD_FORM_EXTRAFLD_TITLE' => $exfld_title
		));
	$t->parse('MAIN.EXTRAFLD');
}


if(cot_plugin_active('mavatars'))
{

	$mavatar = new mavatar('rezume', $rrez['rez_cat'], 'new');
	$t->assign('REZADD_FORM_MAVATAR', $mavatar->generate_upload_form());
}


// Error and message handling
cot_display_messages($t);

/* === Hook === */
foreach (cot_getextplugins('rezume.add.tags') as $pl)
{
	include $pl;
}
/* ===== */

if ($usr['isadmin'])
{
	if ($cfg['rezume']['autovalidaterez']) $usr_can_publish = TRUE;
	$t->parse('MAIN.ADMIN');
}

$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'].'/footer.php';
