<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payadvip', 'plug');
require_once cot_incfile('board', 'module');
require_once cot_incfile('payments', 'module');

if ($pays = cot_payments_getallpays('board.vip', 'paid'))
{
	foreach ($pays as $pay)
	{		
		$adv = $db->query("SELECT adv_vip FROM $db_board WHERE adv_id=" . $pay['pay_code'])->fetch();
		$initialtime = ($adv['adv_vip'] > $sys['now']) ? $adv['adv_vip'] : $sys['now'];
		$rvipexpire = $initialtime + $pay['pay_time'];

		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$db->update($db_board,  array('adv_vip' => (int)$rvipexpire), "adv_id=".(int)$pay['pay_code']);

			/* === Hook === */
			foreach (cot_getextplugins('payadvip.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}

?>