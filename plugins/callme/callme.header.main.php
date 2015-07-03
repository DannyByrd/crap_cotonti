<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=header.main
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

if(defined('COT_ADMIN')) return;

global $cfg;
// var_dump();
$js = "
	var Callme = {};
    Callme.options = {};
    Callme.options.url = '" . cot_url('callme') . "';
	Callme.options.bootstrap_version_support = '" . $cfg['plugin']['callme']['bootstrap_version_support'] . "'";

    cot_rc_embed($js);
    cot_rc_link_file($cfg['plugins_dir'].'/callme/tpl/callme.css');
    cot_rc_link_file($cfg['plugins_dir'].'/callme/js/callme.js');

?>