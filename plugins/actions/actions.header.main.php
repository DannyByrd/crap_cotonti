<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=header.main
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

global $cfg, $env, $db, $db_pages;

$plg_name = 'actions';
$plg_lang = $cfg['defaultlang'];
$plg_activated_on = array('index', 'page', 'products');
$extrafield_actions = 'prod_actions';
$supress_plg_actions = false;
$plg_gmt = '+3';
if(!in_array($env['ext'], $plg_activated_on)){
	$supress_plg_actions	= true;
	return;
} 

require_once cot_incfile($plg_name, 'plug');

$id = cot_import('id', 'G', 'INT');
$al = $db->prep(cot_import('al', 'G', 'TXT'));
$c = cot_import('c', 'G', 'TXT');

cot_rc_link_file($cfg['mainurl'].'/js/lib/jquery.countdown/jquery.plugin.js');
cot_rc_link_file($cfg['mainurl'].'/js/lib/jquery.countdown/jquery.countdown.js');
cot_rc_link_file($cfg['mainurl'].'/js/lib/jquery.countdown/jquery.countdown-' . $plg_lang . '.js');
cot_rc_link_file($cfg['mainurl'].'/js/lib/jquery.countdown/jquery.countdown.css');
