<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin.extrafields.first
  [END_COT_EXT]
  ==================== */

/**
 * Adv module
 *
 * @package blogs
 * @version 0.7.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('blogs', 'module');
$extra_whitelist[$db_blogs] = array(
	'name' => $db_blogs,
	'caption' => $L['Module'].' Blogs',
	'type' => 'module',
	'code' => 'blogs',
	'tags' => array(
		'blogs.list.tpl' => '{LIST_ROW_XXXXX}, {LIST_TOP_XXXXX}',
		'blogs.tpl' => '{POST_XXXXX}, {POST_XXXXX_TITLE}',
		'blogs.add.tpl' => '{POSTADD_FORM_XXXXX}, {POSTADD_FORM_XXXXX_TITLE}',
		'blogs.edit.tpl' => '{POSTEDIT_FORM_XXXXX}, {POSTEDIT_FORM_XXXXX_TITLE}',
		'news.tpl' => '{POST_ROW_XXXXX}',
		'recentitems.blogs.tpl' => '{POST_ROW_XXXXX}',
	)
);
