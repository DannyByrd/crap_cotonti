<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=afisha.add.add.done,afisha.edit.update.done
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

if (empty($revent['event_alias']))
{
	require_once cot_incfile('autoalias2', 'plug', 'functions.afisha');
	$revent['event_alias'] = autoalias2_update($revent['event_title'], $id);
}
