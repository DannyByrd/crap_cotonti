<?php
/**
 * Adv display.
 *
 * @package rezume
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('rezume', 'any');
cot_block($usr['auth_read']);

$id = cot_import('id', 'G', 'INT');
$al = $db->prep(cot_import('al', 'G', 'TXT'));
$c = cot_import('c', 'G', 'TXT');
$pg = cot_import('pg', 'G', 'INT');

/* === Hook === */
foreach (cot_getextplugins('rezume.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($id > 0 || !empty($al))
{
	$where = (!empty($al)) ? "rez_alias='".$al."' AND rez_cat='".$c."'" : 'rez_id='.$id.' AND rez_alias=""';
	$sql_rezume = $db->query("SELECT p.*, u.* $join_columns
		FROM $db_rezume AS p $join_condition
		LEFT JOIN $db_users AS u ON u.user_id=p.rez_ownerid
		WHERE $where LIMIT 1");
}

if(!$id && empty($al) || !$sql_rezume || $sql_rezume->rowCount() == 0)
{
	cot_die_message(404, TRUE);
}
$rez = $sql_rezume->fetch();

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('rezume', $rez['rez_cat'], 'RWA');
cot_block($usr['auth_read']);

if($a == 'sendmsg')
{
	$msgname = cot_import('msgname', 'P', 'TXT');
	$msgemail = cot_import('msgemail', 'P', 'TXT', 64, TRUE);
	$msgphone = cot_import('msgphone', 'P', 'TXT');
	$msgtext = cot_import('msgtext', 'P', 'TXT');
	
	if (empty($msgname))	cot_error('rez_contact_error_name', 'msgname');
	if (empty($msgemail) && empty($msgphone)) cot_error('rez_contact_error_phoneoremail', 'msgemail');
	if (!empty($msgemail) && !cot_check_email($msgemail))	cot_error('aut_emailtooshort', 'msgemail');
	
	/* === Hook === */
	foreach (cot_getextplugins('rezume.contactform.error') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if(!cot_error_found())
	{
		$subject = $L['rez_contact_msg_subject'];
		$body = sprintf($L['rez_contact_msg_body'], $rez['user_name'], $rez['rez_title'], $msgname, $msgemail, $msgphone, $msgtext);
		$headers = "From: \"" . mb_encode_mimeheader($cfg['maintitle'], 'UTF-8', 'B', "\n") . "\" <" . $cfg['adminemail'] . ">\n" . "Reply-To: <" . $msgemail . ">\n";
		
		/* === Hook === */
		foreach (cot_getextplugins('rezume.contactform.send') as $pl)
		{
			include $pl;
		}
		/* ===== */

		cot_mail($rez['user_email'], $subject, $body, $headers);
	}
	
	$url = (empty($rez['rez_alias'])) ? cot_url('rezume', 'c='.$rez['rez_cat'].'&id='.$rez['rez_id']) : cot_url('rezume', 'c='.$rez['rez_cat'].'&al='.$rez['rez_alias']);
	cot_redirect($url);
}


$al = empty($rez['rez_alias']) ? '' : $rez['rez_alias'];
$id = (int) $rez['rez_id'];
$cat = $structure['rezume'][$rez['rez_cat']];

$sys['sublocation'] = $rez['rez_title'];

$rez['rez_pageurl'] = empty($al) ? cot_url('rezume', array('c' => $rez['rez_cat'], 'id' => $id)) : cot_url('rezume', array('c' => $rez['rez_cat'], 'al' => $al));

if (($rez['rez_state'] == 1
		|| ($rez['rez_state'] == 2))
	&& (!$usr['isadmin'] && $usr['id'] != $rez['rez_ownerid']))
{
	cot_log("Attempt to directly access an un-validated REZ", 'sec');
	cot_die_message(403, TRUE);
}
if (!$usr['isadmin'] || $cfg['rezume']['count_admin'])
{
	$rez['rez_count']++;
	$sql_rez_update =  $db->query("UPDATE $db_rezume SET rez_count='".$rez['rez_count']."' WHERE rez_id=$id");
}

$title_params = array(
	'TITLE' => empty($rez['rez_metatitle']) ? $rez['rez_title'] : $rez['rez_metatitle'],
	'CATEGORY' => $cat['title']
);
$out['subtitle'] = cot_title($cfg['rezume']['title_rezume'], $title_params);

$out['desc'] = empty($rez['rez_metadesc']) ? strip_tags($rez['rez_desc']) : strip_tags($rez['rez_metadesc']);
$out['keywords'] = strip_tags($rez['rez_keywords']);

// Building the canonical URL
$rezurl_params = array('c' => $rez['rez_cat']);
empty($al) ? $rezurl_params['id'] = $id : $rezurl_params['al'] = $al;
if ($pg > 0)
{
	$rezurl_params['pg'] = $pg;
}
$out['canonical_uri'] = cot_url('rezume', $rezurl_params);

$mskin = cot_tplfile(array('rezume', $cat['tpl']));

/* === Hook === */
foreach (cot_getextplugins('rezume.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'] . '/header.php';
require_once cot_incfile('users', 'module');
$t = new XTemplate($mskin);

$t->assign(cot_generate_reztags($rez, 'REZ_', $usr['isadmin'], $cfg['homebreadcrumb']));
$t->assign('REZ_OWNER', cot_build_user($rez['rez_ownerid'], htmlspecialchars($rez['user_name'])));
$t->assign(cot_generate_usertags($rez, 'REZ_OWNER_'));

// Error and message handling
cot_display_messages($t, 'MAIN.CONTACTFORM');

$t->assign(array(
	'REZ_CONTACT_FORM_ACTION' => cot_url('rezume', 'c='.$rez['rez_cat'].'&id='.$rez['rez_alias'].'&a=sendmsg'),
	'REZ_CONTACT_FORM_NAME' => cot_inputbox('text', 'msgname', $msgname, array('size' => '64', 'maxlength' => '255')),
	'REZ_CONTACT_FORM_EMAIL' => cot_inputbox('text', 'msgemail', $msgemail, array('size' => '64', 'maxlength' => '255')),
	'REZ_CONTACT_FORM_PHONE' => cot_inputbox('text', 'msgphone', $msgphone, array('size' => '64', 'maxlength' => '255')),
	'REZ_CONTACT_FORM_TEXT' => cot_textarea('msgtext', $msgtext, 2, 64, array('maxlength' => '255')),
    
    'REZ_CONTACT_FORM_VERIFYIMG' => cot_captcha_generate(),
    'REZ_CONTACT_FORM_VERIFYINPUT' => cot_inputbox('text', 'rverify', '', 'size="10" maxlength="20"'),
));

/* === Hook === */
foreach (cot_getextplugins('rezume.contactform.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN.CONTACTFORM');

/* === Hook === */
foreach (cot_getextplugins('rezume.tags') as $pl)
{
	include $pl;
}
/* ===== */
if ($usr['isadmin'] || $usr['id'] == $rez['rez_ownerid'])
{
	$t->parse('MAIN.REZ_ADMIN');
}
$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'] . '/footer.php';

if ($cache && $usr['id'] === 0 && $cfg['cache_rezume']
	&& (!isset($cfg['cache_rez_blacklist']) || !in_array($rez['rez_cat'], $cfg['cache_rez_blacklist'])))
{
	$cache->rezume->write();
}
