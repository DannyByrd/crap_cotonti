<?php

defined('COT_CODE') or die('Wrong URL');

cot_incfile('simpleorders', 'plug');

global $L, $cfg, $db_x, $db;


require_once cot_incfile('users', 'module');




$L['plu_simpleorders_email_subject'] 	= 'Поступил заказ ';
$L['plu_simpleorders_email_prd_title'] 		= 'Наменование: ';
$L['plu_simpleorders_email_prd_quantity'] 	= 'кол-во: ';
$L['plu_simpleorders_email_prd_price'] 	= 'цена: ';
$L['plu_simpleorders_email_total_price'] 	= 'итог: ';
$L['plu_simpleorders_email_h_customer'] 	= 'Данные покупателя:';
$L['plu_simpleorders_email_form_name'] 	= 'ФИО покупателя:';
$L['plu_simpleorders_email_form_email'] 	= 'Емайл покупателя:';
$L['plu_simpleorders_email_form_tel'] 	= 'Телефон покупателя:';
$L['plu_simpleorders_email_h_order'] 	= 'Заказанное:';

//$data = cot_so_load_data();
$full_data = cot_so_full_data();
$i = 0;
$mailBody = '';
$nl = "\n";

$formData = $_POST['formData'];

if(!$usr['id']){
	$uData = createUser($formData);
}else{
	$uData = getUser($usr['id']);
}

$status = 'Не обработан';
$db_order = $db_x.'order';
$db_order_product = $db_x.'order_product';

$res = $db->prepare("INSERT INTO $db_order (customer_id,customer_name,customer_email,telephone,status) 
			         VALUES (?,?,?,?) ");
$res->execute(array($uData['user_id'],$formData['name'],$uData['user_email'],$formData['tel'],$status));
$Lid = $db->lastInsertId();



$mailBody .= $L['plu_simpleorders_email_h_customer'] . $nl;
foreach ($formData as $key => $val) {
	$label = isset($L['plu_simpleorders_email_form_'.$key]) ? $L['plu_simpleorders_email_form_'.$key] : $key . ':';
	$mailBody .= $label . ' ' . $val. $nl;

}
$mailBody .= 'Ваш логин: '.$uData['login'].$nl;
$mailBody .= 'Ваш пароль: '.$uData['password'].$nl;




$mailBody .= $nl.$nl;

$mailBody .= $L['plu_simpleorders_email_h_order'] . $nl;
/*
foreach ($data['cart'] as $title => $quantity) {
	$i++;
	$mailBody .= $i . '. ' . $L['plu_simpleorders_email_prd_title'] . $title . ', ' . $L['plu_simpleorders_email_prd_quantity'] . $quantity . $nl;
}
*/


$sum = 0;
foreach ($full_data as $f_data) {

		$i++;
		$mailBody .= $i . '. ' . $L['plu_simpleorders_email_prd_title'] . $f_data['title'] . ', ' .$L['plu_simpleorders_email_prd_price'].$f_data['price'].', '. $L['plu_simpleorders_email_prd_quantity'] . $f_data['quantity'] . $nl;
		$sum += $f_data['price'] * $f_data['quantity'];

		$order['order_id'] = $Lid;

		if(array_key_exists('page_id', $f_data) ){

			$order['module'] = 'page';
			$order['product_id'] = $f_data['page_id'];

		}elseif(array_key_exists('prd_id', $f_data)){

			$order['module'] = 'products';
			$order['product_id'] = $f_data['prd_id'];
		}

		$order['name'] =  $f_data['title'];
		$order['quantity'] =  $f_data['quantity'];
		$order['price'] =  $f_data['price'];
		$order['total'] =  $f_data['price'] * $f_data['quantity'];
		if (!$db->insert($db_order_product, $order)) return;

}
$mailBody .= $L['plu_simpleorders_email_total_price'].$sum.$nl;



require_once cot_incfile('functions');



cot_mail($cfg['adminemail'], $L['plu_simpleorders_email_subject'], $mailBody);
cot_mail($formData['email'], $L['plu_simpleorders_email_subject'], $mailBody);

$t = new XTemplate(cot_tplfile('simpleorders.order.send.success', 'plug'));
$t->parse();
$json = array(
		'html' => $t->text(),
	);
echo json_encode($json);
cot_so_remove_data();
exit();

function createUser($formData){

	global $cfg,$db,$db_x;


	$user['user_name'] = trim(substr($formData['email'],0,strpos($formData['email'],'@')));
	$user['user_email'] = trim(mb_strtolower($formData['email']));
	$rpassword1 = generatePassword();
	
	$user['user_country'] = '00';
	$user['user_timezone'] = 'GMT';
	$user['user_text'] = NULL;
	$user['user_maingrp'] = 4; //cot_import('um_usermaingrp','P','INT');

	$user['user_passsalt'] = cot_unique(16);
	$user['user_passfunc'] = empty($cfg['hashfunc']) ? 'sha256' : $cfg['hashfunc'];
	$user['user_password'] = cot_hash($rpassword1, $user['user_passsalt'], $user['user_passfunc']);

	$db_users = $db_x.'users';
	$users_count = $db->query("SELECT COUNT(*) AS c FROM $db_users WHERE user_name = ? ", array($user['user_name']))->fetch();
	if($users_count['c']){
		$user['user_name'].=$users_count['c'] + 1;
	}

	$userid = cot_add_user($user,$umuser['user_email'],$umuser['user_name'],$rpassword1,$umuser['user_maingrp'],$sendemail =false );
		// Вносим в базу все данные о новом пользователе.
	$db->update($db_users, $user, 'user_id='.$userid);



	return  array('user_id'=>$userid,'login'=>$user['user_name'] , 'password'=>$rpassword1, 'user_email'=>$user['user_email']);

}
function getUser($id){

	global $db,$db_x;

	$db_users = $db_x.'users';
	$sql_prep = $db->prepare("SELECT * FROM $db_users WHERE user_id = ? LIMIT 1");
	$sql_prep->execute(array($id));
	return $sql_prep->fetch();


}

function generatePassword($length = 8){
  $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
  $numChars = strlen($chars);
  $string = '';
  for ($i = 0; $i < $length; $i++) {
    $string .= substr($chars, rand(1, $numChars) - 1, 1);
  }
  return $string;
}

