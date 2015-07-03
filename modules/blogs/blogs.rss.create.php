<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=rss.create
 * [END_COT_EXT]
 */

/**
 * Blogs module
 *
 * @package blogs
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2013
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

if ($m == "blogs")
{
	require_once cot_incfile('blogs', 'module');
	
	$default_mode = false;
	
	if($c == $m) unset($c);
	
	if (!empty($c) && isset($structure['blogs'][$c]))
	{
		$mtch = $structure['blogs'][$c]['path'].".";
		$mtchlen = mb_strlen($mtch);
		$catsub = array();
		$catsub[] = $c;

		foreach ($structure['blogs'] as $i => $x)
		{
			if (mb_substr($x['path'], 0, $mtchlen) == $mtch)
			{
				$catsub[] = $i;
			}
		}

		$sql = $db->query("SELECT f.*, u.* FROM $db_blogs AS f
				LEFT JOIN $db_users AS u ON f.post_ownerid = u.user_id
			WHERE post_state=0 AND post_cat IN ('".implode("','", $catsub)."') 
			ORDER BY post_date DESC LIMIT ".$cfg['rss']['rss_maxitems']);
	}
	else
	{
		$sql = $db->query("SELECT f.*, u.* FROM $db_blogs AS f
				LEFT JOIN $db_users AS u ON f.post_ownerid = u.user_id
			WHERE post_state=0
			ORDER BY post_date DESC LIMIT ".$cfg['rss']['rss_maxitems']);
	}
	$i = 0;
	while ($row = $sql->fetch())
	{
		$row['post_pageurl'] = (empty($row['post_alias'])) ? cot_url('blogs', 'c='.$row['post_cat'].'&id='.$row['post_id'], '', true) : cot_url('blogs', 'c='.$row['post_cat'].'&al='.$row['post_alias'], '', true);

		$items[$i]['title'] = $row['post_title'];
		$items[$i]['link'] = COT_ABSOLUTE_URL . $row['post_pageurl'];
		$items[$i]['pubDate'] = cot_date('r', $row['post_date']);
		$items[$i]['description'] = cot_parse($row['post_text']);
		$items[$i]['fields'] = cot_generate_blogposttags($row);

		$i++;
	}
	$sql->closeCursor();
}

?>