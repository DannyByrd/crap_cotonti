<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=header.main
[END_COT_EXT]
==================== */

/**
 * Header notices for new vacancies
 *
 * @package Cotonti
 * @version 0.7.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('vacancies', 'module');

if ($usr['id'] > 0 && cot_auth('vacancies', 'any', 'A'))
{
	$sql_vac_queued = $db->query("SELECT COUNT(*) FROM $db_vacancies WHERE vac_state=1");
	$sys['vacanciesqueued'] = $sql_vac_queued->fetchColumn();

	if ($sys['vacanciesqueued'] > 0)
	{
		$out['notices_array'][] = array(cot_url('admin', 'm=vacancies'), cot_declension($sys['vacanciesqueued'], $Ls['unvalidated_vacancies']));
	}
}
elseif ($usr['id'] > 0 && cot_auth('vacancies', 'any', 'W'))
{
	$sys['vacanciesqueued'] = (int) $db->query("SELECT COUNT(*) FROM $db_vacancies WHERE vac_state=1 AND vac_ownerid = " . $usr['id'])->fetchColumn();

	if ($sys['vacanciesqueued'] > 0)
	{
		$out['notices_array'][] = array(cot_url('vacancies', 'c=unvalidated'), cot_declension($sys['vacanciesqueued'], $Ls['unvalidated_vacancies']));
	}
}

if ($usr['id'] > 0 && cot_auth('vacancies', 'any', 'W'))
{
	$sys['vacanciesindrafts'] = (int) $db->query("SELECT COUNT(*) FROM $db_vacancies WHERE vac_state=2 AND vac_ownerid = " . $usr['id'])->fetchColumn();

	if ($sys['vacanciesindrafts'] > 0)
	{
		$out['notices_array'][] = array(cot_url('vacancies', 'c=saved_drafts'), cot_declension($sys['vacanciesindrafts'], $Ls['vac_in_drafts']));
	}
}
