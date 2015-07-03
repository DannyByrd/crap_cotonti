<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=afishatags.main
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payafishavip', 'plug');

if($event_data['event_vip'] > $sys['now'])
{
	$temp_array['PAYVIP'] = 'VIP до ' . date('d.m.Y H:i',$event_data['event_vip']) . ' ' . cot_rc_link(cot_url('plug', 'e=payafishavip&id='.$event_data['event_id']), 'продлить');
	$temp_array['VIP'] = $event_data['event_vip'];
}
else
{
	if($event_data['event_vip'] > 0)
	{
		$db->query("UPDATE $db_afisha SET event_vip=0 WHERE event_id=".$event_data['event_id']);
	}
	
	$temp_array['PAYVIP'] = cot_rc_link(cot_url('plug', 'e=payafishavip&id='.$event_data['event_id']), 'Оплатить VIP-событие');
	$temp_array['VIP'] = 0;
}

?>