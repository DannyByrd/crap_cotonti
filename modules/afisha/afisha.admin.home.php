<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.home.sidepanel
[END_COT_EXT]
==================== */

/**
 * Afisha manager & Queue of afisha
 *
 * @package Cotonti
 * @version 0.9.4
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

$tt = new XTemplate(cot_tplfile('afisha.admin.home', 'module', true));

require_once cot_incfile('afisha', 'module');

	$afishaqueued = $db->query("SELECT COUNT(*) FROM $db_afisha WHERE event_state='1'");
	$afishaqueued = $afishaqueued->fetchColumn();
	$tt->assign(array(
		'ADMIN_HOME_URL' => cot_url('admin', 'm=afisha'),
		'ADMIN_HOME_PAGESQUEUED' => $afishaqueued
	));

$tt->parse('MAIN');

$line = $tt->text('MAIN');
