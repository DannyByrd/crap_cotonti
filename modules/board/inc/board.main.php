<?php
/**
 * Adv display.
 *
 * @package board
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('board', 'any');
cot_block($usr['auth_read']);

$id = cot_import('id', 'G', 'INT');
$al = $db->prep(cot_import('al', 'G', 'TXT'));
$c = cot_import('c', 'G', 'TXT');
$pg = cot_import('pg', 'G', 'INT');

/* === Hook === */
foreach (cot_getextplugins('board.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($id > 0 || !empty($al))
{
	$where = (!empty($al)) ? "adv_alias='".$al."'" : 'adv_id='.$id.' AND adv_alias=""';
	$sql_board = $db->query("SELECT p.*, u.* $join_columns
		FROM $db_board AS p $join_condition
		LEFT JOIN $db_users AS u ON u.user_id=p.adv_ownerid
		WHERE $where LIMIT 1");
}

if(!$id && empty($al) || !$sql_board || $sql_board->rowCount() == 0)
{
	cot_die_message(404, TRUE);
}
$adv = $sql_board->fetch();

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('board', $adv['adv_cat'], 'RWA');
cot_block($usr['auth_read']);

if($a == 'sendmsg')
{
	$msgname = cot_import('msgname', 'P', 'TXT');
	$msgemail = cot_import('msgemail', 'P', 'TXT', 64, TRUE);
	$msgphone = cot_import('msgphone', 'P', 'TXT');
	$msgtext = cot_import('msgtext', 'P', 'TXT');
	
	if (empty($msgname))	cot_error('adv_contact_error_name', 'msgname');
	if (empty($msgemail) && empty($msgphone)) cot_error('adv_contact_error_phoneoremail', 'msgemail');
	if (!empty($msgemail) && !cot_check_email($msgemail))	cot_error('aut_emailtooshort', 'msgemail');
	
	/* === Hook === */
	foreach (cot_getextplugins('board.contactform.error') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if(!cot_error_found())
	{
		$subject = $L['adv_contact_msg_subject'];
		$body = sprintf($L['adv_contact_msg_body'], $adv['user_name'], $adv['adv_title'], $msgname, $msgemail, $msgphone, $msgtext);
		$headers = "From: \"" . mb_encode_mimeheader($cfg['maintitle'], 'UTF-8', 'B', "\n") . "\" <" . $cfg['adminemail'] . ">\n" . "Reply-To: <" . $msgemail . ">\n";
		
		/* === Hook === */
		foreach (cot_getextplugins('board.contactform.send') as $pl)
		{
			include $pl;
		}
		/* ===== */

		cot_mail($adv['user_email'], $subject, $body, $headers);
	}
	
	$url = (empty($adv['adv_alias'])) ? cot_url('board', 'c='.$adv['adv_cat'].'&id='.$adv['adv_id']) : cot_url('board', 'c='.$adv['adv_cat'].'&al='.$adv['adv_alias']);
	cot_redirect($url);
}

$al = empty($adv['adv_alias']) ? '' : $adv['adv_alias'];
$id = (int) $adv['adv_id'];
$cat = $structure['board'][$adv['adv_cat']];

$sys['sublocation'] = $adv['adv_title'];

$adv['adv_pageurl'] = empty($al) ? cot_url('board', array('c' => $adv['adv_cat'], 'id' => $id)) : cot_url('board', array('c' => $adv['adv_cat'], 'al' => $al));

if (($adv['adv_state'] == 1
		|| ($adv['adv_state'] == 2))
	&& (!$usr['isadmin'] && $usr['id'] != $adv['adv_ownerid']))
{
	cot_log("Attempt to directly access an un-validated adv", 'sec');
	cot_die_message(403, TRUE);
}
if (!$usr['isadmin'] || $cfg['board']['count_admin'])
{
	$adv['adv_count']++;
	$sql_adv_update =  $db->query("UPDATE $db_board SET adv_count='".$adv['adv_count']."' WHERE adv_id=$id");
}

$title_params = array(
	'TITLE' => empty($adv['adv_metatitle']) ? $adv['adv_title'] : $adv['adv_metatitle'],
	'CATEGORY' => $cat['title']
);
$out['subtitle'] = cot_title($cfg['board']['title_board'], $title_params);

$out['desc'] = empty($adv['adv_metadesc']) ? strip_tags($adv['adv_desc']) : strip_tags($adv['adv_metadesc']);
$out['keywords'] = strip_tags($adv['adv_keywords']);

// Building the canonical URL
$advurl_params = array('c' => $adv['adv_cat']);
empty($al) ? $advurl_params['id'] = $id : $advurl_params['al'] = $al;
if ($pg > 0)
{
	$advurl_params['pg'] = $pg;
}
$out['canonical_uri'] = cot_url('board', $advurl_params);

$mskin = cot_tplfile(array('board', $cat['tpl']));

/* === Hook === */
foreach (cot_getextplugins('board.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'] . '/header.php';
require_once cot_incfile('users', 'module');
$t = new XTemplate($mskin);

$t->assign(cot_generate_advtags($adv, 'ADV_', 0, $usr['isadmin'], $cfg['homebreadcrumb']));
$t->assign('ADV_OWNER', cot_build_user($adv['adv_ownerid'], htmlspecialchars($adv['user_name'])));
$t->assign(cot_generate_usertags($adv, 'ADV_OWNER_'));

// Error and message handling
cot_display_messages($t, 'MAIN.CONTACTFORM');

$t->assign(array(
	'ADV_CONTACT_FORM_ACTION' => cot_url('board', 'c='.$adv['adv_cat'].'&id='.$adv['adv_id'].'&a=sendmsg'),
	'ADV_CONTACT_FORM_NAME' => cot_inputbox('text', 'msgname', $msgname, array('size' => '64', 'maxlength' => '255')),
	'ADV_CONTACT_FORM_EMAIL' => cot_inputbox('text', 'msgemail', $msgemail, array('size' => '64', 'maxlength' => '255')),
	'ADV_CONTACT_FORM_PHONE' => cot_inputbox('text', 'msgphone', $msgphone, array('size' => '64', 'maxlength' => '255')),
	'ADV_CONTACT_FORM_TEXT' => cot_textarea('msgtext', $msgtext, 2, 64, array('maxlength' => '255')),
));

/* === Hook === */
foreach (cot_getextplugins('board.contactform.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN.CONTACTFORM');

/* === Hook === */
foreach (cot_getextplugins('board.tags') as $pl)
{
	include $pl;
}
/* ===== */
if ($usr['isadmin'] || $usr['id'] == $adv['adv_ownerid'])
{
	$t->parse('MAIN.ADV_ADMIN');
}
$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'] . '/footer.php';

if ($cache && $usr['id'] === 0 && $cfg['cache_board']
	&& (!isset($cfg['cache_adv_blacklist']) || !in_array($adv['adv_cat'], $cfg['cache_adv_blacklist'])))
{
	$cache->board->write();
}
