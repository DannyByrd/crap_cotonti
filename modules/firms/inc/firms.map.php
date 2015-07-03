<?php
/**
 * Firms map
 *
 * @package firms
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

// Environment setup
define('COT_FIRMS', TRUE);

$s = cot_import('s', 'G', 'ALP'); // order field name without 'firm_'
$w = cot_import('w', 'G', 'ALP', 4); // order way (asc, desc)
$c = cot_import('c', 'G', 'TXT'); // cat code
$o = cot_import('ord', 'G', 'ARR'); // filter field names without 'firm_'
$p = cot_import('p', 'G', 'ARR'); // filter values

list($pgc, $dc, $dcurl) = cot_import_pagenav('dc', $cfg['firms']['maxlistsperpage']);// firms number for cats list

if (empty($c))
{
	$c = '';
	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('firms', 'any');
	cot_block($usr['auth_read']);
}
elseif ($c == 'unvalidated' || $c == 'saved_drafts')
{
	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('firms', 'any');
	cot_block($usr['auth_write']);
}
elseif (!isset($structure['firms'][$c]))
{
	cot_die_message(404, TRUE);
}
else
{
	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('firms', $c);
	cot_block($usr['auth_read']);
}

/* === Hook === */
foreach (cot_getextplugins('firms.map.first') as $pl)
{
	include $pl;
}
/* ===== */

$cat = &$structure['firms'][$c];

if (empty($s))
{
	$s = $cfg['firms']['cat_' . $c]['order'];
}
elseif (!$db->fieldExists($db_firms, "firm_$s"))
{
	$s = 'date';
}
$w = empty($w) ? $cfg['firms']['cat_' . $c]['way'] : $w;

$s = empty($s) ? $cfg['firms']['cat___default']['order'] : $s;
$w = (empty($w) || !in_array($w, array('asc', 'desc'))) ? $cfg['firms']['cat___default']['way'] : $w;


$sys['sublocation'] = $cat['title'];

$cfg['firms']['truncatefirmtext'] = (empty($c) || $c == 'unvalidated' || $c == 'saved_drafts') ?
	$cfg['firms']['cat___default']['truncatefirmtext'] :
	$cfg['firms']['cat_' . $c]['truncatefirmtext'];

$where = array();
$params = array();

$where['state'] = "firm_state=0";
if(empty($c))
{
	$cat['title'] = $L['Firms'];
	$cat['desc'] = $cfg['firms']['description'];
}
elseif ($c == 'unvalidated')
{
	$cat['tpl'] = 'unvalidated';
	$where['state'] = 'firm_state = 1';
	$where['ownerid'] = $usr['isadmin'] ? '1' : 'firm_ownerid = ' . $usr['id'];
	$cat['title'] = $L['firm_validation'];
	$cat['desc'] = $L['firm_validation_desc'];
	$s = 'date';
	$w = 'desc';
}
elseif ($c == 'saved_drafts')
{
	$cat['tpl'] = 'unvalidated';
	$where['state'] = 'firm_state = 2';
	$where['ownerid'] = $usr['isadmin'] ? '1' : 'firm_ownerid = ' . $usr['id'];
	$cat['title'] = $L['firm_drafts'];
	$cat['desc'] = $L['firm_drafts_desc'];
	$s = 'date';
	$w = 'desc';
}
else
{
	$catsub = cot_structure_children('firms', $c);
	$where['cat'] = "firm_cat IN ('".implode("','", $catsub)."')";
	
	$where['state'] = "firm_state=0";
}

cot_die((empty($cat['title'])) && !$usr['isadmin']);

if ($o && $p)
{
	if (!is_array($o)) $o = array($o);
	if (!is_array($p)) $p = array($p);
	$filters = array_combine($o, $p);
	foreach ($filters as $key => $val)
	{
		$key = cot_import($key, 'D', 'ALP', 16);
		$val = cot_import($val, 'D', 'TXT', 16);
		if ($key && $val && $db->fieldExists($db_firms, "firm_$key"))
		{
			$params[$key] = $val;
			$where['filter'][] = "firm_$key = :$key";
		}
	}
	empty($where['filter']) || $where['filter'] = implode(' AND ', $where['filter']);
}

$orderby = "firm_$s $w";

$list_url_path = array('c' => $c, 'ord' => $o, 'p' => $p);
if ($s != $cfg['firms']['cat_' . $c]['order'])
{
	$list_url_path['s'] = $s;
}
if ($w != $cfg['firms']['cat_' . $c]['way'])
{
	$list_url_path['w'] = $w;
}
$list_url = cot_url('firms', $list_url_path);

// Building the canonical URL
$firmsurl_params = array('c' => $c, 'ord' => $o, 'p' => $p);
if ($durl > 1)
{
	$firmsurl_params['d'] = $durl;
}
if ($dcurl > 1)
{
	$firmsurl_params['dc'] = $dcurl;
}

$catpatharray = cot_firms_buildpath($c);
$catpath = cot_breadcrumbs($catpatharray, $cfg['homebreadcrumb'], true);

$shortpath = $catpatharray;
array_pop($shortpath);
$catpath_short = (empty($c) || $c == 'system' || $c == 'unvalidated' || $c == 'saved_drafts') ? '' : cot_breadcrumbs($shortpath, $cfg['homebreadcrumb']);

/* === Hook === */
foreach (cot_getextplugins('firms.map.query') as $pl)
{
	include $pl;
}
/* ===== */

if(empty($sql_firm_string))
{
	$where = array_filter($where);
	$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
	$sql_firm_count = "SELECT COUNT(*) FROM $db_firms as f $join_condition $where";
	$sql_firm_string = "SELECT f.*, u.* $join_columns
		FROM $db_firms as f $join_condition
		LEFT JOIN $db_users AS u ON u.user_id=f.firm_ownerid
		$where";
}
$totallines = $db->query($sql_firm_count, $params)->fetchColumn();
$sqllist = $db->query($sql_firm_string, $params);

$out['desc'] = htmlspecialchars(strip_tags($cat['desc']));
$out['subtitle'] = $cat['title'];
$out['keywords'] = (!empty($cfg['firms']['cat_' . $c]['keywords'])) ? $cfg['firms']['cat_' . $c]['keywords'] : $cfg['firms']['cat___default']['keywords'];

// Building the canonical URL
$out['canonical_uri'] = cot_url('firms', $firmsurl_params);

$_SESSION['cat'] = $c;

$mskin = cot_tplfile(array('firms', 'list', $cat['tpl']));

/* === Hook === */
foreach (cot_getextplugins('firms.map.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'] . '/header.php';
$t = new XTemplate($mskin);

$t->assign(array(
	'LIST_FIRMTITLE' => $catpath,
	'LIST_CATEGORY' => htmlspecialchars($cat['title']),
	'LIST_CAT' => $c,
	'LIST_CAT_RSS' => cot_url('rss', "m=firms&c=$c"),
	'LIST_CATTITLE' => $cat['title'],
	'LIST_CATPATH' => $catpath,
	'LIST_CATSHORTPATH' => $catpath_short,
	'LIST_CATURL' => cot_url('firms', $list_url_path),
	'LIST_CATDESC' => $cat['desc'],
	'LIST_CATICON' => empty($cat['icon']) ? '' : cot_rc('img_structure_cat', array(
			'icon' => $cat['icon'],
			'title' => htmlspecialchars($cat['title']),
			'desc' => htmlspecialchars($cat['desc'])
		)),
	'LIST_EXTRATEXT' => $extratext,
	'LIST_TOP_PAGINATION' => $pagenav['main'],
	'LIST_TOP_PAGEPREV' => $pagenav['prev'],
	'LIST_TOP_PAGENEXT' => $pagenav['next'],
	'LIST_TOP_CURRENTPAGE' => $pagenav['current'],
	'LIST_TOP_TOTALLINES' => $totallines,
	'LIST_TOP_MAXPERPAGE' => $cfg['firms']['maxrowsperpage'],
	'LIST_TOP_TOTALPAGES' => $pagenav['total']
));

if ($usr['auth_write'] && $c != 'unvalidated' && $c != 'saved_drafts')
{
	$t->assign(array(
		'LIST_SUBMITNEWFIRM' => cot_rc('firm_submitnewfirms', array('sub_url' => cot_url('firms', 'm=add&c='.$c))),
		'LIST_SUBMITNEWFIRM_URL' => cot_url('firms', 'm=add&c='.$c)
	));
}

// Extra fields for structure
foreach ($cot_extrafields[$db_structure] as $exfld)
{
	$uname = strtoupper($exfld['field_name']);
	$t->assign(array(
		'LIST_CAT_'.$uname.'_TITLE' => isset($L['structure_'.$exfld['field_name'].'_title']) ?
			$L['structure_'.$exfld['field_name'].'_title'] : $exfld['field_description'],
		'LIST_CAT_'.$uname => cot_build_extrafields_data('structure', $exfld, $cat[$exfld['field_name']]),
		'LIST_CAT_'.$uname.'_VALUE' => $cat[$exfld['field_name']],
	));
}

$arrows = array();
foreach ($cot_extrafields[$db_firms] + array('title' => 'title', 'key' => 'key', 'date' => 'date', 'owner' => 'owner', 'count' => 'count') as $row_k => $row_p)
{
	$uname = strtoupper($row_k);
	$url_asc = cot_url('firms',  array('s' => $row_k, 'w' => 'asc') + $list_url_path);
	$url_desc = cot_url('firms', array('s' => $row_k, 'w' => 'desc') + $list_url_path);
	$arrows[$row_k]['asc']  = $R['icon_down'];
	$arrows[$row_k]['desc'] = $R['icon_up'];
	if ($s == $val)
	{
		$arrows[$s][$w] = $R['icon_vert_active'][$w];
	}
	if(in_array($row_k, array('title', 'key', 'date', 'owner', 'count')))
	{
		$t->assign(array(
		'LIST_TOP_'.$uname => cot_rc("list_link_$row_k", array(
			'cot_img_down' => $arrows[$col]['asc'], 'cot_img_up' => $arrows[$col]['desc'],
			'list_link_url_down' => $url_asc, 'list_link_url_up' => $url_desc
		))));
	}
	else
	{
		$extratitle = isset($L['firm_'.$row_k.'_title']) ?	$L['firm_'.$row_k.'_title'] : $row_p['field_description'];
		$t->assign(array(
			'LIST_TOP_'.$uname => cot_rc('list_link_field_name', array(
				'cot_img_down' => $arrows[$row_k]['asc'],
				'cot_img_up' => $arrows[$row_k]['desc'],
				'list_link_url_down' => $url_asc,
				'list_link_url_up' => $url_desc
		))));
	}
	$t->assign(array(
		'LIST_TOP_'.$uname.'_URL_ASC' => $url_asc,
		'LIST_TOP_'.$uname.'_URL_DESC' => $url_desc
	));
}

$pagenav_cat = cot_pagenav('firms', $list_url_path + array('d' => $durl), $dc, count($allsub), $cfg['firms']['maxlistsperpage'], 'dc');

$t->assign(array(
	'LISTCAT_PAGEPREV' => $pagenav_cat['prev'],
	'LISTCAT_PAGENEXT' => $pagenav_cat['next'],
	'LISTCAT_PAGNAV' => $pagenav_cat['main']
));

$jj = 0;
/* === Hook - Part1 : Set === */
$extp = cot_getextplugins('firms.map.loop');
/* ===== */
$sqllist_rowset = $sqllist->fetchAll();

$sqllist_rowset_other = false;
/* === Hook === */
foreach (cot_getextplugins('firms.map.before_loop') as $pl)
{
	include $pl;
}
/* ===== */

if(!$sqllist_rowset_other)
{
	foreach ($sqllist_rowset as $firm)
	{
		$jj++;
		$t->assign(cot_generate_firmtags($firm, 'LIST_ROW_', $cfg['firms']['truncatetext'], $usr['isadmin']));
		$t->assign(array(
			'LIST_ROW_OWNER' => cot_build_user($firm['firm_ownerid'], htmlspecialchars($firm['user_name'])),
			'LIST_ROW_ODDEVEN' => cot_build_oddeven($jj),
			'LIST_ROW_NUM' => $jj
		));
		$t->assign(cot_generate_usertags($firm, 'LIST_ROW_OWNER_'));

		/* === Hook - Part2 : Include === */
		foreach ($extp as $pl)
		{
			include $pl;
		}
		/* ===== */
		$t->parse('MAIN.LIST_ROW');
	}
}

/* === Hook === */
foreach (cot_getextplugins('firms.map.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'] . '/footer.php';

if ($cache && $usr['id'] === 0 && $cfg['cache_firms'])
{
	$cache->firms->write();
}
