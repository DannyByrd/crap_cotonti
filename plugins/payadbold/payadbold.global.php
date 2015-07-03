<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payadbold', 'plug');
require_once cot_incfile('board', 'module');
require_once cot_incfile('payments', 'module');

if ($pays = cot_payments_getallpays('board.bold', 'paid'))
{
	foreach ($pays as $pay)
	{		
		$adv = $db->query("SELECT adv_bold FROM $db_board WHERE adv_id=" . $pay['pay_code'])->fetch();
		$initialtime = ($adv['adv_bold'] > $sys['now']) ? $adv['adv_bold'] : $sys['now'];
		$rboldexpire = $initialtime + $pay['pay_time'];

		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$db->update($db_board,  array('adv_bold' => (int)$rboldexpire), "adv_id=".(int)$pay['pay_code']);

			/* === Hook === */
			foreach (cot_getextplugins('payadbold.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}

?>