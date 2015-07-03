<?php

defined('COT_CODE') or die('Wrong URL');
cot_incfile('simpleorders', 'plug');

$data = cot_so_load_data();

$cartdata = $_POST['cartdata'];
$data['cart'] = array();
foreach ($cartdata['title'] as $key => $title) {
	$simpleorders_title = $title;
	$simpleorders_quantity = $cartdata['quantity'][$key];
	if((int)$simpleorders_quantity){
		$data['cart'][$simpleorders_title] = $simpleorders_quantity;
	}
}

cot_so_save_data($data);

$json = array(
		'success' => 1,
	);

echo json_encode($json);
exit();