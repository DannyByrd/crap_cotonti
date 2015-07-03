<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payprdvip', 'plug');
require_once cot_incfile('products', 'module');
require_once cot_incfile('payments', 'module');

if ($pays = cot_payments_getallpays('products.vip', 'paid'))
{
	foreach ($pays as $pay)
	{		
		$adv = $db->query("SELECT prd_vip FROM $db_products WHERE prd_id=" . $pay['pay_code'])->fetch();
		$initialtime = ($adv['prd_vip'] > $sys['now']) ? $adv['prd_vip'] : $sys['now'];
		$rvipexpire = $initialtime + $pay['pay_time'];

		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$db->update($db_products,  array('prd_vip' => (int)$rvipexpire), "prd_id=".(int)$pay['pay_code']);

			/* === Hook === */
			foreach (cot_getextplugins('payprdvip.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}

?>