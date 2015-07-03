<?php
/**
 * Afisha list
 *
 * @package afisha
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

// Environment setup
define('COT_BOARD', TRUE);

$s = cot_import('s', 'G', 'ALP'); // order field name without 'event_'
$w = cot_import('w', 'G', 'ALP', 4); // order way (asc, desc)
$c = cot_import('c', 'G', 'TXT'); // cat code
$o = cot_import('ord', 'G', 'ARR'); // filter field names without 'event_'
$p = cot_import('p', 'G', 'ARR'); // filter values
$maxrowsperpage = ($cfg['afisha']['cat_' . $c]['maxrowsperpage']) ? $cfg['afisha']['cat_' . $c]['maxrowsperpage'] : $cfg['afisha']['cat___default']['maxrowsperpage'];
list($pg, $d, $durl) = cot_import_pagenav('d', $maxrowsperpage); //afisha number for afisha list
list($pgc, $dc, $dcurl) = cot_import_pagenav('dc', $cfg['afisha']['maxlistsperpage']);// afisha number for cats list

if (empty($c))
{
	$c = '';
	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('afisha', 'any');
	cot_block($usr['auth_read']);
}
elseif ($c == 'unvalidated' || $c == 'saved_drafts')
{
	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('afisha', 'any');
	cot_block($usr['auth_write']);
}
elseif (!isset($structure['afisha'][$c]))
{
	cot_die_message(404, TRUE);
}
else
{
	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('afisha', $c);
	cot_block($usr['auth_read']);
}

/* === Hook === */
foreach (cot_getextplugins('afisha.list.first') as $pl)
{
	include $pl;
}
/* ===== */

$cat = &$structure['afisha'][$c];

if (empty($s))
{
	$s = $cfg['afisha']['cat_' . $c]['order'];
}
elseif (!$db->fieldExists($db_afisha, "event_$s"))
{
	$s = 'date';
}
$w = empty($w) ? $cfg['afisha']['cat_' . $c]['way'] : $w;

$s = empty($s) ? $cfg['afisha']['cat___default']['order'] : $s;
$w = (empty($w) || !in_array($w, array('asc', 'desc'))) ? $cfg['afisha']['cat___default']['way'] : $w;

$sys['sublocation'] = $cat['title'];

$cfg['afisha']['maxrowsperpage'] = (empty($c) || $c == 'unvalidated' || $c == 'saved_drafts') ?
	$cfg['afisha']['cat___default']['maxrowsperpage'] :
	$cfg['afisha']['cat_' . $c]['maxrowsperpage'];
$cfg['afisha']['maxrowsperpage'] = $cfg['afisha']['maxrowsperpage'] > 0 ? $cfg['afisha']['maxrowsperpage'] : 1;

$cfg['afisha']['truncateeventtext'] = (empty($c) || $c == 'unvalidated' || $c == 'saved_drafts') ?
	$cfg['afisha']['cat___default']['truncateeventtext'] :
	$cfg['afisha']['cat_' . $c]['truncateeventtext'];

$where = array();
$params = array();

$where['state'] = "event_state=0";
$where['expire'] = "(event_expire=0 OR event_expire > {$sys['now']})";

if(empty($c))
{
	$cat['title'] = $L['Afisha'];
	$cat['desc'] = $cfg['afisha']['description'];
}
elseif ($c == 'unvalidated')
{
	$cat['tpl'] = 'unvalidated';
	$where['state'] = 'event_state = 1';
	$where['ownerid'] = $usr['isadmin'] ? '1' : 'event_ownerid = ' . $usr['id'];
	$cat['title'] = $L['event_validation'];
	$cat['desc'] = $L['event_validation_desc'];
	$s = 'date';
	$w = 'desc';
}
elseif ($c == 'saved_drafts')
{
	$cat['tpl'] = 'unvalidated';
	$where['state'] = 'event_state = 2';
	$where['ownerid'] = $usr['isadmin'] ? '1' : 'event_ownerid = ' . $usr['id'];
	$cat['title'] = $L['event_drafts'];
	$cat['desc'] = $L['event_drafts_desc'];
	$s = 'date';
	$w = 'desc';
}
else
{
	$catsub = cot_structure_children('afisha', $c);
	$where['cat'] = "event_cat IN ('".implode("','", $catsub)."')";
	
	$where['state'] = "event_state=0";
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
		if ($key && $val && $db->fieldExists($db_afisha, "event_$key"))
		{
			$params[$key] = $val;
			$where['filter'][] = "event_$key = :$key";
		}
	}
	empty($where['filter']) || $where['filter'] = implode(' AND ', $where['filter']);
}
if ($c != 'unvalidated' && $c != 'saved_drafts')
{
	$where['date'] = "(event_expire = 0 OR event_expire > {$sys['now']})";
}

$orderby = "event_$s $w";

$list_url_path = array('c' => $c, 'ord' => $o, 'p' => $p);
if ($s != $cfg['afisha']['cat_' . $c]['order'])
{
	$list_url_path['s'] = $s;
}
if ($w != $cfg['afisha']['cat_' . $c]['way'])
{
	$list_url_path['w'] = $w;
}
$list_url = cot_url('afisha', $list_url_path);

// Building the canonical URL
$pageurl_params = array('c' => $c, 'ord' => $o, 'p' => $p);
if ($durl > 1)
{
	$pageurl_params['d'] = $durl;
}
if ($dcurl > 1)
{
	$pageurl_params['dc'] = $dcurl;
}

$catpatharray = cot_afisha_buildpath($c);
$catpath = cot_breadcrumbs($catpatharray, $cfg['homebreadcrumb'], true);

$shortpath = $catpatharray;
array_pop($shortpath);
$catpath_short = (empty($c) || $c == 'system' || $c == 'unvalidated' || $c == 'saved_drafts') ? '' : cot_breadcrumbs($shortpath, $cfg['homebreadcrumb']);

/* === Hook === */
foreach (cot_getextplugins('afisha.list.query') as $pl)
{
	include $pl;
}
/* ===== */

if(empty($sql_event_string))
{
	$where = array_filter($where);
	$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
	$sql_event_count = "SELECT COUNT(*) FROM $db_afisha as p $join_condition $where";
	$sql_event_string = "SELECT p.*, u.* $join_columns
		FROM $db_afisha as p $join_condition
		LEFT JOIN $db_users AS u ON u.user_id=p.event_ownerid
		$where
		ORDER BY $orderby LIMIT $d, ".$cfg['afisha']['maxrowsperpage'];
}
$totallines = $db->query($sql_event_count, $params)->fetchColumn();
$sqllist = $db->query($sql_event_string, $params);

if ((!$cfg['easypagenav'] && $durl > 0 && $cfg['afisha']['maxrowsperpage'] > 0 && $durl % $cfg['afisha']['maxrowsperpage'] > 0)
	|| ($d > 0 && $d >= $totallines))
{
	cot_redirect(cot_url('afisha', $list_url_path + array('dc' => $dcurl)));
}

$pagenav = cot_pagenav('afisha', $list_url_path + array('dc' => $dcurl), $d, $totallines, $cfg['afisha']['maxrowsperpage']);

if(empty($c)){
	$cfg_seotitle = trim($cfg['afisha']['seo_title']);
	$subtitle = !empty($cfg_seotitle) ? $cfg_seotitle : $cat['title'];
} else{
	$seotitle = trim($cat['seotitle']);
	$subtitle = !empty($seotitle) ? $seotitle : $cat['title'];
}

$out['desc'] = htmlspecialchars(strip_tags($cat['metadesc']));
$out['subtitle'] = $subtitle;
$out['keywords'] = (!empty($cfg['afisha']['cat_' . $c]['keywords'])) ? $cfg['afisha']['cat_' . $c]['keywords'] : $cfg['afisha']['cat___default']['keywords'];

// Building the canonical URL
$out['canonical_uri'] = cot_url('afisha', $pageurl_params);

$_SESSION['cat'] = $c;

$mskin = cot_tplfile(array('afisha', 'list', $cat['tpl']));

/* === Hook === */
foreach (cot_getextplugins('afisha.list.main') as $pl)
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
	'LIST_CAT_RSS' => cot_url('rss', "m=afisha&c=$c"),
	'LIST_CATTITLE' => $cat['title'],
	'LIST_CATPATH' => $catpath,
	'LIST_CATSHORTPATH' => $catpath_short,
	'LIST_CATURL' => cot_url('afisha', $list_url_path),
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
	'LIST_TOP_MAXPERPAGE' => $cfg['afisha']['maxrowsperpage'],
	'LIST_TOP_TOTALPAGES' => $pagenav['total']
));

if ($usr['auth_write'] && $c != 'unvalidated' && $c != 'saved_drafts')
{
	$t->assign(array(
		'LIST_SUBMITNEWFIRM' => cot_rc('event_submitnewafisha', array('sub_url' => cot_url('afisha', 'm=add&c='.$c))),
		'LIST_SUBMITNEWADV_URL' => cot_url('afisha', 'm=add&c='.$c)
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
foreach ($cot_extrafields[$db_afisha] + array('title' => 'title', 'key' => 'key', 'date' => 'date', 'owner' => 'owner', 'count' => 'count') as $row_k => $row_p)
{
	$uname = strtoupper($row_k);
	$url_asc = cot_url('afisha',  array('s' => $row_k, 'w' => 'asc') + $list_url_path);
	$url_desc = cot_url('afisha', array('s' => $row_k, 'w' => 'desc') + $list_url_path);
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
		$extratitle = isset($L['event_'.$row_k.'_title']) ?	$L['event_'.$row_k.'_title'] : $row_p['field_description'];
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

$pagenav_cat = cot_pagenav('afisha', $list_url_path + array('d' => $durl), $dc, count($allsub), $cfg['afisha']['maxlistsperpage'], 'dc');

$t->assign(array(
	'LISTCAT_PAGEPREV' => $pagenav_cat['prev'],
	'LISTCAT_PAGENEXT' => $pagenav_cat['next'],
	'LISTCAT_PAGNAV' => $pagenav_cat['main']
));

$jj = 0;
/* === Hook - Part1 : Set === */
$extp = cot_getextplugins('afisha.list.loop');
/* ===== */
$sqllist_rowset = $sqllist->fetchAll();

$sqllist_rowset_other = false;
/* === Hook === */
foreach (cot_getextplugins('afisha.list.before_loop') as $pl)
{
	include $pl;
}
/* ===== */

if(!$sqllist_rowset_other)
{
	foreach ($sqllist_rowset as $event)
	{
		$jj++;
		$t->assign(cot_generate_eventtags($event, 'LIST_ROW_', $cfg['afisha']['truncateeventtext'], $usr['isadmin']));
		$t->assign(array(
			'LIST_ROW_OWNER' => cot_build_user($event['event_ownerid'], htmlspecialchars($event['user_name'])),
			'LIST_ROW_ODDEVEN' => cot_build_oddeven($jj),
			'LIST_ROW_NUM' => $jj
		));
		$t->assign(cot_generate_usertags($event, 'LIST_ROW_OWNER_'));

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
foreach (cot_getextplugins('afisha.list.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'] . '/footer.php';

if ($cache && $usr['id'] === 0 && $cfg['cache_afisha'])
{
	$cache->afisha->write();
}
