<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=boardtags.main
 * [END_COT_EXT]
 */
/**
 * Pagemultiavatar for Cotonti CMF
 *
 * @version 1.00
 * @author  esclkm, graber, devkont
 * @copyright (c) 2011 esclkm, graber, CMSWorks Team 2013
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('mavatars', 'plug');

$mavatar = new mavatar('board', $adv_data['adv_cat'], $adv_data['adv_id']);
$mavatars_tags = $mavatar->generate_mavatars_tags();

$temp_array['MAVATAR'] = $mavatars_tags;
$temp_array['MAVATARCOUNT'] = count($mavatars_tags);

?>