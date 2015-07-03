<?php
/**
 * 1.0.1 Adding the adv_cost, adv_expire, adv_hidemail fields
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('board', 'module');

global $db_board;

if (!$db->fieldExists($db_board, 'adv_cost'))
{
	$db->query("ALTER TABLE `$db_board` ADD COLUMN `adv_cost` float(16,2) default NULL");
}

if (!$db->fieldExists($db_board, 'adv_expire'))
{
	$db->query("ALTER TABLE `$db_board` ADD COLUMN `adv_expire` int(11) NOT NULL default '0'");
}

if (!$db->fieldExists($db_board, 'adv_hidemail'))
{
	$db->query("ALTER TABLE `$db_board` ADD COLUMN `adv_hidemail` tinyint(1) NOT NULL default '0'");
}

?>