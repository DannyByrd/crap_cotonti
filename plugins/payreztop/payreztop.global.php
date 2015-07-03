<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payreztop', 'plug');
require_once cot_incfile('rezume', 'module');
require_once cot_incfile('payments', 'module');

if ($pays = cot_payments_getallpays('rezume.top', 'paid'))
{
	foreach ($pays as $pay)
	{		
		$adv = $db->query("SELECT rez_top FROM $db_rezume WHERE rez_id=" . $pay['pay_code'])->fetch();
		$initialtime = ($adv['rez_top'] > $sys['now']) ? $adv['rez_top'] : $sys['now'];
		$rtopexpire = $initialtime + $pay['pay_time'];

		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$db->update($db_rezume,  array('rez_top' => (int)$rtopexpire), "rez_id=".(int)$pay['pay_code']);

			/* === Hook === */
			foreach (cot_getextplugins('payreztop.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}

?>