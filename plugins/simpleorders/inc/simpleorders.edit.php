<?php

defined('COT_CODE') or die('Wrong URL');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('simpleorders', 'any');

if(!$usr['isadmin'])
	cot_die_message(404);


$id = cot_import('id', 'G', 'INT');

$db_order = $db_x.'order';
$db_order_product = $db_x.'order_product';


if($m == 'update'){

	$ids_order = $db->query("SELECT order_product_id AS id FROM $db_order_product 
				 			   WHERE order_id = '".$db->prep($id)."'")->fetchAll();


	 $sorder = cot_simpleorders_import(count($ids_order));
	

	 $q = $db->prepare("UPDATE $db_order
	  					SET customer_name = ?, customer_email = ?, telephone = ?, status = ? 
	  					WHERE order_id = ?");
	 $q->execute(array($sorder['customer_name'], $sorder['customer_email'], $sorder['telephone'], $sorder['status'], $id));

	 
	$i = 0;
	foreach ($ids_order as $id_order) {
		$i++;
		$q = $db->prepare("UPDATE $db_order_product
	  					  SET quantity = ?, price = ?, total = ?
	  					  WHERE order_product_id = ? AND order_id = ?")->execute(array($sorder["quantity_$i"], $sorder["price_$i"], $sorder["total_$i"], $id_order['id'],$id));
		
	}

	 
}

$t = new XTemplate(cot_tplfile('simpleorders.edit', 'plug'));

$order = $db->query("SELECT * FROM $db_order 
				    WHERE order_id = '".$db->prep($id)."' LIMIT 1")->fetch();



	$t->assign(array(
	    'SIMPLEORDERS_DATA_ORDER_ID' =>$order['order_id'],
	    'SIMPLEORDERS_DATA_ORDER_DATEADDED' =>$order['date_added'],
	    'SIMPLEORDERS_DATA_ORDER_TEL' =>cot_inputbox('text', 'so_telephone', $order['telephone'], array('size' => '48', 'maxlength' => '255')),
	    'SIMPLEORDERS_DATA_ORDER_EMAIL' =>cot_inputbox('text', 'so_email', $order['customer_email'], array('size' => '48', 'maxlength' => '255')),
	    'SIMPLEORDERS_DATA_ORDER_FIO' => cot_inputbox('text', 'so_fio', $order['customer_name'], array('size' => '48', 'maxlength' => '255')),
	    'SIMPLEORDERS_DATA_ORDER_STATUS' =>cot_inputbox('text', 'so_status', $order['status'], array('size' => '48', 'maxlength' => '255')),
	    'SIMPLEORDERS_FORM_ACTION' =>cot_url('simpleorders', 'a=edit&id='.$order['order_id'].'&m=update'),
		));



$t->parse('MAIN.CUSTOMER_DATA');

$order = $db->query("SELECT * FROM $db_order_product 
				    WHERE order_id = '".$db->prep($id)."'")->fetchAll();
$i = 0;
foreach($order as $o){
    $i++;
	$t->assign(array(
			'SIMPLEORDERS_DATA_GOODS_NAME' => $o['name'],
			'SIMPLEORDERS_DATA_GOODS_MODULE' => $o['module'],
			'SIMPLEORDERS_DATA_GOODS_QUANTITY' =>cot_inputbox('text', 'so_quantity'."_$i", $o['quantity'], array('size' => '12', 'maxlength' => '20')), 
			'SIMPLEORDERS_DATA_GOODS_PRICE' => cot_inputbox('text', 'so_price'."_$i", $o['price'], array('size' => '12', 'maxlength' => '20')),
			'SIMPLEORDERS_DATA_GOODS_TOTAL' => cot_inputbox('text', 'so_total'."_$i", $o['total'], array('size' => '12', 'maxlength' => '20')),
	));
	$t->parse('MAIN.GOODS_DATA');
	
}





