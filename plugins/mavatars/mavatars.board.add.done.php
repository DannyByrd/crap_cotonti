<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=board.add.add.done,board.edit.update.done
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

if (!cot_error_found())
{
	$mavatar = new mavatar('board', $radv['adv_cat'], $id);
	if(!$cfg['plugin']['mavatars']['turnajax']){
		$mavatar->upload();
	}
	$mavatar->update();
	
}

?>