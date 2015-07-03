<?php

defined('COT_CODE') or die('Wrong URL');

function getProductsFiltersData($e, $c, $rfilters=array())
{
	cot::$db->registerTable('products');
	global $db, $db_products, $db_extra_fields, $extra_whitelist, $structure;

	// get filters for current page
	$filters = getFilters($e, $c, 'cot_products');
	
	$whereAND = array('prd_cat' => "prd_cat='$c'");

	$filtersArr = getFiltersArr($e,$c);
	$rfilters = array();
	foreach ($filtersArr as $filter) {
		if($filter_val = cot_import($filter, 'G', 'TXT')){
			$rfilters[$filter] = 'prd_' . $filter . ' LIKE "%' . $filter_val . '%"';
		}
	}

	$whereAND = array_merge($whereAND, $rfilters);
	$where = implode(' AND ', $whereAND);
	$res = $db->query("SELECT * FROM $db_products WHERE $where");
	$pages = $res->fetchAll();

	// get fiters data for current page
	$res_data = array();
	foreach ($pages as $page) {
		foreach ($filters as $filter_description => $filter) {
			// var_dump($filter_description);
			!isset($res_data[$filter_description]) && $res_data[$filter_description] = array();
			foreach ($filter as $filter_name => $filter_variants) {
				!isset($res_data[$filter_description][$filter_name]) && $res_data[$filter_description][$filter_name] = array();
				$filter_variants_arr = explode(',', $filter_variants);
				// var_dump($filter_description,$filter_variants_arr);
				$prd_filter_variants = $page['prd_'.$filter_name];
				$prd_filter_variants_arr = explode(',', $prd_filter_variants);
				foreach ($filter_variants_arr as $filter_variant) {
					// var_dump($filter_description,$filter_variants_arr);
					!isset($res_data[$filter_description][$filter_name][$filter_variant]) && $res_data[$filter_description][$filter_name][$filter_variant] = 0;
					if(in_array($filter_variant, $prd_filter_variants_arr)) $res_data[$filter_description][$filter_name][$filter_variant]++;
				}
			}
		}
	}
	unset($filter_name);
	unset($filter_variants);
	unset($filter_variants_arr);
	unset($page);
	unset($prd_filter_variants);
	unset($prd_filter_variants_arr);
	// var_dump($res_data);
	return $res_data;
}