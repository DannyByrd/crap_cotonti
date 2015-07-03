<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

/**
 * Home page main code
 *
 * @package callme
 * @version 0.1.0
 * @author Palmirastudio
 * @copyright Copyright (c) Palmirastudio 2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

	switch ($cfg['plugin']['callme']['bootstrap_version_support']) {
		case '2.x':
			$tplfile = cot_tplfile('callme.v2x', 'plug');
	  	 break;

		default: 
			$tplfile = cot_tplfile('callme.v3x', 'plug');
		 break;
	}
	

	
	$t = new XTemplate($tplfile);

	if (COT_AJAX){
		$t->assign('IS_AJAX', true);
	} else {
		$t->assign('IS_AJAX', false);
	}	

if (COT_AJAX){

	require_once cot_incfile('callme', 'plug');

	$form_date = array(
		plg_callme_name => cot_import('plg_callme_name', 'P', 'TXT'),
		plg_callme_tel => cot_import('plg_callme_tel', 'P', 'INT'),
		plg_callme_additional => cot_import('plg_callme_additional', 'P', 'TXT'),
		plg_callme_handytime => cot_import('plg_callme_handytime', 'P', 'TXT'),
	);

	if(isset($_POST['plg_callme_name'])){
		if($errors = cot_callme_validate()) {
			foreach ($errors as $key => $value) {
				$t->assign(strtoupper('ERROR_' . $key), $value);
			}
		}else{
				$newLineSymb = "\n";
				
				// Отправка уведомления админу
				$subject = 'Записаться на прием';
				$header = "From: " . $sitemaintitle . " <" . $cfg['adminemail'] . ">\n" . "Reply-To: <" . $cfg['adminemail'] . ">\n";
				$body = 'Имя: ' . $form_date['plg_callme_name'] . $newLineSymb;
				$body .= 'Телефон: ' . $form_date['plg_callme_tel'] . $newLineSymb;
				if($cfg['plugin']['callme']['use_handytime']){
						$body .= 'Удобное время: ' . $form_date['plg_callme_handytime']. $newLineSymb;
						
				}
				$body .= 'Сообщение: ' . $form_date['plg_callme_additional'] . $newLineSymb;
				$body .= 'Страница: ' . cot_import('plg_callme_page_link', 'P', 'TXT');
				

				if (cot_mail($cfg['adminemail'], $subject, $body, $header)){
					$t->assign('MAIL_SENDED', true);
						$form_date = array(
							plg_callme_name => '',
							plg_callme_tel => '',
							plg_callme_additional => '',
							plg_callme_handytime => '',
						);
						

				} else {
					$t->assign('MAIL_SENDED', false);
				}
		}
	}

	foreach ($form_date as $key => $value) {
		$t->assign(strtoupper($key), $value);
	}
	if($cfg['plugin']['callme']['use_handytime']){
			
			$t->assign(array('USE_HANDY_TIME'=>1));
	}

}
