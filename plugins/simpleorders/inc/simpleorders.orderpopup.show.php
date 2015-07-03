<?php

defined('COT_CODE') or die('Wrong URL');

$data = cot_so_load_data();

$t = new XTemplate(cot_tplfile('simpleorders.orderpopup.add', 'plug'));
$i = 0;

if($usr['id']){

	$t->assign(array('USER_LOGGED'=>1));
}


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

$t->assign(array(
	'SIMPLEORDERS_TOTAL' 		=> $i,
));

$t->parse();

$json = array(
		'html' => $t->text(),
	);
echo json_encode($json);
exit();