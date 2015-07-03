<?php
/**
 * YML for vacancies.
 *
 * @package vacancies
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');


list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('vacancies', 'any');

ob_clean();
header('Content-type: text/xml; charset=UTF-8');

/* === Hook === */
foreach (cot_getextplugins('vacancies.xml.first') as $pl)
{
	include $pl;
}
/* ===== */
cot_block($usr['auth_read']);

$mskin = cot_tplfile(array('vacancies', 'xml'));

/* === Hook === */
foreach (cot_getextplugins('vacancies.xml.main') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

$where = array();
$params = array();

$where['state'] = "vac_state=0";

/* === Hook === */
foreach (cot_getextplugins('vacancies.xml.query') as $pl)
{
	include $pl;
}
/* ===== */

if(empty($sql_vac_string))
{
	$where = array_filter($where);
	$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
	$sql_vac_count = "SELECT COUNT(*) FROM $db_vacancies as p $join_condition $where";
	$sql_vac_string = "SELECT p.*, u.* $join_columns
		FROM $db_vacancies as p $join_condition
		LEFT JOIN $db_users AS u ON u.user_id=p.vac_ownerid
		$where
		ORDER BY vac_date DESC";
}
$totallines = $db->query($sql_vac_count, $params)->fetchColumn();
$sqllist = $db->query($sql_vac_string, $params);

/* === Hook - Part1 : Set === */
$extp = cot_getextplugins('vacancies.xml.loop');
/* ===== */
$sqllist_rowset = $sqllist->fetchAll();

$sqllist_rowset_other = false;
/* === Hook === */
foreach (cot_getextplugins('vacancies.xml.before_loop') as $pl)
{
	include $pl;
}
/* ===== */

if(!$sqllist_rowset_other)
{
	foreach ($sqllist_rowset as $vac)
	{
		$jj++;
		$t->assign(cot_generate_vactags($vac, 'XML_ROW_', $cfg['vacancies']['truncatevactext'], $usr['isadmin']));

		/* === Hook - Part2 : Include === */
		foreach ($extp as $pl)
		{
			include $pl;
		}
		/* ===== */
		$t->parse('MAIN.XML_ROW');
	}
}

$t->parse('MAIN');
$t->out('MAIN');

