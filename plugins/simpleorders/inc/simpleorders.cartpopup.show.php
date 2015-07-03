<?php

defined('COT_CODE') or die('Wrong URL');

$data = cot_so_load_data();

$t = new XTemplate(cot_tplfile('simpleorders.cartpopup', 'plug'));
$i = 0;

$full_data = cot_so_full_data();



/*
if(isset($data['cart'])){
	foreach ($data['cart'] as $title => $quantity) {
		
		$i++;
		$t->assign(array(
			'SIMPLEORDERS_ITEM_NUMB' 		=> $i,
			'SIMPLEORDERS_ITEM_TITLE' 		=> $title,
			'SIMPLEORDERS_ITEM_QUANTITY' 	=> $quantity,
		));
		$t->parse('MAIN.ITEMS');
	}
}
*/
if(isset($data['cart'])){

	$sum = 0;
	foreach ($full_data as $f_data) {

		$i++;
		$t->assign(array(
			'SIMPLEORDERS_ITEM_NUMB' 		=> $i,
			'SIMPLEORDERS_ITEM_TITLE' 		=> $f_data['title'],
			'SIMPLEORDERS_ITEM_PRICE' 		=> $f_data['price'],
			'SIMPLEORDERS_ITEM_QUANTITY' 	=> $f_data['quantity'],
			'SIMPLEORDERS_ITEM_AVATAR' 	    => $f_data['avatar'],
		));
		$t->parse('MAIN.ITEMS');

		$sum += $f_data['price'] * $f_data['quantity'];
	}

	$t->assign(array('SIMPLEORDERS_ITEM_TOTALPRICE' => $sum));
  

}



$t->parse('MAIN');

$json = array(
		'html' => $t->text(),
	);
echo json_encode($json);
exit();