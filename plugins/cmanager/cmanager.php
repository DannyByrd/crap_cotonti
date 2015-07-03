<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

/**
 * Will clean various things
 *
 * @package whatpay
 * @version 0.7.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');



$pluf_name = 'cmanager';

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