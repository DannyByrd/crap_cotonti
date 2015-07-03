<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.home.sidepanel
[END_COT_EXT]
==================== */

/**
 * Vacancies manager & Queue of vacancies
 *
 * @package Cotonti
 * @version 0.9.4
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

$tt = new XTemplate(cot_tplfile('vacancies.admin.home', 'module', true));

require_once cot_incfile('vacancies', 'module');

	$vacanciesqueued = $db->query("SELECT COUNT(*) FROM $db_vacancies WHERE vac_state='1'");
	$vacanciesqueued = $vacanciesqueued->fetchColumn();
	$tt->assign(array(
		'ADMIN_HOME_URL' => cot_url('admin', 'm=vacancies'),
		'ADMIN_HOME_PAGESQUEUED' => $vacanciesqueued
	));

$tt->parse('MAIN');

$line = $tt->text('MAIN');
