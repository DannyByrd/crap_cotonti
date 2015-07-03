<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=admin.structure.update.done
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
	foreach ($rstructurecode as $i => $k)
	{

		$category = preg_replace('#[^\w\p{L}\-]#u', '', cot_import($rstructurecode[$i], 'D', 'TXT'));
		$code = $i;

		$mavatar = new mavatar('structure', $category, $code);
		if(!$cfg['plugin']['mavatars']['turnajax']){
			$mavatar->upload();
		}
		$mavatar->update();
	}
	
}

?>