<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('afisha', 'module');

global $db_afisha;

// Add field if missing
if (!$db->fieldExists($db_afisha, "event_vip"))
{
	$dbres = $db->query("ALTER TABLE `$db_afisha` ADD COLUMN `event_vip` int(10) NOT NULL");
}

?>