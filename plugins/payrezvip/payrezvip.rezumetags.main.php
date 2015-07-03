<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=rezumetags.main
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payrezvip', 'plug');

if($rez_data['rez_vip'] > $sys['now'])
{
	$temp_array['PAYVIP'] = 'VIP до ' . date('d.m.Y H:i',$rez_data['rez_vip']) . ' ' . cot_rc_link(cot_url('plug', 'e=payrezvip&id='.$rez_data['rez_id']), 'продлить');
	$temp_array['VIP'] = $rez_data['rez_vip'];
}
else
{
	if($rez_data['rez_vip'] > 0)
	{
		$db->query("UPDATE $db_rezume SET rez_vip=0 WHERE rez_id=".$rez_data['rez_id']);
	}
	
	$temp_array['PAYVIP'] = cot_rc_link(cot_url('plug', 'e=payrezvip&id='.$rez_data['rez_id']), 'Оплатить VIP-резюме');
	$temp_array['VIP'] = 0;
}
	
?>