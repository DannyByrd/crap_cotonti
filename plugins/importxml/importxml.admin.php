<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=tools
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('users', 'a');
cot_block($usr['isadmin']);

global $structure,$cfg;

$show_eror = false;
$plug_name = 'importxml';

$structures = array_keys($structure);

if($_POST && $a=='set_settings'){ // save settings
	$structure_name = cot_import('structure_name', 'P', 'TXT');
	$structure_cat_name = cot_import('structure_cat_name', 'P', 'TXT');

	$_SESSION['zi_structure_name'] = $structure_name;
	$_SESSION['zi_structure_cat_name'] = $structure_cat_name;

} else{ //get settings
 	$structure_name = $_SESSION['zi_structure_name'];
 	$structure_cat_name = $_SESSION['zi_structure_cat_name'];
}

$structure_cats = $structure_name && isset($structure[$structure_name]) ? array_keys($structure[$structure_name]) : '';
$structure_cat_path = $structure_cat_name ? $structure[$structure_name][$structure_cat_name]['rpath'] : '';

$t = new XTemplate(cot_tplfile($plug_name.'.admin', 'plug', true));
$t->assign(array(
	'ZI_FORM_ACTION' => cot_url('admin', 'm=other&p='.$plug_name),  
	'ZI_FORM_ACTION_SETTINGS' => cot_url('admin', 'm=other&p='.$plug_name.'&a=set_settings'),  
	'ZI_FORM_ACTION_IMPORT' => cot_url('admin', 'm=other&p='.$plug_name.'&a=import'),  
	'ZI_FORM_STRUCTRE_SELECT' => cot_selectbox($structure_name, 'structure_name', $structures, $structures), 
	'ZI_FORM_STRUCTRE_CAT_SELECT' => cot_selectbox($structure_cat_name, 'structure_cat_name', $structure_cats, $structure_cats), 
	)
);

if(isset($a) && $a == 'import'){
	require_once cot_incfile($plug_name, 'plug');
}  	

cot_display_messages($t);


$t->parse();
$plugin_body = $t->text();
