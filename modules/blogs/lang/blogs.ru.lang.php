<?php
/**
 * Russian Language File for the Blogs Module (blogs.ru.lang.php)
 *
 * @package blogs
 * @version 0.9.6
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */

$L['cfg_autovalidatepost'] = 'Автоматическое утверждение сообщений';
$L['cfg_autovalidatepost_hint'] = 'Автоматически утверждать публикацию сообщений, созданных пользователем с правом администрирования раздела';
$L['cfg_count_admin'] = 'Считать посещения администраторов';
$L['cfg_count_admin_hint'] = 'Включить посещения администраторов в статистику посещаемости сайта';
$L['cfg_maxlistsperpage'] = 'Макс. количество категорий на странице';
$L['cfg_maxlistsperpage_hint'] = ' ';
$L['cfg_order'] = 'Поле сортировки';
$L['cfg_title_blogs'] = 'Формат заголовка сообщения';
$L['cfg_title_post_hint'] = 'Опции: {TITLE}, {CATEGORY}';
$L['cfg_way'] = 'Направление сортировки';
$L['cfg_truncateposttext'] = 'Ограничить размер текста в списках сообщений';
$L['cfg_truncateposttext_hint'] = '0 для отключения';
$L['cfg_allowemptyposttext'] = 'Разрешить пустой текст сообщения';
$L['cfg_keywords'] = 'Ключевые слова';

$L['info_desc'] = 'Управление контентом: блоги';

/**
 * Structure Confing
 */

$L['cfg_order_params'] = array(); // Redefined in cot_blogs_config_order()
$L['cfg_way_params'] = array($L['Ascending'], $L['Descending']);

/**
 * Admin Adv Section
 */

$L['adm_queue_deleted'] = 'Сообщение удалено в корзину';
$L['adm_valqueue'] = 'В очереди на утверждение';
$L['adm_validated'] = 'Утвержденные';
$L['adm_structure'] = 'Структура (категории)';
$L['adm_sort'] = 'Сортировать';
$L['adm_sortingorder'] = 'Порядок сортировки по умолчанию в категории';
$L['adm_showall'] = 'Показать все';

/**
 * Adv add and edit
 */

$L['post_addtitle'] = 'Создать сообщение';
$L['post_addsubtitle'] = 'Заполните необходимые поля и нажмите "Отправить" для продолжения';
$L['post_edittitle'] = 'Информация об сообщения';
$L['post_editsubtitle'] = 'Измените необходимые поля и нажмите "Отправить" для продолжения';

$L['post_aliascharacters'] = 'Недопустимо использование символов \'+\', \'/\', \'?\', \'%\', \'#\', \'&\' в алиасах';
$L['post_catmissing'] = 'Код категории отсутствует';
$L['post_clone'] = 'Клонировать сообщение';
$L['post_confirm_delete'] = 'Вы действительно хотите удалить это сообщение?';
$L['post_confirm_validate'] = 'Хотите утвердить это сообщение?';
$L['post_confirm_unvalidate'] = 'Вы действительно хотите отправить это сообщение в очередь на утверждение?';
$L['post_drafts'] = 'Черновики';
$L['post_drafts_desc'] = 'Сообщения, сохраненные в ваших черновиках';
$L['post_notavailable'] = 'Сообщение будет опубликовано через';
$L['post_textmissing'] = 'Текст сообщения не должен быть пустым';
$L['post_titletooshort'] = 'Название сообщения слишком короткое либо отсутствует';
$L['post_validation'] = 'Ожидают утверждения';
$L['post_validation_desc'] = 'Ваши сообщения, которые еще не утверждены администратором';

$L['post_title'] = 'Заголовок';
$L['post_desc'] = 'Краткое описание';

$L['post_metakeywords'] = 'Ключевые слова';
$L['post_metatitle'] = 'Meta-заголовок';
$L['post_metadesc'] = 'Meta-описание';

$L['post_formhint'] = 'После заполнения формы сообщение будет помещено в очередь на утверждение и будет скрыто до тех пор, пока модератор или администратор не утвердят его публикацию в соответствующем разделе. Внимательно проверьте правильность заполнения полей формы. Если вам понадобится изменить содержание сообщения, то вы сможете сделать это позже, но сообщение вновь будет отправлена на утверждение.';

$L['post_postid'] = 'ID сообщения';
$L['post_deleteblogs'] = 'Удалить сообщение';

$L['post_savedasdraft'] = 'Сообщение сохранено в черновиках';

/**
 * Adv statuses
 */

$L['post_status_draft'] = 'Черновик';
$L['post_status_pending'] = 'На рассмотрении';
$L['post_status_approved'] = 'Утверждена';
$L['post_status_published'] = 'Опубликована';

/**
 * Moved from theme.lang
 */

$L['post_linesperpage'] = 'Записей на страницу';
$L['post_linesinthissection'] = 'Записей в разделе';

$L['Blogs'] = "Блоги";
$L['blogs_catalog'] = "Блоги";
$L['blogs_new'] = "Новые сообщения";

$Ls['blogs'] = "сообщение,сообщения,сообщений";
$Ls['unvalidated_blogs'] = "неутвержденное сообщение,неутвержденные сообщения,неутвержденных сообщений";
$Ls['post_in_drafts'] = "сообщение в черновиках,сообщения в черновиках,сообщений в черновиках";

$L['post_submitnewpost'] = 'Добавить сообщение';


// Параметры поиска сообщений в блогах
$L['plu_blogs_set_sec'] = 'Разделы';
$L['plu_blogs_res_sort1'] = 'Дате публикации';
$L['plu_blogs_res_sort2'] = 'Заголовку';
$L['plu_blogs_res_sort3'] = 'Популярности';
$L['plu_blogs_res_sort3'] = 'Категории';
$L['plu_blogs_search_names'] = 'Поиск в заголовках';
$L['plu_blogs_search_desc'] = 'Поиск в кратком описании';
$L['plu_blogs_search_text'] = 'Поиск в описании';
$L['plu_blogs_set_subsec'] = 'Поиск в подразделах';