<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=header.main
[END_COT_EXT]
==================== */

/**
 * Header notices for new board
 *
 * @package Cotonti
 * @version 0.7.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('board', 'module');

if ($usr['id'] > 0 && cot_auth('board', 'any', 'A'))
{
	$sql_adv_queued = $db->query("SELECT COUNT(*) FROM $db_board WHERE adv_state=1");
	$sys['boardqueued'] = $sql_adv_queued->fetchColumn();

	if ($sys['boardqueued'] > 0)
	{
		$out['notices_array'][] = array(cot_url('admin', 'm=board'), cot_declension($sys['boardqueued'], $Ls['unvalidated_board']));
	}
}
elseif ($usr['id'] > 0 && cot_auth('board', 'any', 'W'))
{
	$sys['boardqueued'] = (int) $db->query("SELECT COUNT(*) FROM $db_board WHERE adv_state=1 AND adv_ownerid = " . $usr['id'])->fetchColumn();

	if ($sys['boardqueued'] > 0)
	{
		$out['notices_array'][] = array(cot_url('board', 'c=unvalidated'), cot_declension($sys['boardqueued'], $Ls['unvalidated_board']));
	}
}

if ($usr['id'] > 0 && cot_auth('board', 'any', 'W'))
{
	$sys['boardindrafts'] = (int) $db->query("SELECT COUNT(*) FROM $db_board WHERE adv_state=2 AND adv_ownerid = " . $usr['id'])->fetchColumn();

	if ($sys['boardindrafts'] > 0)
	{
		$out['notices_array'][] = array(cot_url('board', 'c=saved_drafts'), cot_declension($sys['boardindrafts'], $Ls['adv_in_drafts']));
	}
}
