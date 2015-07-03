<?php 

defined('COT_CODE') or die('Wrong URL.');

global $db, $db_x;

	$db->delete($db_x . 'placemarks', "mark_area='map'");
