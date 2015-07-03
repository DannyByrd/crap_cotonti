<?php
defined('COT_CODE') or die('Wrong URL.');



	global $cfg, $db_x, $db;
	


	if(empty($_GET['userCode']) || (strlen(trim($_GET['userCode'])) <= 0 )){

		$res = array('wpay_comment'=>'false');
		echo json_encode($res);
		
		die();
		
	}
	$code = trim($_GET['userCode']);

	$query = $db->prepare("SELECT wpay_comment FROM $db_x"."whatpay WHERE wpay_code = ?");
	$query->execute(array($code));
	$res = $query->fetch();
	
	if($res === false){
	
		$res = array('wpay_comment'=>'0');

	}
	echo json_encode($res);
