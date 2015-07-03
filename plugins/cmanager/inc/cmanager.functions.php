<?php

defined('COT_CODE') or die('Wrong URL');

$cmanager_shapka1 = getLabel();

function cot_show_cmanager(){


	global $db, $db_x, $cfg, $cot_plugins_active;

	$t = new XTemplate(cot_tplfile('cmanager', 'plug'));
	if(cot_plugin_active('mavatars'))
	{

		$mavatar = new mavatar('contentmanager', 'head', 'cm_head');
		$t->assign('CMANMADD_FORM_MAVATAR', $mavatar->generate_upload_form());

	}

	$mavatar = new mavatar('contentmanager','head', 'cm_head');
	$mavatars_tags = $mavatar->generate_mavatars_tags();

	

	$t->assign(array(
		'CMANAGER_URL'=>'http:vk.com',
		'ICON' => $mavatars_tags,
		));



	$t->parse('MAIN.CMANAGER');

	$t->parse('MAIN');
	

	return $t->text();

}
function getLabel(){

	return 'My super label';
}


