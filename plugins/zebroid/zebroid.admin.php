<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=tools
[END_COT_EXT]
==================== */

/**
 * Home page main code
 *
 * @package callme
 * @version 0.1.0
 * @author Palmirastudio
 * @copyright Copyright (c) Palmirastudio 2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('users', 'a');
cot_block($usr['isadmin']);

global $structure,$cfg;

$show_eror = false;
$plug_name = 'zebroid';

$structures = array_keys($structure);

if($structure_name = cot_import('structure_name', 'P', 'TXT')){
	$_SESSION['zi_structure_name'] = $structure_name;
} else {
	$structure_name = $_SESSION['zi_structure_name'];
}

if($structure_cat_name = cot_import('structure_cat_name', 'P', 'TXT')){
	$_SESSION['zi_structure_cat_name'] = $structure_cat_name;
} else {
	$structure_cat_name = $_SESSION['zi_structure_cat_name'];
}

if(!$structure_name){
	$structure_cats = '';
} else{
	$structure_cats = array_keys($structure[$structure_name]);
	$structure_cat_path = $structure[$structure_name][$structure_cat_name]['rpath'];
}
// var_dump($structure_cat_path);

	$t = new XTemplate(cot_tplfile($plug_name.'.admin', 'plug', true));
	$t->assign(array(
		'ZI_FORM_ACTION' => cot_url('admin', 'm=other&p='.$plug_name),  
		'ZI_FORM_ACTION_SETTINGS' => cot_url('admin', 'm=other&p='.$plug_name.'&a=set_settings'),  
		'ZI_FORM_ACTION_IMPORT' => cot_url('admin', 'm=other&p='.$plug_name.'&a=import'),  
		'ZI_FORM_STRUCTRE_SELECT' => cot_selectbox($structure_name, 'structure_name', $structures, $structures), 
		'ZI_FORM_STRUCTRE_CAT_SELECT' => cot_selectbox($structure_cat_name, 'structure_cat_name', $structure_cats, $structure_cats), 
		)
	);

if(isset($a)){
	if(!$structure_name){
		cot_message('Не указана настройка "Сатруктура"', 'error');
	}

	if(!$structure_cat_name){
		cot_message('Не указана настройка "Категория структyры"', 'error');
	}
}

if(isset($a) && $a == 'import'){
	require_once cot_incfile($plug_name, 'plug');
}  	

cot_display_messages($t);


$t->parse();
$plugin_body = $t->text();
