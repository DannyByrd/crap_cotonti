<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=firmstags.main
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payfirmbold', 'plug');

if($firm_data['firm_bold'] > $sys['now'])
{
	$temp_array['PAYBOLD'] = 'Выделено до ' . date('d.m.Y H:i',$firm_data['firm_bold']) . ' ' . cot_rc_link(cot_url('plug', 'e=payfirmbold&id='.$firm_data['firm_id']), 'продлить');
	$temp_array['BOLD'] = $firm_data['firm_bold'];
}
else
{
	if($firm_data['firm_bold'] > 0)
	{
		$db->query("UPDATE $db_firms SET firm_bold=0 WHERE firm_id=".$firm_data['firm_id']);
	}
	
	$temp_array['PAYBOLD'] = cot_rc_link(cot_url('plug', 'e=payfirmbold&id='.$firm_data['firm_id']), 'Выделить фирму');
	$temp_array['BOLD'] = 0;
}
	
?>