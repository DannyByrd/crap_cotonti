<?php

	$subject = 'Пример письма';
	$body = '';
	foreach ($data as $key => $value) {
		if($key == 'form_id') continue;
		if($key == 'files') continue;
		$body .= $L['multiforms_email_filed_' . $key] . $value . "\n";
	}

	cot_mail($cfg['adminemail'], $subject, $body, '', false, nul, false, $files);

	cot_message('Письмо успешно отправлено!');

	// Error and message handling
	cot_display_messages($t);

?>