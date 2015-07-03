<?php
/**
 * Installation handler
 *
 * @package payfirmvip
 * @version 1.0.0
 * @author levhik
 * @copyright Copyright (c) PalmiraStudio 2015
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('firms', 'module');

global $db_firms;

// Add field if missing
if (!$db->fieldExists($db_firms, "firm_vip"))
{
	$dbres = $db->query("ALTER TABLE `$db_firms` ADD COLUMN `firm_vip` int(10) NOT NULL");
}

?>