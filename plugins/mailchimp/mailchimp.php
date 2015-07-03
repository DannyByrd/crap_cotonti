<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

/**
 * Will clean various things
 *
 * @package mailchimp
 * @version 0.7.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die("Wrong URL.");  

if (COT_AJAX)
{
	require_once cot_incfile('bbcode', 'plug');

		$api_key = $cfg['plugin']['mailchimp']['api_key'];
		$list_name = $cfg['plugin']['mailchimp']['list_mapping'];

		$mi = new Mailchimp_Integration($api_key, $list_name);

	if($mi_action = cot_import('mi_action', 'P', 'TXT')){
		if($mi_action == 'getErrors'){
			if(!$api_key){
				echo 'api_key is not specified! Please set mailchimp api_key in your configuration!';
			}elseif($list_name == 'none') {
				echo 'list_mapping is not specified! Please set mailchimp api_key in your configuration!';
			}else {
				echo $mi->get_errors();
			}
		}
	}

	if($cfg['plugin']['mailchimp']['api_key'] && $email = cot_import('email', 'P', 'TXT')){

		$cfg_list_mapping = &$optionslist['list_mapping']['config_variants'];
		$cfg_list_mapping .=   ',';

		foreach ($mi->lists as $key => $list) {
			$cfg_list_mapping .= $list['name'] . ',';
		}

		$cfg_list_mapping = substr($cfg_list_mapping, 0, -1);
		
		$i_data = array(
			'email' => 	$email,
			'fname' => cot_import('fname', 'P', 'TXT'),
			'phone' => cot_import('phone', 'P', 'TXT'),
		);

		$mi_mess = $mi->listBatchSubscribeOne($i_data);

		if(is_array($mi_mess)){
			foreach ($mi_mess as $key => $value) {
				if(is_string($value) || is_int($value)){
					$ajax_mess .= $key . ':' . $value . '; ';
				}
			}
		}

		echo $ajax_mess;
	}
}
else
{
    cot_die_message(404);
}

?>