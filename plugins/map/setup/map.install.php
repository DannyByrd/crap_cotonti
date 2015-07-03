<?php 

defined('COT_CODE') or die('Wrong URL.');

global $db, $db_x;

	$data = array(
			'mark_area' => 'map',	
			'mark_code' => '1',	
			'mark_coord' => '55.76,37.64',
			'mark_zoom' => '12',	
		);

	if ($db->insert($db_x . 'placemarks', $data))
	{
		$id = $db->lastInsertId();
	}

