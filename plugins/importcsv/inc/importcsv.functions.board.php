<?php

function icsv_create_board(&$radv, $images)
{
    global $cache, $cfg, $db, $db_board, $db_structure, $structure, $L;

    if (count($auth) == 0)
    {
        $auth = cot_board_auth($radv['adv_cat']);
    }

    if ($radv['adv_state'] == 0)
    {
        if ($auth['isadmin'] && $cfg['board']['autovalidateadv'])
        {
            $db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_area='board' AND structure_code = ?", $radv['adv_cat']);
            $cache && $cache->db->remove('structure', 'system');
        }
        else
        {
            $radv['adv_state'] = 1;
        }
    }

    if ($db->insert($db_board, $radv))
    {
        $id = $db->lastInsertId();
        save_images('board', $radv['adv_alias'], $id, $images);
        cot_extrafield_movefiles();
    }
    else
    {
        $id = false;
    }

    if ($radv['adv_state'] == 0 && $cache)
    {
        if ($cfg['cache_board'])
        {
            $cache->board->clear('board/' . str_replace('.', '/', $structure['board'][$radv['adv_cat']]['path']));
        }
        if ($cfg['cache_index'])
        {
            $cache->board->clear('index');
        }
    }
    cot_shield_update(30, "r board");
    cot_log("Add board #".$id, 'adm');

    return $id;
}

function icsv_update_board(&$radv, $images)
{
    global $cache, $cfg, $db, $db_board, $db_structure, $structure, $L;

    if (count($auth) == 0)
    {
        $auth = cot_board_auth($radv['adv_cat']);
    }

    $row_board = $db->query("SELECT * FROM $db_board WHERE adv_alias = ? AND adv_cat = ?", array($radv['adv_alias'],$radv['adv_cat']))->fetch();

    if ($row_board['adv_cat'] != $radv['adv_cat'] && $row_board['adv_state'] == 0)
    {
        $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code = ? AND structure_area = 'board'", $row_board['adv_cat']);
    }

    if ($radv['adv_state'] == 0)
    {
        if ($auth['isadmin'] && $cfg['board']['autovalidateadv'])
        {
            if ($row_board['adv_state'] != 0 || $row_board['adv_cat'] != $radv['adv_cat'])
            {
                $db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code = ? AND structure_area = 'board'", $radv['adv_cat']);
            }
        }
        else
        {
            $radv['adv_state'] = 1;
        }
    }

    if ($radv['adv_state'] != 0 && $row_board['adv_state'] == 0)
    {
        $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code = ?", $radv['adv_cat']);
    }
    $cache && $cache->db->remove('structure', 'system');
    save_images('board', $row_board['adv_alias'], $row_board['adv_id'], $images);

    if (!$db->update($db_board, $radv, "adv_alias = ? AND adv_cat = ?", array($radv['adv_alias'],$radv['adv_cat'])))
    {
        return false;
    }

    cot_extrafield_movefiles();

    if (($radv['adv_state'] == 0  || $radv['adv_cat'] != $row_board['adv_cat']) && $cache)
    {
        if ($cfg['cache_board'])
        {
            $cache->board->clear('board/' . str_replace('.', '/', $structure['board'][$radv['adv_cat']]['path']));
            if ($radv['adv_cat'] != $row_board['adv_cat'])
            {
                $cache->board->clear('board/' . str_replace('.', '/', $structure['board'][$row_board['adv_cat']]['path']));
            }
        }
        if ($cfg['cache_index'])
        {
            $cache->board->clear('index');
        }
    }

    return true;
}
?>