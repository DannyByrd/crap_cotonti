<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payvactop', 'plug');
require_once cot_incfile('vacancies', 'module');
require_once cot_incfile('payments', 'module');

if ($pays = cot_payments_getallpays('vac.top', 'paid'))
{
	foreach ($pays as $pay)
	{		
		$vac = $db->query("SELECT vac_top FROM $db_vacancies WHERE vac_id=" . $pay['pay_code'])->fetch();
		$initialtime = ($vac['vac_top'] > $sys['now']) ? $vac['vac_top'] : $sys['now'];
		$rtopexpire = $initialtime + $pay['pay_time'];

		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$db->update($db_vacancies,  array('vac_top' => (int)$rtopexpire), "vac_id=".(int)$pay['pay_code']);

			/* === Hook === */
			foreach (cot_getextplugins('payvactop.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}

?>