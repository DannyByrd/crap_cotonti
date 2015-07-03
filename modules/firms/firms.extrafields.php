<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin.extrafields.first
  [END_COT_EXT]
  ==================== */

/**
 * Firm module
 *
 * @package firms
 * @version 0.7.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('firms', 'module');
$extra_whitelist[$db_firms] = array(
	'name' => $db_firms,
	'caption' => $L['Module'].' Firms',
	'type' => 'module',
	'code' => 'firms',
	'tags' => array(
		'firms.list.tpl' => '{LIST_ROW_XXXXX}, {LIST_TOP_XXXXX}',
		'firms.tpl' => '{FIRM_XXXXX}, {FIRM_XXXXX_TITLE}',
		'firms.add.tpl' => '{FIRMADD_FORM_XXXXX}, {FIRMADD_FORM_XXXXX_TITLE}',
		'firms.edit.tpl' => '{FIRMEDIT_FORM_XXXXX}, {FIRMEDIT_FORM_XXXXX_TITLE}',
		'news.tpl' => '{FIRM_ROW_XXXXX}',
		'recentitems.firms.tpl' => '{FIRM_ROW_XXXXX}',
	)
);
