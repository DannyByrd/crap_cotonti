<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=header.main
[END_COT_EXT]
==================== */

/**
 * Header notices for new afisha
 *
 * @package Cotonti
 * @version 0.7.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('afisha', 'module');

if ($usr['id'] > 0 && cot_auth('afisha', 'any', 'A'))
{
	$sql_event_queued = $db->query("SELECT COUNT(*) FROM $db_afisha WHERE event_state=1");
	$sys['afishaqueued'] = $sql_event_queued->fetchColumn();

	if ($sys['afishaqueued'] > 0)
	{
		$out['notices_array'][] = array(cot_url('admin', 'm=afisha'), cot_declension($sys['afishaqueued'], $Ls['unvalidated_afisha']));
	}
}
elseif ($usr['id'] > 0 && cot_auth('afisha', 'any', 'W'))
{
	$sys['afishaqueued'] = (int) $db->query("SELECT COUNT(*) FROM $db_afisha WHERE event_state=1 AND event_ownerid = " . $usr['id'])->fetchColumn();

	if ($sys['afishaqueued'] > 0)
	{
		$out['notices_array'][] = array(cot_url('afisha', 'c=unvalidated'), cot_declension($sys['afishaqueued'], $Ls['unvalidated_afisha']));
	}
}

if ($usr['id'] > 0 && cot_auth('afisha', 'any', 'W'))
{
	$sys['afishaindrafts'] = (int) $db->query("SELECT COUNT(*) FROM $db_afisha WHERE event_state=2 AND event_ownerid = " . $usr['id'])->fetchColumn();

	if ($sys['afishaindrafts'] > 0)
	{
		$out['notices_array'][] = array(cot_url('afisha', 'c=saved_drafts'), cot_declension($sys['afishaindrafts'], $Ls['event_in_drafts']));
	}
}
