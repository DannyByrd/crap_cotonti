<?php
/* 0.9.18-05 */
defined('COT_CODE') && defined('COT_UPDATE') or die('Wrong URL');

global $cfg, $db, $db_x;

$db_extra_fields 		= $db_x . 'extra_fields';

$query = $db->query("SELECT * FROM $db_extra_fields LIMIT 1;")->fetch();
if($query){
	$cols = array_keys($query);
	if(!array_search('field_cats', $cols)){
		$db->query("ALTER TABLE  $db_extra_fields ADD  `field_cats` TEXT NOT NULL AFTER  `field_description`");
	}	
}
?>
