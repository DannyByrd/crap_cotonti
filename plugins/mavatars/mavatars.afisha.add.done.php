<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=afisha.add.add.done,afisha.edit.update.done
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
	$mavatar = new mavatar('afisha', $revent['event_cat'], $id);
	if(!$cfg['plugin']['mavatars']['turnajax']){
		$mavatar->upload();
	}
	$mavatar->update();
	
}

?>