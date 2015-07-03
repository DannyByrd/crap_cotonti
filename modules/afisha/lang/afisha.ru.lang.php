<?php
/**
 * Russian Language File for the Afisha Module (afisha.ru.lang.php)
 *
 * @package afisha
 * @version 0.9.6
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */

$L['cfg_autovalidateevent'] = 'Автоматическое утверждение событий';
$L['cfg_autovalidateevent_hint'] = 'Автоматически утверждать публикацию событий, созданных пользователем с правом администрирования раздела';
$L['cfg_count_admin'] = 'Считать посещения администраторов';
$L['cfg_count_admin_hint'] = 'Включить посещения администраторов в статистику посещаемости сайта';
$L['cfg_maxlistsperpage'] = 'Макс. количество категорий на странице';
$L['cfg_maxlistsperpage_hint'] = ' ';
$L['cfg_order'] = 'Поле сортировки';
$L['cfg_title_afisha'] = 'Формат заголовка объявлении';
$L['cfg_title_event_hint'] = 'Опции: {TITLE}, {CATEGORY}';
$L['cfg_way'] = 'Направление сортировки';
$L['cfg_truncateeventtext'] = 'Ограничить размер текста в списках событий';
$L['cfg_truncateeventtext_hint'] = '0 для отключения';
$L['cfg_allowemptyeventtext'] = 'Разрешить пустой текст события';
$L['cfg_keywords'] = 'Ключевые слова';

$L['info_desc'] = 'Управление контентом: события и категории событий';

/**
 * Structure Confing
 */

$L['cfg_order_params'] = array(); // Redefined in cot_afisha_config_order()
$L['cfg_way_params'] = array($L['Ascending'], $L['Descending']);

/**
 * Admin Adv Section
 */

$L['adm_queue_deleted'] = 'Событие удалено в корзину';
$L['adm_valqueue'] = 'В очереди на утверждение';
$L['adm_validated'] = 'Утвержденные';
$L['adm_expired'] = 'Просроченные';
$L['adm_structure'] = 'Структура (категории)';
$L['adm_sort'] = 'Сортировать';
$L['adm_sortingorder'] = 'Порядок сортировки по умолчанию в категории';
$L['adm_showall'] = 'Показать все';
$L['adm_help_event'] = '';

/**
 * Adv add and edit
 */

$L['event_addtitle'] = 'Создать событие';
$L['event_addsubtitle'] = 'Заполните необходимые поля и нажмите "Отправить" для продолжения';
$L['event_edittitle'] = 'Информация об объявлении';
$L['event_editsubtitle'] = 'Измените необходимые поля и нажмите "Отправить" для продолжения';

$L['event_aliascharacters'] = 'Недопустимо использование символов \'+\', \'/\', \'?\', \'%\', \'#\', \'&\' в алиасах';
$L['event_catmissing'] = 'Код категории отсутствует';
$L['event_clone'] = 'Клонировать событие';
$L['event_conafisha_delete'] = 'Вы действительно хотите удалить это событие?';
$L['event_conafisha_validate'] = 'Хотите утвердить это событие?';
$L['event_conafisha_unvalidate'] = 'Вы действительно хотите отправить это событие в очередь на утверждение?';
$L['event_drafts'] = 'Черновики';
$L['event_drafts_desc'] = 'События, сохраненные в ваших черновиках';
$L['event_notavailable'] = 'Событие будет опубликовано через';
$L['event_textmissing'] = 'Текст события не должен быть пустым';
$L['event_titletooshort'] = 'Заголовок события слишком короткий либо отсутствует';
$L['event_validation'] = 'Ожидают утверждения';
$L['event_validation_desc'] = 'Ваши события, которые еще не утверждены администратором';

$L['event_title'] = 'Заголовок события';
$L['event_desc'] = 'Краткое описание';

$L['event_metakeywords'] = 'Ключевые слова';
$L['event_metatitle'] = 'Meta-заголовок';
$L['event_metadesc'] = 'Meta-описание';

$L['event_cost'] = 'Цена';

$L['event_formhint'] = 'После заполнения формы событие будет помещено в очередь на утверждение и будет скрыто до тех пор, пока модератор или администратор не утвердят его публикацию в соответствующем разделе. Внимательно проверьте правильность заполнения полей формы. Если вам понадобится изменить содержание события, то вы сможете сделать это позже, но событие вновь будет отправлена на утверждение.';

$L['event_eventid'] = 'ID события';
$L['event_deleteevent'] = 'Удалить событие';

$L['event_savedasdraft'] = 'Событие сохранено в черновиках';

/**
 * Adv statuses
 */

$L['event_status_draft'] = 'Черновик';
$L['event_status_pending'] = 'На рассмотрении';
$L['event_status_approved'] = 'Утверждено';
$L['event_status_published'] = 'Опубликовано';
$L['event_status_expired'] = 'Устарело';

/**
 * Moved from theme.lang
 */

$L['event_linesperpage'] = 'Записей на страницу';
$L['event_linesinthissection'] = 'Записей в разделе';

$L['Afisha'] = "Афиша города";
$L['afisha_catalog'] = "Каталог событий";
$L['afisha_new'] = "Новые события";
$L['afisha_vip'] = "VIP события";

$Ls['afisha'] = "событие,события,событий";
$Ls['unvalidated_afisha'] = "неутвержденное событие,неутвержденные события,неутвержденных событий";
$Ls['event_in_drafts'] = "событие в черновиках,события в черновиках,событий в черновиках";

$L['event_submitnewevent'] = 'Добавить событие';

// Параметры поиск событий
$L['plu_afisha_set_sec'] = 'Разделы';
$L['plu_afisha_res_sort1'] = 'Дате публикации';
$L['plu_afisha_res_sort2'] = 'Заголовку';
$L['plu_afisha_res_sort3'] = 'Популярности';
$L['plu_afisha_res_sort3'] = 'Категории';
$L['plu_afisha_search_names'] = 'Поиск в названиях';
$L['plu_afisha_search_desc'] = 'Поиск в кратком описании';
$L['plu_afisha_search_text'] = 'Поиск в описании';
$L['plu_afisha_set_subsec'] = 'Поиск в подразделах';
