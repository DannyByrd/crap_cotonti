<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=global
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

if(COT_ADMIN === true) return;

$out['plg_smartfilter']['active'] = false;

global $structure,$out;

$e = cot_import('e', 'G', 'TXT');
$c = cot_import('c', 'G', 'TXT');
$id = cot_import('id', 'G', 'TXT');
$al = cot_import('al', 'G', 'TXT');
$fnName = 'get' . ucfirst($e) . 'FiltersData';
switch ($e) {
	case 'page':
		$extra_field_location = 'cot_pages';
		break;

	case 'products':
		$extra_field_location = 'cot_products';
		break;
	
	default:
		return;
		break;
}

require_once cot_incfile('smartfilter', 'plug');
file_exists(cot_incfile('smartfilter', 'plug', $e)) 
	&& require_once cot_incfile('smartfilter', 'plug', $e);

if(!isSupporting($e,$c,$id,$al,$fnName)) return;


/* 
/	Let's start  
*/

$out['plg_smartfilter']['active'] = true;

$url = 'c='.$c;

$filtersArr = getFiltersArr($e,$c,$extra_field_location);
if(!$filtersArr) return;
$rfilters = array();
foreach ($filtersArr as $filter) {
	if($filter_val = cot_import($filter, 'G', 'TXT')){
		$rfilters[$filter] = $filter_val;
		$url .= '&' . $filter . '=' . $filter_val;
	}
}
unset($filter);
unset($filter_val);
unset($filtersArr);

$filters_data = $fnName($e,$c,$rfilters);
if(!$filters_data) return;

$t = new XTemplate(cot_tplfile('smartfilter', 'plug'));
	$filters_counter = 0;
	foreach ($filters_data as $filter_description => $filter_data) {
		// var_dump($filter_data);
		$t->assign('FILTER_ROW_DESCRIPTION', $filter_description);
		foreach ($filter_data as $filter_name => $filter_counts) {
			// var_dump($filter_description, $filter_name,$filter_counts);
			foreach ($filter_counts as $filter_title => $filter_count) {
				// var_dump($filter_description, $filter_name,$filter_title,$filter_count);

				$t->assign(array(
					'FILTER_ITEM_NAME' => $filter_name,
					'FILTER_ITEM_TITLE' => $filter_title,
					'FILTER_ITEM_COUNT' => $filter_count,
					'FILTER_ITEM_URL' => cot_url($e, $url.'&' . $filter_name . '='.$filter_title),
				));
				if($filter_count == 0){
					$t->assign('FILTER_ITEM_DISABLED', true);
				} else {
					$t->assign('FILTER_ITEM_DISABLED', false);
					$filters_counter += $filter_count;
				}

				$t->parse('MAIN.FILTER_ROW.FILTER_ITEM');
			}
		}
		$t->assign('FILTER_COUNT', $filters_counter);
		$t->parse('MAIN.FILTER_ROW');
	}

$t->assign('FILTER_URL_RESET', cot_url($e, 'c='.$c));
$t->parse();
$out['plg_smartfilter']['html'] = $t->text('MAIN');