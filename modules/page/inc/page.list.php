<?php
/**
 * Page list
 *
 * @package Page
 * @copyright (c) Cotonti Team
 * @license https://github.com/Cotonti/Cotonti/blob/master/License.txt
 */

defined('COT_CODE') or die('Wrong URL');

// Environment setup
define('COT_LIST', TRUE);
$env['location'] = 'list';

global $ignore_pages_by_al;

$s = cot_import('s', 'G', 'ALP'); // order field name without 'page_'
$w = cot_import('w', 'G', 'ALP', 4); // order way (asc, desc)
$c = cot_import('c', 'G', 'TXT'); // cat code
$o = cot_import('ord', 'G', 'ARR'); // filter field names without 'page_'
$p = cot_import('p', 'G', 'ARR'); // filter values
$maxrowsperpage = ($cfg['page']['cat_' . $c]['maxrowsperpage']) ? $cfg['page']['cat_' . $c]['maxrowsperpage'] : $cfg['page']['cat___default']['maxrowsperpage'];
list($pg, $d, $durl) = cot_import_pagenav('d', $maxrowsperpage); //page number for pages list
list($pgc, $dc, $dcurl) = cot_import_pagenav('dc', $cfg['page']['maxlistsperpage']);// page number for cats list

if ($c == 'all' || $c == 'system')
{
	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('admin', 'a');
	cot_block($usr['isadmin']);
}
elseif ($c == 'unvalidated' || $c == 'saved_drafts')
{
	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('page', 'any');
	cot_block($usr['auth_write']);
}
elseif (!isset($structure['page'][$c]))
{
	cot_die_message(404, TRUE);
}
else
{
	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('page', $c);
	cot_block($usr['auth_read']);
}



/* === Hook === */
foreach (cot_getextplugins('page.list.first') as $pl)
{
	include $pl;
}
/* ===== */

$cat = &$structure['page'][$c];

if (empty($s))
{
	$s = $cfg['page']['cat_' . $c]['order'];
}
elseif (!$db->fieldExists($db_pages, "page_$s"))
{
	$s = 'title';
}
$w = empty($w) ? $cfg['page']['cat_' . $c]['way'] : $w;

$s = empty($s) ? $cfg['page']['cat___default']['order'] : $s;
$w = (empty($w) || !in_array($w, array('asc', 'desc'))) ? $cfg['page']['cat___default']['way'] : $w;


$sys['sublocation'] = $cat['title'];

$cfg['page']['maxrowsperpage'] = ($c == 'all' || $c == 'system' || $c == 'unvalidated' || $c == 'saved_drafts') ?
	$cfg['page']['cat___default']['maxrowsperpage'] :
	$cfg['page']['cat_' . $c]['maxrowsperpage'];
$cfg['page']['maxrowsperpage'] = $cfg['page']['maxrowsperpage'] > 0 ? $cfg['page']['maxrowsperpage'] : 1;

$cfg['page']['truncatetext'] = ($c == 'all' || $c == 'system' || $c == 'unvalidated' || $c == 'saved_drafts') ?
	$cfg['page']['cat___default']['truncatetext'] :
	$cfg['page']['cat_' . $c]['truncatetext'];

$where = array();
$params = array();

$where_state = $usr['isadmin'] ? '1' : "page_ownerid = {$usr['id']}";
$where['state'] = "(page_state=0 AND $where_state)";
if ($c == 'unvalidated')
{
	$cat['tpl'] = 'unvalidated';
	$where['state'] = 'page_state = 1';
	$where['ownerid'] = $usr['isadmin'] ? '1' : 'page_ownerid = ' . $usr['id'];
	$cat['title'] = $L['page_validation'];
	$cat['desc'] = $L['page_validation_desc'];
	$s = 'date';
	$w = 'desc';
}
elseif ($c == 'saved_drafts')
{
	$cat['tpl'] = 'unvalidated';
	$where['state'] = 'page_state = 2';
	$where['ownerid'] = $usr['isadmin'] ? '1' : 'page_ownerid = ' . $usr['id'];
	$cat['title'] = $L['page_drafts'];
	$cat['desc'] = $L['page_drafts_desc'];
	$s = 'date';
	$w = 'desc';
}
elseif ($c != 'all')
{
	if($cfg['page']['cat_' . $c]['show_items_inner_cats'] == 'global'){
		$show_inner_items = $cfg['page']['show_items_allsubcats'];
	} else {
		switch ($cfg['page']['cat_' . $c]['show_items_inner_cats']) {
			case 'show':
				$show_inner_items = 1;
				break;
			
			default:
				$show_inner_items = 0;
				break;
		}
	}

	if($show_inner_items){
		$allsubcats = cot_structure_children('page', $c);

		$allsubcats_condition = '';
		$OR_condition = ' OR ';

		foreach ($allsubcats as $subcat_num => $subcat_code) {
			$allsubcats_condition .= 'ps.structure_code=' . $db->quote($subcat_code) . $OR_condition;
		}

		$allsubcats_condition = substr($allsubcats_condition, 0, '-'.strlen($OR_condition));
		$where['cat'] = '(' . $allsubcats_condition . ')';
	} else {
		$where['cat'] = 'ps.structure_code=' . $db->quote($c);
	}

	$where['state'] = "p.page_state=0";

	if(isset($ignore_pages_by_al) && !empty($ignore_pages_by_al))
    foreach($ignore_pages_by_al as $key => $val){
        $where['cat_al_ignore_'.$key] = "p.page_alias!='" . $val . "'";
    }

}

$c = (empty($cat['title'])) ? 'all' : $c;
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
		if ($key && $val && $db->fieldExists($db_pages, "page_$key"))
		{
			$params[$key] = $val;
			$where['filter'][] = "page_$key = :$key";
		}
	}
	empty($where['filter']) || $where['filter'] = implode(' AND ', $where['filter']);
}
if (!$usr['isadmin'] && $c != 'unvalidated' && $c !== 'saved_drafts')
{
	$where['date'] = "page_begin <= {$sys['now']} AND (page_expire = 0 OR page_expire > {$sys['now']})";
}

$orderby = "p.page_$s $w";

$list_url_path = array('c' =>$c, 'ord' => $o, 'p' => $p);
if ($s != $cfg['page']['cat_' . $c]['order'])
{
	$list_url_path['s'] = $s;
}
if ($w != $cfg['page']['cat_' . $c]['way'])
{
	$list_url_path['w'] = $w;
}
$list_url = cot_url('page', $list_url_path);

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

$catpatharray = cot_structure_buildpath('page', $c);
$catpath = ($c == 'all' || $c == 'system' || $c == 'unvalidated' || $c == 'saved_drafts') ? $cat['title'] : cot_breadcrumbs($catpatharray, $cfg['homebreadcrumb'], true);
$shortpath = $catpatharray;
array_pop($shortpath);
$catpath_short = ($c == 'all' || $c == 'system' || $c == 'unvalidated' || $c == 'saved_drafts') ? '' : cot_breadcrumbs($shortpath, $cfg['homebreadcrumb']);

/* === Hook === */
foreach (cot_getextplugins('page.list.query') as $pl)
{
	include $pl;
}
/* ===== */

if(empty($sql_page_string))
{
	$where = array_filter($where);
	$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
	$sql_page_count = "SELECT COUNT(*) FROM $db_pages_in_structure as ps $join_condition LEFT JOIN `$db_pages` AS p ON p.page_id = ps.page_id $where";
	$sql_page_string = "SELECT p.*, u.* $join_columns
		FROM  `$db_pages_in_structure` AS ps $join_condition
		LEFT JOIN `$db_pages` AS p ON p.page_id = ps.page_id
		LEFT JOIN `$db_users` AS u ON u.user_id=p.page_ownerid
		$where
		GROUP BY ps.page_id
		ORDER BY $orderby LIMIT $d, ".$cfg['page']['maxrowsperpage'];
}
$totallines = $db->query($sql_page_count, $params)->fetchColumn();
$sqllist = $db->query($sql_page_string, $params);

if ((!$cfg['easypagenav'] && $durl > 0 && $cfg['page']['maxrowsperpage'] > 0 && $durl % $cfg['page']['maxrowsperpage'] > 0)
	|| ($d > 0 && $d >= $totallines))
{
	cot_redirect(cot_url('page', $list_url_path + array('dc' => $dcurl)));
}

$pagenav = cot_pagenav('page', $list_url_path + array('dc' => $dcurl), $d, $totallines, $cfg['page']['maxrowsperpage']);

$out['desc'] = htmlspecialchars(strip_tags($cat['metadesc']));
$seotitle =trim($cat['seotitle']);
$out['subtitle'] = !empty($seotitle) ? $seotitle : $cat['title'];
if (!empty($cfg['page']['cat_' . $c]['keywords']))
{
	$out['keywords'] = $cfg['page']['cat_' . $c]['keywords'];
}
if (!empty($cfg['page']['cat_' . $c]['metadesc']))
{
	$out['desc'] = $cfg['page']['cat_' . $c]['metadesc'];
}
if (!empty($cfg['page']['cat_' . $c]['metatitle']))
{
	$out['subtitle'] = $cfg['page']['cat_' . $c]['metatitle'];
}
// Building the canonical URL
$out['canonical_uri'] = cot_url('page', $pageurl_params);

$_SESSION['cat'] = $c;

$mskin = cot_tplfile(array('page', 'list', $cat['tpl']));

/* === Hook === */
foreach (cot_getextplugins('page.list.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'] . '/header.php';
$t = new XTemplate($mskin);



$t->assign(array(
	'LIST_PAGETITLE' => $catpath,
	'LIST_CATEGORY' => htmlspecialchars($cat['title']),
	'LIST_CAT' => $c,
	'LIST_CAT_RSS' => cot_url('rss', "c=$c"),
	'LIST_CATTITLE' => $cat['title'],
	'LIST_CATPATH' => $catpath,
	'LIST_CATSHORTPATH' => $catpath_short,
	'LIST_CATURL' => cot_url('page', $list_url_path),
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
	'LIST_TOP_MAXPERPAGE' => $cfg['page']['maxrowsperpage'],
	'LIST_TOP_TOTALPAGES' => $pagenav['total']
));

if ($usr['auth_write'] && $c != 'all' && $c != 'unvalidated' && $c != 'saved_drafts')
{
	$t->assign(array(
		'LIST_SUBMITNEWPAGE' => cot_rc('page_submitnewpage', array('sub_url' => cot_url('page', 'm=add&c='.$c))),
		'LIST_SUBMITNEWPAGE_URL' => cot_url('page', 'm=add&c='.$c)
	));
}

// Extra fields for structure

foreach ($cot_extrafields[$db_structure] as $exfld2)
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
foreach ($cot_extrafields[$db_pages] + array('title' => 'title', 'key' => 'key', 'date' => 'date', 'author' => 'author', 'owner' => 'owner', 'count' => 'count', 'filecount' => 'filecount') as $row_k => $row_p)
{
	$uname = strtoupper($row_k);
	$url_asc = cot_url('page',  array('s' => $row_k, 'w' => 'asc') + $list_url_path);
	$url_desc = cot_url('page', array('s' => $row_k, 'w' => 'desc') + $list_url_path);
	$arrows[$row_k]['asc']  = $R['icon_down'];
	$arrows[$row_k]['desc'] = $R['icon_up'];
	if ($s == $val)
	{
		$arrows[$s][$w] = $R['icon_vert_active'][$w];
	}
	if(in_array($row_k, array('title', 'key', 'date', 'author', 'owner', 'count', 'filecount')))
	{
		$t->assign(array(
		'LIST_TOP_'.$uname => cot_rc("list_link_$row_k", array(
			'cot_img_down' => $arrows[$col]['asc'], 'cot_img_up' => $arrows[$col]['desc'],
			'list_link_url_down' => $url_asc, 'list_link_url_up' => $url_desc
		))));
	}
	else
	{
		$extratitle = isset($L['page_'.$row_k.'_title']) ?	$L['page_'.$row_k.'_title'] : $row_p['field_description'];
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

global $structure;

$mtch = $structure['page'][$c]['path'].'.'; 
$mtchlen = mb_strlen($mtch);
$mtchlvl = mb_substr_count($mtch,".");

 
if($mtchlvl != 1){
	$c = '';
}

$kk = 0; 
$allsub = cot_structure_children('page', $c, false, false, true, false);
$subcat = array_slice($allsub, $dc, $cfg['page']['maxlistsperpage']);

/* === Hook === */
foreach (cot_getextplugins('page.list.rowcat.first') as $pl)
{
	include $pl;
}
/* ===== */

/* === Hook - Part1 : Set === */
$extp = cot_getextplugins('page.list.rowcat.loop');
/* ===== */

foreach ($subcat as $x)
{
	$kk++;
	$cat_childs = cot_structure_children('page', $x);
	$sub_count = 0;
	foreach ($cat_childs as $cat_child)
	{
		$sub_count += (int)$structure['page'][$cat_child]['count'];
	}

	$sub_url_path = $list_url_path;
	$sub_url_path['c'] = $x;
	$t->assign(array(
		'LIST_ROWCAT_ID' => $structure['page'][$x]['id'],
		'LIST_ROWCAT_URL' => cot_url('page', $sub_url_path),
		'LIST_ROWCAT_TITLE' => $structure['page'][$x]['title'],
		'LIST_ROWCAT_DESC' => $structure['page'][$x]['desc'],
		'LIST_ROWCAT_ICON' => $structure['page'][$x]['icon'],
		'LIST_ROWCAT_COUNT' => $sub_count,
		'LIST_ROWCAT_ODDEVEN' => cot_build_oddeven($kk),
		'LIST_ROWCAT_NUM' => $kk
	));

	// Extra fields for structure
	foreach ($cot_extrafields[$db_structure] as $exfld)
	{
		$uname = strtoupper($exfld['field_name']);
		$t->assign(array(
			'LIST_ROWCAT_'.$uname.'_TITLE' => isset($L['structure_'.$exfld['field_name'].'_title']) ?  $L['structure_'.$exfld['field_name'].'_title'] : $exfld['field_description'],
			'LIST_ROWCAT_'.$uname => cot_build_extrafields_data('structure', $exfld, $structure['page'][$x][$exfld['field_name']]),
			'LIST_ROWCAT_'.$uname.'_VALUE' => $structure['page'][$x][$exfld['field_name']],
		));
	}

	/* === Hook - Part2 : Include === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse('MAIN.LIST_ROWCAT');
}

$pagenav_cat = cot_pagenav('page', $list_url_path + array('d' => $durl), $dc, count($allsub), $cfg['page']['maxlistsperpage'], 'dc');

$t->assign(array(
	'LISTCAT_PAGEPREV' => $pagenav_cat['prev'],
	'LISTCAT_PAGENEXT' => $pagenav_cat['next'],
	'LISTCAT_PAGNAV' => $pagenav_cat['main']
));

$jj = 0;
/* === Hook - Part1 : Set === */
$extp = cot_getextplugins('page.list.loop');
/* ===== */
$sqllist_rowset = $sqllist->fetchAll();

$sqllist_rowset_other = false;
/* === Hook === */
foreach (cot_getextplugins('page.list.before_loop') as $pl)
{
	include $pl;
}
/* ===== */



if(!$sqllist_rowset_other)
{
	foreach ($sqllist_rowset as $pag)
	{
		$jj++;
		$t->assign(cot_generate_pagetags($pag, 'LIST_ROW_', $cfg['page']['truncatetext'], $usr['isadmin']));
		$t->assign(array(
			'LIST_ROW_OWNER' => cot_build_user($pag['page_ownerid'], htmlspecialchars($pag['user_name'])),
			'LIST_ROW_ODDEVEN' => cot_build_oddeven($jj),
			'LIST_ROW_NUM' => $jj
		));
		$t->assign(cot_generate_usertags($pag, 'LIST_ROW_OWNER_'));

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
foreach (cot_getextplugins('page.list.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'] . '/footer.php';

if ($cache && $usr['id'] === 0 && $cfg['cache_page'])
{
	$cache->page->write();
}
