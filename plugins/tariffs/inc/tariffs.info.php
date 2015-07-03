<?php

defined('COT_CODE') or die('Wrong URL');

global $cfg;

if(!$usr['id'])
	cot_redirect(cot_url('login'));

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


