<?php

defined('COT_CODE') or die('Wrong URL');

if(!$_POST) return;

function cot_structure_check_path_exists($structure_area, $structure_path){
	global $db,$db_structure;
	$query = $db->query("SELECT COUNT(*) FROM $db_structure WHERE structure_area='$structure_area' AND structure_path='$structure_path'");
	$res = $query->fetchColumn();

	return $res;
}


function cot_structure_check_by_code($structure_code){
	global $structure_name, $structure;
	return isset($structure[$structure_name][$structure_code]);
}

function create_structure($data){
	global $structure_name, $structure;

	require_once cot_incfile('structure');

	$res = cot_structure_add($structure_name, $data);
	if ($res === true){
		cot_message("Категория <b>".$data['structure_title']."</b> добавлена в модуль <b>" . $structure_name . "</b>");
	} else {
		cot_error('Категория с кодом <b>'. $data['structure_code'] .'</b> уже существует');
			$res = false;
	}
		// var_dump($structure[$structure_name][$data['structure_code']]);

	return $res;
}

$FilePath = '';
if(isset($_FILES["uploadedfile"]) AND $_FILES["uploadedfile"]["tmp_name"] != ''){
	$FilePath = $_FILES["uploadedfile"]["tmp_name"];

	require_once cot_incfile($plug_name, 'plug', 'class');

	$z_import = new Z_Import();
	$z_import->import_file($FilePath);		
} else{
	cot_message('Не выбран файл или размер файла больше указанных в php.ini', 'error');
}

?>