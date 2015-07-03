<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=rss.create
 * [END_COT_EXT]
 */

/**
 * Firms module
 *
 * @package firms
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2013
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

if ($m == "firms")
{
	require_once cot_incfile('firms', 'module');
	
	$default_mode = false;
	
	if($c == $m) unset($c);
		
	if (!empty($c) && isset($structure['firms'][$c]))
	{
		$mtch = $structure['firms'][$c]['path'].".";
		$mtchlen = mb_strlen($mtch);
		$catsub = array();
		$catsub[] = $c;

		foreach ($structure['firms'] as $i => $x)
		{
			if (mb_substr($x['path'], 0, $mtchlen) == $mtch)
			{
				$catsub[] = $i;
			}
		}

		$sql = $db->query("SELECT f.*, u.* FROM $db_firms AS f
				LEFT JOIN $db_users AS u ON f.firm_ownerid = u.user_id
			WHERE firm_state=0 AND firm_cat IN ('".implode("','", $catsub)."') 
			ORDER BY firm_date DESC LIMIT ".$cfg['rss']['rss_maxitems']);
	}
	else
	{
		$sql = $db->query("SELECT f.*, u.* FROM $db_firms AS f
				LEFT JOIN $db_users AS u ON f.firm_ownerid = u.user_id
			WHERE firm_state=0
			ORDER BY firm_date DESC LIMIT ".$cfg['rss']['rss_maxitems']);
	}
	$i = 0;
	while ($row = $sql->fetch())
	{
		$row['firm_pageurl'] = (empty($row['firm_alias'])) ? cot_url('firms', 'c='.$row['firm_cat'].'&id='.$row['firm_id'], '', true) : cot_url('firms', 'c='.$row['firm_cat'].'&al='.$row['firm_alias'], '', true);

		$items[$i]['title'] = $row['firm_title'];
		$items[$i]['link'] = COT_ABSOLUTE_URL . $row['firm_pageurl'];
		$items[$i]['pubDate'] = cot_date('r', $row['firm_date']);
		$items[$i]['description'] = cot_parse($row['firm_text']);
		$items[$i]['fields'] = cot_generate_firmtags($row);

		$i++;
	}
	$sql->closeCursor();
}

?>