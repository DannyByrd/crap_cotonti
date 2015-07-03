<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=footer.main
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

if(defined('COT_ADMIN')) return;

	$t_callme = new XTemplate(cot_tplfile('callme', 'plug'));
	$t_callme->parse('MAIN');

	global $out;
	echo $t_callme->text('MAIN');

?>