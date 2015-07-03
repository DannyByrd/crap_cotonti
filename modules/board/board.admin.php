<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin
[END_COT_EXT]
==================== */

/**
 * Board manager & Queue of board
 *
 * @package Cotonti
 * @version 0.7.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('board', 'any');
cot_block($usr['isadmin']);

$t = new XTemplate(cot_tplfile('board.admin', 'module', true));

require_once cot_incfile('board', 'module');

$adminpath[] = array(cot_url('admin', 'm=extensions'), $L['Extensions']);
$adminpath[] = array(cot_url('admin', 'm=extensions&a=details&mod='.$m), $cot_modules[$m]['title']);
$adminpath[] = array(cot_url('admin', 'm='.$m), $L['Administration']);
$adminhelp = $L['adm_help_board'];
$adminsubtitle = $L['Board'];

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
$sqlsorttype = 'adv_'.$sorttype;

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
	$sqlwhere = "adv_state=1";
}
elseif ($filter == 'validated')
{
	$sqlwhere = "adv_state=0";
}
elseif ($filter == 'expired')
{
	$sqlwhere = "adv_expire <> 0 AND adv_expire < {$sys['now']}";
}

$catsub = cot_structure_children('board', '');
if (count($catsub) < count($structure['board']))
{
	$sqlwhere .= " AND adv_cat IN ('" . join("','", $catsub) . "')";
}

/* === Hook  === */
foreach (cot_getextplugins('board.admin.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($a == 'validate')
{
	cot_check_xg();

	/* === Hook  === */
	foreach (cot_getextplugins('board.admin.validate') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sql_board = $db->query("SELECT adv_cat FROM $db_board WHERE adv_id = $id AND adv_state != 0");
	if ($row = $sql_board->fetch())
	{
		$usr['isadmin_local'] = cot_auth('board', $row['adv_cat'], 'A');
		cot_block($usr['isadmin_local']);
		$sql_board = $db->update($db_board, array('adv_state' => 0), "adv_id = $id");
		$sql_board = $db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code=".$db->quote($row['adv_cat']));

		cot_log($L['Adv'].' #'.$id.' - '.$L['adm_queue_validated'], 'adm');

		if ($cache)
		{
			if ($cfg['cache_board'])
			{
				$cache->board->clear('board/' . str_replace('.', '/', $structure['board'][$row['adv_cat']]['path']));
			}
			if ($cfg['cache_index'])
			{
				$cache->board->clear('index');
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
	foreach (cot_getextplugins('board.admin.unvalidate') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sql_board = $db->query("SELECT adv_cat FROM $db_board WHERE adv_id=$id");
	if ($row = $sql_board->fetch())
	{
		$usr['isadmin_local'] = cot_auth('board', $row['adv_cat'], 'A');
		cot_block($usr['isadmin_local']);

		$sql_board = $db->update($db_board, array('adv_state' => 1), "adv_id=$id");
		$sql_board = $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code=".$db->quote($row['adv_cat']));

		cot_log($L['Adv'].' #'.$id.' - '.$L['adm_queue_unvalidated'], 'adm');

		if ($cache)
		{
			if ($cfg['cache_board'])
			{
				$cache->board->clear('board/' . str_replace('.', '/', $structure['board'][$row['adv_cat']]['path']));
			}
			if ($cfg['cache_index'])
			{
				$cache->board->clear('index');
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
	foreach (cot_getextplugins('board.admin.delete') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sql_board = $db->query("SELECT * FROM $db_board WHERE adv_id=$id LIMIT 1");
	if ($row = $sql_board->fetch())
	{
		if ($row['adv_state'] == 0)
		{
			$sql_board = $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code=".$db->quote($row['adv_cat']));
		}

		foreach($cot_extrafields[$db_board] as $exfld)
		{
			cot_extrafield_unlinkfiles($row['adv_'.$exfld['field_name']], $exfld);
		}

		$sql_board = $db->delete($db_board, "adv_id=$id");

		cot_log($L['Adv'].' #'.$id.' - '.$L['Deleted'], 'adm');

		/* === Hook === */
		foreach (cot_getextplugins('board.admin.delete.done') as $pl)
		{
			include $pl;
		}
		/* ===== */

		if ($cache)
		{
			if ($cfg['cache_board'])
			{
				$cache->board->clear('board/' . str_replace('.', '/', $structure['board'][$row['adv_cat']]['path']));
			}
			if ($cfg['cache_index'])
			{
				$cache->board->clear('index');
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
				foreach (cot_getextplugins('board.admin.checked_validate') as $pl)
				{
					include $pl;
				}
				/* ===== */

				$sql_board = $db->query("SELECT * FROM $db_board WHERE adv_id=".(int)$i);
				if ($row = $sql_board->fetch())
				{
					$id = $row['adv_id'];
					$usr['isadmin_local'] = cot_auth('board', $row['adv_cat'], 'A');
					cot_block($usr['isadmin_local']);

					$sql_board = $db->update($db_board, array('adv_state' => 0), "adv_id=$id");
					$sql_board = $db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code=".$db->quote($row['adv_cat']));

					cot_log($L['Adv'].' #'.$id.' - '.$L['adm_queue_validated'], 'adm');

					if ($cache && $cfg['cache_board'])
					{
						$cache->board->clear('board/' . str_replace('.', '/', $structure['board'][$row['adv_cat']]['path']));
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
			$cache->board->clear('index');
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
				foreach (cot_getextplugins('board.admin.checked_delete') as $pl)
				{
					include $pl;
				}
				/* ===== */

				$sql_board = $db->query("SELECT * FROM $db_board WHERE adv_id=".(int)$i." LIMIT 1");
				if ($row = $sql_board->fetch())
				{
					$id = $row['adv_id'];
					if ($row['adv_state'] == 0)
					{
						$sql_board = $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code=".$db->quote($row['adv_cat']));
					}

					$sql_board = $db->delete($db_board, "adv_id=$id");

					cot_log($L['Adv'].' #'.$id.' - '.$L['Deleted'],'adm');

					if ($cache && $cfg['cache_board'])
					{
						$cache->board->clear('board/' . str_replace('.', '/', $structure['board'][$row['adv_cat']]['path']));
					}

					/* === Hook === */
					foreach (cot_getextplugins('board.admin.delete.done') as $pl)
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
			$cache->board->clear('index');
		}

		if (!empty($perelik))
		{
			cot_message($notfoundet.$perelik.' - '.$L['adm_queue_deleted']);
		}
	}
}

$totalitems = $db->query("SELECT COUNT(*) FROM $db_board WHERE ".$sqlwhere)->fetchColumn();
$pagenav = cot_pagenav('admin', 'm=board&sorttype='.$sorttype.'&sortway='.$sortway.'&filter='.$filter, $d, $totalitems, $cfg['maxrowsperpage'], 'd', '', $cfg['jquery'] && $cfg['turnajax']);

$sql_board = $db->query("SELECT p.*, u.user_name
	FROM $db_board as p
	LEFT JOIN $db_users AS u ON u.user_id=p.adv_ownerid
	WHERE $sqlwhere
		ORDER BY $sqlsorttype $sqlsortway
		LIMIT $d, ".$cfg['maxrowsperpage']);

$ii = 0;
/* === Hook - Part1 : Set === */
$extp = cot_getextplugins('board.admin.loop');
/* ===== */
foreach ($sql_board->fetchAll() as $row)
{
	$sql_adv_subcount = $db->query("SELECT SUM(structure_count) FROM $db_structure WHERE structure_path LIKE '".$db->prep($structure['board'][$row["adv_cat"]]['rpath'])."%' ");
	$sub_count = $sql_adv_subcount->fetchColumn();
	$row['adv_file'] = intval($row['adv_file']);
	$t->assign(cot_generate_advtags($row, 'ADMIN_ADV_', 200));
	$t->assign(array(
		'ADMIN_ADV_ID_URL' => cot_url('board', 'c='.$row['adv_cat'].'&id='.$row['adv_id']),
		'ADMIN_ADV_OWNER' => cot_build_user($row['adv_ownerid'], htmlspecialchars($row['user_name'])),
		'ADMIN_ADV_FILE_BOOL' => $row['adv_file'],
		'ADMIN_ADV_URL_FOR_VALIDATED' => cot_confirm_url(cot_url('admin', 'm=board&a=validate&id='.$row['adv_id'].'&d='.$durl.'&'.cot_xg()), 'board', 'adv_confirm_validate'),
		'ADMIN_ADV_URL_FOR_UNVALIDATE' => cot_confirm_url(cot_url('admin', 'm=board&a=unvalidate&id='.$row['adv_id'].'&d='.$durl.'&'.cot_xg()), 'board', 'adv_confirm_unvalidate'),
		'ADMIN_ADV_URL_FOR_DELETED' => cot_confirm_url(cot_url('admin', 'm=board&a=delete&id='.$row['adv_id'].'&d='.$durl.'&'.cot_xg()), 'board', 'adv_confirm_delete'),
		'ADMIN_ADV_URL_FOR_EDIT' => cot_url('board', 'm=edit&id='.$row['adv_id']),
		'ADMIN_ADV_ODDEVEN' => cot_build_oddeven($ii),
		'ADMIN_ADV_CAT_COUNT' => $sub_count
	));
	$t->assign(cot_generate_usertags($row['adv_ownerid'], 'ADMIN_ADV_OWNER_'), htmlspecialchars($row['user_name']));

	/* === Hook - Part2 : Include === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse('MAIN.ADV_ROW');
	$ii++;
}

$is_row_empty = ($sql_board->rowCount() == 0) ? true : false ;

$totaldbboard = $db->countRows($db_board);
$sql_adv_queued = $db->query("SELECT COUNT(*) FROM $db_board WHERE adv_state=1");
$sys['boardqueued'] = $sql_adv_queued->fetchColumn();

$t->assign(array(
	'ADMIN_ADV_URL_CONFIG' => cot_url('admin', 'm=config&n=edit&o=module&p=board'),
	'ADMIN_ADV_URL_ADD' => cot_url('board', 'm=add'),
	'ADMIN_ADV_URL_EXTRAFIELDS' => cot_url('admin', 'm=extrafields&n='.$db_board),
	'ADMIN_ADV_URL_STRUCTURE' => cot_url('admin', 'm=structure&n=board'),
	'ADMIN_ADV_FORM_URL' => cot_url('admin', 'm=board&a=update_checked&sorttype='.$sorttype.'&sortway='.$sortway.'&filter='.$filter.'&d='.$durl),
	'ADMIN_ADV_ORDER' => cot_selectbox($sorttype, 'sorttype', array_keys($sort_type), array_values($sort_type), false),
	'ADMIN_ADV_WAY' => cot_selectbox($sortway, 'sortway', array_keys($sort_way), array_values($sort_way), false),
	'ADMIN_ADV_FILTER' => cot_selectbox($filter, 'filter', array_keys($filter_type), array_values($filter_type), false),
	'ADMIN_ADV_TOTALDBFIRMS' => $totaldbboard,
	'ADMIN_ADV_PAGINATION_PREV' => $pagenav['prev'],
	'ADMIN_ADV_PAGNAV' => $pagenav['main'],
	'ADMIN_ADV_PAGINATION_NEXT' => $pagenav['next'],
	'ADMIN_ADV_TOTALITEMS' => $totalitems,
	'ADMIN_ADV_ON_FIRM' => $ii
));

cot_display_messages($t);

/* === Hook  === */
foreach (cot_getextplugins('board.admin.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$adminmain = $t->text('MAIN');
