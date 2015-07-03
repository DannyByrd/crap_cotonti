<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=vacancies.list.query
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payvactop', 'plug');

$orderby = 'vac_top DESC, '.$orderby;
	
?>