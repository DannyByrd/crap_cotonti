<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin
[END_COT_EXT]
==================== */

/**
 * Firms manager & Queue of firms
 *
 * @package Cotonti
 * @version 0.7.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('firms', 'any');
cot_block($usr['isadmin']);

$t = new XTemplate(cot_tplfile('firms.admin', 'module', true));

require_once cot_incfile('firms', 'module');

$adminpath[] = array(cot_url('admin', 'm=extensions'), $L['Extensions']);
$adminpath[] = array(cot_url('admin', 'm=extensions&a=details&mod='.$m), $cot_modules[$m]['title']);
$adminpath[] = array(cot_url('admin', 'm='.$m), $L['Administration']);
$adminhelp = $L['adm_help_firms'];
$adminsubtitle = $L['Firms'];

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
$sqlsorttype = 'firm_'.$sorttype;

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
	$sqlwhere = "firm_state=1";
}
elseif ($filter == 'validated')
{
	$sqlwhere = "firm_state=0";
}

$catsub = cot_structure_children('firms', '');
if (count($catsub) < count($structure['firms']))
{
	$sqlwhere .= " AND firm_cat IN ('" . join("','", $catsub) . "')";
}

/* === Hook  === */
foreach (cot_getextplugins('firms.admin.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($a == 'validate')
{
	cot_check_xg();

	/* === Hook  === */
	foreach (cot_getextplugins('firms.admin.validate') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sql_firms = $db->query("SELECT firm_cat FROM $db_firms WHERE firm_id = $id AND firm_state != 0");
	if ($row = $sql_firms->fetch())
	{
		$usr['isadmin_local'] = cot_auth('firms', $row['firm_cat'], 'A');
		cot_block($usr['isadmin_local']);
		$sql_firms = $db->update($db_firms, array('firm_state' => 0), "firm_id = $id");
		$sql_firms = $db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code=".$db->quote($row['firm_cat']));

		cot_log($L['Firm'].' #'.$id.' - '.$L['adm_queue_validated'], 'adm');

		if ($cache)
		{
			if ($cfg['cache_firms'])
			{
				$cache->firms->clear('firms/' . str_replace('.', '/', $structure['firms'][$row['firm_cat']]['path']));
			}
			if ($cfg['cache_index'])
			{
				$cache->firms->clear('index');
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
	foreach (cot_getextplugins('firms.admin.unvalidate') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sql_firms = $db->query("SELECT firm_cat FROM $db_firms WHERE firm_id=$id");
	if ($row = $sql_firms->fetch())
	{
		$usr['isadmin_local'] = cot_auth('firms', $row['firm_cat'], 'A');
		cot_block($usr['isadmin_local']);

		$sql_firms = $db->update($db_firms, array('firm_state' => 1), "firm_id=$id");
		$sql_firms = $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code=".$db->quote($row['firm_cat']));

		cot_log($L['Firm'].' #'.$id.' - '.$L['adm_queue_unvalidated'], 'adm');

		if ($cache)
		{
			if ($cfg['cache_firms'])
			{
				$cache->firms->clear('firms/' . str_replace('.', '/', $structure['firms'][$row['firm_cat']]['path']));
			}
			if ($cfg['cache_index'])
			{
				$cache->firms->clear('index');
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
	foreach (cot_getextplugins('firms.admin.delete') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sql_firms = $db->query("SELECT * FROM $db_firms WHERE firm_id=$id LIMIT 1");
	if ($row = $sql_firms->fetch())
	{
		if ($row['firm_state'] == 0)
		{
			$sql_firms = $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code=".$db->quote($row['firm_cat']));
		}

		foreach($cot_extrafields[$db_firms] as $exfld)
		{
			cot_extrafield_unlinkfiles($row['firm_'.$exfld['field_name']], $exfld);
		}

		$sql_firms = $db->delete($db_firms, "firm_id=$id");

		cot_log($L['Firm'].' #'.$id.' - '.$L['Deleted'], 'adm');

		/* === Hook === */
		foreach (cot_getextplugins('firms.admin.delete.done') as $pl)
		{
			include $pl;
		}
		/* ===== */

		if ($cache)
		{
			if ($cfg['cache_firms'])
			{
				$cache->firms->clear('firms/' . str_replace('.', '/', $structure['firms'][$row['firm_cat']]['path']));
			}
			if ($cfg['cache_index'])
			{
				$cache->firms->clear('index');
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
				foreach (cot_getextplugins('firms.admin.checked_validate') as $pl)
				{
					include $pl;
				}
				/* ===== */

				$sql_firms = $db->query("SELECT * FROM $db_firms WHERE firm_id=".(int)$i);
				if ($row = $sql_firms->fetch())
				{
					$id = $row['firm_id'];
					$usr['isadmin_local'] = cot_auth('firms', $row['firm_cat'], 'A');
					cot_block($usr['isadmin_local']);

					$sql_firms = $db->update($db_firms, array('firm_state' => 0), "firm_id=$id");
					$sql_firms = $db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code=".$db->quote($row['firm_cat']));

					cot_log($L['Firm'].' #'.$id.' - '.$L['adm_queue_validated'], 'adm');

					if ($cache && $cfg['cache_firms'])
					{
						$cache->firms->clear('firms/' . str_replace('.', '/', $structure['firms'][$row['firm_cat']]['path']));
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
			$cache->firms->clear('index');
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
				foreach (cot_getextplugins('firms.admin.checked_delete') as $pl)
				{
					include $pl;
				}
				/* ===== */

				$sql_firms = $db->query("SELECT * FROM $db_firms WHERE firm_id=".(int)$i." LIMIT 1");
				if ($row = $sql_firms->fetch())
				{
					$id = $row['firm_id'];
					if ($row['firm_state'] == 0)
					{
						$sql_firms = $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code=".$db->quote($row['firm_cat']));
					}

					$sql_firms = $db->delete($db_firms, "firm_id=$id");

					cot_log($L['Firm'].' #'.$id.' - '.$L['Deleted'],'adm');

					if ($cache && $cfg['cache_firms'])
					{
						$cache->firms->clear('firms/' . str_replace('.', '/', $structure['firms'][$row['firm_cat']]['path']));
					}

					/* === Hook === */
					foreach (cot_getextplugins('firms.admin.delete.done') as $pl)
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
			$cache->firms->clear('index');
		}

		if (!empty($perelik))
		{
			cot_message($notfoundet.$perelik.' - '.$L['adm_queue_deleted']);
		}
	}
}

$totalitems = $db->query("SELECT COUNT(*) FROM $db_firms WHERE ".$sqlwhere)->fetchColumn();
$pagenav = cot_pagenav('admin', 'm=firms&sorttype='.$sorttype.'&sortway='.$sortway.'&filter='.$filter, $d, $totalitems, $cfg['maxrowsperpage'], 'd', '', $cfg['jquery'] && $cfg['turnajax']);

$sql_firms = $db->query("SELECT p.*, u.user_name
	FROM $db_firms as p
	LEFT JOIN $db_users AS u ON u.user_id=p.firm_ownerid
	WHERE $sqlwhere
		ORDER BY $sqlsorttype $sqlsortway
		LIMIT $d, ".$cfg['maxrowsperpage']);

$ii = 0;
/* === Hook - Part1 : Set === */
$extp = cot_getextplugins('firms.admin.loop');
/* ===== */
foreach ($sql_firms->fetchAll() as $row)
{
	$sql_firm_subcount = $db->query("SELECT SUM(structure_count) FROM $db_structure WHERE structure_path LIKE '".$db->prep($structure['firms'][$row["firm_cat"]]['rpath'])."%' ");
	$sub_count = $sql_firm_subcount->fetchColumn();
	$row['firm_file'] = intval($row['firm_file']);
	$t->assign(cot_generate_firmtags($row, 'ADMIN_FIRM_', 200));
	$t->assign(array(
		'ADMIN_FIRM_ID_URL' => cot_url('firms', 'c='.$row['firm_cat'].'&id='.$row['firm_id']),
		'ADMIN_FIRM_OWNER' => cot_build_user($row['firm_ownerid'], htmlspecialchars($row['user_name'])),
		'ADMIN_FIRM_FILE_BOOL' => $row['firm_file'],
		'ADMIN_FIRM_URL_FOR_VALIDATED' => cot_confirm_url(cot_url('admin', 'm=firms&a=validate&id='.$row['firm_id'].'&d='.$durl.'&'.cot_xg()), 'firms', 'firm_confirm_validate'),
		'ADMIN_FIRM_URL_FOR_UNVALIDATE' => cot_confirm_url(cot_url('admin', 'm=firms&a=unvalidate&id='.$row['firm_id'].'&d='.$durl.'&'.cot_xg()), 'firms', 'firm_confirm_unvalidate'),
		'ADMIN_FIRM_URL_FOR_DELETED' => cot_confirm_url(cot_url('admin', 'm=firms&a=delete&id='.$row['firm_id'].'&d='.$durl.'&'.cot_xg()), 'firms', 'firm_confirm_delete'),
		'ADMIN_FIRM_URL_FOR_EDIT' => cot_url('firms', 'm=edit&id='.$row['firm_id']),
		'ADMIN_FIRM_ODDEVEN' => cot_build_oddeven($ii),
		'ADMIN_FIRM_CAT_COUNT' => $sub_count
	));
	$t->assign(cot_generate_usertags($row['firm_ownerid'], 'ADMIN_FIRM_OWNER_'), htmlspecialchars($row['user_name']));

	/* === Hook - Part2 : Include === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse('MAIN.FIRM_ROW');
	$ii++;
}

$is_row_empty = ($sql_firms->rowCount() == 0) ? true : false ;

$totaldbfirms = $db->countRows($db_firms);
$sql_firm_queued = $db->query("SELECT COUNT(*) FROM $db_firms WHERE firm_state=1");
$sys['firmsqueued'] = $sql_firm_queued->fetchColumn();

$t->assign(array(
	'ADMIN_FIRM_URL_CONFIG' => cot_url('admin', 'm=config&n=edit&o=module&p=firms'),
	'ADMIN_FIRM_URL_ADD' => cot_url('firms', 'm=add'),
	'ADMIN_FIRM_URL_EXTRAFIELDS' => cot_url('admin', 'm=extrafields&n='.$db_firms),
	'ADMIN_FIRM_URL_STRUCTURE' => cot_url('admin', 'm=structure&n=firms'),
	'ADMIN_FIRM_FORM_URL' => cot_url('admin', 'm=firms&a=update_checked&sorttype='.$sorttype.'&sortway='.$sortway.'&filter='.$filter.'&d='.$durl),
	'ADMIN_FIRM_ORDER' => cot_selectbox($sorttype, 'sorttype', array_keys($sort_type), array_values($sort_type), false),
	'ADMIN_FIRM_WAY' => cot_selectbox($sortway, 'sortway', array_keys($sort_way), array_values($sort_way), false),
	'ADMIN_FIRM_FILTER' => cot_selectbox($filter, 'filter', array_keys($filter_type), array_values($filter_type), false),
	'ADMIN_FIRM_TOTALDBFIRMS' => $totaldbfirms,
	'ADMIN_FIRM_PAGINATION_PREV' => $pagenav['prev'],
	'ADMIN_FIRM_PAGNAV' => $pagenav['main'],
	'ADMIN_FIRM_PAGINATION_NEXT' => $pagenav['next'],
	'ADMIN_FIRM_TOTALITEMS' => $totalitems,
	'ADMIN_FIRM_ON_FIRM' => $ii
));

cot_display_messages($t);

/* === Hook  === */
foreach (cot_getextplugins('firms.admin.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$adminmain = $t->text('MAIN');
