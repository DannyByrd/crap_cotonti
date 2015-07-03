<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=map.admin.tags
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('placemarks', 'plug');

$code = 1;
$mapsedit_array['MAPEDIT_FORM_PLACEMARKS'] = cot_placemarks_getmark('map', $code, 'map.admin.form');

?>