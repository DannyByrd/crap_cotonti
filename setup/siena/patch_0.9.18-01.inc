<?php
/* 0.9.18-01 */
defined('COT_CODE') && defined('COT_UPDATE') or die('Wrong URL');

global $cfg, $db, $db_x;

$db_structure 		= $db_x . 'structure';

$query = $db->query("SELECT * FROM $db_structure LIMIT 1;")->fetch();
$cols = array_keys($query);
if(!array_search('structure_text', $cols)){
	$db->query("ALTER TABLE  $db_structure ADD  `structure_text` TEXT NOT NULL AFTER  `structure_desc`");
}

if(!array_search('structure_seotitle', $cols)){
	$db->query("ALTER TABLE  $db_structure ADD  `structure_seotitle` varchar(128) NOT NULL AFTER  `structure_title`");
}

if(!array_search('structure_metadesc', $cols)){
	$db->query("ALTER TABLE  $db_structure ADD  `structure_metadesc` mediumtext NOT NULL AFTER  `structure_desc`");
}

?>
