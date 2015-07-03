<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=tools
[END_COT_EXT]
==================== */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('banners', 'any');
cot_block($usr['isadmin']);

$a = cot_import('a', 'G', 'TXT');

if($a == 'update'){
	/* === Hook  === */
	foreach (cot_getextplugins('map.tools.update') as $pl)
	{
		include $pl;
	}
	/* ===== */
}

$tpl = new XTemplate(cot_tplfile('map.admin', 'plug'));

$mapsedit_array = array(
	'MAPEDIT_FORM_SEND' => cot_url('admin', "m=other&p=map&a=update"),
);

/* === Hook  === */
foreach (cot_getextplugins('map.admin.tags') as $pl)
{
	include $pl;
}
/* ===== */

$tpl->assign($mapsedit_array);
$tpl->parse('MAIN');

$plugin_body .=  $tpl->text();