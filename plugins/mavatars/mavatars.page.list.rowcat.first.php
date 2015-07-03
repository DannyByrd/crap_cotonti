<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=page.list.rowcat.first,products.list.before_loop
 * [END_COT_EXT]
 */
/**
 * Pagemultiavatar for Cotonti CMF
 *
 * @version 1.00
 * @author  esclkm, graber
 * @copyright (c) 2011 esclkm, graber
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('mavatars', 'plug');
$path_arr = explode('.', $cat['path']);
$cat_code = end($path_arr);

$mavatar = new mavatar('structure', $cat_code, $cat['id']);
$mavatars_tags = $mavatar->generate_mavatars_tags();

$t->assign(array(
	'LIST_CAT_MAVATAR' => $mavatars_tags,
	'LIST_CAT_MAVATARCOUNT' => count($mavatars_tags)

));