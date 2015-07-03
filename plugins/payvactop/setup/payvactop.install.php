<?php
/**
 * Installation handler
 *
 * @package payvactop
 * @version 1.0.0
 * @author devkont
 * @copyright Copyright (c) CMSWorks Team 2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('vacancies', 'module');

global $db_vacancies;

// Add field if missing
if (!$db->fieldExists($db_vacancies, "vac_top"))
{
	$dbres = $db->query("ALTER TABLE `$db_vacancies` ADD COLUMN `vac_top` int(10) NOT NULL");
}

?>