<?php

defined('COT_CODE') or die('Wrong URL');


function cot_show_tariffs(){

	global $cfg;
	$t = new XTemplate(cot_tplfile('tariffs', 'plug'));

	$first = $cfg['plugin']['tariffs']['first_tariff'];
	$second = $cfg['plugin']['tariffs']['second_tariff'];
	$third = $cfg['plugin']['tariffs']['third_tariff'];

	$t->assign(array(
				
				'TARIFFS_FIRST'=>$first,
				'TARIFFS_SECOND'=>$second,
				'TARIFFS_THIRD'=>$third,
				));



	$t->parse('MAIN.TARIFFS');

	$t->parse('MAIN');


	return $t->text();

	
}