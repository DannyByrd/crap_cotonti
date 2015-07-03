<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=vacanciestags.main
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payvactop', 'plug');

if($vac_data['vac_top'] > $sys['now'])
{
	$temp_array['PAYTOP'] = 'TOP до ' . date('d.m.Y H:i',$vac_data['vac_top']) . ' ' . cot_rc_link(cot_url('plug', 'e=payvactop&id='.$vac_data['vac_id']), 'продлить');
	$temp_array['TOP'] = $vac_data['vac_top'];
}
else
{
	if($vac_data['vac_top'] > 0)
	{
		$db->query("UPDATE $db_vacancies SET vac_top=0 WHERE vac_id=".$vac_data['vac_id']);
	}
	
	$temp_array['PAYTOP'] = cot_rc_link(cot_url('plug', 'e=payvactop&id='.$vac_data['vac_id']), 'Оплатить TOP-вакансию');
	$temp_array['TOP'] = 0;
}
	
?>