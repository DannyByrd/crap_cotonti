<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin
[END_COT_EXT]
==================== */

/**
 * rezume manager & Queue of rezume
 *
 * @package Cotonti
 * @version 0.7.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('rezume', 'any');
cot_block($usr['isadmin']);

$t = new XTemplate(cot_tplfile('rezume.admin', 'module', true));

require_once cot_incfile('rezume', 'module');

$adminpath[] = array(cot_url('admin', 'm=extensions'), $L['Extensions']);
$adminpath[] = array(cot_url('admin', 'm=extensions&a=details&mod='.$m), $cot_modules[$m]['title']);
$adminpath[] = array(cot_url('admin', 'm='.$m), $L['Administration']);
$adminhelp = $L['adm_help_rezume'];
$adminsubtitle = $L['Rezume'];

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
$sqlsorttype = 'rez_'.$sorttype;

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
	$sqlwhere = "rez_state=1";
}
elseif ($filter == 'validated')
{
	$sqlwhere = "rez_state=0";
}

$catsub = cot_structure_children('rezume', '');
if (count($catsub) < count($structure['rezume']))
{
	$sqlwhere .= " AND rez_cat IN ('" . join("','", $catsub) . "')";
}

/* === Hook  === */
foreach (cot_getextplugins('rezume.admin.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($a == 'validate')
{
	cot_check_xg();

	/* === Hook  === */
	foreach (cot_getextplugins('rezume.admin.validate') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sql_rezume = $db->query("SELECT rez_cat FROM $db_rezume WHERE rez_id = $id AND rez_state != 0");
	if ($row = $sql_rezume->fetch())
	{
		$usr['isadmin_local'] = cot_auth('rezume', $row['rez_cat'], 'A');
		cot_block($usr['isadmin_local']);
		$sql_rezume = $db->update($db_rezume, array('rez_state' => 0), "rez_id = $id");
		$sql_rezume = $db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code=".$db->quote($row['rez_cat']));

		cot_log($L['Adv'].' #'.$id.' - '.$L['adm_queue_validated'], 'adm');

		if ($cache)
		{
			if ($cfg['cache_rezume'])
			{
				$cache->rezume->clear('rezume/' . str_replace('.', '/', $structure['rezume'][$row['rez_cat']]['path']));
			}
			if ($cfg['cache_index'])
			{
				$cache->rezume->clear('index');
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
	foreach (cot_getextplugins('rezume.admin.unvalidate') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sql_rezume = $db->query("SELECT rez_cat FROM $db_rezume WHERE rez_id=$id");
	if ($row = $sql_rezume->fetch())
	{
		$usr['isadmin_local'] = cot_auth('rezume', $row['rez_cat'], 'A');
		cot_block($usr['isadmin_local']);

		$sql_rezume = $db->update($db_rezume, array('rez_state' => 1), "rez_id=$id");
		$sql_rezume = $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code=".$db->quote($row['rez_cat']));

		cot_log($L['Adv'].' #'.$id.' - '.$L['adm_queue_unvalidated'], 'adm');

		if ($cache)
		{
			if ($cfg['cache_rezume'])
			{
				$cache->rezume->clear('rezume/' . str_replace('.', '/', $structure['rezume'][$row['rez_cat']]['path']));
			}
			if ($cfg['cache_index'])
			{
				$cache->rezume->clear('index');
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
	foreach (cot_getextplugins('rezume.admin.delete') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sql_rezume = $db->query("SELECT * FROM $db_rezume WHERE rez_id=$id LIMIT 1");
	if ($row = $sql_rezume->fetch())
	{
		if ($row['rez_state'] == 0)
		{
			$sql_rezume = $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code=".$db->quote($row['rez_cat']));
		}

		foreach($cot_extrafields[$db_rezume] as $exfld)
		{
			cot_extrafield_unlinkfiles($row['rez_'.$exfld['field_name']], $exfld);
		}

		$sql_rezume = $db->delete($db_rezume, "rez_id=$id");

		cot_log($L['Adv'].' #'.$id.' - '.$L['Deleted'], 'adm');

		/* === Hook === */
		foreach (cot_getextplugins('rezume.admin.delete.done') as $pl)
		{
			include $pl;
		}
		/* ===== */

		if ($cache)
		{
			if ($cfg['cache_rezume'])
			{
				$cache->rezume->clear('rezume/' . str_replace('.', '/', $structure['rezume'][$row['rez_cat']]['path']));
			}
			if ($cfg['cache_index'])
			{
				$cache->rezume->clear('index');
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
				foreach (cot_getextplugins('rezume.admin.checked_validate') as $pl)
				{
					include $pl;
				}
				/* ===== */

				$sql_rezume = $db->query("SELECT * FROM $db_rezume WHERE rez_id=".(int)$i);
				if ($row = $sql_rezume->fetch())
				{
					$id = $row['rez_id'];
					$usr['isadmin_local'] = cot_auth('rezume', $row['rez_cat'], 'A');
					cot_block($usr['isadmin_local']);

					$sql_rezume = $db->update($db_rezume, array('rez_state' => 0), "rez_id=$id");
					$sql_rezume = $db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code=".$db->quote($row['rez_cat']));

					cot_log($L['Adv'].' #'.$id.' - '.$L['adm_queue_validated'], 'adm');

					if ($cache && $cfg['cache_rezume'])
					{
						$cache->rezume->clear('rezume/' . str_replace('.', '/', $structure['rezume'][$row['rez_cat']]['path']));
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
			$cache->rezume->clear('index');
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
				foreach (cot_getextplugins('rezume.admin.checked_delete') as $pl)
				{
					include $pl;
				}
				/* ===== */

				$sql_rezume = $db->query("SELECT * FROM $db_rezume WHERE rez_id=".(int)$i." LIMIT 1");
				if ($row = $sql_rezume->fetch())
				{
					$id = $row['rez_id'];
					if ($row['rez_state'] == 0)
					{
						$sql_rezume = $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code=".$db->quote($row['rez_cat']));
					}

					$sql_rezume = $db->delete($db_rezume, "rez_id=$id");

					cot_log($L['Adv'].' #'.$id.' - '.$L['Deleted'],'adm');

					if ($cache && $cfg['cache_rezume'])
					{
						$cache->rezume->clear('rezume/' . str_replace('.', '/', $structure['rezume'][$row['rez_cat']]['path']));
					}

					/* === Hook === */
					foreach (cot_getextplugins('rezume.admin.delete.done') as $pl)
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
			$cache->rezume->clear('index');
		}

		if (!empty($perelik))
		{
			cot_message($notfoundet.$perelik.' - '.$L['adm_queue_deleted']);
		}
	}
}

$totalitems = $db->query("SELECT COUNT(*) FROM $db_rezume WHERE ".$sqlwhere)->fetchColumn();
$pagenav = cot_pagenav('admin', 'm=rezume&sorttype='.$sorttype.'&sortway='.$sortway.'&filter='.$filter, $d, $totalitems, $cfg['maxrowsperpage'], 'd', '', $cfg['jquery'] && $cfg['turnajax']);

$sql_rezume = $db->query("SELECT p.*, u.user_name
	FROM $db_rezume as p
	LEFT JOIN $db_users AS u ON u.user_id=p.rez_ownerid
	WHERE $sqlwhere
		ORDER BY $sqlsorttype $sqlsortway
		LIMIT $d, ".$cfg['maxrowsperpage']);

$ii = 0;
/* === Hook - Part1 : Set === */
$extp = cot_getextplugins('rezume.admin.loop');
/* ===== */
foreach ($sql_rezume->fetchAll() as $row)
{
	$sql_rez_subcount = $db->query("SELECT SUM(structure_count) FROM $db_structure WHERE structure_path LIKE '".$db->prep($structure['rezume'][$row["rez_cat"]]['rpath'])."%' ");
	$sub_count = $sql_rez_subcount->fetchColumn();
	$row['rez_file'] = intval($row['rez_file']);
	$t->assign(cot_generate_reztags($row, 'ADMIN_REZ_', 200));
	$t->assign(array(
		'ADMIN_REZ_ID_URL' => cot_url('rezume', 'c='.$row['rez_cat'].'&id='.$row['rez_id']),
		'ADMIN_REZ_OWNER' => cot_build_user($row['rez_ownerid'], htmlspecialchars($row['user_name'])),
		'ADMIN_REZ_FILE_BOOL' => $row['rez_file'],
		'ADMIN_REZ_URL_FOR_VALIDATED' => cot_confirm_url(cot_url('admin', 'm=rezume&a=validate&id='.$row['rez_id'].'&d='.$durl.'&'.cot_xg()), 'rezume', 'rez_confirm_validate'),
		'ADMIN_REZ_URL_FOR_UNVALIDATE' => cot_confirm_url(cot_url('admin', 'm=rezume&a=unvalidate&id='.$row['rez_id'].'&d='.$durl.'&'.cot_xg()), 'rezume', 'rez_confirm_unvalidate'),
		'ADMIN_REZ_URL_FOR_DELETED' => cot_confirm_url(cot_url('admin', 'm=rezume&a=delete&id='.$row['rez_id'].'&d='.$durl.'&'.cot_xg()), 'rezume', 'rez_confirm_delete'),
		'ADMIN_REZ_URL_FOR_EDIT' => cot_url('rezume', 'm=edit&id='.$row['rez_id']),
		'ADMIN_REZ_ODDEVEN' => cot_build_oddeven($ii),
		'ADMIN_REZ_CAT_COUNT' => $sub_count
	));
	$t->assign(cot_generate_usertags($row['rez_ownerid'], 'ADMIN_REZ_OWNER_'), htmlspecialchars($row['user_name']));

	/* === Hook - Part2 : Include === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse('MAIN.rez_ROW');
	$ii++;
}

$is_row_empty = ($sql_rezume->rowCount() == 0) ? true : false ;

$totaldbrezume = $db->countRows($db_rezume);
$sql_rez_queued = $db->query("SELECT COUNT(*) FROM $db_rezume WHERE rez_state=1");
$sys['rezumequeued'] = $sql_rez_queued->fetchColumn();

$t->assign(array(
	'ADMIN_REZ_URL_CONFIG' => cot_url('admin', 'm=config&n=edit&o=module&p=rezume'),
	'ADMIN_REZ_URL_ADD' => cot_url('rezume', 'm=add'),
	'ADMIN_REZ_URL_EXTRAFIELDS' => cot_url('admin', 'm=extrafields&n='.$db_rezume),
	'ADMIN_REZ_URL_STRUCTURE' => cot_url('admin', 'm=structure&n=rezume'),
	'ADMIN_REZ_FORM_URL' => cot_url('admin', 'm=rezume&a=update_checked&sorttype='.$sorttype.'&sortway='.$sortway.'&filter='.$filter.'&d='.$durl),
	'ADMIN_REZ_ORDER' => cot_selectbox($sorttype, 'sorttype', array_keys($sort_type), array_values($sort_type), false),
	'ADMIN_REZ_WAY' => cot_selectbox($sortway, 'sortway', array_keys($sort_way), array_values($sort_way), false),
	'ADMIN_REZ_FILTER' => cot_selectbox($filter, 'filter', array_keys($filter_type), array_values($filter_type), false),
	'ADMIN_REZ_TOTALDBFIRMS' => $totaldbrezume,
	'ADMIN_REZ_PAGINATION_PREV' => $pagenav['prev'],
	'ADMIN_REZ_PAGNAV' => $pagenav['main'],
	'ADMIN_REZ_PAGINATION_NEXT' => $pagenav['next'],
	'ADMIN_REZ_TOTALITEMS' => $totalitems,
	'ADMIN_REZ_ON_FIRM' => $ii
));

cot_display_messages($t);

/* === Hook  === */
foreach (cot_getextplugins('rezume.admin.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$adminmain = $t->text('MAIN');
