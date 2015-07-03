<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=global 
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL');

if(!COT_ADMIN  || COT_ADMIN === 'COT_ADMIN')
	require(cot_incfile('latestnews', 'plug'));