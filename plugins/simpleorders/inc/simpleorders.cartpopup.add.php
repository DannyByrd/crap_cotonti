<?php

defined('COT_CODE') or die('Wrong URL');

cot_incfile('simpleorders', 'plug');

if(isset($_POST['title'])){
	$so_title 	= cot_import('title', 'P', 'TXT');
	$so_quantity 	= cot_import('quantity', 'P', 'INT');
	if(is_null($so_quantity)) $so_quantity = 1;
	if((int)$so_quantity < 0) $so_quantity = 0;
}

$data = cot_so_load_data();

if(isset($data['cart'][$so_title])){
	$data['cart'][$so_title] += $so_quantity;
} else {
	if((int)$so_quantity){
		$data['cart'][$so_title] = $so_quantity;
	}
}

$so_total = cot_so_get_total($data);
cot_so_save_data($data);

$success_text = '';
if((int)$so_quantity !== 0){
	$success_text = '<span class="label label-success">Товар добавлен в корзину</span>';
}
$json = array(
		'success' => $success_text,
		'total' => $so_total,
	);

echo json_encode($json);
exit();