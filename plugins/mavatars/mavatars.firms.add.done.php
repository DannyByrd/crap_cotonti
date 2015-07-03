<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=firms.add.add.done,firms.edit.update.done
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('mavatars', 'plug');

if (!cot_error_found())
{
	$mavatar = new mavatar('firms', $rfirm['firm_cat'], $id);
	if(!$cfg['plugin']['mavatars']['turnajax']){
		$mavatar->upload();
	}
	$mavatar->update();
	
}

?>