<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.list.query
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('smartfilter', 'plug');

$e = cot_import('e', 'G', 'TXT');
$c = cot_import('c', 'G', 'TXT');
$id = cot_import('id', 'G', 'TXT');
$al = cot_import('al', 'G', 'TXT');

if(!isSupporting($e,$c,$id,$al,$fnName)) return;


$filtersArr = getFiltersArr($e,$c);
$rfilters = array();
foreach ($filtersArr as $filter) {
	if($filter_val = cot_import($filter, 'G', 'TXT')){
		$rfilters[$filter] = 'page_' . $filter . ' LIKE "%' . $filter_val . '%"';
	}
}

$where = array_merge($where, $rfilters);