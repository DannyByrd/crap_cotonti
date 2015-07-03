<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin
[END_COT_EXT]
==================== */

/**
 * Vacancies manager & Queue of vacancies
 *
 * @package Cotonti
 * @version 0.7.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('vacancies', 'any');
cot_block($usr['isadmin']);

$t = new XTemplate(cot_tplfile('vacancies.admin', 'module', true));

require_once cot_incfile('vacancies', 'module');

$adminpath[] = array(cot_url('admin', 'm=extensions'), $L['Extensions']);
$adminpath[] = array(cot_url('admin', 'm=extensions&a=details&mod='.$m), $cot_modules[$m]['title']);
$adminpath[] = array(cot_url('admin', 'm='.$m), $L['Administration']);
$adminhelp = $L['adm_help_vacancies'];
$adminsubtitle = $L['Vacancies'];

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
$sqlsorttype = 'vac_'.$sorttype;

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
	$sqlwhere = "vac_state=1";
}
elseif ($filter == 'validated')
{
	$sqlwhere = "vac_state=0";
}

$catsub = cot_structure_children('vacancies', '');
if (count($catsub) < count($structure['vacancies']))
{
	$sqlwhere .= " AND vac_cat IN ('" . join("','", $catsub) . "')";
}

/* === Hook  === */
foreach (cot_getextplugins('vacancies.admin.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($a == 'validate')
{
	cot_check_xg();

	/* === Hook  === */
	foreach (cot_getextplugins('vacancies.admin.validate') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sql_vacancies = $db->query("SELECT vac_cat FROM $db_vacancies WHERE vac_id = $id AND vac_state != 0");
	if ($row = $sql_vacancies->fetch())
	{
		$usr['isadmin_local'] = cot_auth('vacancies', $row['vac_cat'], 'A');
		cot_block($usr['isadmin_local']);
		$sql_vacancies = $db->update($db_vacancies, array('vac_state' => 0), "vac_id = $id");
		$sql_vacancies = $db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code=".$db->quote($row['vac_cat']));

		cot_log($L['Adv'].' #'.$id.' - '.$L['adm_queue_validated'], 'adm');

		if ($cache)
		{
			if ($cfg['cache_vacancies'])
			{
				$cache->vacancies->clear('vacancies/' . str_replace('.', '/', $structure['vacancies'][$row['vac_cat']]['path']));
			}
			if ($cfg['cache_index'])
			{
				$cache->vacancies->clear('index');
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
	foreach (cot_getextplugins('vacancies.admin.unvalidate') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sql_vacancies = $db->query("SELECT vac_cat FROM $db_vacancies WHERE vac_id=$id");
	if ($row = $sql_vacancies->fetch())
	{
		$usr['isadmin_local'] = cot_auth('vacancies', $row['vac_cat'], 'A');
		cot_block($usr['isadmin_local']);

		$sql_vacancies = $db->update($db_vacancies, array('vac_state' => 1), "vac_id=$id");
		$sql_vacancies = $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code=".$db->quote($row['vac_cat']));

		cot_log($L['Adv'].' #'.$id.' - '.$L['adm_queue_unvalidated'], 'adm');

		if ($cache)
		{
			if ($cfg['cache_vacancies'])
			{
				$cache->vacancies->clear('vacancies/' . str_replace('.', '/', $structure['vacancies'][$row['vac_cat']]['path']));
			}
			if ($cfg['cache_index'])
			{
				$cache->vacancies->clear('index');
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
	foreach (cot_getextplugins('vacancies.admin.delete') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sql_vacancies = $db->query("SELECT * FROM $db_vacancies WHERE vac_id=$id LIMIT 1");
	if ($row = $sql_vacancies->fetch())
	{
		if ($row['vac_state'] == 0)
		{
			$sql_vacancies = $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code=".$db->quote($row['vac_cat']));
		}

		foreach($cot_extrafields[$db_vacancies] as $exfld)
		{
			cot_extrafield_unlinkfiles($row['vac_'.$exfld['field_name']], $exfld);
		}

		$sql_vacancies = $db->delete($db_vacancies, "vac_id=$id");

		cot_log($L['Adv'].' #'.$id.' - '.$L['Deleted'], 'adm');

		/* === Hook === */
		foreach (cot_getextplugins('vacancies.admin.delete.done') as $pl)
		{
			include $pl;
		}
		/* ===== */

		if ($cache)
		{
			if ($cfg['cache_vacancies'])
			{
				$cache->vacancies->clear('vacancies/' . str_replace('.', '/', $structure['vacancies'][$row['vac_cat']]['path']));
			}
			if ($cfg['cache_index'])
			{
				$cache->vacancies->clear('index');
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
				foreach (cot_getextplugins('vacancies.admin.checked_validate') as $pl)
				{
					include $pl;
				}
				/* ===== */

				$sql_vacancies = $db->query("SELECT * FROM $db_vacancies WHERE vac_id=".(int)$i);
				if ($row = $sql_vacancies->fetch())
				{
					$id = $row['vac_id'];
					$usr['isadmin_local'] = cot_auth('vacancies', $row['vac_cat'], 'A');
					cot_block($usr['isadmin_local']);

					$sql_vacancies = $db->update($db_vacancies, array('vac_state' => 0), "vac_id=$id");
					$sql_vacancies = $db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code=".$db->quote($row['vac_cat']));

					cot_log($L['Adv'].' #'.$id.' - '.$L['adm_queue_validated'], 'adm');

					if ($cache && $cfg['cache_vacancies'])
					{
						$cache->vacancies->clear('vacancies/' . str_replace('.', '/', $structure['vacancies'][$row['vac_cat']]['path']));
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
			$cache->vacancies->clear('index');
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
				foreach (cot_getextplugins('vacancies.admin.checked_delete') as $pl)
				{
					include $pl;
				}
				/* ===== */

				$sql_vacancies = $db->query("SELECT * FROM $db_vacancies WHERE vac_id=".(int)$i." LIMIT 1");
				if ($row = $sql_vacancies->fetch())
				{
					$id = $row['vac_id'];
					if ($row['vac_state'] == 0)
					{
						$sql_vacancies = $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code=".$db->quote($row['vac_cat']));
					}

					$sql_vacancies = $db->delete($db_vacancies, "vac_id=$id");

					cot_log($L['Adv'].' #'.$id.' - '.$L['Deleted'],'adm');

					if ($cache && $cfg['cache_vacancies'])
					{
						$cache->vacancies->clear('vacancies/' . str_replace('.', '/', $structure['vacancies'][$row['vac_cat']]['path']));
					}

					/* === Hook === */
					foreach (cot_getextplugins('vacancies.admin.delete.done') as $pl)
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
			$cache->vacancies->clear('index');
		}

		if (!empty($perelik))
		{
			cot_message($notfoundet.$perelik.' - '.$L['adm_queue_deleted']);
		}
	}
}

$totalitems = $db->query("SELECT COUNT(*) FROM $db_vacancies WHERE ".$sqlwhere)->fetchColumn();
$pagenav = cot_pagenav('admin', 'm=vacancies&sorttype='.$sorttype.'&sortway='.$sortway.'&filter='.$filter, $d, $totalitems, $cfg['maxrowsperpage'], 'd', '', $cfg['jquery'] && $cfg['turnajax']);

$sql_vacancies = $db->query("SELECT p.*, u.user_name
	FROM $db_vacancies as p
	LEFT JOIN $db_users AS u ON u.user_id=p.vac_ownerid
	WHERE $sqlwhere
		ORDER BY $sqlsorttype $sqlsortway
		LIMIT $d, ".$cfg['maxrowsperpage']);

$ii = 0;
/* === Hook - Part1 : Set === */
$extp = cot_getextplugins('vacancies.admin.loop');
/* ===== */
foreach ($sql_vacancies->fetchAll() as $row)
{
	$sql_vac_subcount = $db->query("SELECT SUM(structure_count) FROM $db_structure WHERE structure_path LIKE '".$db->prep($structure['vacancies'][$row["vac_cat"]]['rpath'])."%' ");
	$sub_count = $sql_vac_subcount->fetchColumn();
	$row['vac_file'] = intval($row['vac_file']);
	$t->assign(cot_generate_vactags($row, 'ADMIN_VAC_', 200));
	$t->assign(array(
		'ADMIN_VAC_ID_URL' => cot_url('vacancies', 'c='.$row['vac_cat'].'&id='.$row['vac_id']),
		'ADMIN_VAC_OWNER' => cot_build_user($row['vac_ownerid'], htmlspecialchars($row['user_name'])),
		'ADMIN_VAC_FILE_BOOL' => $row['vac_file'],
		'ADMIN_VAC_URL_FOR_VALIDATED' => cot_confirm_url(cot_url('admin', 'm=vacancies&a=validate&id='.$row['vac_id'].'&d='.$durl.'&'.cot_xg()), 'vacancies', 'vac_confirm_validate'),
		'ADMIN_VAC_URL_FOR_UNVALIDATE' => cot_confirm_url(cot_url('admin', 'm=vacancies&a=unvalidate&id='.$row['vac_id'].'&d='.$durl.'&'.cot_xg()), 'vacancies', 'vac_confirm_unvalidate'),
		'ADMIN_VAC_URL_FOR_DELETED' => cot_confirm_url(cot_url('admin', 'm=vacancies&a=delete&id='.$row['vac_id'].'&d='.$durl.'&'.cot_xg()), 'vacancies', 'vac_confirm_delete'),
		'ADMIN_VAC_URL_FOR_EDIT' => cot_url('vacancies', 'm=edit&id='.$row['vac_id']),
		'ADMIN_VAC_ODDEVEN' => cot_build_oddeven($ii),
		'ADMIN_VAC_CAT_COUNT' => $sub_count
	));
	$t->assign(cot_generate_usertags($row['vac_ownerid'], 'ADMIN_VAC_OWNER_'), htmlspecialchars($row['user_name']));

	/* === Hook - Part2 : Include === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse('MAIN.VAC_ROW');
	$ii++;
}

$is_row_empty = ($sql_vacancies->rowCount() == 0) ? true : false ;

$totaldbvacancies = $db->countRows($db_vacancies);
$sql_vac_queued = $db->query("SELECT COUNT(*) FROM $db_vacancies WHERE vac_state=1");
$sys['vacanciesqueued'] = $sql_vac_queued->fetchColumn();

$t->assign(array(
	'ADMIN_VAC_URL_CONFIG' => cot_url('admin', 'm=config&n=edit&o=module&p=vacancies'),
	'ADMIN_VAC_URL_ADD' => cot_url('vacancies', 'm=add'),
	'ADMIN_VAC_URL_EXTRAFIELDS' => cot_url('admin', 'm=extrafields&n='.$db_vacancies),
	'ADMIN_VAC_URL_STRUCTURE' => cot_url('admin', 'm=structure&n=vacancies'),
	'ADMIN_VAC_FORM_URL' => cot_url('admin', 'm=vacancies&a=update_checked&sorttype='.$sorttype.'&sortway='.$sortway.'&filter='.$filter.'&d='.$durl),
	'ADMIN_VAC_ORDER' => cot_selectbox($sorttype, 'sorttype', array_keys($sort_type), array_values($sort_type), false),
	'ADMIN_VAC_WAY' => cot_selectbox($sortway, 'sortway', array_keys($sort_way), array_values($sort_way), false),
	'ADMIN_VAC_FILTER' => cot_selectbox($filter, 'filter', array_keys($filter_type), array_values($filter_type), false),
	'ADMIN_VAC_TOTALDBFIRMS' => $totaldbvacancies,
	'ADMIN_VAC_PAGINATION_PREV' => $pagenav['prev'],
	'ADMIN_VAC_PAGNAV' => $pagenav['main'],
	'ADMIN_VAC_PAGINATION_NEXT' => $pagenav['next'],
	'ADMIN_VAC_TOTALITEMS' => $totalitems,
	'ADMIN_VAC_ON_FIRM' => $ii
));

cot_display_messages($t);

/* === Hook  === */
foreach (cot_getextplugins('vacancies.admin.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$adminmain = $t->text('MAIN');
