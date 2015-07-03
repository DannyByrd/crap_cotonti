<?php

defined('COT_CODE') or die('Wrong URL');

if(!$_POST) return;

/*function get_all_cats(){
	global $structure,$structure_name;
	return  $structure[$structure_name];
}*/

/*function get_terms($from, $field, $where=''){
	global $modx;
	$result = false;
	
	$select = $modx->db->select($field, $modx->getFullTableName($from), $where);

	while ($query = $modx->db->getRow($select)) $result [] =  $query[$field];
	return $result;
}
*/
/*function modx_get_tv_id($name)
{
	$tv = get_terms('site_tmplvars', 'id', "name = '" . $name . "'");
	if($tv)
		$tv = $tv[0];
		
	return $tv;
}*/
/*
function modx_process_tv($id, $tv_arr)
{
	global $modx;

	foreach($tv_arr as $tv_name => $tv_value)
	{
		$tv = modx_get_tv_id($tv_name);
		if($tv)
		{
			$fields = array(
				'tmplvarid'		=> $tv,
				'contentid'		=> $id,
				'value'			=> $tv_value,
				);
			$modx->db->insert($fields, $modx->getFullTableName('site_tmplvar_contentvalues'));
		}
	}
}*/


function modx_insert_post($postdata, $templ, $tv_arr)
{
	global $modx;
	
	$table_name = $modx->getFullTableName('site_content');
	$postdata['post_title'] = $modx->db->escape($postdata['post_title']);
	$postdata['post_alt_name'] = $modx->db->escape($postdata['post_alt_name']);
	$postdata['post_cat'] = $modx->db->escape($postdata['post_cat']);
	$postdata['post_description'] = $modx->db->escape($postdata['post_description']);
	$postdata['post_full_story'] = $modx->db->escape($postdata['post_full_story']);

	$fields = array(
		'pagetitle'		=> $postdata['post_title'],
		'alias'			=> $postdata['post_alt_name'],
		'parent'		=> $postdata['post_cat'],
		'introtext'		=> $postdata['post_description'],
		'content'		=> $postdata['post_full_story'],
		'createdon'		=> $postdata['post_date'],
		'editedon'		=> $postdata['post_date'],
		'pub_date'		=> $postdata['post_date'],
		'template'		=> $templ,
		'published'		=> $postdata['post_published'],
		'isfolder'		=> "0",
		);
	
	$modx->db->insert($fields, $modx->getFullTableName('site_content'));
	
	modx_process_tv($modx->db->getInsertId(), $tv_arr);
	
	return $modx->db->getInsertId();
}

function cot_structure_check_path_exists($structure_area, $structure_path){
	global $db,$db_structure;
	$query = $db->query("SELECT COUNT(*) FROM $db_structure WHERE structure_area='$structure_area' AND structure_path='$structure_path'");
	$res = $query->fetchColumn();

	return $res;
}


function cot_structure_get_by_code($structure_code){
	global $structure;
	foreach ($structure as $module_name => $module) {
		if(isset($module[$structure_code])) return $module[$structure_code];
	}

	return false;
}

require_once cot_incfile($plug_name, 'plug', 'class');

$FilePath = '';
if(isset($_FILES["uploadedfile"]) AND $_FILES["uploadedfile"]["tmp_name"] != ''){
	$FilePath = $_FILES["uploadedfile"]["tmp_name"];
	$z_import = new Z_Import();
	$z_import->import_file($FilePath);		
} else{
	cot_message('Не выбран файл или размер файла больше указанных в <b>php.ini</b>', 'error');
}

?>