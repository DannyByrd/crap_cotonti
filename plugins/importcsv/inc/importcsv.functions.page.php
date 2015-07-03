<?php

function icsv_create_page(&$rpage, $images){
    global $cache, $cfg, $db, $db_pages, $db_structure, $structure, $L;

    if (count($auth) == 0)
    {
        $auth = cot_page_auth($rpage['page_cat']);
    }

    if (!empty($rpage['page_alias']))
    {
        $page_count = $db->query("SELECT COUNT(*) FROM $db_pages WHERE page_alias = ? AND page_cat = ?", array($rpage['page_alias'], $rpage['page_cat']))->fetchColumn();
        if ($page_count > 0)
        {
            $rpage['page_alias'] = $rpage['page_alias'].rand(1000, 9999);
        }
    }

    if ($rpage['page_state'] == 0)
    {
        if ($auth['isadmin'] && $cfg['page']['autovalidate'])
        {
            $db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_area='page' AND structure_code = ?", $rpage['page_cat']);
            $cache && $cache->db->remove('structure', 'system');
        }
        else
        {
            $rpage['page_state'] = 1;
        }
    }

    /* === Hook === */
    foreach (cot_getextplugins('page.add.add.query') as $pl)
    {
        include $pl;
    }
    /* ===== */

    if ($db->insert($db_pages, $rpage))
    {
        $id = $db->lastInsertId();
        save_images('page', $data['page_alias'], $id, $images);
        cot_extrafield_movefiles();
    }
    else
    {
        $id = false;
    }

    /* === Hook === */
    foreach (cot_getextplugins('page.add.add.done') as $pl)
    {
        include $pl;
    }
    /* ===== */

    if ($rpage['page_state'] == 0 && $cache)
    {
        if ($cfg['cache_page'])
        {
            $cache->page->clear('page/' . str_replace('.', '/', $structure['page'][$rpage['page_cat']]['path']));
        }
        if ($cfg['cache_index'])
        {
            $cache->page->clear('index');
        }
    }
    cot_shield_update(30, "r page");
    cot_log("Add page #".$id, 'adm');

    return $id;
}

function icsv_update_page(&$rpage, $images)
{
    global $cache, $cfg, $db, $db_pages, $db_structure, $structure, $L;

    if (count($auth) == 0)
    {
        $auth = cot_page_auth($rpage['page_cat']);
    }

    $row_page = $db->query("SELECT * FROM $db_pages WHERE page_alias = ? AND page_cat = ?", array($rpage['page_alias'], $rpage['page_cat']))->fetch();

    if ($row_page['page_cat'] != $rpage['page_cat'] && $row_page['page_state'] == 0)
    {
        $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code = ? AND structure_area = 'page'", $row_page['page_cat']);
    }

    //$usr['isadmin'] = cot_auth('page', $rpage['page_cat'], 'A');
    if ($rpage['page_state'] == 0)
    {
        if ($auth['isadmin'] && $cfg['page']['autovalidate'])
        {
            if ($row_page['page_state'] != 0 || $row_page['page_cat'] != $rpage['page_cat'])
            {
                $db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code = ? AND structure_area = 'page'", $rpage['page_cat']);
            }
        }
        else
        {
            $rpage['page_state'] = 1;
        }
    }

    if ($rpage['page_state'] != 0 && $row_page['page_state'] == 0)
    {
        $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code = ?", $rpage['page_cat']);
    }
    $cache && $cache->db->remove('structure', 'system');

    save_images('page', $row_page['page_alias'], $row_page['page_id'], $images);

    if (!$db->update($db_pages, $rpage, 'page_alias = ? AND page_cat = ?', array($rpage['page_alias'], $rpage['page_cat'])))
    {
        return false;
    }
    cot_extrafield_movefiles();

    /* === Hook === */
    foreach (cot_getextplugins('page.edit.update.done') as $pl)
    {
        include $pl;
    }
    /* ===== */

    if (($rpage['page_state'] == 0  || $rpage['page_cat'] != $row_page['page_cat']) && $cache)
    {
        if ($cfg['cache_page'])
        {
            $cache->page->clear('page/' . str_replace('.', '/', $structure['page'][$rpage['page_cat']]['path']));
            if ($rpage['page_cat'] != $row_page['page_cat'])
            {
                $cache->page->clear('page/' . str_replace('.', '/', $structure['page'][$row_page['page_cat']]['path']));
            }
        }
        if ($cfg['cache_index'])
        {
            $cache->page->clear('index');
        }
    }

    return true;
}

?>