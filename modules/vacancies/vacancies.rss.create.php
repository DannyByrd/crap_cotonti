<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=rss.create
 * [END_COT_EXT]
 */

/**
 * Vacancies module
 *
 * @package vacancies
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2013
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

if ($m == "vacancies")
{
	require_once cot_incfile('vacancies', 'module');
	
	$default_mode = false;
	
	if($c == $m) unset($c);
	
	if (!empty($c) && isset($structure['vacancies'][$c]))
	{
		$mtch = $structure['vacancies'][$c]['path'].".";
		$mtchlen = mb_strlen($mtch);
		$catsub = array();
		$catsub[] = $c;

		foreach ($structure['vacancies'] as $i => $x)
		{
			if (mb_substr($x['path'], 0, $mtchlen) == $mtch)
			{
				$catsub[] = $i;
			}
		}

		$sql = $db->query("SELECT f.*, u.* FROM $db_vacancies AS f
				LEFT JOIN $db_users AS u ON f.vac_ownerid = u.user_id
			WHERE vac_state=0 AND (vac_expire = 0 OR vac_expire > {$sys['now']}) AND vac_cat IN ('".implode("','", $catsub)."') 
			ORDER BY vac_date DESC LIMIT ".$cfg['rss']['rss_maxitems']);
	}
	else
	{
		$sql = $db->query("SELECT f.*, u.* FROM $db_vacancies AS f
				LEFT JOIN $db_users AS u ON f.vac_ownerid = u.user_id
			WHERE vac_state=0 AND (vac_expire = 0 OR vac_expire > {$sys['now']})
			ORDER BY vac_date DESC LIMIT ".$cfg['rss']['rss_maxitems']);
	}
	$i = 0;
	while ($row = $sql->fetch())
	{
		$row['vac_pageurl'] = (empty($row['vac_alias'])) ? cot_url('vacancies', 'c='.$row['vac_cat'].'&id='.$row['vac_id'], '', true) : cot_url('vacancies', 'c='.$row['vac_cat'].'&al='.$row['vac_alias'], '', true);

		$items[$i]['title'] = $row['vac_title'];
		$items[$i]['link'] = COT_ABSOLUTE_URL . $row['vac_pageurl'];
		$items[$i]['pubDate'] = cot_date('r', $row['vac_date']);
		$items[$i]['description'] = cot_parse($row['vac_text']);
		$items[$i]['fields'] = cot_generate_vactags($row);

		$i++;
	}
	$sql->closeCursor();
}

?>