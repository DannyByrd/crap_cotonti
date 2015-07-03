<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('blogs', 'module');

/**
 * Converts a title into an alias
 *
 * @param string $title Title
 * @param int $id Page ID
 * @param bool $duplicate TRUE if duplicate alias was previously detected
 * @return string
 */
function autoalias2_convert($title, $id = 0, $duplicate = false)
{
	global $cfg, $cot_translit, $cot_translit_custom;

	if($cfg['plugin']['autoalias2']['translit'] && file_exists(cot_langfile('translit', 'core')))
	{
		include cot_langfile('translit', 'core');
		if (is_array($cot_translit_custom))
		{
			$title = strtr($title, $cot_translit_custom);
		}
		elseif (is_array($cot_translit))
		{
			$title = strtr($title, $cot_translit);
		}
	}
	$title = preg_replace('#[^\p{L}0-9\-_ ]#u', '', $title);
	$title = str_replace(' ', $cfg['plugin']['autoalias2']['sep'], $title);

	while(strpos($title, '--') !== false){
		$title = str_replace('--', $cfg['plugin']['autoalias2']['sep'], $title);
	}	
	$title = trim($title, '-');

	if ($cfg['plugin']['autoalias2']['lowercase'])
	{
		$title = mb_strtolower($title);
	}

	if ($cfg['plugin']['autoalias2']['prepend_id'] && !empty($id))
	{
		$title = $id . $cfg['plugin']['autoalias2']['sep'] . $title;
	}
	elseif ($duplicate)
	{
		switch ($cfg['plugin']['autoalias2']['on_duplicate'])
		{
			case 'ID':
				if (!empty($id))
				{
					$title .= $cfg['plugin']['autoalias2']['sep'] . $id;
					break;
				}
			default:
				$title .= $cfg['plugin']['autoalias2']['sep'] . rand(2, 99);
				break;
		}
	}

	return $title;
}

/**
 * Updates an alias for a specific products
 *
 * @param string $title Page title
 * @param int $id Page ID
 */
function autoalias2_update($title, $id)
{
	global $cfg, $db, $db_blogs;
	$duplicate = false;
	$c = cot_import('c', 'G', 'TXT');
	do
	{
		$alias = autoalias2_convert($title, $id, $duplicate);
		if (!$cfg['plugin']['autoalias2']['prepend_id']
			&& $db->query("SELECT COUNT(*) FROM $db_blogs
				WHERE post_alias = '$alias' AND post_id != $id AND post_cat = '$c'")->fetchColumn() > 0)
		{
			$duplicate = true;
		}
		else
		{
			$db->update($db_blogs, array('post_alias' => $alias), "post_id = $id");
			$duplicate = false;
		}
	}
	while ($duplicate && !$cfg['plugin']['autoalias2']['prepend_id']);
	return $alias;
}
