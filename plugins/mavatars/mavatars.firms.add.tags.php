<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=firms.add.tags,firms.edit.tags
 * Tags=firms.add.tpl:{FIRMADD_FORM_MAVATARTITLE}, {FIRMADD_FORM_MAVATAR};firms.edit.tpl:{FIRMEDIT_FORM_MAVATARTITLE}, {FIRMEDIT_FORM_MAVATARFILE}, {FIRMEDIT_FORM_MAVATAR}, {FIRMEDIT_FORM_MAVATARDELETE}
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('mavatars', 'plug');

if ((int) $id > 0)
{
	$code = $id;
	$category = $firm['firm_cat'];
	$mavpr = 'EDIT';
}
else
{
	$code = 'new';
	$category = $revent['firm_cat'];
	$mavpr = 'ADD';
}
$mavatar = new mavatar('firms', $category, $code);

$t->assign('FIRM'.$mavpr.'_FORM_MAVATAR', $mavatar->generate_upload_form());

?>