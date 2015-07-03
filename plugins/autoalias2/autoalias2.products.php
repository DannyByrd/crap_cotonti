<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=products.add.add.done,products.edit.update.done
[END_COT_EXT]
==================== */

/**
 * Creates alias when adding or updating a products
 *
 * @package autoalias2
 * @version 2.1.2
 * @author Trustmaster
 * @copyright (c) Cotonti Team 2010-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if (empty($rprd['prd_alias']))
{
	require_once cot_incfile('autoalias2', 'plug', 'functions.products');
	$rprd['prd_alias'] = autoalias2_update($rprd['prd_title'], $id);
}
