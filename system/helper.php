<?php

/*
	пример вывода для тайтла для структуры:

		cot_helper_get_field('structure_title',
							 "structure_code='concert'&&structure_area='afisha'",
							 'structure'
							 );


	пример вывода для тайтла для модулья products:

		cot_helper_get_field('prd_title',
							 "prd_code='pila-m1142'",
							 'products'
							 );

 */

function cot_helper_get_field($field = '', $condition='', $module='page'){
	global $db;

	if(!$field) return false;

	if(strrpos($field, ',') >= 0){
		$tmp = explode(',', $field);
		$field = reset($tmp);
	}

	$select = $field == '' ? $field = '*' : $field;
	$select = "SELECT $select";

	$where = '';
	if($condition){
		$where = str_replace('||', ' OR ', $condition);
		$where = str_replace('&&', ' AND ', $where);
		$where = "WHERE $where";
	}

	if($count){
		$limit = " LIMIT $count";
	} else {
		$limit = ' LIMIT 1';
	}

	switch ($module) {
		case 'page':
			global $db_pages;
			$curr_db = $db_pages;
			break;

		case 'products':
			global $db_products;
			$curr_db = $db_products;

			break;
	
		case 'structure':
			global $db_structure;
			$curr_db = $db_structure;

			break;
	
		default:
			return false;
			break;
	}

	$sql = $db->query("$select
						FROM $curr_db
						$where $limit");

	$res = $sql->fetch();

	return $res[$field];
}


?>