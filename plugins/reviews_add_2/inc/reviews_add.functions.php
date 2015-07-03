<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('page', 'module');

function pageAdd(&$data){
	global $cfg;

	

	if($_POST['rpagestate'] == 1){
		if(cot_page_add($data) !== false){
			
				if($cfg['plugin']['reviews_add']['notify_admin']){
					// Отправка уведомления админу
					$subject = 'Добавлен отзыв';
					$newLineSymb = "\n";
					$header = "From: " . $sitemaintitle . " <" . $cfg['adminemail'] . ">\n" . "Reply-To: <" . $cfg['adminemail'] . ">\n";
					$body = 'Тема отзыва: ' . $data['page_title'] . $newLineSymb;
					$body .= 'Автор: ' . $data['page_author'] . $newLineSymb;
					$body .= 'Город: ' . $data['page_city'] . $newLineSymb;
					$body .= 'Текст сообщения: ' . $data['page_text'] . $newLineSymb;
					cot_mail($cfg['adminemail'], $subject, $body, $header, true);
				}

			$data['page_title'] = '';
			$data['page_text'] = '';
			$data['page_author'] = '';
			$data['page_city'] = '';
			return true;
		} else {
			return false;
		}
				
	}

}

?>