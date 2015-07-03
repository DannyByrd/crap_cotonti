<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=vacanciestags.main
 * [END_COT_EXT]
 */

/**
 * Placemarks for firms module
 *
 * @version 1.00
 * @author  devkont
 * @copyright (c) 2013 CMSWorks Team 2013
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('placemarks', 'plug');

$temp_array['PLACEMARKS'] = cot_placemarks_getmark ('vacancies', $firm_data['vac_id'], 'vacancies');

?>