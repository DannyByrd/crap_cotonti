<?php

defined('COT_CODE') or die('Wrong URL');

global $cfg;
 $tariff =  cot_import('t', 'G', 'TXT');



 switch ($tariff) {

 	case 'first':  kindOfTariff($cfg['plugin']['tariffs']['first_tariff'],$usr['id']); break;
 	case 'second': kindOfTariff( $cfg['plugin']['tariffs']['second_tariff'],$usr['id']); break;
 	case 'third':  kindOfTariff($cfg['plugin']['tariffs']['third_tariff'],$usr['id']); break;
 	
 	default: die('Wrong URL'); break;
 	 		
 }




 function kindOfTariff($summ,$userid){

 	global $db, $sys, $db_x;

 	if(!is_numeric($tariff) && !is_null($id))
 		die('Wrong URL');

 	$pdata['pay_userid'] = $userid;
	$pdata['pay_summ'] = $summ;
	$pdata['pay_area'] = 'balance';
	$pdata['pay_status'] = 'new';
	//$pdata['pay_code'] = 'first';
	$pdata['pay_desc'] = 'Пополнение счета';
	$pdata['pay_cdate'] = $sys['now'];
	$pdata['pay_pdate'] = 0;
	$pdata['pay_adate'] =0;

 	
 	


 	$sql = $db->insert($db_x."payments", $pdata);
 	$Lid = $db->lastInsertId();

 	cot_redirect(cot_url('payments', 'm=billing&pid=' . $Lid, '', true));


 }


