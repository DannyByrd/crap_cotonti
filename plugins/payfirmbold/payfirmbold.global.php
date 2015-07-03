<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payfirmbold', 'plug');
require_once cot_incfile('firms', 'module');
require_once cot_incfile('payments', 'module');

if ($pays = cot_payments_getallpays('firms.bold', 'paid'))
{
	foreach ($pays as $pay)
	{		
		$adv = $db->query("SELECT firm_bold FROM $db_firms WHERE firm_id=" . $pay['pay_code'])->fetch();
		$initialtime = ($adv['firm_bold'] > $sys['now']) ? $adv['firm_bold'] : $sys['now'];
		$rboldexpire = $initialtime + $pay['pay_time'];

		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$db->update($db_firms,  array('firm_bold' => (int)$rboldexpire), "firm_id=".(int)$pay['pay_code']);

			/* === Hook === */
			foreach (cot_getextplugins('payfirmbold.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}

?>