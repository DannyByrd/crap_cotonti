<?php

defined('COT_CODE') or die('Wrong URL');

$t = new XTemplate(cot_tplfile('simpleorders.delete.order', 'plug'));

$t->parse('MAIN');

$json = array(
		'html' => $t->text(),
	);
echo json_encode($json);
exit();