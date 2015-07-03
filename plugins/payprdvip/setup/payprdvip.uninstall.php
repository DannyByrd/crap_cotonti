<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('products', 'module');

global $db_products;

// Remove column from table
if ($db->fieldExists($db_products, "prd_vip"))
{
	$db->query("ALTER TABLE `$db_products` DROP COLUMN `prd_vip`");
}

?>