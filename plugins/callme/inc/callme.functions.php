<?php

/**
 * Callme module
 *
 * @package callme
 * @version 1.1.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');


function cot_callme_validate()
{
	global $form_date;

	$error = array();

	
    	if ((mb_strlen($form_date['plg_callme_name']) < 2) || (mb_strlen($form_date['plg_callme_name']) > 32)) {
      		$error['plg_callme_name'] = 'Не верное имя';
    	}
		
		 if ((mb_strlen($form_date['plg_callme_tel']) < 3) || (mb_strlen($form_date['plg_callme_tel']) > 32)) {
      		$error['plg_callme_tel'] = 'Не вервый номер телефона';
    	}
		
 		return $error;

}

?>