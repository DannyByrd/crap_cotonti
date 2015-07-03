<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=rezumetags.main
 * [END_COT_EXT]
 */


defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payreztop', 'plug');

if($rez_data['rez_top'] > $sys['now'])
{
	$temp_array['PAYTOP'] = 'TOP до ' . date('d.m.Y H:i',$rez_data['rez_top']) . ' ' . cot_rc_link(cot_url('plug', 'e=payreztop&id='.$rez_data['rez_id']), 'продлить');
	$temp_array['TOP'] = $rez_data['rez_top'];
}
else
{
	if($rez_data['rez_top'] > 0)
	{
		$db->query("UPDATE $db_rezume SET rez_top=0 WHERE rez_id=".$rez_data['rez_id']);
	}
	
	$temp_array['PAYTOP'] = cot_rc_link(cot_url('plug', 'e=payreztop&id='.$rez_data['rez_id']), 'Оплатить TOP-резюме');
	$temp_array['TOP'] = 0;
}

?>