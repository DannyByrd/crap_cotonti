<?php
/**
 * Uninstallation handler
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

// Remove column from table
if ($db->fieldExists($db_vacancies, "vac_top"))
{
	$db->query("ALTER TABLE `$db_vacancies` DROP COLUMN `vac_top`");
}

?>