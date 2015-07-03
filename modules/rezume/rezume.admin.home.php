<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.home.sidepanel
[END_COT_EXT]
==================== */

/**
 * rezume manager & Queue of rezume
 *
 * @package Cotonti
 * @version 0.9.4
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

$tt = new XTemplate(cot_tplfile('rezume.admin.home', 'module', true));

require_once cot_incfile('rezume', 'module');

	$rezumequeued = $db->query("SELECT COUNT(*) FROM $db_rezume WHERE rez_state='1'");
	$rezumequeued = $rezumequeued->fetchColumn();
	$tt->assign(array(
		'ADMIN_HOME_URL' => cot_url('admin', 'm=rezume'),
		'ADMIN_HOME_PAGESQUEUED' => $rezumequeued
	));

$tt->parse('MAIN');

$line = $tt->text('MAIN');
