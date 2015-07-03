<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=boardtags.main
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payadbold', 'plug');

if($adv_data['adv_bold'] > $sys['now'])
{
	$temp_array['PAYBOLD'] = 'Выделено до ' . date('d.m.Y H:i',$adv_data['adv_bold']) . ' ' . cot_rc_link(cot_url('plug', 'e=payadbold&id='.$adv_data['adv_id']), 'продлить');
	$temp_array['BOLD'] = $adv_data['adv_bold'];
}
else
{
	if($adv_data['adv_bold'] > 0)
	{
		$db->query("UPDATE $db_board SET adv_bold=0 WHERE adv_id=".$adv_data['adv_id']);
	}
	
	$temp_array['PAYBOLD'] = cot_rc_link(cot_url('plug', 'e=payadbold&id='.$adv_data['adv_id']), 'Выделить объявление');
	$temp_array['BOLD'] = 0;
}
	
?>