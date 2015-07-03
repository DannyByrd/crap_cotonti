<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.home.sidepanel
[END_COT_EXT]
==================== */

/**
 * Blogs manager & Queue of blogs
 *
 * @package Cotonti
 * @version 0.9.4
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

$tt = new XTemplate(cot_tplfile('blogs.admin.home', 'module', true));

require_once cot_incfile('blogs', 'module');

	$blogsqueued = $db->query("SELECT COUNT(*) FROM $db_blogs WHERE post_state='1'");
	$blogsqueued = $blogsqueued->fetchColumn();
	$tt->assign(array(
		'ADMIN_HOME_URL' => cot_url('admin', 'm=blogs'),
		'ADMIN_HOME_PAGESQUEUED' => $blogsqueued
	));

$tt->parse('MAIN');

$line = $tt->text('MAIN');
