<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=blogs.add.add.done,blogs.edit.update.done
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

if (empty($rpost['post_alias']))
{
	require_once cot_incfile('autoalias2', 'plug', 'functions.blogs');
	$rpost['post_alias'] = autoalias2_update($rpost['post_title'], $id);
}
