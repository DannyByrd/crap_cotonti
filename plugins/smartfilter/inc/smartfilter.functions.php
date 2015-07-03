<?php

defined('COT_CODE') or die('Wrong URL');

function isSupporting($e,$c,$id,$al,$fnName){
	global $structure;
	// check module page
	$modules = array_keys($structure);
	if(is_null($e) && !in_array($e, $modules)) return false;

	// check datailed page
	if($id || $al) return false;

	//	check support by the plugin current page
	if(!is_null($fnName))
	if(!function_exists($fnName)) return false;

	return true;
}

function getFiltersArr($e, $c, $field_location='cot_pages'){
	global $db, $db_extra_fields, $structure;

	if(is_null($e) && is_null($c)){
		$where = "field_location = '$field_location' AND field_type='filter' AND  field_enabled=1";
	} elseif(!is_null($e) && !is_null($c)){
		$pathcode = $structure[$e][$c]['path'];
		$where = "field_location = '$field_location' AND field_type='filter' AND  field_enabled=1 AND (field_cats LIKE '%\"all\"%' OR field_cats LIKE '%\"$pathcode\"%')";
	} elseif(!is_null($e) && is_null($c)){
		$where = "field_location = '$field_location' AND field_type='filter' AND  field_enabled=1";
	}

	if(is_null($where)) return false;
	$res = $db->query("SELECT field_name FROM $db_extra_fields WHERE $where");
	$extra_fields = $res->fetchAll();

	$filters = array();
	foreach ($extra_fields as $extfld) {
		$filters[] = $extfld["field_name"];
	}

	return $filters;
}

function getFilters($e, $c, $field_location='cot_pages'){
	global $db, $db_extra_fields, $structure;

	if(is_null($e) && is_null($c)){
		$where = "field_location = '$field_location' AND field_type='filter' AND  field_enabled=1";
	} elseif(!is_null($e) && !is_null($c)){
		$pathcode = $structure[$e][$c]['path'];
		$where = "field_location = '$field_location' AND field_type='filter' AND  field_enabled=1 AND (field_cats LIKE '%\"all\"%' OR field_cats LIKE '%\"$pathcode\"%')";
	}

	if(is_null($where)) return false;

	$res = $db->query("SELECT field_description,field_name,field_variants FROM $db_extra_fields WHERE $where");
	$extra_fields = $res->fetchAll();

	$filters = array();
	foreach ($extra_fields as $extfld) {
		// var_dump($extfld);
		$filters[$extfld["field_description"]] =  array(
			$extfld["field_name"] => $extfld["field_variants"]
		);
	}

	return $filters;
}