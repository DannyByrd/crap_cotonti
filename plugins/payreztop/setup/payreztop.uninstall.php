<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('rezume', 'module');

global $db_rezume;

// Remove column from table
if ($db->fieldExists($db_rezume, "rez_top"))
{
	$db->query("ALTER TABLE `$db_rezume` DROP COLUMN `rez_top`");
}

?>