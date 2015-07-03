<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=rezume.add.add.done,rezume.edit.update.done
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

if (empty($rrez['rez_alias']))
{
	require_once cot_incfile('autoalias2', 'plug', 'functions.rezume');
	$rrez['rez_alias'] = autoalias2_update($rrez['rez_title'], $id);
}
