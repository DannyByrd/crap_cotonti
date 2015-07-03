<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=map.tools.update
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('placemarks', 'plug');

$rcoord = cot_import('rcoord', 'P', 'TXT');
$rzoom = cot_import('rzoom', 'P', 'INT');

cot_placemarks_savemark ('map', 1, $rcoord, $rzoom);	

?>