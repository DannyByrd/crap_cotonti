<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=firmstags.main
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payfirmvip', 'plug');

if($firm_data['firm_vip'] > $sys['now'])
{
	$temp_array['PAYVIP'] = 'VIP до ' . date('d.m.Y H:i',$firm_data['firm_vip']) . ' ' . cot_rc_link(cot_url('plug', 'e=payfirmvip&id='.$firm_data['firm_id']), 'продлить');
	$temp_array['VIP'] = $firm_data['firm_vip'];
}
else
{
	if($firm_data['firm_vip'] > 0)
	{
		$db->query("UPDATE $db_firms SET firm_vip=0 WHERE firm_id=".$firm_data['firm_id']);
	}
	
	$temp_array['PAYVIP'] = cot_rc_link(cot_url('plug', 'e=payfirmvip&id='.$firm_data['firm_id']), 'Оплатить VIP-фирму');
	$temp_array['VIP'] = 0;
}
	
?>