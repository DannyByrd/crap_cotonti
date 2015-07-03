<?php

/* ====================
  [BEGIN_COT_EXT]
 * Hooks=standalone
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('payfirmbold', 'plug');

list($auth_read, $auth_write, $auth_admin) = cot_auth('plug', 'payfirmbold');
cot_block($auth_write);

$id = cot_import('id', 'G', 'INT');
	
if ($a == 'buy' && !empty($id))
{
	$days = cot_import('days', 'P', 'INT');

	cot_check(empty($days), 'payfirmbold_error_days');

	if (!cot_error_found())
	{

		$summ = $days * $cfg['plugin']['payfirmbold']['cost'];
		$options['time'] = $days * 24 * 60 * 60;
		$options['code'] = $id;
		$options['desc'] = $L['payfirmbold_buy_paydesc'];

		cot_payments_create_order('firms.bold', $summ, $options);
	}
}

$t = new XTemplate(cot_tplfile('payfirmbold', 'plug'));

cot_display_messages($t);

$t->assign(array(
	'PAY_FORM_ACTION' => cot_url('plug', 'e=payfirmbold&a=buy&id='.$id),
	'PAY_FORM_PERIOD' => cot_selectbox('', 'days', range(1, 30), range(1, 30), false),
));
?>