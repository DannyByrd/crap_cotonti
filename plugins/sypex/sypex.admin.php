	<?php
/* ====================
[BEGIN_COT_EXT]
Code=sypex
Hooks=tools
Tags=
Order=10
[END_COT_EXT]
==================== */

/**
 * Sypex Dumper for Cotonti CMF
 *
 * @version 2.1 Beta (security add-on)
 * @author esclkm, http://www.littledev.ru, add-on by Macik (http://bm.galaxyhost.org)
 * @copyright (c) 2008-2010 esclkm, http://www.littledev.ru, Macik 2010-2011 (http://bm.galaxyhost.org)
 */

defined('COT_CODE') or die('Wrong URL');

$plugin_title = "Sypex Dumper";
$plug_name = 'sypex';
$pl_cfg = $cfg['plugin'][$plug_name];
$unique = $pl_cfg['unique'];
file_put_contents(dirname(__FILE__).'/unique.dat',$unique);
// mod by macik for security reason
$name = 'COT_SXD';
$mark = md5($name.gmdate('zG').$unique);
cot_setcookie($name,$mark,time()+1800,'/','');
// mod by macik for security reason

$plugin_body .= '<div class="centerall"><iframe src="'.$cfg['plugins_dir'].'/sypex/sxd_2.0.11/index.php?uid=' . $usr['id'] . '&sid=' . $usr['profile']['user_sid'] . '" width="586" height="462" frameborder="0" style="margin:0;"></iframe></div>';

?>
