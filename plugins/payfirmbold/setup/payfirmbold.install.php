<?php
/**
 * Installation handler
 *
 * @package payfirmbold
 * @version 1.0.0
 * @author levhik
 * @copyright Copyright (c) PalmraStudio 2015
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('firms', 'module');

global $db_firms;

// Add field if missing
if (!$db->fieldExists($db_firms, "firm_bold"))
{
	$dbres = $db->query("ALTER TABLE `$db_firms` ADD COLUMN `firm_bold` int(10) NOT NULL");
}

?>