<?php
/**
 * Installation handler
 *
 * @package payvacvip
 * @version 1.0.0
 * @author devkont
 * @copyright Copyright (c) CMSWorks Team 2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('vacancies', 'module');

global $db_vacancies;

// Add field if missing
if (!$db->fieldExists($db_vacancies, "vac_vip"))
{
	$dbres = $db->query("ALTER TABLE `$db_vacancies` ADD COLUMN `vac_vip` int(10) NOT NULL");
}

?>