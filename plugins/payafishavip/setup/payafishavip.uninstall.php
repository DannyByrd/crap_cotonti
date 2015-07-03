<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('afisha', 'module');

global $db_afisha;

// Remove column from table
if ($db->fieldExists($db_afisha, "event_vip"))
{
	$db->query("ALTER TABLE `$db_afisha` DROP COLUMN `event_vip`");
}

?>