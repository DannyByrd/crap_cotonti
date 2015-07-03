<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=productstags.main
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payprdvip', 'plug');

if($prd_data['prd_vip'] > $sys['now'])
{
	$temp_array['PAYVIP'] = 'VIP до ' . date('d.m.Y H:i',$prd_data['prd_vip']) . ' ' . cot_rc_link(cot_url('plug', 'e=payprdvip&id='.$prd_data['prd_id']), 'продлить');
	$temp_array['VIP'] = $prd_data['prd_vip'];
}
else
{
	if($prd_data['prd_vip'] > 0)
	{
		$db->query("UPDATE $db_products SET prd_vip=0 WHERE prd_id=".$prd_data['prd_id']);
	}
	
	$temp_array['PAYVIP'] = cot_rc_link(cot_url('plug', 'e=payprdvip&id='.$prd_data['prd_id']), 'Оплатить VIP-товар');
	$temp_array['VIP'] = 0;
}
	
?>