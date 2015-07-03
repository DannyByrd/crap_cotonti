<?php


defined('COT_CODE') or die('Wrong URL.');



	global $cfg, $db_x, $db;
	

	if(!empty($_GET['pay_id']) && !empty($_GET['email']) && !empty($_GET['date']) &&
		!empty($_GET['desc']) && !empty($_GET['comm']) && !empty($_GET['price'])){

		$pay_id = $_GET['pay_id'];
		$email = $_GET['email'];
		$date = $_GET['date'];
		$comm = $_GET['comm'];
		$desc = $_GET['desc'];
		$price = $_GET['price'];

		

		$res = sendToCustomer($email,$comm,$price,$date,$desc);


		if($res){
			echo 'Сообщение отправленно';
		}else{
			echo "Что то пошло не так";
		}




	}else{
		echo 'Слишком мало параметов отправленно )=';
		
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
	
	

function sendToCustomer($email,$comm,$price,$date,$desc){
	global $cfg,$db,$db_x;
	$email_title = mb_encode_mimeheader($cfg['maintitle'], 'UTF-8', 'B', "\n");
	$email_title = 'Ваши пожертвования';
	$new_line_symbol = "\n";
	$code = generatePassword();

	$email_body = '';
	$email_body .= 'Вы потратили '.$price.$new_line_symbol;
	$email_body .= 'На '.$desc.$new_line_symbol;
	$email_body .=  $date." числа".$new_line_symbol;
	$email_body .=  $comm.$new_line_symbol;
	$email_body .=  'Ваш пароль: '.$code.$new_line_symbol;
	
	$res = cot_mail($email, $email_title, $email_body);


	$query = $db->prepare("INSERT INTO $db_x"."whatpay (wpay_code, wpay_email, wpay_comment) VALUES (?, ?, ?)");
	$query->execute(array($code,$email,$comm));
	return $res;

}

