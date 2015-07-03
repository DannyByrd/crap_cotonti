<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=pagetags.main
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

global $env, $plg_name, $extrafield_actions;

if(!$page_data['page_'.$extrafield_actions] || $page_data['page_'.$extrafield_actions] < time()) return;

require_once cot_incfile('actions', 'plug');


$al = cot_import('al', 'G', 'TXT');
$id = cot_import('id', 'G', 'TXT');
$type = $al || $id ? 'main' : 'list';
$myskin = cot_tplfile(array($plg_name, $env['ext'], $type), 'plug');

$tt = new XTemplate($myskin);
$tt->assign(array(
	'ACTION_ID' => $page_data['page_id'],
	'ACTION_EXPIRY_DATE' => $page_data['page_'.$extrafield_actions],
));
$tt->parse();

$temp_array['ACTION_BLOCK'] = $tt->text();;


