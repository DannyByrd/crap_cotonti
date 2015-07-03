<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payvacvip', 'plug');
require_once cot_incfile('vacancies', 'module');
require_once cot_incfile('payments', 'module');

if ($pays = cot_payments_getallpays('vac.vip', 'paid'))
{
	foreach ($pays as $pay)
	{		
		$vac = $db->query("SELECT vac_vip FROM $db_vacancies WHERE vac_id=" . $pay['pay_code'])->fetch();
		$initialtime = ($vac['vac_vip'] > $sys['now']) ? $vac['vac_vip'] : $sys['now'];
		$rvipexpire = $initialtime + $pay['pay_time'];

		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$db->update($db_vacancies,  array('vac_vip' => (int)$rvipexpire), "vac_id=".(int)$pay['pay_code']);

			/* === Hook === */
			foreach (cot_getextplugins('payvacvip.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}

?>