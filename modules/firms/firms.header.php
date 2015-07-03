<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=header.main
[END_COT_EXT]
==================== */

/**
 * Header notices for new firms
 *
 * @package Cotonti
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('firms', 'module');

if ($usr['id'] > 0 && cot_auth('firms', 'any', 'A'))
{
	$sql_firm_queued = $db->query("SELECT COUNT(*) FROM $db_firms WHERE firm_state=1");
	$sys['firmsqueued'] = $sql_firm_queued->fetchColumn();

	if ($sys['firmsqueued'] > 0)
	{
		$out['notices_array'][] = array(cot_url('admin', 'm=firms'), cot_declension($sys['firmsqueued'], $Ls['unvalidated_firms']));
	}
}
elseif ($usr['id'] > 0 && cot_auth('firms', 'any', 'W'))
{
	$sys['firmsqueued'] = (int) $db->query("SELECT COUNT(*) FROM $db_firms WHERE firm_state=1 AND firm_ownerid = " . $usr['id'])->fetchColumn();

	if ($sys['firmsqueued'] > 0)
	{
		$out['notices_array'][] = array(cot_url('firms', 'c=unvalidated'), cot_declension($sys['firmsqueued'], $Ls['unvalidated_firms']));
	}
}

if ($usr['id'] > 0 && cot_auth('firms', 'any', 'W'))
{
	$sys['firmsindrafts'] = (int) $db->query("SELECT COUNT(*) FROM $db_firms WHERE firm_state=2 AND firm_ownerid = " . $usr['id'])->fetchColumn();

	if ($sys['firmsindrafts'] > 0)
	{
		$out['notices_array'][] = array(cot_url('firms', 'c=saved_drafts'), cot_declension($sys['firmsindrafts'], $Ls['firm_in_drafts']));
	}
}
