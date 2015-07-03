<?php
/**
 * Adv display.
 *
 * @package vacancies
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('vacancies', 'any');
cot_block($usr['auth_read']);

$id = cot_import('id', 'G', 'INT');
$al = $db->prep(cot_import('al', 'G', 'TXT'));
$c = cot_import('c', 'G', 'TXT');
$pg = cot_import('pg', 'G', 'INT');

/* === Hook === */
foreach (cot_getextplugins('vacancies.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($id > 0 || !empty($al))
{
	$where = (!empty($al)) ? "vac_alias='".$al."' AND vac_cat='".$c."'" : 'vac_id='.$id.' AND vac_alias=""';
	$sql_vacancies = $db->query("SELECT p.*, u.* $join_columns
		FROM $db_vacancies AS p $join_condition
		LEFT JOIN $db_users AS u ON u.user_id=p.vac_ownerid
		WHERE $where LIMIT 1");
}

if(!$id && empty($al) || !$sql_vacancies || $sql_vacancies->rowCount() == 0)
{
	cot_die_message(404, TRUE);
}
$vac = $sql_vacancies->fetch();

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('vacancies', $vac['vac_cat'], 'RWA');
cot_block($usr['auth_read']);

if($a == 'sendmsg')
{
	$msgname = cot_import('msgname', 'P', 'TXT');
	$msgemail = cot_import('msgemail', 'P', 'TXT', 64, TRUE);
	$msgphone = cot_import('msgphone', 'P', 'TXT');
	$msgtext = cot_import('msgtext', 'P', 'TXT');
	
	if (empty($msgname))	cot_error('vac_contact_error_name', 'msgname');
	if (empty($msgemail) && empty($msgphone)) cot_error('vac_contact_error_phoneoremail', 'msgemail');
	if (!empty($msgemail) && !cot_check_email($msgemail))	cot_error('aut_emailtooshort', 'msgemail');
	
	/* === Hook === */
	foreach (cot_getextplugins('vacancies.contactform.error') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if(!cot_error_found())
	{
		$subject = $L['vac_contact_msg_subject'];
		$body = sprintf($L['vac_contact_msg_body'], $vac['user_name'], $vac['vac_title'], $msgname, $msgemail, $msgphone, $msgtext);
		$headers = "From: \"" . mb_encode_mimeheader($cfg['maintitle'], 'UTF-8', 'B', "\n") . "\" <" . $cfg['adminemail'] . ">\n" . "Reply-To: <" . $msgemail . ">\n";
		
		/* === Hook === */
		foreach (cot_getextplugins('vacancies.contactform.send') as $pl)
		{
			include $pl;
		}
		/* ===== */

		cot_mail($vac['user_email'], $subject, $body, $headers);
	}
	
	$url = (empty($vac['vac_alias'])) ? cot_url('vacancies', 'c='.$vac['vac_cat'].'&id='.$vac['vac_id']) : cot_url('vacancies', 'c='.$vac['vac_cat'].'&al='.$vac['vac_alias']);
	cot_redirect($url);
}


$al = empty($vac['vac_alias']) ? '' : $vac['vac_alias'];
$id = (int) $vac['vac_id'];
$cat = $structure['vacancies'][$vac['vac_cat']];

$sys['sublocation'] = $vac['vac_title'];

$vac['vac_pageurl'] = empty($al) ? cot_url('vacancies', array('c' => $vac['vac_cat'], 'id' => $id)) : cot_url('vacancies', array('c' => $vac['vac_cat'], 'al' => $al));

if (($vac['vac_state'] == 1
		|| ($vac['vac_state'] == 2))
	&& (!$usr['isadmin'] && $usr['id'] != $vac['vac_ownerid']))
{
	cot_log("Attempt to directly access an un-validated vac", 'sec');
	cot_die_message(403, TRUE);
}
if (!$usr['isadmin'] || $cfg['vacancies']['count_admin'])
{
	$vac['vac_count']++;
	$sql_vac_update =  $db->query("UPDATE $db_vacancies SET vac_count='".$vac['vac_count']."' WHERE vac_id=$id");
}

$title_params = array(
	'TITLE' => empty($vac['vac_metatitle']) ? $vac['vac_title'] : $vac['vac_metatitle'],
	'CATEGORY' => $cat['title']
);
$out['subtitle'] = cot_title($cfg['vacancies']['title_vacancies'], $title_params);

$out['desc'] = empty($vac['vac_metadesc']) ? strip_tags($vac['vac_desc']) : strip_tags($vac['vac_metadesc']);
$out['keywords'] = strip_tags($vac['vac_keywords']);

// Building the canonical URL
$vacurl_params = array('c' => $vac['vac_cat']);
empty($al) ? $vacurl_params['id'] = $id : $vacurl_params['al'] = $al;
if ($pg > 0)
{
	$vacurl_params['pg'] = $pg;
}
$out['canonical_uri'] = cot_url('vacancies', $vacurl_params);

$mskin = cot_tplfile(array('vacancies', $cat['tpl']));

/* === Hook === */
foreach (cot_getextplugins('vacancies.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'] . '/header.php';
require_once cot_incfile('users', 'module');
$t = new XTemplate($mskin);

$t->assign(cot_generate_vactags($vac, 'VAC_', $usr['isadmin'], $cfg['homebreadcrumb']));
$t->assign('VAC_OWNER', cot_build_user($vac['vac_ownerid'], htmlspecialchars($vac['user_name'])));
$t->assign(cot_generate_usertags($vac, 'VAC_OWNER_'));

// Error and message handling
cot_display_messages($t, 'MAIN.CONTACTFORM');

$t->assign(array(
	'VAC_CONTACT_FORM_ACTION' => cot_url('vacancies', 'c='.$vac['vac_cat'].'&id='.$vac['vac_id'].'&a=sendmsg'),
	'VAC_CONTACT_FORM_NAME' => cot_inputbox('text', 'msgname', $msgname, array('size' => '64', 'maxlength' => '255')),
	'VAC_CONTACT_FORM_EMAIL' => cot_inputbox('text', 'msgemail', $msgemail, array('size' => '64', 'maxlength' => '255')),
	'VAC_CONTACT_FORM_PHONE' => cot_inputbox('text', 'msgphone', $msgphone, array('size' => '64', 'maxlength' => '255')),
	'VAC_CONTACT_FORM_TEXT' => cot_textarea('msgtext', $msgtext, 2, 64, array('maxlength' => '255')),
));

/* === Hook === */
foreach (cot_getextplugins('vacancies.contactform.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN.CONTACTFORM');

/* === Hook === */
foreach (cot_getextplugins('vacancies.tags') as $pl)
{
	include $pl;
}
/* ===== */
if ($usr['isadmin'] || $usr['id'] == $vac['vac_ownerid'])
{
	$t->parse('MAIN.VAC_ADMIN');
}
$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'] . '/footer.php';

if ($cache && $usr['id'] === 0 && $cfg['cache_vacancies']
	&& (!isset($cfg['cache_vac_blacklist']) || !in_array($vac['vac_cat'], $cfg['cache_vac_blacklist'])))
{
	$cache->vacancies->write();
}
