<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin
[END_COT_EXT]
==================== */

/**
 * Afisha manager & Queue of afisha
 *
 * @package Cotonti
 * @version 0.7.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('afisha', 'any');
cot_block($usr['isadmin']);

$t = new XTemplate(cot_tplfile('afisha.admin', 'module', true));

require_once cot_incfile('afisha', 'module');

$adminpath[] = array(cot_url('admin', 'm=extensions'), $L['Extensions']);
$adminpath[] = array(cot_url('admin', 'm=extensions&a=details&mod='.$m), $cot_modules[$m]['title']);
$adminpath[] = array(cot_url('admin', 'm='.$m), $L['Administration']);
$adminhelp = $L['adm_help_afisha'];
$adminsubtitle = $L['Afisha'];

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
	'expire' => $L['Expire'],
	'rating' => $L['Rating'],
	'count' => $L['Hits']
);
$sqlsorttype = 'event_'.$sorttype;

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
	'expired' => $L['adm_expired'],
);
if ($filter == 'all')
{
	$sqlwhere = "1 ";
}
elseif ($filter == 'valqueue')
{
	$sqlwhere = "event_state=1";
}
elseif ($filter == 'validated')
{
	$sqlwhere = "event_state=0";
}
elseif ($filter == 'expired')
{
	$sqlwhere = "event_expire <> 0 AND event_expire < {$sys['now']}";
}

$catsub = cot_structure_children('afisha', '');
if (count($catsub) < count($structure['afisha']))
{
	$sqlwhere .= " AND event_cat IN ('" . join("','", $catsub) . "')";
}

/* === Hook  === */
foreach (cot_getextplugins('afisha.admin.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($a == 'validate')
{
	cot_check_xg();

	/* === Hook  === */
	foreach (cot_getextplugins('afisha.admin.validate') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sql_afisha = $db->query("SELECT event_cat FROM $db_afisha WHERE event_id = $id AND event_state != 0");
	if ($row = $sql_afisha->fetch())
	{
		$usr['isadmin_local'] = cot_auth('afisha', $row['event_cat'], 'A');
		cot_block($usr['isadmin_local']);
		$sql_afisha = $db->update($db_afisha, array('event_state' => 0), "event_id = $id");
		$sql_afisha = $db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code=".$db->quote($row['event_cat']));

		cot_log($L['Adv'].' #'.$id.' - '.$L['adm_queue_validated'], 'adm');

		if ($cache)
		{
			if ($cfg['cache_afisha'])
			{
				$cache->afisha->clear('afisha/' . str_replace('.', '/', $structure['afisha'][$row['event_cat']]['path']));
			}
			if ($cfg['cache_index'])
			{
				$cache->afisha->clear('index');
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
	foreach (cot_getextplugins('afisha.admin.unvalidate') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sql_afisha = $db->query("SELECT event_cat FROM $db_afisha WHERE event_id=$id");
	if ($row = $sql_afisha->fetch())
	{
		$usr['isadmin_local'] = cot_auth('afisha', $row['event_cat'], 'A');
		cot_block($usr['isadmin_local']);

		$sql_afisha = $db->update($db_afisha, array('event_state' => 1), "event_id=$id");
		$sql_afisha = $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code=".$db->quote($row['event_cat']));

		cot_log($L['Adv'].' #'.$id.' - '.$L['adm_queue_unvalidated'], 'adm');

		if ($cache)
		{
			if ($cfg['cache_afisha'])
			{
				$cache->afisha->clear('afisha/' . str_replace('.', '/', $structure['afisha'][$row['event_cat']]['path']));
			}
			if ($cfg['cache_index'])
			{
				$cache->afisha->clear('index');
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
	foreach (cot_getextplugins('afisha.admin.delete') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sql_afisha = $db->query("SELECT * FROM $db_afisha WHERE event_id=$id LIMIT 1");
	if ($row = $sql_afisha->fetch())
	{
		if ($row['event_state'] == 0)
		{
			$sql_afisha = $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code=".$db->quote($row['event_cat']));
		}

		foreach($cot_extrafields[$db_afisha] as $exfld)
		{
			cot_extrafield_unlinkfiles($row['event_'.$exfld['field_name']], $exfld);
		}

		$sql_afisha = $db->delete($db_afisha, "event_id=$id");

		cot_log($L['Adv'].' #'.$id.' - '.$L['Deleted'], 'adm');

		/* === Hook === */
		foreach (cot_getextplugins('afisha.admin.delete.done') as $pl)
		{
			include $pl;
		}
		/* ===== */

		if ($cache)
		{
			if ($cfg['cache_afisha'])
			{
				$cache->afisha->clear('afisha/' . str_replace('.', '/', $structure['afisha'][$row['event_cat']]['path']));
			}
			if ($cfg['cache_index'])
			{
				$cache->afisha->clear('index');
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
				foreach (cot_getextplugins('afisha.admin.checked_validate') as $pl)
				{
					include $pl;
				}
				/* ===== */

				$sql_afisha = $db->query("SELECT * FROM $db_afisha WHERE event_id=".(int)$i);
				if ($row = $sql_afisha->fetch())
				{
					$id = $row['event_id'];
					$usr['isadmin_local'] = cot_auth('afisha', $row['event_cat'], 'A');
					cot_block($usr['isadmin_local']);

					$sql_afisha = $db->update($db_afisha, array('event_state' => 0), "event_id=$id");
					$sql_afisha = $db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code=".$db->quote($row['event_cat']));

					cot_log($L['Adv'].' #'.$id.' - '.$L['adm_queue_validated'], 'adm');

					if ($cache && $cfg['cache_afisha'])
					{
						$cache->afisha->clear('afisha/' . str_replace('.', '/', $structure['afisha'][$row['event_cat']]['path']));
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
			$cache->afisha->clear('index');
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
				foreach (cot_getextplugins('afisha.admin.checked_delete') as $pl)
				{
					include $pl;
				}
				/* ===== */

				$sql_afisha = $db->query("SELECT * FROM $db_afisha WHERE event_id=".(int)$i." LIMIT 1");
				if ($row = $sql_afisha->fetch())
				{
					$id = $row['event_id'];
					if ($row['event_state'] == 0)
					{
						$sql_afisha = $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code=".$db->quote($row['event_cat']));
					}

					$sql_afisha = $db->delete($db_afisha, "event_id=$id");

					cot_log($L['Adv'].' #'.$id.' - '.$L['Deleted'],'adm');

					if ($cache && $cfg['cache_afisha'])
					{
						$cache->afisha->clear('afisha/' . str_replace('.', '/', $structure['afisha'][$row['event_cat']]['path']));
					}

					/* === Hook === */
					foreach (cot_getextplugins('afisha.admin.delete.done') as $pl)
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
			$cache->afisha->clear('index');
		}

		if (!empty($perelik))
		{
			cot_message($notfoundet.$perelik.' - '.$L['adm_queue_deleted']);
		}
	}
}

$totalitems = $db->query("SELECT COUNT(*) FROM $db_afisha WHERE ".$sqlwhere)->fetchColumn();
$pagenav = cot_pagenav('admin', 'm=afisha&sorttype='.$sorttype.'&sortway='.$sortway.'&filter='.$filter, $d, $totalitems, $cfg['maxrowsperpage'], 'd', '', $cfg['jquery'] && $cfg['turnajax']);

$sql_afisha = $db->query("SELECT p.*, u.user_name
	FROM $db_afisha as p
	LEFT JOIN $db_users AS u ON u.user_id=p.event_ownerid
	WHERE $sqlwhere
		ORDER BY $sqlsorttype $sqlsortway
		LIMIT $d, ".$cfg['maxrowsperpage']);

$ii = 0;
/* === Hook - Part1 : Set === */
$extp = cot_getextplugins('afisha.admin.loop');
/* ===== */
foreach ($sql_afisha->fetchAll() as $row)
{
	$sql_event_subcount = $db->query("SELECT SUM(structure_count) FROM $db_structure WHERE structure_path LIKE '".$db->prep($structure['afisha'][$row["event_cat"]]['rpath'])."%' ");
	$sub_count = $sql_event_subcount->fetchColumn();
	$row['event_file'] = intval($row['event_file']);
	$t->assign(cot_generate_eventtags($row, 'ADMIN_ADV_', 200));
	$t->assign(array(
		'ADMIN_ADV_ID_URL' => cot_url('afisha', 'c='.$row['event_cat'].'&id='.$row['event_id']),
		'ADMIN_ADV_OWNER' => cot_build_user($row['event_ownerid'], htmlspecialchars($row['user_name'])),
		'ADMIN_ADV_FILE_BOOL' => $row['event_file'],
		'ADMIN_ADV_URL_FOR_VALIDATED' => cot_confirm_url(cot_url('admin', 'm=afisha&a=validate&id='.$row['event_id'].'&d='.$durl.'&'.cot_xg()), 'afisha', 'event_confirm_validate'),
		'ADMIN_ADV_URL_FOR_UNVALIDATE' => cot_confirm_url(cot_url('admin', 'm=afisha&a=unvalidate&id='.$row['event_id'].'&d='.$durl.'&'.cot_xg()), 'afisha', 'event_confirm_unvalidate'),
		'ADMIN_ADV_URL_FOR_DELETED' => cot_confirm_url(cot_url('admin', 'm=afisha&a=delete&id='.$row['event_id'].'&d='.$durl.'&'.cot_xg()), 'afisha', 'event_confirm_delete'),
		'ADMIN_ADV_URL_FOR_EDIT' => cot_url('afisha', 'm=edit&id='.$row['event_id']),
		'ADMIN_ADV_ODDEVEN' => cot_build_oddeven($ii),
		'ADMIN_ADV_CAT_COUNT' => $sub_count
	));
	$t->assign(cot_generate_usertags($row['event_ownerid'], 'ADMIN_ADV_OWNER_'), htmlspecialchars($row['user_name']));

	/* === Hook - Part2 : Include === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse('MAIN.ADV_ROW');
	$ii++;
}

$is_row_empty = ($sql_afisha->rowCount() == 0) ? true : false ;

$totaldbafisha = $db->countRows($db_afisha);
$sql_event_queued = $db->query("SELECT COUNT(*) FROM $db_afisha WHERE event_state=1");
$sys['afishaqueued'] = $sql_event_queued->fetchColumn();

$t->assign(array(
	'ADMIN_ADV_URL_CONFIG' => cot_url('admin', 'm=config&n=edit&o=module&p=afisha'),
	'ADMIN_ADV_URL_ADD' => cot_url('afisha', 'm=add'),
	'ADMIN_ADV_URL_EXTRAFIELDS' => cot_url('admin', 'm=extrafields&n='.$db_afisha),
	'ADMIN_ADV_URL_STRUCTURE' => cot_url('admin', 'm=structure&n=afisha'),
	'ADMIN_ADV_FORM_URL' => cot_url('admin', 'm=afisha&a=update_checked&sorttype='.$sorttype.'&sortway='.$sortway.'&filter='.$filter.'&d='.$durl),
	'ADMIN_ADV_ORDER' => cot_selectbox($sorttype, 'sorttype', array_keys($sort_type), array_values($sort_type), false),
	'ADMIN_ADV_WAY' => cot_selectbox($sortway, 'sortway', array_keys($sort_way), array_values($sort_way), false),
	'ADMIN_ADV_FILTER' => cot_selectbox($filter, 'filter', array_keys($filter_type), array_values($filter_type), false),
	'ADMIN_ADV_TOTALDBFIRMS' => $totaldbafisha,
	'ADMIN_ADV_PAGINATION_PREV' => $pagenav['prev'],
	'ADMIN_ADV_PAGNAV' => $pagenav['main'],
	'ADMIN_ADV_PAGINATION_NEXT' => $pagenav['next'],
	'ADMIN_ADV_TOTALITEMS' => $totalitems,
	'ADMIN_ADV_ON_FIRM' => $ii
));

cot_display_messages($t);

/* === Hook  === */
foreach (cot_getextplugins('afisha.admin.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$adminmain = $t->text('MAIN');
