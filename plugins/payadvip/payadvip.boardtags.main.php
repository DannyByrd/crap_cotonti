<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=boardtags.main
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payadvip', 'plug');

if($adv_data['adv_vip'] > $sys['now'])
{
	$temp_array['PAYVIP'] = 'VIP до ' . date('d.m.Y H:i',$adv_data['adv_vip']) . ' ' . cot_rc_link(cot_url('plug', 'e=payadvip&id='.$adv_data['adv_id']), 'продлить');
	$temp_array['VIP'] = $adv_data['adv_vip'];
}
else
{
	if($adv_data['adv_vip'] > 0)
	{
		$db->query("UPDATE $db_board SET adv_vip=0 WHERE adv_id=".$adv_data['adv_id']);
	}
	
	$temp_array['PAYVIP'] = cot_rc_link(cot_url('plug', 'e=payadvip&id='.$adv_data['adv_id']), 'Оплатить VIP-объявление');
	$temp_array['VIP'] = 0;
}
	
?>