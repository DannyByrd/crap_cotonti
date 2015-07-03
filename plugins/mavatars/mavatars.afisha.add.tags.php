<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=afisha.add.tags,afisha.edit.tags
 * Tags=afisha.add.tpl:{EVTADD_FORM_MAVATARTITLE}, {EVTADD_FORM_MAVATAR};afisha.edit.tpl:{EVTEDIT_FORM_MAVATARTITLE}, {EVTEDIT_FORM_MAVATARFILE}, {EVTEDIT_FORM_MAVATAR}, {EVTEDIT_FORM_MAVATARDELETE}
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
	$category = $event['adv_cat'];
	$mavpr = 'EDIT';
}
else
{
	$code = 'new';
	$category = $revent['adv_cat'];
	$mavpr = 'ADD';
}
$mavatar = new mavatar('afisha', $category, $code);

$t->assign('EVT'.$mavpr.'_FORM_MAVATAR', $mavatar->generate_upload_form());

?>