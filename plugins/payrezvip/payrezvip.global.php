<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payrezvip', 'plug');
require_once cot_incfile('rezume', 'module');
require_once cot_incfile('payments', 'module');

if ($pays = cot_payments_getallpays('rezume.vip', 'paid'))
{
	foreach ($pays as $pay)
	{		
		$adv = $db->query("SELECT rez_vip FROM $db_rezume WHERE rez_id=" . $pay['pay_code'])->fetch();
		$initialtime = ($adv['rez_vip'] > $sys['now']) ? $adv['rez_vip'] : $sys['now'];
		$rvipexpire = $initialtime + $pay['pay_time'];

		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$db->update($db_rezume,  array('rez_vip' => (int)$rvipexpire), "rez_id=".(int)$pay['pay_code']);

			/* === Hook === */
			foreach (cot_getextplugins('payrezvip.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}

?>