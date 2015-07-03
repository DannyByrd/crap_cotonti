<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=standalone
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL');

// Environment setup
define('COT_MAP', TRUE);
$env['location'] = 'map';

// Additional API requirements
require_once cot_incfile('extrafields');

// Self requirements
require_once cot_incfile('firms', 'module');
require_once cot_incfile('map', 'plug');

require_once cot_incfile('map', 'plug', 'list');

?>