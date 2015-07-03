<?php
/**
 * Adv display.
 *
 * @package afisha
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('afisha', 'any');
cot_block($usr['auth_read']);

$id = cot_import('id', 'G', 'INT');
$al = $db->prep(cot_import('al', 'G', 'TXT'));
$c = cot_import('c', 'G', 'TXT');
$pg = cot_import('pg', 'G', 'INT');

/* === Hook === */
foreach (cot_getextplugins('afisha.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($id > 0 || !empty($al))
{
	$where = (!empty($al)) ? "event_alias='".$al."' AND event_cat='".$c."'" : 'event_id='.$id.' AND event_alias=""';
	$sql_afisha = $db->query("SELECT p.*, u.* $join_columns
		FROM $db_afisha AS p $join_condition
		LEFT JOIN $db_users AS u ON u.user_id=p.event_ownerid
		WHERE $where LIMIT 1");
}

if(!$id && empty($al) || !$sql_afisha || $sql_afisha->rowCount() == 0)
{
	cot_die_message(404, TRUE);
}
$event = $sql_afisha->fetch();

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('afisha', $event['event_cat'], 'RWA');
cot_block($usr['auth_read']);

$al = empty($event['event_alias']) ? '' : $event['event_alias'];
$id = (int) $event['event_id'];
$cat = $structure['afisha'][$event['event_cat']];

$sys['sublocation'] = $event['event_title'];

$event['event_pageurl'] = empty($al) ? cot_url('afisha', array('c' => $event['event_cat'], 'id' => $id)) : cot_url('afisha', array('c' => $event['event_cat'], 'al' => $al));

if (($event['event_state'] == 1
		|| ($event['event_state'] == 2))
	&& (!$usr['isadmin'] && $usr['id'] != $event['event_ownerid']))
{
	cot_log("Attempt to directly access an un-validated event", 'sec');
	cot_die_message(403, TRUE);
}
if (!$usr['isadmin'] || $cfg['afisha']['count_admin'])
{
	$event['event_count']++;
	$sql_event_update =  $db->query("UPDATE $db_afisha SET event_count='".$event['event_count']."' WHERE event_id=$id");
}

$title_params = array(
	'TITLE' => empty($event['event_metatitle']) ? $event['event_title'] : $event['event_metatitle'],
	'CATEGORY' => $cat['title']
);
$out['subtitle'] = cot_title($cfg['afisha']['title_afisha'], $title_params);

$out['desc'] = empty($event['event_metadesc']) ? strip_tags($event['event_desc']) : strip_tags($event['event_metadesc']);
$out['keywords'] = strip_tags($event['event_keywords']);

// Building the canonical URL
$eventurl_params = array('c' => $event['event_cat']);
empty($al) ? $eventurl_params['id'] = $id : $eventurl_params['al'] = $al;
if ($pg > 0)
{
	$eventurl_params['pg'] = $pg;
}
$out['canonical_uri'] = cot_url('afisha', $eventurl_params);

$mskin = cot_tplfile(array('afisha', $cat['tpl']));

/* === Hook === */
foreach (cot_getextplugins('afisha.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'] . '/header.php';
require_once cot_incfile('users', 'module');
$t = new XTemplate($mskin);

$t->assign(cot_generate_eventtags($event, 'EVT_', 0, $usr['isadmin'], $cfg['homebreadcrumb']));
$t->assign('EVT_OWNER', cot_build_user($event['event_ownerid'], htmlspecialchars($event['user_name'])));
$t->assign(cot_generate_usertags($event, 'EVT_OWNER_'));

/* === Hook === */
foreach (cot_getextplugins('afisha.tags') as $pl)
{
	include $pl;
}
/* ===== */
if ($usr['isadmin'] || $usr['id'] == $event['event_ownerid'])
{
	$t->parse('MAIN.EVT_ADMIN');
}
$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'] . '/footer.php';

if ($cache && $usr['id'] === 0 && $cfg['cache_afisha']
	&& (!isset($cfg['cache_event_blacklist']) || !in_array($event['event_cat'], $cfg['cache_event_blacklist'])))
{
	$cache->afisha->write();
}
