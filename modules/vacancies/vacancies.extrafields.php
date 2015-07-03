<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin.extrafields.first
  [END_COT_EXT]
  ==================== */

/**
 * Adv module
 *
 * @package vacancies
 * @version 0.7.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('vacancies', 'module');
$extra_whitelist[$db_vacancies] = array(
	'name' => $db_vacancies,
	'caption' => $L['Module'].' Vacancies',
	'type' => 'module',
	'code' => 'vacancies',
	'tags' => array(
		'vacancies.list.tpl' => '{LIST_ROW_XXXXX}, {LIST_TOP_XXXXX}',
		'vacancies.tpl' => '{VAC_XXXXX}, {VAC_XXXXX_TITLE}',
		'vacancies.add.tpl' => '{VACADD_FORM_XXXXX}, {VACADD_FORM_XXXXX_TITLE}',
		'vacancies.edit.tpl' => '{VACEDIT_FORM_XXXXX}, {VACEDIT_FORM_XXXXX_TITLE}',
		'news.tpl' => '{VAC_ROW_XXXXX}',
		'recentitems.vacancies.tpl' => '{VAC_ROW_XXXXX}',
	)
);
