<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=firms.add.tags,firms.edit.tags
 * Tags=firms.add.tpl:{FIRMADD_FORM_PLACEMARKS};firms.edit.tpl:{FIRMEDIT_FORM_PLACEMARKS}
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

if ((int) $id > 0)
{
	$code = $id;
	$plmpr = 'EDIT';
}
else
{
	$code = '';
	$plmpr = 'ADD';
}

$t->assign('FIRM'.$plmpr.'_FORM_PLACEMARKS', cot_placemarks_getmark('firms', $code, 'edit'));

?>