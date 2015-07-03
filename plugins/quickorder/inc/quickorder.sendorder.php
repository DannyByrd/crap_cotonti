<?php

defined('COT_CODE') or die('Wrong URL.');

switch ($_POST['type']) {
		case 'products': $table = 'products'; $table_id = 'prd_id'; $TBL_ID = 'PRD_ID'; $TBL_TITLE = 'PRD_TITLE'; $url = 'prd_url'; $t_cat = 'prd_cat'; $cost = 'prd_cost';
			
			break;
		case 'page':     $table = 'pages'; $table_id = 'page_id'; $TBL_ID = 'PAGE_ID'; $TBL_TITLE = 'PAGE_TITLE'; $url = 'page_url';$t_cat = 'page_cat';$cost = 'page_cost';
			
			break;
		
		default:
			 $params = NULL;
			break;
	}




global $cfg, $db_x, $db, $db_tables;

$db_tables = isset($db_tables) ? $db_tables : $db_x . $table;

function getPrdById($t_id){
		global $db, $db_tables,$table_id;
		$sql = $db->query("SELECT * FROM ".$db_tables." WHERE ".$table_id." = '" . (int) $t_id . "' LIMIT 1");
		$table_data = $sql->fetch();

		return $table_data;
}

function sendToAdmin(){
	global $cfg,$user_name,$user_phone,$user_email,$user_text,$user_text2,$table_data, $cfg,$cost,$TBL_TITLE;
	// echo 'sendToCustomer()';
	$email_title = 'Заказ от ' . $user_name;
	$new_line_symbol = "\n";
	
	$email_body = '';
	$email_body = 'Имя товара: ' . $table_data[strtolower($TBL_TITLE)] . $new_line_symbol;
	$email_body = 'Цена товара: ' .$table_data[$cost] . $new_line_symbol;
	$email_body .= 'Ссылка на товар: ' . $cfg['mainurl'] . '/' . $table_data[$url] . $new_line_symbol;

	$email_body .= $new_line_symbol;
	if($cfg['plugin']['quickorder']['use_field_name'])
		$email_body .= 'Имя пользователя: ' . $user_name . $new_line_symbol;
	if($cfg['plugin']['quickorder']['use_field_phone'])		
		$email_body .= 'Номер телефона пользователя: ' . $user_phone . $new_line_symbol;	
	if($cfg['plugin']['quickorder']['use_field_email'])		
		$email_body .= 'Email пользователя: ' . $user_email . $new_line_symbol;	
	if($cfg['plugin']['quickorder']['use_field_text'])	
		$email_body .= 'Text пользователя: ' . $user_text . $new_line_symbol;
	if($cfg['plugin']['quickorder']['use_field_text2'])	
		$email_body .= 'Text пользователя2: ' . $user_text2 . $new_line_symbol;

	$res = cot_mail($cfg['adminemail'], $email_title, $email_body);
	return $res;
}

function sendToCustomer(){
	global $user_name,$user_phone,$user_email,$table_data, $cfg, $cost,$TBL_TITLE,$url;
	// echo 'sendToCustomer()';
	$email_title = mb_encode_mimeheader($cfg['maintitle'], 'UTF-8', 'B', "\n");
	$email_title = 'Ваш заказ';
	$new_line_symbol = "\n";
	
	$email_body = '';
	$email_body .= 'Имя товара: ' . $table_data[strtolower($TBL_TITLE)] . $new_line_symbol;
	$email_body .= 'Цена товара: ' .$table_data[$cost] . $new_line_symbol;
	$email_body .= 'Ссылка на товар: ' . $cfg['mainurl'] . '/' . $table_data[$url] . $new_line_symbol;
// var_dump($prd_data);
	$res = cot_mail($user_email, $email_title, $email_body);
	return $res;
}

function checkData(){
	global $cfg,$error,$user_name, $user_text, $user_text2,$user_phone,$user_email;



			if($cfg['plugin']['quickorder']['use_field_name']){
					
				if ((mb_strlen($user_name) < 2) || (mb_strlen($user_name) > 32)) {
		      		$error['plg_quickorder_name'] = 'Не верное имя';
		      	  }
			}
		    
			if($cfg['plugin']['quickorder']['use_field_phone']){

				if ((mb_strlen($user_phone) < 3) || (mb_strlen($user_phone) > 32)) {
		      		$error['plg_quickorder_tel'] = 'Не верный номер телефона';
		      	 }
	  	    }

	  	    if($cfg['plugin']['quickorder']['use_field_email']){


				if (!cot_check_email($user_email)){
		      		$error['plg_quickorder_email'] = 'Не верный email';
		      	}
			}
			if($cfg['plugin']['quickorder']['use_field_text']){


				if((mb_strlen($user_text) < 3) || (mb_strlen($user_text) > 32)){
		      		$error['plg_quickorder_text'] = 'Не верный какой то текст';
		      	}
			}
			if($cfg['plugin']['quickorder']['use_field_text2']){


				if((mb_strlen($user_text2) < 3) || (mb_strlen($user_text2) > 32)){
		      		$error['plg_quickorder_text2'] = 'Не верный какой то текст2';
		      	}
			}
		
}


$t = new XTemplate(cot_tplfile('quickorder.add.form', 'plug'));

if(COT_AJAX){
	$tables_id = cot_import($table_id, 'P', 'INT');

		if($tables_id){
			$table_data = getprdById($tables_id);

			$user_name = cot_import('user_name', 'P', 'TXT');
			$user_phone = cot_import('user_phone', 'P', 'INT');
			$user_email = cot_import('user_email', 'P', 'TXT');  
			$user_text = cot_import('user_text', 'P', 'TXT'); // $_POST 
			$user_text2 = cot_import('user_text2', 'P', 'TXT');

			$table_data[$url] = urldecode(cot_url($table, array('c' => $table_data[$t_cat], 'id' => $table_data[$table_id])));

			$error = array();
			
			checkData();

			

			if(isset($error['plg_quickorder_name'])){
				$t->assign('USE_FIELD_NAME',1);
				$t->assign('ERROR_USER_NAME', $error['plg_quickorder_name']);
			}

			if(isset($error['plg_quickorder_tel'])){
				$t->assign('USE_FIELD_PHONE',1);
				$t->assign('ERROR_USER_PHONE', $error['plg_quickorder_tel']);
			}

			if(isset($error['plg_quickorder_email'])){
				$t->assign('USE_FIELD_EMAIL',1);
				$t->assign('ERROR_USER_EMAIL', $error['plg_quickorder_email']);

			}
			if(isset($error['plg_quickorder_text'])){
				$t->assign('USE_FIELD_TEXT',1);
				$t->assign('ERROR_USER_TEXT', $error['plg_quickorder_text']);

			}
			if(isset($error['plg_quickorder_text2'])){
				$t->assign('USE_FIELD_TEXT2',1);
				$t->assign('ERROR_USER_TEXT2', $error['plg_quickorder_text2']);

			}		

			$mails_send_success = 0;
			
			if(!$error){


				if($cfg['plugin']['quickorder']['send_order_to_admin']){
					sendToAdmin();
					$mails_send_success = 1;
				}

				if($cfg['plugin']['quickorder']['send_order_to_customer']){
					sendToCustomer();
					$mails_send_success = 1;
				}
			}
			
			if($mails_send_success){
				$user_name = '';
				$user_phone = '';
				$user_email = '';
				$user_text = '';
				$user_text2 = '';
			}

			$t->assign(array(
				$TBL_TITLE => $table_data[strtolower($TBL_TITLE)],
				$TBL_ID => $table_data[strtolower($TBL_ID)],
				'USER_NAME' => $user_name,
				'USER_PHONE' => $user_phone,
				'USER_EMAIL' => $user_email,
				'USER_TEXT' => $user_text,
				'USER_TEXT2' => $user_text2,
				'MAIL_SENDED' => $mails_send_success

			));

		}

} else {
    cot_die_message(404);
}

?>
