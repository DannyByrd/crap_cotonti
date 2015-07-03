<?php
/**
 * Russian Language File for the Firm Module (firms.ru.lang.php)
 *
 * @package firms
 * @version 0.9.6
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */

$L['cfg_autovalidatefirm'] = 'Автоматическое утверждение организаций';
$L['cfg_autovalidatefirm_hint'] = 'Автоматически утверждать публикацию организаций, созданных пользователем с правом администрирования раздела';
$L['cfg_count_admin'] = 'Считать посещения администраторов';
$L['cfg_count_admin_hint'] = 'Включить посещения администраторов в статистику посещаемости сайта';
$L['cfg_maxlistsperfirme'] = 'Макс. количество категорий на странице';
$L['cfg_maxlistsperfirme_hint'] = ' ';
$L['cfg_order'] = 'Поле сортировки';
$L['cfg_title_firms'] = 'Формат заголовка организации';
$L['cfg_title_firm_hint'] = 'Опции: {TITLE}, {CATEGORY}';
$L['cfg_way'] = 'Направление сортировки';
$L['cfg_truncatefirmtext'] = 'Ограничить размер текста в списках организаций';
$L['cfg_truncatefirmtext_hint'] = '0 для отключения';
$L['cfg_allowemptyfirmtext'] = 'Разрешить пустой текст об организации';
$L['cfg_keywords'] = 'Ключевые слова';

$L['info_desc'] = 'Управление контентом: организации и категории организаций';

/**
 * Structure Confing
 */

$L['cfg_order_params'] = array(); // Redefined in cot_firms_config_order()
$L['cfg_way_params'] = array($L['Ascending'], $L['Descending']);

/**
 * Admin Firm Section
 */

$L['adm_queue_deleted'] = 'Организация удалена в корзину';
$L['adm_valqueue'] = 'В очереди на утверждение';
$L['adm_validated'] = 'Утвержденные';
$L['adm_structure'] = 'Структура (категории)';
$L['adm_sort'] = 'Сортировать';
$L['adm_sortingorder'] = 'Порядок сортировки по умолчанию в категории';
$L['adm_showall'] = 'Показать все';

/**
 * Firm add and edit
 */

$L['firm_addtitle'] = 'Создать организацию';
$L['firm_addsubtitle'] = 'Заполните необходимые поля и нажмите "Отправить" для продолжения';
$L['firm_edittitle'] = 'Информация об организации';
$L['firm_editsubtitle'] = 'Измените необходимые поля и нажмите "Отправить" для продолжения';

$L['firm_aliascharacters'] = 'Недопустимо использование символов \'+\', \'/\', \'?\', \'%\', \'#\', \'&\' в алиасах';
$L['firm_catmissing'] = 'Код категории отсутствует';
$L['firm_clone'] = 'Клонировать организацию';
$L['firm_confirm_delete'] = 'Вы действительно хотите удалить эту организацию?';
$L['firm_confirm_validate'] = 'Хотите утвердить эту организацию?';
$L['firm_confirm_unvalidate'] = 'Вы действительно хотите отправить эту организацию в очередь на утверждение?';
$L['firm_drafts'] = 'Черновики';
$L['firm_drafts_desc'] = 'Организации, сохраненные в ваших черновиках';
$L['firm_notavailable'] = 'Организация будет опубликована через';
$L['firm_textmissing'] = 'Текст об организации не должен быть пустым';
$L['firm_titletooshort'] = 'Название организации слишком короткое либо отсутствует';
$L['firm_validation'] = 'Ожидают утверждения';
$L['firm_validation_desc'] = 'Ваши организации, которые еще не утверждены администратором';

$L['firm_title'] = 'Название организации';
$L['firm_desc'] = 'Краткое описание';
$L['firm_logo'] = 'Логотип';

$L['firm_metakeywords'] = 'Ключевые слова';
$L['firm_metatitle'] = 'Meta-заголовок';
$L['firm_metadesc'] = 'Meta-описание';

$L['firm_formhint'] = 'После заполнения формы организация будет помещена в очередь на утверждение и будет скрыта до тех пор, пока модератор или администратор не утвердят ее публикацию в соответствующем разделе. Внимательно проверьте правильность заполнения полей формы. Если вам понадобится изменить содержание организации, то вы сможете сделать это позже, но организация вновь будет отправлена на утверждение.';

$L['firm_firmsid'] = 'ID организации';
$L['firm_deletefirms'] = 'Удалить организацию';

$L['firm_savedasdraft'] = 'Организация сохранена в черновиках';

/**
 * Firm statuses
 */

$L['firm_status_draft'] = 'Черновик';
$L['firm_status_pending'] = 'На рассмотрении';
$L['firm_status_approved'] = 'Утверждена';
$L['firm_status_published'] = 'Опубликована';

$L['firm_logo_notvalid'] = 'Загружаемый файл не является изображением';
/**
 * Moved from theme.lang
 */

$L['firm_linesperfirm'] = 'Записей на организацию';
$L['firm_linesinthissection'] = 'Записей в разделе';

$L['Firms'] = "Организации";
$L['firm_catalog'] = "Каталог организаций";
$L['firm_new'] = "Новые организации";

$Ls['firms'] = "организация,организации,организаций";
$Ls['unvalidated_firms'] = "неутвержденная организация,неутвержденные организации,неутвержденных организаций";
$Ls['firm_in_drafts'] = "организация в черновиках,организации в черновиках,организаций в черновиках";

$L['firm_submitnewfirm'] = 'Добавить организацию';


$L['firm_addr'] = 'Адрес';
$L['firm_phone'] = 'Телефоны';
$L['firm_skype'] = 'Skype';
$L['firm_site'] = 'Сайт';
$L['firm_email'] = 'E-mail';


// Параметры поиск фирм.
$L['plu_firm_set_sec'] = 'Разделы';
$L['plu_firm_res_sort1'] = 'Дате публикации';
$L['plu_firm_res_sort2'] = 'Названию';
$L['plu_firm_res_sort3'] = 'Популярности';
$L['plu_firm_res_sort3'] = 'Категории';
$L['plu_firm_search_names'] = 'Поиск в названиях';
$L['plu_firm_search_desc'] = 'Поиск в кратком описании';
$L['plu_firm_search_text'] = 'Поиск в описании';
$L['plu_firm_set_subsec'] = 'Поиск в подразделах';