<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=board.add.add.done,board.edit.update.done
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

if (empty($radv['adv_alias']))
{
	require_once cot_incfile('autoalias2', 'plug', 'functions.board');
	$radv['adv_alias'] = autoalias2_update($radv['adv_title'], $id);
}
