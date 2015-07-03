<?php
/**
 * Edit rezume.
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

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('rezume', 'any');

/* === Hook === */
foreach (cot_getextplugins('rezume.edit.first') as $pl)
{
	include $pl;
}
/* ===== */

cot_block($usr['auth_read']);

if (!$id || $id < 0)
{
	cot_die_message(404);
}
$sql_rezume = $db->query("SELECT * FROM $db_rezume WHERE rez_id=$id LIMIT 1");
if($sql_rezume->rowCount() == 0)
{
	cot_die_message(404);
}
$row_rez = $sql_rezume->fetch();

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('rezume', $row_rez['rez_cat']);

$parser_list = cot_get_parsers();
$sys['parser'] = $row_rez['rez_parser'];

if ($a == 'update')
{
	/* === Hook === */
	foreach (cot_getextplugins('rezume.edit.update.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_block($usr['isadmin'] || $usr['auth_write'] && $usr['id'] == $row_rez['rez_ownerid']);

	$rez = cot_rezume_import('POST', $row_rez, $usr);

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$rezdelete = cot_import('rrezdelete', 'P', 'BOL');
	}
	else
	{
		$rezdelete = cot_import('delete', 'G', 'BOL');
		cot_check_xg();
	}

	if ($rezdelete)
	{
		cot_rezume_delete($id, $row_rez);
		cot_redirect(cot_url('rezume', "c=" . $row_rez['rez_cat'], '', true));
	}

	/* === Hook === */
	foreach (cot_getextplugins('rezume.edit.update.import') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_rezume_validate($rez);

	/* === Hook === */
	foreach (cot_getextplugins('rezume.edit.update.error') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!cot_error_found())
	{
		cot_rezume_update($id, $rez);

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

		switch ($rez['rez_state'])
		{
			case 0:
				$urlparams = empty($rez['rez_alias']) ?
					array('c' => $rez['rez_cat'], 'id' => $id) :
					array('c' => $rez['rez_cat'], 'al' => $rez['rez_alias']);
				$r_url = cot_url('rezume', $urlparams, '', true);
				break;
			case 1:
				$r_url = cot_url('message', 'msg=300', '', true);
				break;
			case 2:
				cot_message($L['rez_savedasdraft']);
				$r_url = cot_url('rezume', 'm=edit&id=' . $id, '', true);
				break;
		}
		cot_redirect($r_url);
	}
	else
	{
		cot_redirect(cot_url('rezume', "m=edit&id=$id", '', true));
	}
}

$rez = $row_rez;

$rez['rez_status'] = cot_rezume_status($rez['rez_state'], $rez['rez_expire']);

cot_block($usr['isadmin'] || $usr['auth_write'] && $usr['id'] == $rez['rez_ownerid']);

$out['subtitle'] = $L['rez_edittitle'];
$out['head'] .= $R['code_noindex'];
$sys['sublocation'] = $structure['rezume'][$rez['rez_cat']]['title'];

$mskin = cot_tplfile(array('rezume', 'edit', $structure['rezume'][$rez['rez_cat']]['tpl']));

/* === Hook === */
foreach (cot_getextplugins('rezume.edit.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'].'/header.php';
$t = new XTemplate($mskin);

$rezumeedit_array = array(
	'REZEDIT_FIRMTITLE' => $L['rez_edittitle'],
	'REZEDIT_SUBTITLE' => $L['rez_editsubtitle'],
	'REZEDIT_FORM_SEND' => cot_url('rezume', "m=edit&a=update&id=".$rez['rez_id']),
	'REZEDIT_FORM_ID' => $rez['rez_id'],
	'REZEDIT_FORM_STATE' => $rez['rez_state'],
	'REZEDIT_FORM_STATUS' => $rez['rez_status'],
	'REZEDIT_FORM_LOCALSTATUS' => $L['rez_status_'.$rez['rez_status']],
	'REZEDIT_FORM_CAT' => cot_selectbox_structure('rezume', $rez['rez_cat'], 'rrezcat'),
	'REZEDIT_FORM_CAT_SHORT' => cot_selectbox_structure('rezume', $rez['rez_cat'], 'rrezcat', $c),
	'REZEDIT_FORM_KEYWORDS' => cot_inputbox('text', 'rrezkeywords', $rez['rez_keywords'], array('size' => '32', 'maxlength' => '255')),
	'REZEDIT_FORM_METATITLE' => cot_inputbox('text', 'rrezmetatitle', $rez['rez_metatitle'], array('size' => '64', 'maxlength' => '255')),
	'REZEDIT_FORM_METADESC' => cot_textarea('rrezmetadesc', $rez['rez_metadesc'], 2, 64, array('maxlength' => '255')),
	'REZEDIT_FORM_ALIAS' => cot_inputbox('text', 'rrezalias', $rez['rez_alias'], array('size' => '32', 'maxlength' => '255')),
	'REZEDIT_FORM_TITLE' => cot_inputbox('text', 'rreztitle', $rez['rez_title'], array('size' => '64', 'maxlength' => '255')),
	'REZEDIT_FORM_DATE' => cot_selectbox_date($rez['rez_date'], 'long', 'rrezdate').' '.$usr['timetext'],
	'REZEDIT_FORM_DATENOW' => cot_checkbox(0, 'rrezdatenow'),
	'REZEDIT_FORM_UPDATED' => cot_date('datetime_full', $rez['rez_updated']).' '.$usr['timetext'],
	'REZEDIT_FORM_EXPIRE' => cot_selectbox_date($rez['rez_expire'], 'long', 'rrezexpire').' '.$usr['timetext'],
	'REZEDIT_FORM_QUA' => cot_textarea('rrezqua', $rez['rez_qua'], 6, 80, '', ''),
	'REZEDIT_FORM_EXP' => cot_selectbox($rez['rez_exp'], 'rrezexp', range(1, 60)),
	'REZEDIT_FORM_WORKS' => cot_textarea('rrezworks', $rez['rez_works'], 6, 80, '', ''),
	'REZEDIT_FORM_EDU' => cot_selectbox_edu($rez['rez_edu'], 'rrezedu'),
	'REZEDIT_FORM_STUDY' => cot_textarea('rrezstudy', $rez['rez_study'], 6, 80, '', ''),
	'REZEDIT_FORM_AGE' => cot_selectbox($rez['rez_age'], 'rrezage', range(14, 65)),
	'REZEDIT_FORM_SEX' => cot_selectbox_sex($rez['rez_sex'], 'rrezsex'),
	'REZEDIT_FORM_SALARY' => cot_inputbox('text', 'rrezsalary', $rez['rez_salary'], array('size' => '12', 'maxlength' => '10')),
	'REZEDIT_FORM_FIO' => cot_inputbox('text', 'rrezfio', $rez['rez_fio'], array('size' => '64', 'maxlength' => '255')),
	'REZEDIT_FORM_ADDR' => cot_inputbox('text', 'rrezaddr', $rez['rez_addr'], array('size' => '64', 'maxlength' => '255')),
	'REZEDIT_FORM_PHONE' => cot_inputbox('text', 'rrezphone', $rez['rez_phone'], array('size' => '64', 'maxlength' => '255')),
	'REZEDIT_FORM_SKYPE' => cot_inputbox('text', 'rrezskype', $rez['rez_skype'], array('size' => '64', 'maxlength' => '255')),
	'REZEDIT_FORM_SITE' => cot_inputbox('text', 'rrezsite', $rez['rez_site'], array('size' => '64', 'maxlength' => '255')),
	'REZEDIT_FORM_EMAIL' => cot_inputbox('text', 'rrezemail', $rez['rez_email'], array('size' => '64', 'maxlength' => '255')),
	'REZEDIT_FORM_DELETE' => cot_radiobox(0, 'rrezdelete', array(1, 0), array($L['Yes'], $L['No'])),
	'REZEDIT_FORM_PARSER' => cot_selectbox($rez['rez_parser'], 'rrezparser', cot_get_parsers(), cot_get_parsers(), false),
);
if ($usr['isadmin'])
{
	$rezumeedit_array += array(
		'REZEDIT_FORM_OWNERID' => cot_inputbox('text', 'rrezownerid', $rez['rez_ownerid'], array('size' => '24', 'maxlength' => '24')),
		'REZEDIT_FORM_rezCOUNT' => cot_inputbox('text', 'rrezcount', $rez['rez_count'], array('size' => '8', 'maxlength' => '8')),
	);
}

$t->assign($rezumeedit_array);

// Extra fields
foreach($cot_extrafields[$db_rezume] as $exfld)
{
	$uname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields('rrez'.$exfld['field_name'], $exfld, $rez['rez_'.$exfld['field_name']]);
	$exfld_title = isset($L['rez_'.$exfld['field_name'].'_title']) ?  $L['rez_'.$exfld['field_name'].'_title'] : $exfld['field_description'];

	$t->assign(array(
		'REZEDIT_FORM_'.$uname => $exfld_val,
		'REZEDIT_FORM_'.$uname.'_TITLE' => $exfld_title,
		'REZEDIT_FORM_EXTRAFLD' => $exfld_val,
		'REZEDIT_FORM_EXTRAFLD_TITLE' => $exfld_title
	));
	$t->parse('MAIN.EXTRAFLD');
}

// Error and message handling
cot_display_messages($t);

/* === Hook === */
foreach (cot_getextplugins('rezume.edit.tags') as $pl)
{
	include $pl;
}
/* ===== */

if(cot_plugin_active('mavatars'))
{
	$mavatar = new mavatar('rezume', $rez['rez_cat'], $rez['rez_id']);
	$t->assign('REZEDIT_FORM_MAVATAR', $mavatar->generate_upload_form());
}

if ($usr['isadmin'])
{
	if ($cfg['rezume']['autovalidaterez']) $usr_can_publish = TRUE;
	$t->parse('MAIN.ADMIN');
}

$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'].'/footer.php';
