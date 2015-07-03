<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=board.add.tags,board.edit.tags
 * Tags=board.add.tpl:{ADVADD_FORM_PLACEMARKS};board.edit.tpl:{ADVEDIT_FORM_PLACEMARKS}
 * [END_COT_EXT]
 */

/**
 * Placemarks for board module
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

$t->assign('ADV'.$plmpr.'_FORM_PLACEMARKS', cot_placemarks_getmark('board', $code, 'edit'));

?>