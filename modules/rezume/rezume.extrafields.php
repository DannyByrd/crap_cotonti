<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin.extrafields.first
  [END_COT_EXT]
  ==================== */

/**
 * Adv module
 *
 * @package rezume
 * @version 0.7.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('rezume', 'module');
$extra_whitelist[$db_rezume] = array(
	'name' => $db_rezume,
	'caption' => $L['Module'].' rezume',
	'type' => 'module',
	'code' => 'rezume',
	'tags' => array(
		'rezume.list.tpl' => '{LIST_ROW_XXXXX}, {LIST_TOP_XXXXX}',
		'rezume.tpl' => '{rez_XXXXX}, {rez_XXXXX_TITLE}',
		'rezume.add.tpl' => '{REZADD_FORM_XXXXX}, {REZADD_FORM_XXXXX_TITLE}',
		'rezume.edit.tpl' => '{REZEDIT_FORM_XXXXX}, {REZEDIT_FORM_XXXXX_TITLE}',
		'news.tpl' => '{rez_ROW_XXXXX}',
		'recentitems.rezume.tpl' => '{rez_ROW_XXXXX}',
	)
);
