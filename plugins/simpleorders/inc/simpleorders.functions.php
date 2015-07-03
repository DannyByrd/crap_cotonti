<?php

defined('COT_CODE') or die('Wrong URL');

if (cot_plugin_active('mavatars'))
{
	require_once cot_incfile('mavatars', 'plug');
}

function cot_so_load_data(){
	

	if(isset($_COOKIE['simpleorders'])){
		$data = unserialize($_COOKIE['simpleorders']);
	} else {
		$data = array();
	}

	return $data;
}

function cot_so_full_data(){


	global $db;
	if(isset($_COOKIE['simpleorders'])){
		$data = unserialize($_COOKIE['simpleorders']);
	} else {
		$data = array();
	}


	$result = array();

	foreach ($data['cart'] as $title => $quantity) {
	
		
		$res_query = $db->query("SELECT prd_id, prd_cat, prd_cost
			 					 FROM cot_products
			 					 WHERE prd_title = '".$db->prep($title)."'")->fetch();
	
		if(!$res_query){
			$res_query = $db->query("SELECT page_id, page_cat
			 					 FROM cot_pages
			 					 WHERE page_title = '".$db->prep($title)."'")->fetch();

		}

		
		$mavatars_tags = NULL;
		if($res_query && (key($res_query) == 'prd_id')){

			$mavatar = new mavatar('products', $res_query['prd_cat'], $res_query['prd_id']);
			$mavatars_tags = $mavatar->generate_mavatars_tags();
			$res_query['price'] = $res_query['prd_cost'];

		}elseif($res_query && key($res_query) == 'page_id'){

			$mavatar = new mavatar('page', $res_query['page_cat'], $res_query['page_id']);
			$mavatars_tags = $mavatar->generate_mavatars_tags();
			$res_query['price'] = $res_query['page_cost'];
			
		}
		$res_query['title'] =  $title;
		$res_query['quantity'] = $quantity;

		$res_query['avatar'] = $mavatars_tags;



	  $result[] = $res_query;
			
	}


	return $result;

}

function cot_so_remove_data(){

	setcookie("simpleorders","");
}

function cot_so_save_data($data){
	setcookie("simpleorders",serialize($data),time()+18000);
}

function cot_so_get_total($data=null){
	if(is_null($data)) $data = cot_so_load_data();

	$total = 0;
	if(isset($data['cart'])){
		foreach ($data['cart'] as $t => $quantity) {
			if(isset($quantity)) $total += (int)$quantity;
		}
	}

	return $total;
}

function cot_show_simpleorders(){

	global $db,$db_x;

	$db_order = $db_x.'order';
	$db_order_product = $db_x.'order_product';

	$t = new XTemplate(cot_tplfile('simpleorders.order.table', 'plug'));
	
	$orders = $db->query("SELECT order_id,customer_name,status,date_added,
	 					 (SELECT SUM(total) FROM $db_order_product WHERE  $db_order_product.order_id = $db_order.order_id ) AS tsum
	 					   FROM $db_order")->fetchAll();
	


	foreach ($orders as $order) {
		$t->assign(array(
			'SIMPLEORDERS_ORDER_ID'=>$order['order_id'],
			'SIMPLEORDERS_ORDER_UNAME'=>$order['customer_name'],
			'SIMPLEORDERS_ORDER_STATUS'=>$order['status'],
			'SIMPLEORDERS_ORDER_TOTAL'=>$order['tsum'],
			'SIMPLEORDERS_ORDER_DATEADDED'=>$order['date_added'],
			'SIMPLEORDERS_ORDER_EDIT'=>cot_url('simpleorders', 'a=edit&id='.$order['order_id']),
			));

		$t->parse('MAIN.ORDER_ROW');

	}

	$t->parse();
	return $t->text();
}
// $count - количество записей в таблице
function cot_simpleorders_import($count = 0){

	$simpleorder['telephone']    = cot_import('so_telephone', 'P', 'TXT');
	$simpleorder['status']    = cot_import('so_status', 'P', 'TXT');
	$simpleorder['customer_email']    = cot_import('so_email', 'P', 'TXT');
	$simpleorder['customer_name']    = cot_import('so_fio', 'P', 'TXT');

	for($i=1; $i<=$count; $i++){
		$simpleorder["quantity_$i"]    = cot_import('so_quantity'."_$i", 'P', 'TXT');
		$simpleorder["price_$i"]    = cot_import('so_price'."_$i", 'P', 'TXT');
		$simpleorder["total_$i"]    = cot_import('so_total'."_$i", 'P', 'TXT');
	}

	return $simpleorder;
	
}
