<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=rss.create
 * [END_COT_EXT]
 */

/**
 * Afisha module
 *
 * @package afisha
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2013
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

if ($m == "afisha")
{
	require_once cot_incfile('afisha', 'module');
	
	$default_mode = false;
	
	if($c == $m) unset($c);
	
	if (!empty($c) && isset($structure['afisha'][$c]))
	{
		$mtch = $structure['afisha'][$c]['path'].".";
		$mtchlen = mb_strlen($mtch);
		$catsub = array();
		$catsub[] = $c;

		foreach ($structure['afisha'] as $i => $x)
		{
			if (mb_substr($x['path'], 0, $mtchlen) == $mtch)
			{
				$catsub[] = $i;
			}
		}

		$sql = $db->query("SELECT f.*, u.* FROM $db_afisha AS f
				LEFT JOIN $db_users AS u ON f.event_ownerid = u.user_id
			WHERE event_state=0 AND event_cat IN ('".implode("','", $catsub)."') 
			ORDER BY event_date DESC LIMIT ".$cfg['rss']['rss_maxitems']);
	}
	else
	{
		$sql = $db->query("SELECT f.*, u.* FROM $db_afisha AS f
				LEFT JOIN $db_users AS u ON f.event_ownerid = u.user_id
			WHERE event_state=0 AND (event_expire = 0 OR event_expire > {$sys['now']})
			ORDER BY event_date DESC LIMIT ".$cfg['rss']['rss_maxitems']);
	}
	$i = 0;
	while ($row = $sql->fetch())
	{
		$row['event_pageurl'] = (empty($row['event_alias'])) ? cot_url('afisha', 'c='.$row['event_cat'].'&id='.$row['event_id'], '', true) : cot_url('afisha', 'c='.$row['event_cat'].'&al='.$row['event_alias'], '', true);

		$items[$i]['title'] = $row['event_title'];
		$items[$i]['link'] = COT_ABSOLUTE_URL . $row['event_pageurl'];
		$items[$i]['pubDate'] = cot_date('r', $row['event_date']);
		$items[$i]['description'] = cot_parse($row['event_text']);
		$items[$i]['fields'] = cot_generate_eventtags($row);

		$i++;
	}
	$sql->closeCursor();
}

?>