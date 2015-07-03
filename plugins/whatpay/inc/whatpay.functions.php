<?php

defined('COT_CODE') or die('Wrong URL');


function cot_show_payments(){

	global $db, $db_x, $cfg, $cot_plugins_active;
	
	$db_pages = $db_x.'payments';
	$where = "pay_status='done' AND pay_summ>0 AND pay_area = 'balance' ";

	

	$query = $db->query("SELECT * FROM $db_pages AS payments
						 LEFT JOIN $db_x"."users AS users 
						 ON payments.pay_userid = users.user_id 
						 LEFT JOIN $db_x"."whatpay AS whatpay 
						 ON users.user_email = whatpay.wpay_email 
						 WHERE $where   ORDER BY pay_pdate DESC");



	
	$users = $query->fetchAll();
	
	$t = new XTemplate(cot_tplfile('whatpay', 'plug'));
	
	$c_link = 'http://'.$_SERVER['HTTP_HOST'].'/';
	$t->assign(array('WHATPAY_URL'=>$c_link));

	if(cot_auth('admin', 'any', 'R')){

		$t->assign(array('ADMIN_USER'=>true));
	}

	foreach ($users as $user) {
			
		
		$t->assign(array(
				'WHATPAY_USER_PAYID'	=> $user['pay_id'],
			 	'WHATPAY_USER_EMAIL'	=> $user['user_email'],
			 	'WHATPAY_USER_DATE'	    => $user['pay_pdate'],
			 	'WHATPAY_USER_DESC'	    => $user['pay_desc'],
			 	'WHATPAY_USER_SUMM'	    => $user['pay_summ'],
			 	'WHATPAY_USER_COMMENT'  => $user['wpay_comment'],
			 	'WHAYPAY_USET_WHOPAID'  => $user['pay_code'],
			 
	 		 	
		 ));
		
		
		$t->parse('MAIN.WHATPAY.HIST_ROW');
	}

	
	

	$t->parse('MAIN.WHATPAY');

	$t->parse('MAIN');
	//$t->parse();

	return $t->text();
}