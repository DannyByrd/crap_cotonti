<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.home.sidepanel
[END_COT_EXT]
==================== */

/**
 * Board manager & Queue of board
 *
 * @package Cotonti
 * @version 0.9.4
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

$tt = new XTemplate(cot_tplfile('board.admin.home', 'module', true));

require_once cot_incfile('board', 'module');

	$boardqueued = $db->query("SELECT COUNT(*) FROM $db_board WHERE adv_state='1'");
	$boardqueued = $boardqueued->fetchColumn();
	$tt->assign(array(
		'ADMIN_HOME_URL' => cot_url('admin', 'm=board'),
		'ADMIN_HOME_PAGESQUEUED' => $boardqueued
	));

$tt->parse('MAIN');

$line = $tt->text('MAIN');
