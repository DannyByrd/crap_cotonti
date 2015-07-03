<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=firmstags.main
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('mavatars', 'plug');

$mavatar = new mavatar('firms', $firm_data['firm_cat'], $firm_data['firm_id']);
$mavatars_tags = $mavatar->generate_mavatars_tags();

$temp_array['MAVATAR'] = $mavatars_tags;
$temp_array['MAVATARCOUNT'] = count($mavatars_tags);

?>