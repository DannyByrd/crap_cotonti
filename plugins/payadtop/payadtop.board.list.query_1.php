<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=board.list.query
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payadtop', 'plug');

$orderby = 'adv_top DESC, '.$orderby;
	
?>