<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=boardtags.main
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payadtop', 'plug');

if($adv_data['adv_top'] > $sys['now'])
{
	$temp_array['PAYTOP'] = 'TOP до ' . date('d.m.Y H:i',$adv_data['adv_top']) . ' ' . cot_rc_link(cot_url('plug', 'e=payadtop&id='.$adv_data['adv_id']), 'продлить');
	$temp_array['TOP'] = $adv_data['adv_top'];
}
else
{
	if($adv_data['adv_top'] > 0)
	{
		$db->query("UPDATE $db_board SET adv_top=0 WHERE adv_id=".$adv_data['adv_id']);
	}
	
	$temp_array['PAYTOP'] = cot_rc_link(cot_url('plug', 'e=payadtop&id='.$adv_data['adv_id']), 'Оплатить TOP-объявление');
	$temp_array['TOP'] = 0;
}
	
?>