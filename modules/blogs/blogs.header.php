<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=header.main
[END_COT_EXT]
==================== */

/**
 * Header notices for new blogs
 *
 * @package Cotonti
 * @version 0.7.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('blogs', 'module');

if ($usr['id'] > 0 && cot_auth('blogs', 'any', 'A'))
{
	$sql_post_queued = $db->query("SELECT COUNT(*) FROM $db_blogs WHERE post_state=1");
	$sys['blogsqueued'] = $sql_post_queued->fetchColumn();

	if ($sys['blogsqueued'] > 0)
	{
		$out['notices_array'][] = array(cot_url('admin', 'm=blogs'), cot_declension($sys['blogsqueued'], $Ls['unvalidated_blogs']));
	}
}
elseif ($usr['id'] > 0 && cot_auth('blogs', 'any', 'W'))
{
	$sys['blogsqueued'] = (int) $db->query("SELECT COUNT(*) FROM $db_blogs WHERE post_state=1 AND post_ownerid = " . $usr['id'])->fetchColumn();

	if ($sys['blogsqueued'] > 0)
	{
		$out['notices_array'][] = array(cot_url('blogs', 'c=unvalidated'), cot_declension($sys['blogsqueued'], $Ls['unvalidated_blogs']));
	}
}

if ($usr['id'] > 0 && cot_auth('blogs', 'any', 'W'))
{
	$sys['blogsindrafts'] = (int) $db->query("SELECT COUNT(*) FROM $db_blogs WHERE post_state=2 AND post_ownerid = " . $usr['id'])->fetchColumn();

	if ($sys['blogsindrafts'] > 0)
	{
		$out['notices_array'][] = array(cot_url('blogs', 'c=saved_drafts'), cot_declension($sys['blogsindrafts'], $Ls['post_in_drafts']));
	}
}
