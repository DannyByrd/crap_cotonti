<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */



defined('COT_CODE') or die('Wrong URL.');



$pluf_name = 'simpleorders';

require_once cot_incfile($pluf_name, 'plug');
if(is_null($a)) $a='test';

if (file_exists(cot_incfile($pluf_name, 'plug', $a))) {
	require_once cot_incfile($pluf_name, 'plug', $a);

}else{
    // Error page
    cot_die_message(404);
    exit;
}

?>