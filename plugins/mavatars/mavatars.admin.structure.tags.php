<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=admin.config.edit.loop
 * Tags=admin.structure.tpl:{ADMIN_STRUCTURE_EDIT_FORM_MAVATAR}
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL');

if ((int) $id > 0)
{
	require_once cot_incfile('mavatars', 'plug');
	
	$code = $id;
	$category = $structure_code;
	$mavpr = 'EDIT';
	
	$mavatar = new mavatar('structure', $category, $code);
	$t->assign('ADMIN_STRUCTURE_'.$mavpr.'_FORM_MAVATAR', $mavatar->generate_upload_form());
}
?>