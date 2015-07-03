<?php
/**
 * Uninstallation handler
 *
 * @package payadtop
 * @version 1.0.0
 * @author devkont
 * @copyright Copyright (c) CMSWorks Team 2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('board', 'module');

global $db_board;

// Remove column from table
if ($db->fieldExists($db_board, "adv_top"))
{
	$db->query("ALTER TABLE `$db_board` DROP COLUMN `adv_top`");
}

?>