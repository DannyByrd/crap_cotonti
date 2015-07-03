<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');


if(isset($_POST['action'])){
	require_once cot_incfile('simpleorders', 'plug', $_POST['action']);
} else {
	cot_die_message(404);
	exit;
}