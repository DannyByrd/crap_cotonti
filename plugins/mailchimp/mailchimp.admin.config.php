<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.config.edit.main
[END_COT_EXT]
==================== */

/**
 * Shop admin panel
 *
 * @package shop
 * @copyright http://portal30.ru 2012
 */
(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

global $cfg, $db;

require_once cot_incfile('mailchimp', 'plug');

if($cfg['plugin']['mailchimp']['api_key']){
	$api_key = $cfg['plugin']['mailchimp']['api_key'];
	$list_name = $cfg['plugin']['mailchimp']['list_mapping'];
	$mi = new Mailchimp_Integration($api_key, $list_name);
	$cfg_list_mapping = &$optionslist['list_mapping']['config_variants'];
	$cfg_list_mapping .=   ',';

	foreach ($mi->lists as $key => $list) {
		$cfg_list_mapping .= $list['name'] . ',';
	}

	$cfg_list_mapping = substr($cfg_list_mapping, 0, -1);
	/*
	$i_data = array(
		'email' => 'test@mail.com',
		'fname' => 'Виталий',
		'phone' => '0953217543'
	);

	$mi->listBatchSubscribeOne($i_data);*/
}
