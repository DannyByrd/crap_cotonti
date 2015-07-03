<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payafishavip', 'plug');
require_once cot_incfile('afisha', 'module');
require_once cot_incfile('payments', 'module');

if ($pays = cot_payments_getallpays('event.vip', 'paid'))
{
	foreach ($pays as $pay)
	{		
		$adv = $db->query("SELECT event_vip FROM $db_afisha WHERE event_id=" . $pay['pay_code'])->fetch();
		$initialtime = ($adv['event_vip'] > $sys['now']) ? $adv['event_vip'] : $sys['now'];
		$rvipexpire = $initialtime + $pay['pay_time'];

		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$db->update($db_afisha,  array('event_vip' => (int)$rvipexpire), "event_id=".(int)$pay['pay_code']);

			/* === Hook === */
			foreach (cot_getextplugins('payafishavip.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}

?>