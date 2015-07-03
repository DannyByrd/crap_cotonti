<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=module
[END_COT_EXT]
==================== */

/**
 * Profile module main
 *
 * @package profile
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

// Environment setup
define('COT_PROFILE', TRUE);
$env['location'] = 'profile';

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('profile', 'any');
cot_block($usr['auth_write']);

require_once cot_incfile('profile', 'module');

// Self requirements
require_once cot_incfile('extrafields');

$userid = cot_import('userid', 'G', 'INT');
if(!empty($userid))
{
	cot_block($id == $usr['id'] || $usr['isadmin']);
	$urr = $db->query("SELECT * FROM $db_users WHERE user_id='".$userid."' LIMIT 1")->fetch();
}
else
{
	$urr = $db->query("SELECT * FROM $db_users WHERE user_id='".$usr['id']."' LIMIT 1")->fetch();
}

$out['desc'] = '';
$out['subtitle'] = $L['profile_profile'];

if(empty($m)) $m = 'default';

require_once $cfg['system_dir'] . '/header.php';

$mskin = cot_tplfile(array('profile'));
$t = new XTemplate($mskin);

$catpatharray[] = array(cot_url('profile'), $L['profile_profile']);
$catpath = cot_breadcrumbs($catpatharray, $cfg['homebreadcrumb'], true);

$t->assign(array(
	'PROFILE_TITLE' => $L['profile_profile'],
	'PROFILE_CATPATH' => $catpath,
));

$profilemenu['default']['title'] = $L['Home'];
$profilemenu['default']['url'] = cot_url('profile','m=main');

$profilemenu['all']['title'] =  $L['menu_all'];
$profilemenu['all']['url'] = cot_url('profile', 'm=all');


if($usr['isadmin']){

	$profilemenu['simpleorders']['title'] =  $L['menu_simpleorders'];
	$profilemenu['simpleorders']['url'] = cot_url('profile', 'm=simpleorders');
}

	$profilemenu['whatpay']['title'] =  $L['menu_whatpay'];
	$profilemenu['whatpay']['url'] = cot_url('profile', 'm=whatpay');

	$profilemenu['cmanager']['title'] =  $L['menu_cmanager'];
	$profilemenu['cmanager']['url'] = cot_url('profile', 'm=cmanager');

if($m == 'all'){
	$all_text = '';
}

/* === Hook === */
foreach (cot_getextplugins('profile.include') as $pl)
{
	include $pl;
}
/* ===== */

if($m == 'all'){
	$t->assign('PROFILE_CONTENT', $all_text);
}

if(cot_auth('admin', 'any', 'R')){

	$t->assign(array('ADMIN_USER'=>true));
}

	


foreach($profilemenu as $mid => $menu)
{
	
	$t->assign(array(
		'MENU_ROW_ID' => $mid,
		'MENU_ROW_TITLE' => $menu['title'],
		'MENU_ROW_URL' => $menu['url'],
	));
	$t->parse('MAIN.MENU.MENU_ROW');
}


$t->parse('MAIN.MENU');


$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'] . '/footer.php';