<?php

defined('COT_CODE') or die('Wrong URL');

cot_incfile('simpleorders', 'plug');

$json = array(
		'total' => cot_so_get_total(),
	);

echo json_encode($json);
exit();