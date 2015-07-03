<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin
[END_COT_EXT]
==================== */

/**
 * Blogs manager & Queue of blogs
 *
 * @package Cotonti
 * @version 0.7.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('blogs', 'any');
cot_block($usr['isadmin']);

$t = new XTemplate(cot_tplfile('blogs.admin', 'module', true));

require_once cot_incfile('blogs', 'module');

$adminpath[] = array(cot_url('admin', 'm=extensions'), $L['Extensions']);
$adminpath[] = array(cot_url('admin', 'm=extensions&a=details&mod='.$m), $cot_modules[$m]['title']);
$adminpath[] = array(cot_url('admin', 'm='.$m), $L['Administration']);
$adminhelp = $L['adm_help_blogs'];
$adminsubtitle = $L['Blogs'];

$id = cot_import('id', 'G', 'INT');

list($pg, $d, $durl) = cot_import_pagenav('d', $cfg['maxrowsperpage']);

$sorttype = cot_import('sorttype', 'R', 'ALP');
$sorttype = empty($sorttype) ? 'id' : $sorttype;
$sort_type = array(
	'id' => $L['Id'],
	'type' => $L['Type'],
	'key' => $L['Key'],
	'title' => $L['Title'],
	'desc' => $L['Description'],
	'text' => $L['Body'],
	'ownerid' => $L['Owner'],
	'date' => $L['Date'],
	'rating' => $L['Rating'],
	'count' => $L['Hits']
);
$sqlsorttype = 'post_'.$sorttype;

$sortway = cot_import('sortway', 'R', 'ALP');
$sortway = empty($sortway) ? 'desc' : $sortway;
$sort_way = array(
	'asc' => $L['Ascending'],
	'desc' => $L['Descending']
);
$sqlsortway = $sortway;

$filter = cot_import('filter', 'R', 'ALP');
$filter = empty($filter) ? 'valqueue' : $filter;
$filter_type = array(
	'all' => $L['All'],
	'valqueue' => $L['adm_valqueue'],
	'validated' => $L['adm_validated'],
);
if ($filter == 'all')
{
	$sqlwhere = "1 ";
}
elseif ($filter == 'valqueue')
{
	$sqlwhere = "post_state=1";
}
elseif ($filter == 'validated')
{
	$sqlwhere = "post_state=0";
}

$catsub = cot_structure_children('blogs', '');
if (count($catsub) < count($structure['blogs']))
{
	$sqlwhere .= " AND post_cat IN ('" . join("','", $catsub) . "')";
}

/* === Hook  === */
foreach (cot_getextplugins('blogs.admin.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($a == 'validate')
{
	cot_check_xg();

	/* === Hook  === */
	foreach (cot_getextplugins('blogs.admin.validate') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sql_blogs = $db->query("SELECT post_cat FROM $db_blogs WHERE post_id = $id AND post_state != 0");
	if ($row = $sql_blogs->fetch())
	{
		$usr['isadmin_local'] = cot_auth('blogs', $row['post_cat'], 'A');
		cot_block($usr['isadmin_local']);
		$sql_blogs = $db->update($db_blogs, array('post_state' => 0), "post_id = $id");
		$sql_blogs = $db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code=".$db->quote($row['post_cat']));

		cot_log($L['Adv'].' #'.$id.' - '.$L['adm_queue_validated'], 'adm');

		if ($cache)
		{
			if ($cfg['cache_blogs'])
			{
				$cache->blogs->clear('blogs/' . str_replace('.', '/', $structure['blogs'][$row['post_cat']]['path']));
			}
			if ($cfg['cache_index'])
			{
				$cache->blogs->clear('index');
			}
		}

		cot_message('#'.$id.' - '.$L['adm_queue_validated']);
	}
	else
	{
		cot_die();
	}
}
elseif ($a == 'unvalidate')
{
	cot_check_xg();

	/* === Hook  === */
	foreach (cot_getextplugins('blogs.admin.unvalidate') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sql_blogs = $db->query("SELECT post_cat FROM $db_blogs WHERE post_id=$id");
	if ($row = $sql_blogs->fetch())
	{
		$usr['isadmin_local'] = cot_auth('blogs', $row['post_cat'], 'A');
		cot_block($usr['isadmin_local']);

		$sql_blogs = $db->update($db_blogs, array('post_state' => 1), "post_id=$id");
		$sql_blogs = $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code=".$db->quote($row['post_cat']));

		cot_log($L['Adv'].' #'.$id.' - '.$L['adm_queue_unvalidated'], 'adm');

		if ($cache)
		{
			if ($cfg['cache_blogs'])
			{
				$cache->blogs->clear('blogs/' . str_replace('.', '/', $structure['blogs'][$row['post_cat']]['path']));
			}
			if ($cfg['cache_index'])
			{
				$cache->blogs->clear('index');
			}
		}

		cot_message('#'.$id.' - '.$L['adm_queue_unvalidated']);
	}
	else
	{
		cot_die();
	}
}
elseif ($a == 'delete')
{
	cot_check_xg();

	/* === Hook  === */
	foreach (cot_getextplugins('blogs.admin.delete') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sql_blogs = $db->query("SELECT * FROM $db_blogs WHERE post_id=$id LIMIT 1");
	if ($row = $sql_blogs->fetch())
	{
		if ($row['post_state'] == 0)
		{
			$sql_blogs = $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code=".$db->quote($row['post_cat']));
		}

		foreach($cot_extrafields[$db_blogs] as $exfld)
		{
			cot_extrafield_unlinkfiles($row['post_'.$exfld['field_name']], $exfld);
		}

		$sql_blogs = $db->delete($db_blogs, "post_id=$id");

		cot_log($L['Adv'].' #'.$id.' - '.$L['Deleted'], 'adm');

		/* === Hook === */
		foreach (cot_getextplugins('blogs.admin.delete.done') as $pl)
		{
			include $pl;
		}
		/* ===== */

		if ($cache)
		{
			if ($cfg['cache_blogs'])
			{
				$cache->blogs->clear('blogs/' . str_replace('.', '/', $structure['blogs'][$row['post_cat']]['path']));
			}
			if ($cfg['cache_index'])
			{
				$cache->blogs->clear('index');
			}
		}

		cot_message('#'.$id.' - '.$L['adm_queue_deleted']);
	}
	else
	{
		cot_die();
	}
}
elseif ($a == 'update_checked')
{
	$paction = cot_import('paction', 'P', 'TXT');

	if ($paction == $L['Validate'] && is_array($_POST['s']))
	{
		cot_check_xp();
		$s = cot_import('s', 'P', 'ARR');

		$perelik = '';
		$notfoundet = '';
		foreach ($s as $i => $k)
		{
			if ($s[$i] == '1' || $s[$i] == 'on')
			{
				/* === Hook  === */
				foreach (cot_getextplugins('blogs.admin.checked_validate') as $pl)
				{
					include $pl;
				}
				/* ===== */

				$sql_blogs = $db->query("SELECT * FROM $db_blogs WHERE post_id=".(int)$i);
				if ($row = $sql_blogs->fetch())
				{
					$id = $row['post_id'];
					$usr['isadmin_local'] = cot_auth('blogs', $row['post_cat'], 'A');
					cot_block($usr['isadmin_local']);

					$sql_blogs = $db->update($db_blogs, array('post_state' => 0), "post_id=$id");
					$sql_blogs = $db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code=".$db->quote($row['post_cat']));

					cot_log($L['Adv'].' #'.$id.' - '.$L['adm_queue_validated'], 'adm');

					if ($cache && $cfg['cache_blogs'])
					{
						$cache->blogs->clear('blogs/' . str_replace('.', '/', $structure['blogs'][$row['post_cat']]['path']));
					}

					$perelik .= '#'.$id.', ';
				}
				else
				{
					$notfoundet .= '#'.$id.' - '.$L['Error'].'<br  />';
				}
			}
		}

		if ($cache && $cfg['cache_index'])
		{
			$cache->blogs->clear('index');
		}

		if (!empty($perelik))
		{
			cot_message($notfoundet.$perelik.' - '.$L['adm_queue_validated']);
		}
	}
	elseif ($paction == $L['Delete'] && is_array($_POST['s']))
	{
		cot_check_xp();
		$s = cot_import('s', 'P', 'ARR');

		$perelik = '';
		$notfoundet = '';
		foreach ($s as $i => $k)
		{
			if ($s[$i] == '1' || $s[$i] == 'on')
			{
				/* === Hook  === */
				foreach (cot_getextplugins('blogs.admin.checked_delete') as $pl)
				{
					include $pl;
				}
				/* ===== */

				$sql_blogs = $db->query("SELECT * FROM $db_blogs WHERE post_id=".(int)$i." LIMIT 1");
				if ($row = $sql_blogs->fetch())
				{
					$id = $row['post_id'];
					if ($row['post_state'] == 0)
					{
						$sql_blogs = $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code=".$db->quote($row['post_cat']));
					}

					$sql_blogs = $db->delete($db_blogs, "post_id=$id");

					cot_log($L['Adv'].' #'.$id.' - '.$L['Deleted'],'adm');

					if ($cache && $cfg['cache_blogs'])
					{
						$cache->blogs->clear('blogs/' . str_replace('.', '/', $structure['blogs'][$row['post_cat']]['path']));
					}

					/* === Hook === */
					foreach (cot_getextplugins('blogs.admin.delete.done') as $pl)
					{
						include $pl;
					}
					/* ===== */
					$perelik .= '#'.$id.', ';
				}
				else
				{
					$notfoundet .= '#'.$id.' - '.$L['Error'].'<br  />';
				}
			}
		}

		if ($cache && $cfg['cache_index'])
		{
			$cache->blogs->clear('index');
		}

		if (!empty($perelik))
		{
			cot_message($notfoundet.$perelik.' - '.$L['adm_queue_deleted']);
		}
	}
}

$totalitems = $db->query("SELECT COUNT(*) FROM $db_blogs WHERE ".$sqlwhere)->fetchColumn();
$pagenav = cot_pagenav('admin', 'm=blogs&sorttype='.$sorttype.'&sortway='.$sortway.'&filter='.$filter, $d, $totalitems, $cfg['maxrowsperpage'], 'd', '', $cfg['jquery'] && $cfg['turnajax']);

$sql_blogs = $db->query("SELECT p.*, u.user_name
	FROM $db_blogs as p
	LEFT JOIN $db_users AS u ON u.user_id=p.post_ownerid
	WHERE $sqlwhere
		ORDER BY $sqlsorttype $sqlsortway
		LIMIT $d, ".$cfg['maxrowsperpage']);

$ii = 0;
/* === Hook - Part1 : Set === */
$extp = cot_getextplugins('blogs.admin.loop');
/* ===== */
foreach ($sql_blogs->fetchAll() as $row)
{
	$sql_post_subcount = $db->query("SELECT SUM(structure_count) FROM $db_structure WHERE structure_path LIKE '".$db->prep($structure['blogs'][$row["post_cat"]]['rpath'])."%' ");
	$sub_count = $sql_post_subcount->fetchColumn();
	$row['post_file'] = intval($row['post_file']);
	$t->assign(cot_generate_blogposttags($row, 'ADMIN_POST_', 200));
	$t->assign(array(
		'ADMIN_POST_ID_URL' => cot_url('blogs', 'c='.$row['post_cat'].'&id='.$row['post_id']),
		'ADMIN_POST_OWNER' => cot_build_user($row['post_ownerid'], htmlspecialchars($row['user_name'])),
		'ADMIN_POST_FILE_BOOL' => $row['post_file'],
		'ADMIN_POST_URL_FOR_VALIDATED' => cot_confirm_url(cot_url('admin', 'm=blogs&a=validate&id='.$row['post_id'].'&d='.$durl.'&'.cot_xg()), 'blogs', 'post_confirm_validate'),
		'ADMIN_POST_URL_FOR_UNVALIDATE' => cot_confirm_url(cot_url('admin', 'm=blogs&a=unvalidate&id='.$row['post_id'].'&d='.$durl.'&'.cot_xg()), 'blogs', 'post_confirm_unvalidate'),
		'ADMIN_POST_URL_FOR_DELETED' => cot_confirm_url(cot_url('admin', 'm=blogs&a=delete&id='.$row['post_id'].'&d='.$durl.'&'.cot_xg()), 'blogs', 'post_confirm_delete'),
		'ADMIN_POST_URL_FOR_EDIT' => cot_url('blogs', 'm=edit&id='.$row['post_id']),
		'ADMIN_POST_ODDEVEN' => cot_build_oddeven($ii),
		'ADMIN_POST_CAT_COUNT' => $sub_count
	));
	$t->assign(cot_generate_usertags($row['post_ownerid'], 'ADMIN_POST_OWNER_'), htmlspecialchars($row['user_name']));

	/* === Hook - Part2 : Include === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse('MAIN.POST_ROW');
	$ii++;
}

$is_row_empty = ($sql_blogs->rowCount() == 0) ? true : false ;

$totaldbblogs = $db->countRows($db_blogs);
$sql_post_queued = $db->query("SELECT COUNT(*) FROM $db_blogs WHERE post_state=1");
$sys['blogsqueued'] = $sql_post_queued->fetchColumn();

$t->assign(array(
	'ADMIN_POST_URL_CONFIG' => cot_url('admin', 'm=config&n=edit&o=module&p=blogs'),
	'ADMIN_POST_URL_ADD' => cot_url('blogs', 'm=add'),
	'ADMIN_POST_URL_EXTRAFIELDS' => cot_url('admin', 'm=extrafields&n='.$db_blogs),
	'ADMIN_POST_URL_STRUCTURE' => cot_url('admin', 'm=structure&n=blogs'),
	'ADMIN_POST_FORM_URL' => cot_url('admin', 'm=blogs&a=update_checked&sorttype='.$sorttype.'&sortway='.$sortway.'&filter='.$filter.'&d='.$durl),
	'ADMIN_POST_ORDER' => cot_selectbox($sorttype, 'sorttype', array_keys($sort_type), array_values($sort_type), false),
	'ADMIN_POST_WAY' => cot_selectbox($sortway, 'sortway', array_keys($sort_way), array_values($sort_way), false),
	'ADMIN_POST_FILTER' => cot_selectbox($filter, 'filter', array_keys($filter_type), array_values($filter_type), false),
	'ADMIN_POST_TOTALDBFIRMS' => $totaldbblogs,
	'ADMIN_POST_PAGINATION_PREV' => $pagenav['prev'],
	'ADMIN_POST_PAGNAV' => $pagenav['main'],
	'ADMIN_POST_PAGINATION_NEXT' => $pagenav['next'],
	'ADMIN_POST_TOTALITEMS' => $totalitems,
	'ADMIN_POST_ON_FIRM' => $ii
));

cot_display_messages($t);

/* === Hook  === */
foreach (cot_getextplugins('blogs.admin.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$adminmain = $t->text('MAIN');
