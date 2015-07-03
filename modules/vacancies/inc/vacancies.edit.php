<?php
/**
 * Edit vacancies.
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

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('vacancies', 'any');

/* === Hook === */
foreach (cot_getextplugins('vacancies.edit.first') as $pl)
{
	include $pl;
}
/* ===== */

cot_block($usr['auth_read']);

if (!$id || $id < 0)
{
	cot_die_message(404);
}
$sql_vacancies = $db->query("SELECT * FROM $db_vacancies WHERE vac_id=$id LIMIT 1");
if($sql_vacancies->rowCount() == 0)
{
	cot_die_message(404);
}
$row_vac = $sql_vacancies->fetch();

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('vacancies', $row_vac['vac_cat']);

$parser_list = cot_get_parsers();
$sys['parser'] = $row_vac['vac_parser'];

if ($a == 'update')
{
	/* === Hook === */
	foreach (cot_getextplugins('vacancies.edit.update.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_block($usr['isadmin'] || $usr['auth_write'] && $usr['id'] == $row_vac['vac_ownerid']);

	$vac = cot_vacancies_import('POST', $row_vac, $usr);

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$vacdelete = cot_import('rvacdelete', 'P', 'BOL');
	}
	else
	{
		$vacdelete = cot_import('delete', 'G', 'BOL');
		cot_check_xg();
	}

	if ($vacdelete)
	{
		cot_vacancies_delete($id, $row_vac);
		cot_redirect(cot_url('vacancies', "c=" . $row_vac['vac_cat'], '', true));
	}

	/* === Hook === */
	foreach (cot_getextplugins('vacancies.edit.update.import') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_vacancies_validate($vac);

	/* === Hook === */
	foreach (cot_getextplugins('vacancies.edit.update.error') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!cot_error_found())
	{
		cot_vacancies_update($id, $vac);

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

		switch ($vac['vac_state'])
		{
			case 0:
				$urlparams = empty($vac['vac_alias']) ?
					array('c' => $vac['vac_cat'], 'id' => $id) :
					array('c' => $vac['vac_cat'], 'al' => $vac['vac_alias']);
				$r_url = cot_url('vacancies', $urlparams, '', true);
				break;
			case 1:
				$r_url = cot_url('message', 'msg=300', '', true);
				break;
			case 2:
				cot_message($L['vac_savedasdraft']);
				$r_url = cot_url('vacancies', 'm=edit&id=' . $id, '', true);
				break;
		}
		cot_redirect($r_url);
	}
	else
	{
		cot_redirect(cot_url('vacancies', "m=edit&id=$id", '', true));
	}
}

$vac = $row_vac;

$vac['vac_status'] = cot_vacancies_status($vac['vac_state'], $vac['vac_expire']);

cot_block($usr['isadmin'] || $usr['auth_write'] && $usr['id'] == $vac['vac_ownerid']);

$out['subtitle'] = $L['vac_edittitle'];
$out['head'] .= $R['code_noindex'];
$sys['sublocation'] = $structure['vacancies'][$vac['vac_cat']]['title'];

$mskin = cot_tplfile(array('vacancies', 'edit', $structure['vacancies'][$vac['vac_cat']]['tpl']));

/* === Hook === */
foreach (cot_getextplugins('vacancies.edit.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'].'/header.php';
$t = new XTemplate($mskin);

list($vac['vac_salarymin'], $vac['vac_salarymax']) = explode('-', $vac['vac_salary']);
list($vac['vac_agemin'], $vac['vac_agemax']) = explode('-', $vac['vac_age']);
list($vac['vac_expmin'], $vac['vac_expmax']) = explode('-', $vac['vac_exp']);

$vacanciesedit_array = array(
	'VACEDIT_FIRMTITLE' => $L['vac_edittitle'],
	'VACEDIT_SUBTITLE' => $L['vac_editsubtitle'],
	'VACEDIT_FORM_SEND' => cot_url('vacancies', "m=edit&a=update&id=".$vac['vac_id']),
	'VACEDIT_FORM_ID' => $vac['vac_id'],
	'VACEDIT_FORM_STATE' => $vac['vac_state'],
	'VACEDIT_FORM_STATUS' => $vac['vac_status'],
	'VACEDIT_FORM_LOCALSTATUS' => $L['vac_status_'.$vac['vac_status']],
	'VACEDIT_FORM_CAT' => cot_selectbox_structure('vacancies', $vac['vac_cat'], 'rvaccat'),
	'VACEDIT_FORM_CAT_SHORT' => cot_selectbox_structure('vacancies', $vac['vac_cat'], 'rvaccat', $c),
	'VACEDIT_FORM_KEYWORDS' => cot_inputbox('text', 'rvackeywords', $vac['vac_keywords'], array('size' => '32', 'maxlength' => '255')),
	'VACEDIT_FORM_METATITLE' => cot_inputbox('text', 'rvacmetatitle', $vac['vac_metatitle'], array('size' => '64', 'maxlength' => '255')),
	'VACEDIT_FORM_METADESC' => cot_textarea('rvacmetadesc', $vac['vac_metadesc'], 2, 64, array('maxlength' => '255')),
	'VACEDIT_FORM_ALIAS' => cot_inputbox('text', 'rvacalias', $vac['vac_alias'], array('size' => '32', 'maxlength' => '255')),
	'VACEDIT_FORM_TITLE' => cot_inputbox('text', 'rvactitle', $vac['vac_title'], array('size' => '64', 'maxlength' => '255')),
	'VACEDIT_FORM_DESC' => cot_textarea('rvacdesc', $vac['vac_desc'], 2, 64, '', 'input_textarea_editor'),
	'VACEDIT_FORM_DATE' => cot_selectbox_date($vac['vac_date'], 'long', 'rvacdate').' '.$usr['timetext'],
	'VACEDIT_FORM_DATENOW' => cot_checkbox(0, 'rvacdatenow'),
	'VACEDIT_FORM_UPDATED' => cot_date('datetime_full', $vac['vac_updated']).' '.$usr['timetext'],
	'VACEDIT_FORM_EXPIRE' => cot_selectbox_date($vac['vac_expire'], 'long', 'rvacexpire').' '.$usr['timetext'],
	'VACEDIT_FORM_DUTY' => cot_textarea('rvacduty', $vac['vac_duty'], 6, 80, '', ''),
	'VACEDIT_FORM_TERM' => cot_textarea('rvacterm', $vac['vac_term'], 6, 80, '', ''),
	'VACEDIT_FORM_QUA' => cot_textarea('rvacqua', $vac['vac_qua'], 6, 80, '', ''),
	'VACEDIT_FORM_EXPMIN' => cot_selectbox($vac['vac_expmin'], 'rvacexpmin', range(1, 60)),
	'VACEDIT_FORM_EXPMAX' => cot_selectbox($vac['vac_expmax'], 'rvacexpmax', range(1, 60)),
	'VACEDIT_FORM_EDU' => cot_selectbox_edu($vac['vac_edu'], 'rvacedu'),
	'VACEDIT_FORM_AGEMIN' => cot_selectbox($vac['vac_agemin'], 'rvacagemin', range(14, 65)),
	'VACEDIT_FORM_AGEMAX' => cot_selectbox($vac['vac_agemax'], 'rvacagemax', range(14, 65)),
	'VACEDIT_FORM_SEX' => cot_selectbox_sex($vac['vac_sex'], 'rvacsex'),
	'VACEDIT_FORM_SALARYMIN' => cot_inputbox('text', 'rvacsalarymin', $vac['vac_salarymin'], array('size' => '12', 'maxlength' => '10')),
	'VACEDIT_FORM_SALARYMAX' => cot_inputbox('text', 'rvacsalarymax', $vac['vac_salarymax'], array('size' => '12', 'maxlength' => '10')),
	'VACEDIT_FORM_ADDR' => cot_inputbox('text', 'rvacaddr', $vac['vac_addr'], array('size' => '64', 'maxlength' => '255')),
	'VACEDIT_FORM_PHONE' => cot_inputbox('text', 'rvacphone', $vac['vac_phone'], array('size' => '64', 'maxlength' => '255')),
	'VACEDIT_FORM_SKYPE' => cot_inputbox('text', 'rvacskype', $vac['vac_skype'], array('size' => '64', 'maxlength' => '255')),
	'VACEDIT_FORM_SITE' => cot_inputbox('text', 'rvacsite', $vac['vac_site'], array('size' => '64', 'maxlength' => '255')),
	'VACEDIT_FORM_EMAIL' => cot_inputbox('text', 'rvacemail', $vac['vac_email'], array('size' => '64', 'maxlength' => '255')),
	'VACEDIT_FORM_DELETE' => cot_radiobox(0, 'rvacdelete', array(1, 0), array($L['Yes'], $L['No'])),
	'VACEDIT_FORM_PARSER' => cot_selectbox($vac['vac_parser'], 'rvacparser', cot_get_parsers(), cot_get_parsers(), false),
);
if ($usr['isadmin'])
{
	$vacanciesedit_array += array(
		'VACEDIT_FORM_OWNERID' => cot_inputbox('text', 'rvacownerid', $vac['vac_ownerid'], array('size' => '24', 'maxlength' => '24')),
		'VACEDIT_FORM_VACCOUNT' => cot_inputbox('text', 'rvaccount', $vac['vac_count'], array('size' => '8', 'maxlength' => '8')),
	);
}

$t->assign($vacanciesedit_array);

// Extra fields
foreach($cot_extrafields[$db_vacancies] as $exfld)
{
	$uname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields('rvac'.$exfld['field_name'], $exfld, $vac['vac_'.$exfld['field_name']]);
	$exfld_title = isset($L['vac_'.$exfld['field_name'].'_title']) ?  $L['vac_'.$exfld['field_name'].'_title'] : $exfld['field_description'];

	$t->assign(array(
		'VACEDIT_FORM_'.$uname => $exfld_val,
		'VACEDIT_FORM_'.$uname.'_TITLE' => $exfld_title,
		'VACEDIT_FORM_EXTRAFLD' => $exfld_val,
		'VACEDIT_FORM_EXTRAFLD_TITLE' => $exfld_title
	));
	$t->parse('MAIN.EXTRAFLD');
}

// Error and message handling
cot_display_messages($t);

if(cot_plugin_active('mavatars'))
{
   
	$mavatar = new mavatar('vacancies', $vac['vac_cat'], $vac['vac_id']);
	$t->assign('VACEDIT_FORM_MAVATAR', $mavatar->generate_upload_form());
			
 }

/* === Hook === */
foreach (cot_getextplugins('vacancies.edit.tags') as $pl)
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
