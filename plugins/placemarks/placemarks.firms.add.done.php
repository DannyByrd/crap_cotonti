<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=firms.add.add.done,firms.edit.update.done
 * [END_COT_EXT]
 */

/**
 * Placemarks for firms module
 *
 * @version 1.00
 * @author  devkont
 * @copyright (c) 2013 CMSWorks Team 2013
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('placemarks', 'plug');

$rcoord = cot_import('rcoord', 'P', 'TXT');
$rzoom = cot_import('rzoom', 'P', 'INT');

if (!cot_error_found())
{
	cot_placemarks_savemark ('firms', $id, $rcoord, $rzoom);	
}

?>