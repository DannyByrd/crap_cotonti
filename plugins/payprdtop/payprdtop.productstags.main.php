<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=productstags.main
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payprdtop', 'plug');

if($prd_data['prd_top'] > $sys['now'])
{
	$temp_array['PAYTOP'] = 'TOP до ' . date('d.m.Y H:i',$prd_data['prd_top']) . ' ' . cot_rc_link(cot_url('plug', 'e=payprdtop&id='.$prd_data['prd_id']), 'продлить');
	$temp_array['TOP'] = $prd_data['prd_top'];
}
else
{
	if($prd_data['prd_top'] > 0)
	{
		$db->query("UPDATE $db_products SET prd_top=0 WHERE prd_id=".$prd_data['prd_id']);
	}
	
	$temp_array['PAYTOP'] = cot_rc_link(cot_url('plug', 'e=payprdtop&id='.$prd_data['prd_id']), 'Оплатить TOP-товар');
	$temp_array['TOP'] = 0;
}
	
?>