<?php
/* 0.9.18-04 */
defined('COT_CODE') && defined('COT_UPDATE') or die('Wrong URL');

global $cfg, $db, $db_x;

$db_pages 		= $db_x . 'pages';

$query = $db->query("SELECT * FROM $db_pages LIMIT 1;")->fetch();
$cols = array_keys($query);
if(!array_search('page_tpl', $cols)){
	$db->query("ALTER TABLE  `cot_pages` ADD  `page_tpl` VARCHAR( 120 ) NOT NULL ;");
}

?>