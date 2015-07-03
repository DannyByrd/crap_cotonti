<?php
/**
 * Uninstallation handler
 *
 * @package payfirmvip
 * @version 1.0.0
 * @author levhik
 * @copyright Copyright (c) PalmiraStudio 2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('firms', 'module');

global $db_firms;

// Remove column from table
if ($db->fieldExists($db_firms, "firm_vip"))
{
	$db->query("ALTER TABLE `$db_firms` DROP COLUMN `firm_vip`");
}

?>