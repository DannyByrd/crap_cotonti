<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=rezume.list.query
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payreztop', 'plug');

$orderby = 'rez_top DESC, '.$orderby;
	
?>