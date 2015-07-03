<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.home.sidepanel
[END_COT_EXT]
==================== */

/**
 * Firms manager & Queue of firms
 *
 * @package Cotonti
 * @version 0.9.4
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

$tt = new XTemplate(cot_tplfile('firms.admin.home', 'module', true));

require_once cot_incfile('firms', 'module');

	$firmsqueued = $db->query("SELECT COUNT(*) FROM $db_firms WHERE firm_state='1'");
	$firmsqueued = $firmsqueued->fetchColumn();
	$tt->assign(array(
		'ADMIN_HOME_URL' => cot_url('admin', 'm=firms'),
		'ADMIN_HOME_PAGESQUEUED' => $firmsqueued
	));

$tt->parse('MAIN');

$line = $tt->text('MAIN');
