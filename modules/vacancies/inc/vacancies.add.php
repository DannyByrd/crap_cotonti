<?php
/**
 * Add vac.
 *
 * @package vacancies
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forms');

$id = cot_import('id', 'G', 'INT');
$c = cot_import('c', 'G', 'TXT');

if (!empty($c) && !isset($structure['vacancies'][$c]))
{
	$c = '';
}

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('vacancies', 'any');

/* === Hook === */
foreach (cot_getextplugins('vacancies.add.first') as $pl)
{
	include $pl;
}
/* ===== */
cot_block($usr['auth_write']);

if ($structure['vacancies'][$c]['locked'])
{
	cot_die_message(602, TRUE);
}

$sys['parser'] = $cfg['vacancies']['parser'];
$parser_list = cot_get_parsers();

if ($a == 'add')
{
	cot_shield_protect();

	/* === Hook === */
	foreach (cot_getextplugins('vacancies.add.add.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$rvac = cot_vacancies_import('POST', array(), $usr);

	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('vacancies', $rvac['vac_cat']);
	cot_block($usr['auth_write']);

	/* === Hook === */
	foreach (cot_getextplugins('vacancies.add.add.import') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_vacancies_validate($rvac);

	/* === Hook === */
	foreach (cot_getextplugins('vacancies.add.add.error') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!cot_error_found())
	{
		$id = cot_vacancies_add($rvac, $usr);
		if(cot_plugin_active('mavatars'))
		{

			$mavatar = new mavatar('vacancies', $rvac['vac_cat'], $id);
			$mavatar->ajax_upload();
			
		}

		switch ($rvac['vac_state'])
		{
			case 0:
				$urlparams = empty($rvac['vac_alias']) ?
					array('c' => $rvac['vac_cat'], 'id' => $id) :
					array('c' => $rvac['vac_cat'], 'al' => $rvac['vac_alias']);
				$r_url = cot_url('vacancies', $urlparams, '', true);
				break;
			case 1:
				$r_url = cot_url('message', 'msg=300', '', true);
				break;
			case 2:
				cot_message('vac_savedasdraft');
				$r_url = cot_url('vacancies', 'm=edit&id='.$id, '', true);
				break;
		}
		cot_redirect($r_url);
	}
	else
	{
		$c = ($c != $rvac['vac_cat']) ? $rvac['vac_cat'] : $c;
		cot_redirect(cot_url('vacancies', 'm=add&c='.$c, '', true));
	}
}

// Adv cloning support
$clone = cot_import('clone', 'G', 'INT');
if ($clone > 0)
{
	$rvac = $db->query("SELECT * FROM $db_vacancies WHERE vac_id = ?", $clone)->fetch();
}

if (empty($rvac['vac_cat']) && !empty($c))
{
	$rvac['vac_cat'] = $c;
	$usr['isadmin'] = cot_auth('vacancies', $rvac['vac_cat'], 'A');
}

$out['subtitle'] = $L['vac_addsubtitle'];
$out['head'] .= $R['code_noindex'];
$sys['sublocation'] = $structure['vacancies'][$c]['title'];

$mskin = cot_tplfile(array('vacancies', 'add', $structure['vacancies'][$rvac['vac_cat']]['tpl']));

/* === Hook === */
foreach (cot_getextplugins('vacancies.add.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'].'/header.php';
$t = new XTemplate($mskin);

$vacanciesadd_array = array(
	'VACADD_FIRMTITLE' => $L['vac_addtitle'],
	'VACADD_SUBTITLE' => $L['vac_addsubtitle'],
	'VACADD_ADMINEMAIL' => "mailto:".$cfg['adminemail'],
	'VACADD_FORM_SEND' => cot_url('vacancies', 'm=add&a=add&c='.$c),
	'VACADD_FORM_CAT' => cot_selectbox_structure('vacancies', $rvac['vac_cat'], 'rvaccat'),
	'VACADD_FORM_CAT_SHORT' => cot_selectbox_structure('vacancies', $rvac['vac_cat'], 'rvaccat', $c),
	'VACADD_FORM_KEYWORDS' => cot_inputbox('text', 'rvackeywords', $rvac['vac_keywords'], array('size' => '32', 'maxlength' => '255')),
	'VACADD_FORM_METATITLE' => cot_inputbox('text', 'rvacmetatitle', $rvac['vac_metatitle'], array('size' => '64', 'maxlength' => '255')),
	'VACADD_FORM_METADESC' => cot_textarea('rvacmetadesc', $rvac['vac_metadesc'], 2, 64, array('maxlength' => '255')),
	'VACADD_FORM_ALIAS' => cot_inputbox('text', 'rvacalias', $rvac['vac_alias'], array('size' => '32', 'maxlength' => '255')),
	'VACADD_FORM_TITLE' => cot_inputbox('text', 'rvactitle', $rvac['vac_title'], array('size' => '64', 'maxlength' => '255')),
	'VACADD_FORM_DESC' => cot_textarea('rvacdesc', $rvac['vac_desc'], 2, 64, '', 'input_textarea_editor'),
	'VACADD_FORM_OWNER' => cot_build_user($usr['id'], htmlspecialchars($usr['name'])),
	'VACADD_FORM_OWNERID' => $usr['id'],
	'VACADD_FORM_EXPIRE' => cot_selectbox_date(0, 'long', 'rvacexpire'),
	'VACADD_FORM_DUTY' => cot_textarea('rvacduty', $rvac['vac_duty'], 6, 80, '', ''),
	'VACADD_FORM_TERM' => cot_textarea('rvacterm', $rvac['vac_term'], 6, 80, '', ''),
	'VACADD_FORM_QUA' => cot_textarea('rvacqua', $rvac['vac_qua'], 6, 80, '', ''),
	'VACADD_FORM_EXPMIN' => cot_selectbox($rvac['vac_expmin'], 'rvacexpmin', range(1, 60)),
	'VACADD_FORM_EXPMAX' => cot_selectbox($rvac['vac_expmax'], 'rvacexpmax', range(1, 60)),
	'VACADD_FORM_EDU' => cot_selectbox_edu($rvac['vac_edu'], 'rvacedu'),
	'VACADD_FORM_AGEMIN' => cot_selectbox($rvac['vac_agemin'], 'rvacagemin', range(14, 65)),
	'VACADD_FORM_AGEMAX' => cot_selectbox($rvac['vac_agemax'], 'rvacagemax', range(14, 65)),
	'VACADD_FORM_SEX' => cot_selectbox_sex($rvac['vac_sex'], 'rvacsex'),
	'VACADD_FORM_SALARYMIN' => cot_inputbox('text', 'rvacsalarymin', $rvac['vac_salarymin'], array('size' => '12', 'maxlength' => '10')),
	'VACADD_FORM_SALARYMAX' => cot_inputbox('text', 'rvacsalarymax', $rvac['vac_salarymax'], array('size' => '12', 'maxlength' => '10')),
	'VACADD_FORM_ADDR' => cot_inputbox('text', 'rvacaddr', $rvac['vac_addr'], array('size' => '64', 'maxlength' => '255')),
	'VACADD_FORM_PHONE' => cot_inputbox('text', 'rvacphone', $rvac['vac_phone'], array('size' => '64', 'maxlength' => '255')),
	'VACADD_FORM_SKYPE' => cot_inputbox('text', 'rvacskype', $rvac['vac_skype'], array('size' => '64', 'maxlength' => '255')),
	'VACADD_FORM_SITE' => cot_inputbox('text', 'rvacsite', $rvac['vac_site'], array('size' => '64', 'maxlength' => '255')),
	'VACADD_FORM_EMAIL' => cot_inputbox('text', 'rvacemail', $rvac['vac_email'], array('size' => '64', 'maxlength' => '255')),
	'VACADD_FORM_HIDEMAIL' => cot_checkbox($rvac['vac_hidemail'], 'rvachidemail', $L['vac_hidemail'], 'class="checkbox"', 1),
);

$t->assign($vacanciesadd_array);

// Extra fields
foreach($cot_extrafields[$db_vacancies] as $exfld)
{
	$uname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields('rvac'.$exfld['field_name'], $exfld, $rvac[$exfld['field_name']]);
	$exfld_title = isset($L['vac_'.$exfld['field_name'].'_title']) ?  $L['vac_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
	$t->assign(array(
		'VACADD_FORM_'.$uname => $exfld_val,
		'VACADD_FORM_'.$uname.'_TITLE' => $exfld_title,
		'VACADD_FORM_EXTRAFLD' => $exfld_val,
		'VACADD_FORM_EXTRAFLD_TITLE' => $exfld_title
		));
	$t->parse('MAIN.EXTRAFLD');
}
if(cot_plugin_active('mavatars'))
{

	$mavatar = new mavatar('vacancies', $rvac['vac_cat'], 'new');
	$t->assign('VACADD_FORM_MAVATAR', $mavatar->generate_upload_form());
}

// Error and message handling
cot_display_messages($t);

/* === Hook === */
foreach (cot_getextplugins('vacancies.add.tags') as $pl)
{
	include $pl;
}
/* ===== */

if ($usr['isadmin'])
{
	if ($cfg['vacancies']['autovalidatevac']) $usr_can_publish = TRUE;
	$t->parse('MAIN.ADMIN');
}

$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'].'/footer.php';
