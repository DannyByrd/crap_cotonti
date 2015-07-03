<?php
/**
 * Installation handler
 *
 * @package payadvip
 * @version 1.0.0
 * @author devkont
 * @copyright Copyright (c) CMSWorks Team 2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('board', 'module');

global $db_board;

// Add field if missing
if (!$db->fieldExists($db_board, "adv_vip"))
{
	$dbres = $db->query("ALTER TABLE `$db_board` ADD COLUMN `adv_vip` int(10) NOT NULL");
}

?>