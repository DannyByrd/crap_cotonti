<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=vacancies.add.add.done,vacancies.edit.update.done
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

if (empty($rvac['vac_alias']))
{
	require_once cot_incfile('autoalias2', 'plug', 'functions.vacancies');
	$rvac['vac_alias'] = autoalias2_update($rvac['vac_title'], $id);
}
