<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=products.list.query
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payprdtop', 'plug');

$orderby = 'prd_top DESC, '.$orderby;
	
?>