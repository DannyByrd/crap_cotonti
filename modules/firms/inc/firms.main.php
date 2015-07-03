<?php
/**
 * Firm display.
 *
 * @package firms
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

cot_rc_link_file('http://api-maps.yandex.ru/2.1/?lang=ru_RU');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('firms', 'any');
cot_block($usr['auth_read']);

$id = cot_import('id', 'G', 'INT');
$al = $db->prep(cot_import('al', 'G', 'TXT'));
$c = cot_import('c', 'G', 'TXT');
$pg = cot_import('pg', 'G', 'INT');

/* === Hook === */
foreach (cot_getextplugins('firms.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($id > 0 || !empty($al))
{
	$where = (!empty($al)) ? "firm_alias='".$al."' AND firm_cat='".$c."'" : 'firm_id='.$id.' AND firm_alias=""';
	$sql_firms = $db->query("SELECT p.*, u.* $join_columns
		FROM $db_firms AS p $join_condition
		LEFT JOIN $db_users AS u ON u.user_id=p.firm_ownerid
		WHERE $where LIMIT 1");
}

if(!$id && empty($al) || !$sql_firms || $sql_firms->rowCount() == 0)
{
	cot_die_message(404, TRUE);
}
$firm = $sql_firms->fetch();

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('firms', $firm['firm_cat'], 'RWA');
cot_block($usr['auth_read']);

$al = empty($firm['firm_alias']) ? '' : $firm['firm_alias'];
$id = (int) $firm['firm_id'];
$cat = $structure['firms'][$firm['firm_cat']];

$sys['sublocation'] = $firm['firm_title'];

$firm['firm_firmsurl'] = empty($al) ? cot_url('firms', array('c' => $firm['firm_cat'], 'id' => $id)) : cot_url('firms', array('c' => $firm['firm_cat'], 'al' => $al));

if (($firm['firm_state'] == 1
		|| ($firm['firm_state'] == 2))
	&& (!$usr['isadmin'] && $usr['id'] != $firm['firm_ownerid']))
{
	cot_log("Attempt to directly access an un-validated firms", 'sec');
	cot_die_message(403, TRUE);
}
if (!$usr['isadmin'] || $cfg['firms']['count_admin'])
{
	$firm['firm_count']++;
	$sql_firm_update =  $db->query("UPDATE $db_firms SET firm_count='".$firm['firm_count']."' WHERE firm_id=$id");
}

$title_params = array(
	'TITLE' => empty($firm['firm_metatitle']) ? $firm['firm_title'] : $firm['firm_metatitle'],
	'CATEGORY' => $cat['title']
);
$out['subtitle'] = cot_title($cfg['firms']['title_firms'], $title_params);

$out['desc'] = empty($firm['firm_metadesc']) ? strip_tags($firm['firm_desc']) : strip_tags($firm['firm_metadesc']);
$out['keywords'] = strip_tags($firm['firm_keywords']);

// Building the canonical URL
$firmurl_params = array('c' => $firm['firm_cat']);
empty($al) ? $firmurl_params['id'] = $id : $firmurl_params['al'] = $al;
if ($pg > 0)
{
	$firmurl_params['pg'] = $pg;
}
$out['canonical_uri'] = cot_url('firms', $firmurl_params);

$mskin = cot_tplfile(array('firms', $cat['tpl']));

/* === Hook === */
foreach (cot_getextplugins('firms.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'] . '/header.php';
require_once cot_incfile('users', 'module');
$t = new XTemplate($mskin);

$t->assign(cot_generate_firmtags($firm, 'FIRM_', 0, $usr['isadmin'], $cfg['homebreadcrumb']));
$t->assign('FIRM_OWNER', cot_build_user($firm['firm_ownerid'], htmlspecialchars($firm['user_name'])));
$t->assign(cot_generate_usertags($firm, 'FIRM_OWNER_'));

/* === Hook === */
foreach (cot_getextplugins('firms.tags') as $pl)
{
	include $pl;
}
/* ===== */
if ($usr['isadmin'] || $usr['id'] == $firm['firm_ownerid'])
{
	$t->parse('MAIN.FIRM_ADMIN');
}
$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'] . '/footer.php';

if ($cache && $usr['id'] === 0 && $cfg['cache_firms']
	&& (!isset($cfg['cache_firm_blacklist']) || !in_array($firm['firm_cat'], $cfg['cache_firm_blacklist'])))
{
	$cache->firms->write();
}
