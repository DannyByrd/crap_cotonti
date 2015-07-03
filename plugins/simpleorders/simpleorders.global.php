<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=global
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

global $out;

require_once cot_incfile('simpleorders', 'plug');

$out['plg_simpleorders']['total'] = cot_so_get_total();
