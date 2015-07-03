<?php
/**
 * Adv display.
 *
 * @package blogs
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('blogs', 'any');
cot_block($usr['auth_read']);

$id = cot_import('id', 'G', 'INT');
$al = $db->prep(cot_import('al', 'G', 'TXT'));
$c = cot_import('c', 'G', 'TXT');
$pg = cot_import('pg', 'G', 'INT');

/* === Hook === */
foreach (cot_getextplugins('blogs.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($id > 0 || !empty($al))
{
	$where = (!empty($al)) ? "post_alias='".$al."' AND post_cat='".$c."'" : 'post_id='.$id.' AND post_alias=""';
	$sql_blogs = $db->query("SELECT p.*, u.* $join_columns
		FROM $db_blogs AS p $join_condition
		LEFT JOIN $db_users AS u ON u.user_id=p.post_ownerid
		WHERE $where LIMIT 1");
}

if(!$id && empty($al) || !$sql_blogs || $sql_blogs->rowCount() == 0)
{
	cot_die_message(404, TRUE);
}
$post = $sql_blogs->fetch();

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('blogs', $post['post_cat'], 'RWA');
cot_block($usr['auth_read']);

$al = empty($post['post_alias']) ? '' : $post['post_alias'];
$id = (int) $post['post_id'];
$cat = $structure['blogs'][$post['post_cat']];

$sys['sublocation'] = $post['post_title'];

$post['post_pageurl'] = empty($al) ? cot_url('blogs', array('c' => $post['post_cat'], 'id' => $id)) : cot_url('blogs', array('c' => $post['post_cat'], 'al' => $al));

if (($post['post_state'] == 1
		|| ($post['post_state'] == 2))
	&& (!$usr['isadmin'] && $usr['id'] != $post['post_ownerid']))
{
	cot_log("Attempt to directly access an un-validated post", 'sec');
	cot_die_message(403, TRUE);
}
if (!$usr['isadmin'] || $cfg['blogs']['count_admin'])
{
	$post['post_count']++;
	$sql_post_update =  $db->query("UPDATE $db_blogs SET post_count='".$post['post_count']."' WHERE post_id=$id");
}

$title_params = array(
	'TITLE' => empty($post['post_metatitle']) ? $post['post_title'] : $post['post_metatitle'],
	'CATEGORY' => $cat['title']
);
$out['subtitle'] = cot_title($cfg['blogs']['title_blogs'], $title_params);

$out['desc'] = empty($post['post_metadesc']) ? strip_tags($post['post_desc']) : strip_tags($post['post_metadesc']);
$out['keywords'] = strip_tags($post['post_keywords']);

// Building the canonical URL
$posturl_params = array('c' => $post['post_cat']);
empty($al) ? $posturl_params['id'] = $id : $posturl_params['al'] = $al;
if ($pg > 0)
{
	$posturl_params['pg'] = $pg;
}
$out['canonical_uri'] = cot_url('blogs', $posturl_params);

$mskin = cot_tplfile(array('blogs', $cat['tpl']));

/* === Hook === */
foreach (cot_getextplugins('blogs.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'] . '/header.php';
require_once cot_incfile('users', 'module');
$t = new XTemplate($mskin);

$t->assign(cot_generate_blogposttags($post, 'POST_', 0, $usr['isadmin'], $cfg['homebreadcrumb']));
$t->assign('POST_OWNER', cot_build_user($post['post_ownerid'], htmlspecialchars($post['user_name'])));
$t->assign(cot_generate_usertags($post, 'POST_OWNER_'));

/* === Hook === */
foreach (cot_getextplugins('blogs.tags') as $pl)
{
	include $pl;
}
/* ===== */
if ($usr['isadmin'] || $usr['id'] == $post['post_ownerid'])
{
	$t->parse('MAIN.POST_ADMIN');
}
$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'] . '/footer.php';

if ($cache && $usr['id'] === 0 && $cfg['cache_blogs']
	&& (!isset($cfg['cache_post_blacklist']) || !in_array($post['post_cat'], $cfg['cache_post_blacklist'])))
{
	$cache->blogs->write();
}
