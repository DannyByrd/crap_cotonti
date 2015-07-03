<?php

/**
 * Placemarks plugin
 *
 * @package palcemarks
 * @version 1.0.0
 * @author devkont
 * @copyright Copyright (c) CMSWorks Team 2013
 * @license BSD
 */

// Requirements
require_once cot_langfile('placemarks', 'plug');

// Global variables
global $db_placemarks, $db_x;
$db_placemarks = (isset($db_placemarks)) ? $db_placemarks : $db_x . 'placemarks';


/**
 * Returns all placemark tags for coTemplate
 *
 * @param mixed $mark_data placemark Info Array or ID
 * @return array
 * @global CotDB $db
 */
function cot_generate_placemarktags($mark_data, $tag_prefix = '')
{
	global $db, $cot_extrafields, $cfg, $L, $db_placemarks;

	static $extp_first = null, $extp_main = null;

	if (is_null($extp_first))
	{
		$extp_first = cot_getextplugins('placemarktags.first');
		$extp_main = cot_getextplugins('placemarktags.main');
	}

	/* === Hook === */
	foreach ($extp_first as $pl)
	{
		include $pl;
	}
	/* ===== */
	if (!is_array($mark_data))
	{
		$sql = $db->query("SELECT * FROM $db_placemarks WHERE mark_id = '" . (int)$mark_data . "' LIMIT 1");
		$mark_data = $sql->fetch();
	}

	if ($mark_data['mark_id'] > 0)
	{	
		$temp_array = array(
			'ID' => $mark_data['mark_id'],
			'AREA' => $mark_data['mark_area'],
			'CODE' => $mark_data['mark_code'],
			'COORD' => $mark_data['mark_coord'],
			'ZOOM' => $mark_data['mark_zoom'],
			'TITLE' => $mark_data['firm_title'],
			'DECS' => $mark_data['firm_desc'],
		);

		// Extrafields
		if (isset($cot_extrafields[$db_placemarks]))
		{
			foreach ($cot_extrafields[$db_placemarks] as $exfld)
			{
				$tag = mb_strtoupper($exfld['field_name']);
				$temp_array[$tag . '_TITLE'] = isset($L['placemarks_' . $exfld['field_name'] . '_title']) ? $L['placemarks_' . $exfld['field_name'] . '_title'] : $exfld['field_description'];
				$temp_array[$tag] = cot_build_extrafields_data('placemarks', $exfld, $mark_data['mark_' . $exfld['field_name']]);
			}
		}

		/* === Hook === */
		foreach ($extp_main as $pl)
		{
			include $pl;
		}
		/* ===== */
	}

	$return_array = array();
	if(is_array($temp_array))
	{
		foreach ($temp_array as $key => $val)
		{
			$return_array[$tag_prefix . $key] = $val;
		}
	}

	return $return_array;
}


function cot_placemarks_getmark ($area, $code, $action = 'single')
{
	global $L, $cfg, $db, $db_x, $db_placemarks;

	$db_firms 		= $db_x . 'firms';

	$t1 = new XTemplate(cot_tplfile(array('placemarks', $action, $area), 'plug'));
	
	$placemark = $db->query("SELECT placemarks.*, firms.firm_id, firms.firm_cat, firms.firm_desc, firms.firm_title FROM $db_placemarks AS placemarks
		LEFT JOIN $db_firms AS firms ON firms.firm_id=placemarks.mark_code
		WHERE mark_area='".$db->prep($area)."' AND mark_code='".$db->prep($code)."'")->fetch();

	if($action == 'single' && empty($placemark)) return false;
	
	$t1->assign(cot_generate_placemarktags($placemark, 'MARK_'));
	
	$t1->parse('MAIN');
	return $t1->text('MAIN');
}


function cot_placemarks_getmarks ($area)
{
	global $L, $cfg, $db, $db_placemarks;

	$t1 = new XTemplate(cot_tplfile(array('placemarks', 'list', $area), 'plug'));
	
	$sql = $db->query("SELECT * FROM $db_placemarks
		WHERE mark_area='".$db->prep($area)."'");
	while($placemark = $sql->fetch())
	{
		$t1->assign(cot_generate_placemarktags($placemark, 'MARK_ROW_'));
		$t1->parse('MAIN.MARK_ROW');
	}
	
	$t1->parse('MAIN');
	return $t1->text('MAIN');
}


function cot_placemarks_savemark ($area, $code, $coord, $zoom)
{
	global $L, $cfg, $db, $db_placemarks;

	$rmark['mark_coord'] = $coord;
	$rmark['mark_zoom'] = $zoom;
	
	if(!empty($rmark['mark_coord']) && !empty($rmark['mark_zoom']))
	{
		if($placemark = $db->query("SELECT * FROM $db_placemarks
		WHERE mark_area='".$db->prep($area)."' AND mark_code='".$db->prep($code)."'")->fetch())
		{
			$db->update($db_placemarks, $rmark, "mark_id=" . $placemark['mark_id']);
		}
		else
		{
			$rmark['mark_area'] = $area;
			$rmark['mark_code'] = $code;
			
			$db->insert($db_placemarks, $rmark);
		}
		
		return true;
	}
	
	return false;
}


?>