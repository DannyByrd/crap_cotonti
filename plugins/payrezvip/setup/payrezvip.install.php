<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('rezume', 'module');

global $db_rezume;

// Add field if missing
if (!$db->fieldExists($db_rezume, "rez_vip"))
{
	$dbres = $db->query("ALTER TABLE `$db_rezume` ADD COLUMN `rez_vip` int(10) NOT NULL");
}

?>