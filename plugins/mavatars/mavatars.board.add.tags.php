<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=board.add.tags,board.edit.tags
 * Tags=board.add.tpl:{ADVADD_FORM_MAVATARTITLE}, {ADVADD_FORM_MAVATAR};board.edit.tpl:{ADVEDIT_FORM_MAVATARTITLE}, {ADVEDIT_FORM_MAVATARFILE}, {ADVEDIT_FORM_MAVATAR}, {ADVEDIT_FORM_MAVATARDELETE}
 * [END_COT_EXT]
 */

/**
 * Pagemultiavatar for Cotonti CMF
 *
 * @version 1.00
 * @author  esclkm, graber, devkont
 * @copyright (c) 2011 esclkm, graber, CMSWorks Team 2013
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('mavatars', 'plug');

if ((int) $id > 0)
{
	$code = $id;
	$category = $adv['adv_cat'];
	$mavpr = 'EDIT';
}
else
{
	$code = 'new';
	$category = $radv['adv_cat'];
	$mavpr = 'ADD';
}
$mavatar = new mavatar('board', $category, $code);

$t->assign('ADV'.$mavpr.'_FORM_MAVATAR', $mavatar->generate_upload_form());

?>