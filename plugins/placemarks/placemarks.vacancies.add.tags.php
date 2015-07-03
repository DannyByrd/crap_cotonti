<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=vacancies.add.tags,vacancies.edit.tags
 * Tags=vacancies.add.tpl:{VACADD_FORM_PLACEMARKS};vacancies.edit.tpl:{VACEDIT_FORM_PLACEMARKS}
 * [END_COT_EXT]
 */

/**
 * Placemarks for vacancies module
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

$t->assign('VAC'.$plmpr.'_FORM_PLACEMARKS', cot_placemarks_getmark('vacancies', $code, 'edit'));

?>