<?php

defined('COT_CODE') or die('Wrong URL');

function icsv_create_structure($data, $images)
{
    global $cache, $db, $db_structure,$structure_name;

    $is_module = true;

    if (!empty($data['structure_title']) && !empty($data['structure_code']) && !empty($data['structure_path']) && $data['structure_code'] != 'all')
    {
        $sql = $db->query("SELECT COUNT(*) FROM $db_structure WHERE structure_area=? AND structure_code=?", array($structure_name, $data['structure_code']));
        if ($sql->fetchColumn() == 0)
        {
            $sql = $db->insert($db_structure, $data);
            $id = $db->lastInsertId();
            $auth_permit = array(COT_GROUP_DEFAULT => 'RW', COT_GROUP_GUESTS => 'R', COT_GROUP_MEMBERS => 'RW');
            $auth_lock = array(COT_GROUP_DEFAULT => '0', COT_GROUP_GUESTS => 'A', COT_GROUP_MEMBERS => '0');
            $is_module && cot_auth_add_item($structure_name, $data['structure_code'], $auth_permit, $auth_lock);
            $area_addcat = 'cot_'.$structure_name.'_addcat';
            (function_exists($area_addcat)) ? $area_addcat($data['structure_code']) : FALSE;
            $cache && $cache->clear();
            cot_message("Категория <b>".$data['structure_title']."</b> добавлена в модуль <b>" . $structure_name . "</b>");
            
            save_images('structure', $data['structure_code'], $id, $images);
            return true;
        }
        else
        {
            cot_error('Категория с кодом <b>'. $data['structure_code'] .'</b> уже существует');
            return false;
        }
    }
    else
    {
        cot_error('Не хватает данных для добавления категории');
        return false;
    }
}

function icsv_update_structure($data, $images)
{
    global $cache, $db, $db_auth, $db_config, $db_structure, $db_mavatars, $structure_name;

    $sql1 = $db->update($db_structure, $data, "structure_code='" . $data['structure_code']."'");
    
    $updated = $sql1 > 0;

    if($updated){
        cot_message("Категория <b>".$data['structure_title']."</b> обновлена в модуле <b>" . $structure_name . "</b>");
    }

    $sql = $db->query("SELECT * FROM $db_structure WHERE structure_area=? AND structure_code=?", array($data['structure_area'], $data['structure_code']));
    $cat = $sql->fetch();

    save_images('structure', $cat['structure_code'], $cat['structure_id'], $images);

    return $updated;
}

function save_images($extension, $category, $code, $images){
        if (cot_plugin_active('mavatars'))
        {
            global $db, $db_mavatars;

            require_once cot_incfile('mavatars', 'plug');
            $mavatar = new mavatar($extension, $category, $code);

            foreach ($mavatar->mavatars as $key => $mav) {
                $search_file = $mav['filename'] . '.' . $mav['fileext'];
                $i = array_search($search_file, $images);
                if(is_numeric($i)){
                    unset($images[$i]);
                } else {
                    if($db->delete($db_mavatars, "mav_id = '" . $mav['id'] . "'")){
                        switch ($extension) {
                            case 'structure':
                                cot_message('Фото <b>' . $search_file . '</b> удалено из категории <b>' . $category . '</b>');
                                break;

                            case 'page':
                                cot_message('Фото <b>' . $search_file . '</b> удалено из страницы <b>' . $category . '</b>');
                                break;
                            
                            case 'products':
                                cot_message('Фото <b>' . $search_file . '</b> удалено из товара <b>' . $category . '</b>');
                                break;

                            case 'board':
                                cot_message('Фото <b>' . $search_file . '</b> удалено из обновления <b>' . $category . '</b>');
                                break;

                            default:
                                cot_message('Фото <b>' . $search_file . '</b> удалено');
                                
                                break;
                        }
                    }

                }
            }

            if($images)
            foreach ($images as $key => $image) {
                $image = trim($image);
                if($image){
                    $amv_file = 'datas/mavatars/' . $image;
                    $filesize = @filesize($amv_file);
                    $fileinfo = pathinfo($amv_file);
                    $mav_file = array(
                            'name'      =>  $fileinfo['filename'],
                            'path'      =>  $fileinfo['dirname'],
                            'extension' =>  $fileinfo['extension'],
                            'origname'  =>  $fileinfo['filename'],
                            'size'      =>  $filesize,
                    );
                    if($filesize > 0){
                        $mavatar->mavatar_add($mav_file, $category, $key+1);
                        switch ($extension) {
                            case 'structure':
                                cot_message('Фото <b>' . $image . '</b> добавлено в категорию <b>' . $category . '</b>');
                                break;

                            case 'page':
                                cot_message('Фото <b>' . $image . '</b> добавлено в страницу <b>' . $category . '</b>');
                                break;
                            
                            case 'products':
                                cot_message('Фото <b>' . $image . '</b> добавлено в товар <b>' . $category . '</b>');
                                break;

                            case 'board':
                                cot_message('Фото <b>' . $image . '</b> добавлено в обявление <b>' . $category . '</b>');
                                break;

                            default:
                                cot_message('Фото <b>' . $image . '</b> добавлено');
                                
                                break;
                        }
                    } else {
                        switch ($extension) {
                            case 'structure':
                                cot_error('Фото <b>' . $image . '</b> не было найдено к категории <b>' . $category . '</b> в папке <i>"datas/mavatars"</i>');
                                break;

                            case 'page':
                                cot_error('Фото <b>' . $image . '</b> не было найдено к страницы <b>' . $category . '</b> в папке <i>"datas/mavatars"</i>');
                                break;
                            
                            case 'products':
                                cot_error('Фото <b>' . $image . '</b> не было найдено к товару <b>' . $category . '</b> в папке <i>"datas/mavatars"</i>');
                                break;

                            case 'board':
                                cot_error('Фото <b>' . $image . '</b> не было найдено к обявлению <b>' . $category . '</b> в папке <i>"datas/mavatars"</i>');
                                break;

                            default:
                                cot_error('Фото <b>' . $image . '</b> не было найдено в папке <i>"datas/mavatars"</i>');
                                
                                break;
                        }
                    }
                }
            }
            unset($mavatar);
        } else {
            // var_dump($images);
            count($images) > 0 && cot_error('Фото не были добавлены, так как плагин <a style="color: #d8000c;" href="' . cot_url('admin', 'm=extensions&a=details&pl=mavatars'). '" target="_blank"><b>mavatars</b></a> не был установлен');
        }
}



$FilePath = '';
if(isset($_FILES["uploadedfile"]) AND $_FILES["uploadedfile"]["tmp_name"] != ''){
    $FilePath = $_FILES["uploadedfile"]["tmp_name"];

    require_once cot_incfile($plug_name, 'plug', 'class');

    $ICSV_Import = new ICSV_Import();
    if($ICSV_Import->import_file($FilePath)){
        $ICSV_Import->start_import();  
    }
} else{
    cot_message('Не выбран файл или размер файла больше указанных в php.ini', 'error');
}

?>