<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=board.edit.delete.done
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

$mavatar = new mavatar('board', $radv['adv_cat'], $radv['adv_id']);
$mavatar->delete_all_mavatars();
$mavatar->get_mavatars();

?>
