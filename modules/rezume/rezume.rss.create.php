<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=rss.create
 * [END_COT_EXT]
 */

/**
 * rezume module
 *
 * @package rezume
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2013
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

if ($m == "rezume")
{
	require_once cot_incfile('rezume', 'module');
	
	$default_mode = false;
	
	if($c == $m) unset($c);
	
	if (!empty($c) && isset($structure['rezume'][$c]))
	{
		$mtch = $structure['rezume'][$c]['path'].".";
		$mtchlen = mb_strlen($mtch);
		$catsub = array();
		$catsub[] = $c;

		foreach ($structure['rezume'] as $i => $x)
		{
			if (mb_substr($x['path'], 0, $mtchlen) == $mtch)
			{
				$catsub[] = $i;
			}
		}

		$sql = $db->query("SELECT f.*, u.* FROM $db_rezume AS f
				LEFT JOIN $db_users AS u ON f.rez_ownerid = u.user_id
			WHERE rez_state=0 AND (rez_expire = 0 OR rez_expire > {$sys['now']}) AND rez_cat IN ('".implode("','", $catsub)."') 
			ORDER BY rez_date DESC LIMIT ".$cfg['rss']['rss_maxitems']);
	}
	else
	{
		$sql = $db->query("SELECT f.*, u.* FROM $db_rezume AS f
				LEFT JOIN $db_users AS u ON f.rez_ownerid = u.user_id
			WHERE rez_state=0 AND (rez_expire = 0 OR rez_expire > {$sys['now']})
			ORDER BY rez_date DESC LIMIT ".$cfg['rss']['rss_maxitems']);
	}
	$i = 0;
	while ($row = $sql->fetch())
	{
		$row['rez_pageurl'] = (empty($row['rez_alias'])) ? cot_url('rezume', 'c='.$row['rez_cat'].'&id='.$row['rez_id'], '', true) : cot_url('rezume', 'c='.$row['rez_cat'].'&al='.$row['rez_alias'], '', true);

		$items[$i]['title'] = $row['rez_title'];
		$items[$i]['link'] = COT_ABSOLUTE_URL . $row['rez_pageurl'];
		$items[$i]['pubDate'] = cot_date('r', $row['rez_date']);
		$items[$i]['description'] = cot_parse($row['rez_text']);
		$items[$i]['fields'] = cot_generate_reztags($row);

		$i++;
	}
	$sql->closeCursor();
}

?>