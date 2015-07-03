<?php
	

function cot_costformat($cost)
{
	if(strstr($cost, ','))
	{
		return number_format($cost, 2, '.', ' ');
	}
	else
	{	
		return number_format($cost, 0, '.', ' ');
	}
}

/**
 * Forum URL overrides
 *
 * @param array $args Args passed over from cot_url
 * @return string
 */
function forums_url_structure(&$args)
{
    global $cfg, $db, $structure, $db_forum_topics, $db_forum_posts;

    $script = 'forums';
    $replacement = '';
    if(isset($args['m']) && $args['m'] == 'topics')
    {
        if(isset($args['s']))
        {
			$d = (int) $args['d'];
			
            $replacement .= str_replace('.', '/', $structure['forums'][$args['s']]['path']);
			
			if(isset($args['d']))
			{
				$replacement .= '/page'.$d;
			}
			
			unset($args['d']);
			unset($args['s']);
        }
        else $replacement .= $script;
    }
    elseif(isset($args['m']) && $args['m'] == 'posts')
    {
        if(isset($args['q']))
        {
            $q = (int) $args['q'];
            $d = (int) $args['d'];
            $s = $db->query("SELECT fp_cat FROM $db_forum_posts WHERE fp_topicid=".$q)->fetchColumn();
 
			$replacement .= str_replace('.', '/', $structure['forums'][$s]['path']).'/topic'.$q;
			
			if(isset($args['d']))
			{
				$replacement .= '/page'.$d;
			}
			
			unset($args['d']);
			unset($args['q']);
            unset($args['m']);
        }
        elseif(isset($args['id']))
        {
            $id = (int) $args['id'];
            $s = $db->query("SELECT fp_cat FROM $db_forum_posts WHERE fp_id=".$id)->fetchColumn();
			
            $replacement .= str_replace('.', '/', $structure['forums'][$s]['path']).'/post'.$id;
			
            unset($args['id']);
            unset($args['m']);
        }
        else $replacement .= $script;
    }
    else $replacement .= $script;
    return $replacement;
}
