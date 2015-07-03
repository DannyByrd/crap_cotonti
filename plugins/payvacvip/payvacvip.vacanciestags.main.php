<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=vacanciestags.main
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payvacvip', 'plug');

if($vac_data['vac_vip'] > $sys['now'])
{
	$temp_array['PAYVIP'] = 'VIP до ' . date('d.m.Y H:i',$vac_data['vac_vip']) . ' ' . cot_rc_link(cot_url('plug', 'e=payvacvip&id='.$vac_data['vac_id']), 'продлить');
	$temp_array['VIP'] = $vac_data['vac_vip'];
}
else
{
	if($vac_data['vac_vip'] > 0)
	{
		$db->query("UPDATE $db_vacancies SET vac_vip=0 WHERE vac_id=".$vac_data['vac_id']);
	}
	
	$temp_array['PAYVIP'] = cot_rc_link(cot_url('plug', 'e=payvacvip&id='.$vac_data['vac_id']), 'Оплатить VIP-вакансию');
	$temp_array['VIP'] = 0;
}
	
?>