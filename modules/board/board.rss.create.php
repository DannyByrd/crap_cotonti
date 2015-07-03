<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=rss.create
 * [END_COT_EXT]
 */

/**
 * Board module
 *
 * @package board
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2013
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

if ($m == "board")
{
	require_once cot_incfile('board', 'module');
	
	$default_mode = false;
	
	if($c == $m) unset($c);
	
	if (!empty($c) && isset($structure['board'][$c]))
	{
		$mtch = $structure['board'][$c]['path'].".";
		$mtchlen = mb_strlen($mtch);
		$catsub = array();
		$catsub[] = $c;

		foreach ($structure['board'] as $i => $x)
		{
			if (mb_substr($x['path'], 0, $mtchlen) == $mtch)
			{
				$catsub[] = $i;
			}
		}

		$sql = $db->query("SELECT f.*, u.* FROM $db_board AS f
				LEFT JOIN $db_users AS u ON f.adv_ownerid = u.user_id
			WHERE adv_state=0 AND adv_cat IN ('".implode("','", $catsub)."') 
			ORDER BY adv_date DESC LIMIT ".$cfg['rss']['rss_maxitems']);
	}
	else
	{
		$sql = $db->query("SELECT f.*, u.* FROM $db_board AS f
				LEFT JOIN $db_users AS u ON f.adv_ownerid = u.user_id
			WHERE adv_state=0 AND (adv_expire = 0 OR adv_expire > {$sys['now']})
			ORDER BY adv_date DESC LIMIT ".$cfg['rss']['rss_maxitems']);
	}
	$i = 0;
	while ($row = $sql->fetch())
	{
		$row['adv_pageurl'] = (empty($row['adv_alias'])) ? cot_url('board', 'c='.$row['adv_cat'].'&id='.$row['adv_id'], '', true) : cot_url('board', 'c='.$row['adv_cat'].'&al='.$row['adv_alias'], '', true);

		$items[$i]['title'] = $row['adv_title'];
		$items[$i]['link'] = COT_ABSOLUTE_URL . $row['adv_pageurl'];
		$items[$i]['pubDate'] = cot_date('r', $row['adv_date']);
		$items[$i]['description'] = cot_parse($row['adv_text']);
		$items[$i]['fields'] = cot_generate_advtags($row);

		$i++;
	}
	$sql->closeCursor();
}

?>