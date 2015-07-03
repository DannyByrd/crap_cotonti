<?php
/* 0.9.18-06 */
defined('COT_CODE') && defined('COT_UPDATE') or die('Wrong URL');

global $cfg, $db, $db_x;

$dbname = $cfg['mysqldb'];
$db_pages 					= $db_x . 'pages';
$db_structure 				= $db_x . 'structure';
$db_pages_in_structure 		= $db_x . 'pages_in_structure';

$tables = $db->query("SHOW tables in `$dbname`")->fetchAll();

if(!in_array($db_pages_in_structure, $tables )){
	 $db->query("CREATE TABLE IF NOT EXISTS `" . $db_x . "pages_in_structure` (
  `page_id` int(11) NOT NULL,
  `structure_code` varchar(255) collate utf8_unicode_ci NOT NULL default ''
)ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
}

$data_arr = $db->query("SELECT p.page_id, p.page_cat
FROM `$db_pages` AS p")->fetchAll();

if(count($data_arr)){
	$sql = '';
	foreach ($data_arr as $row) {
		$sql .= "INSERT INTO $db_pages_in_structure (page_id, structure_code) VALUES (". (int)$row['page_id'] .", ". $db->quote($row['page_cat']) .");";
	}

	$db->query($sql);
}

?>
