<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=header.main
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_langfile('mailchimp', 'plug');

	global $sys, $cfg, $L;
	// var_dump($L);
	// cot_rc_link_file($cfg['plugins_dir'].'/mailchimp/js/class/Mialchimp-integration.js');

	$url = cot_url('plug', cot_xg() . '&e=mailchimp');
	$mailchimp_embed = "
	var Mi = {};
	Mi.options = {};
	Mi.l = {};
	Mi.l.error_no_valid_email = '".$L['mi_error_no_valid_email']."';
	Mi.options.url = '$url';
	Mi.options.xg = '" . cot_xg() . "';
	Mi.options.test_mode = '" . $cfg['plugin']['mailchimp']['test_mode'] . "';
	";
	
	cot_rc_embed_footer($mailchimp_embed);
   // cot_rc_link_footer($cfg['plugins_dir'].'/mailchimp/js/mailchimp-script.js');
	 cot_rc_link_footer($cfg['plugins_dir'].'/mailchimp/js/script.js');

?>