<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payprdtop', 'plug');
require_once cot_incfile('products', 'module');
require_once cot_incfile('payments', 'module');

if ($pays = cot_payments_getallpays('products.top', 'paid'))
{
	foreach ($pays as $pay)
	{		
		$adv = $db->query("SELECT prd_top FROM $db_products WHERE prd_id=" . $pay['pay_code'])->fetch();
		$initialtime = ($adv['prd_top'] > $sys['now']) ? $adv['prd_top'] : $sys['now'];
		$rtopexpire = $initialtime + $pay['pay_time'];

		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$db->update($db_products,  array('prd_top' => (int)$rtopexpire), "prd_id=".(int)$pay['pay_code']);

			/* === Hook === */
			foreach (cot_getextplugins('payprdtop.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}

?>