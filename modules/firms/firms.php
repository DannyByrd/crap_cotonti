<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=module
[END_COT_EXT]
==================== */

/**
 * Firm module main
 *
 * @package firms
 * @version 0.9.3
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

// Environment setup
define('COT_FIRMS', TRUE);
$env['location'] = 'firms';

// Additional API requirements
require_once cot_incfile('extrafields');

// Self requirements
require_once cot_incfile('firms', 'module');

// Mode choice
if (!in_array($m, array('add', 'edit', 'firms')))
{
	if (isset($_GET['id']) || isset($_GET['al']))
	{
		$m = 'main';
	}
	else
	{
		$m = 'list';
	}
}

require_once cot_incfile('firms', 'module', $m);
