<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=header.main
[END_COT_EXT]
==================== */

/**
 * Header notices for new rezume
 *
 * @package Cotonti
 * @version 0.7.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('rezume', 'module');

if ($usr['id'] > 0 && cot_auth('rezume', 'any', 'A'))
{
	$sql_rez_queued = $db->query("SELECT COUNT(*) FROM $db_rezume WHERE rez_state=1");
	$sys['rezumequeued'] = $sql_rez_queued->fetchColumn();

	if ($sys['rezumequeued'] > 0)
	{
		$out['notices_array'][] = array(cot_url('admin', 'm=rezume'), cot_declension($sys['rezumequeued'], $Ls['unvalidated_rezume']));
	}
}
elseif ($usr['id'] > 0 && cot_auth('rezume', 'any', 'W'))
{
	$sys['rezumequeued'] = (int) $db->query("SELECT COUNT(*) FROM $db_rezume WHERE rez_state=1 AND rez_ownerid = " . $usr['id'])->fetchColumn();

	if ($sys['rezumequeued'] > 0)
	{
		$out['notices_array'][] = array(cot_url('rezume', 'c=unvalidated'), cot_declension($sys['rezumequeued'], $Ls['unvalidated_rezume']));
	}
}

if ($usr['id'] > 0 && cot_auth('rezume', 'any', 'W'))
{
	$sys['rezumeindrafts'] = (int) $db->query("SELECT COUNT(*) FROM $db_rezume WHERE rez_state=2 AND rez_ownerid = " . $usr['id'])->fetchColumn();

	if ($sys['rezumeindrafts'] > 0)
	{
		$out['notices_array'][] = array(cot_url('rezume', 'c=saved_drafts'), cot_declension($sys['rezumeindrafts'], $Ls['rez_in_drafts']));
	}
}
