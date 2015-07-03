<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=firms.add.add.done,firms.edit.update.done
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

if (empty($rfirm['firm_alias']))
{
	require_once cot_incfile('autoalias2', 'plug', 'functions.firms');
	$rfirm['firm_alias'] = autoalias2_update($rfirm['firm_title'], $id);
}
