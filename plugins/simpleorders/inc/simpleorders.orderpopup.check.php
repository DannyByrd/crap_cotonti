<?php

defined('COT_CODE') or die('Wrong URL');



$formData = $_POST['formData'];





$res_errors = checkData($formData,$usr['id']);

echo json_encode($res_errors);

function checkData($formData, $id=NULL){
	global $L, $cfg, $db_x,$db;
			
	if ((mb_strlen($formData['name']) < 2) || (mb_strlen($formData['name']) > 32)) {
		$error['name'] = 'Не верное имя';
	 }else{
		$error['name'] = 0;
	}
					    
		

	if ((mb_strlen($formData['tel']) < 5) || (mb_strlen($formData['tel']) > 32)) {
		 $error['tel'] = 'Не верный номер телефона';
	}else{
		$error['tel'] = 0;
	}
	  	  
	if($id){

		$error['email'] = 0;

	}else{

		if (!cot_check_email($formData['email'])){
			$error['email'] = 'Не верный email';
		}else{
			$error['email'] = 0;
		}



		if($error['email'] === 0){

			$db_users = $db_x.'users';
			$email_exists = (bool)$db->query("SELECT user_id FROM $db_users WHERE user_email = ? LIMIT 1", array($formData['email']))->fetch();
			if($email_exists){
				$error['email'] = 'Такой email уже существует';
			}else{
				$error['email'] = 0;
			}
				
		}

	}



	return $error;	
		
}


exit;