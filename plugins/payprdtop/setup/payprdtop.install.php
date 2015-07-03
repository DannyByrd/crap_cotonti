<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('products', 'module');

global $db_products;

// Add field if missing
if (!$db->fieldExists($db_products, "prd_top"))
{
	$dbres = $db->query("ALTER TABLE `$db_products` ADD COLUMN `prd_top` int(10) NOT NULL");
}

?>