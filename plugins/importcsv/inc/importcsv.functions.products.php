<?php

function icsv_create_products(&$rprd, $images)
{
    global $cache, $cfg, $db, $db_products, $db_structure, $structure, $L;

    if (count($auth) == 0)
    {
        $auth = cot_products_auth($rprd['prd_cat']);
    }

    if ($rprd['prd_state'] == 0)
    {
        if ($auth['isadmin'] && $cfg['products']['autovalidateprd'])
        {
            $db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_area='products' AND structure_code = ?", $rprd['prd_cat']);
            $cache && $cache->db->remove('structure', 'system');
        }
        else
        {
            $rprd['prd_state'] = 1;
        }
    }

    if ($db->insert($db_products, $rprd))
    {
        $id = $db->lastInsertId();
        save_images('products', $rprd['prd_alias'], $id, $images);
        cot_extrafield_movefiles();
    }
    else
    {
        $id = false;
    }

    if (cot_plugin_active('mavatars'))
    {
        $mavatar = new mavatar('products', $rprd['prd_cat'], $id);
        $mavatar->upload();
        $mavatar->update();
    }

    if ($rprd['prd_state'] == 0 && $cache)
    {
        if ($cfg['cache_products'])
        {
            $cache->products->clear('products/' . str_replace('.', '/', $structure['products'][$rprd['prd_cat']]['path']));
        }
        if ($cfg['cache_index'])
        {
            $cache->products->clear('index');
        }
    }
    cot_shield_update(30, "r products");
    cot_log("Add products #".$id, 'adm');

    return $id;
}

function icsv_update_products(&$rprd, $images)
{
    global $cache, $cfg, $db, $db_products, $db_structure, $structure, $L;

    if (count($auth) == 0)
    {
        $auth = cot_products_auth($rprd['prd_cat']);
    }

    $row_products = $db->query("SELECT * FROM $db_products WHERE prd_alias = ? AND prd_cat = ?", array($rprd['prd_alias'], $rprd['prd_cat']))->fetch();

    if ($row_products['prd_cat'] != $rprd['prd_cat'] && $row_products['prd_state'] == 0)
    {
        $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code = ? AND structure_area = 'products'", $row_products['prd_cat']);
    }

    //$usr['isadmin'] = cot_auth('products', $rprd['prd_cat'], 'A');
    if ($rprd['prd_state'] == 0)
    {
        if ($auth['isadmin'] && $cfg['products']['autovalidateprd'])
        {
            if ($row_products['prd_state'] != 0 || $row_products['prd_cat'] != $rprd['prd_cat'])
            {
                $db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code = ? AND structure_area = 'products'", $rprd['prd_cat']);
            }
        }
        else
        {
            $rprd['prd_state'] = 1;
        }
    }

    if ($rprd['prd_state'] != 0 && $row_products['prd_state'] == 0)
    {
        $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code = ?", $rprd['prd_cat']);
    }
    $cache && $cache->db->remove('structure', 'system');
    save_images('products', $row_products['prd_alias'], $row_products['prd_id'], $images);
    if (!$db->update($db_products, $rprd, 'prd_alias = ? AND prd_cat = ?', array($rprd['prd_alias'], $rprd['prd_cat'])))
    {
        return false;
    }

    cot_extrafield_movefiles();

    if (($rprd['prd_state'] == 0  || $rprd['prd_cat'] != $row_products['prd_cat']) && $cache)
    {
        if ($cfg['cache_products'])
        {
            $cache->products->clear('products/' . str_replace('.', '/', $structure['products'][$rprd['prd_cat']]['path']));
            if ($rprd['prd_cat'] != $row_products['prd_cat'])
            {
                $cache->products->clear('products/' . str_replace('.', '/', $structure['products'][$row_products['prd_cat']]['path']));
            }
        }
        if ($cfg['cache_index'])
        {
            $cache->products->clear('index');
        }
    }

    return true;
}

?>