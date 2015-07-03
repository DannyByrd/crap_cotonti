<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin.extrafields.first
  [END_COT_EXT]
  ==================== */

/**
 * Adv module
 *
 * @package afisha
 * @version 0.7.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('afisha', 'module');
$extra_whitelist[$db_afisha] = array(
	'name' => $db_afisha,
	'caption' => $L['Module'].' Afisha',
	'type' => 'module',
	'code' => 'afisha',
	'tags' => array(
		'afisha.list.tpl' => '{LIST_ROW_XXXXX}, {LIST_TOP_XXXXX}',
		'afisha.tpl' => '{ADV_XXXXX}, {ADV_XXXXX_TITLE}',
		'afisha.add.tpl' => '{ADVADD_FORM_XXXXX}, {ADVADD_FORM_XXXXX_TITLE}',
		'afisha.edit.tpl' => '{ADVEDIT_FORM_XXXXX}, {ADVEDIT_FORM_XXXXX_TITLE}',
		'news.tpl' => '{ADV_ROW_XXXXX}',
		'recentitems.afisha.tpl' => '{ADV_ROW_XXXXX}',
	)
);
