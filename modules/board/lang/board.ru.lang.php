<?php
/**
 * Russian Language File for the Board Module (board.ru.lang.php)
 *
 * @package board
 * @version 0.9.6
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */

$L['cfg_autovalidateadv'] = 'Автоматическое утверждение объявлений';
$L['cfg_autovalidateadv_hint'] = 'Автоматически утверждать публикацию объявлений, созданных пользователем с правом администрирования раздела';
$L['cfg_count_admin'] = 'Считать посещения администраторов';
$L['cfg_count_admin_hint'] = 'Включить посещения администраторов в статистику посещаемости сайта';
$L['cfg_maxlistsperpage'] = 'Макс. количество категорий на странице';
$L['cfg_maxlistsperpage_hint'] = ' ';
$L['cfg_order'] = 'Поле сортировки';
$L['cfg_title_board'] = 'Формат заголовка объявлении';
$L['cfg_title_adv_hint'] = 'Опции: {TITLE}, {CATEGORY}';
$L['cfg_way'] = 'Направление сортировки';
$L['cfg_truncateadvtext'] = 'Ограничить размер текста в списках объявлений';
$L['cfg_truncateadvtext_hint'] = '0 для отключения';
$L['cfg_allowemptyadvtext'] = 'Разрешить пустой текст объявления';
$L['cfg_keywords'] = 'Ключевые слова';

$L['info_desc'] = 'Управление контентом: объявления и категории объявлений';

/**
 * Structure Confing
 */

$L['cfg_order_params'] = array(); // Redefined in cot_board_config_order()
$L['cfg_way_params'] = array($L['Ascending'], $L['Descending']);

/**
 * Admin Adv Section
 */

$L['adm_queue_deleted'] = 'Объявление удалено в корзину';
$L['adm_valqueue'] = 'В очереди на утверждение';
$L['adm_validated'] = 'Утвержденные';
$L['adm_expired'] = 'Просроченные';
$L['adm_structure'] = 'Структура (категории)';
$L['adm_sort'] = 'Сортировать';
$L['adm_sortingorder'] = 'Порядок сортировки по умолчанию в категории';
$L['adm_showall'] = 'Показать все';
$L['adm_help_adv'] = '';

/**
 * Adv add and edit
 */

$L['adv_addtitle'] = 'Создать объявление';
$L['adv_addsubtitle'] = 'Заполните необходимые поля и нажмите "Отправить" для продолжения';
$L['adv_edittitle'] = 'Информация об объявлении';
$L['adv_editsubtitle'] = 'Измените необходимые поля и нажмите "Отправить" для продолжения';

$L['adv_aliascharacters'] = 'Недопустимо использование символов \'+\', \'/\', \'?\', \'%\', \'#\', \'&\' в алиасах';
$L['adv_catmissing'] = 'Код категории отсутствует';
$L['adv_clone'] = 'Клонировать объявление';
$L['adv_conboard_delete'] = 'Вы действительно хотите удалить это объявление?';
$L['adv_conboard_validate'] = 'Хотите утвердить это объявление?';
$L['adv_conboard_unvalidate'] = 'Вы действительно хотите отправить это объявление в очередь на утверждение?';
$L['adv_drafts'] = 'Черновики';
$L['adv_drafts_desc'] = 'Объявления, сохраненные в ваших черновиках';
$L['adv_notavailable'] = 'Объявление будет опубликовано через';
$L['adv_textmissing'] = 'Текст объявления не должен быть пустым';
$L['adv_titletooshort'] = 'Заголовок объявления слишком короткий либо отсутствует';
$L['adv_validation'] = 'Ожидают утверждения';
$L['adv_validation_desc'] = 'Ваши объявления, которые еще не утверждены администратором';

$L['adv_title'] = 'Заголовок объявления';
$L['adv_desc'] = 'Краткое описание';

$L['adv_metakeywords'] = 'Ключевые слова';
$L['adv_metatitle'] = 'Meta-заголовок';
$L['adv_metadesc'] = 'Meta-описание';

$L['adv_cost'] = 'Цена';

$L['adv_formhint'] = 'После заполнения формы объявление будет помещено в очередь на утверждение и будет скрыто до тех пор, пока модератор или администратор не утвердят его публикацию в соответствующем разделе. Внимательно проверьте правильность заполнения полей формы. Если вам понадобится изменить содержание объявления, то вы сможете сделать это позже, но объявление вновь будет отправлена на утверждение.';

$L['adv_advid'] = 'ID объявления';
$L['adv_deleteboard'] = 'Удалить объявление';

$L['adv_savedasdraft'] = 'Объявление сохранено в черновиках';

/**
 * Adv statuses
 */

$L['adv_status_draft'] = 'Черновик';
$L['adv_status_pending'] = 'На рассмотрении';
$L['adv_status_approved'] = 'Утверждено';
$L['adv_status_published'] = 'Опубликовано';
$L['adv_status_expired'] = 'Устарело';

/**
 * Moved from theme.lang
 */

$L['adv_linesperpage'] = 'Записей на страницу';
$L['adv_linesinthissection'] = 'Записей в разделе';

$L['Board'] = "Объявления";
$L['board_catalog'] = "Каталог объявлений";
$L['board_new'] = "Новые объявления";
$L['board_vip'] = "VIP объявления";

$Ls['board'] = "объявление,объявления,объявлений";
$Ls['unvalidated_board'] = "неутвержденное объявление,неутвержденные объявления,неутвержденных объявлений";
$Ls['adv_in_drafts'] = "объявление в черновиках,объявления в черновиках,объявлений в черновиках";

$L['adv_submitnewadv'] = 'Добавить объявление';


$L['adv_addr'] = 'Адрес';
$L['adv_phone'] = 'Телефоны';
$L['adv_skype'] = 'Skype';
$L['adv_site'] = 'Сайт';
$L['adv_email'] = 'E-mail';
$L['adv_hidemail'] = 'Показывать email всем';
$L['adv_sendmsg'] = 'Отправить сообщение';

$L['adv_contact_name'] = 'Ваше имя';
$L['adv_contact_email'] = 'E-mail';
$L['adv_contact_phone'] = 'Телефон';
$L['adv_contact_msg'] = 'Текст сообщения';

$L['adv_contact_error_name'] = 'Не указано ваше имя';
$L['adv_contact_error_phoneoremail'] = 'Не указан телефон или email';
$L['adv_contact_error_text'] = 'Текст сообщения не должен быть пустым';

$L['adv_contact_msg_subject'] = 'Вам сообщение';
$L['adv_contact_msg_body'] = "Здравствуйте %1\$s.\n\nВам отправлено сообщение по вашему объявлению \"%2\$s\":\n\nОтправитель: %3\$s\nE-mail: %4\$s\nТелефон: %5\$s\n\nТекст сообщения: %6\$s\n";

// Параметры поиск объявлений
$L['plu_board_set_sec'] = 'Разделы';
$L['plu_board_res_sort1'] = 'Дате публикации';
$L['plu_board_res_sort2'] = 'Заголовку';
$L['plu_board_res_sort3'] = 'Популярности';
$L['plu_board_res_sort3'] = 'Категории';
$L['plu_board_search_names'] = 'Поиск в названиях';
$L['plu_board_search_desc'] = 'Поиск в кратком описании';
$L['plu_board_search_text'] = 'Поиск в описании';
$L['plu_board_set_subsec'] = 'Поиск в подразделах';

$L['adv_error_emptyphone'] = 'Не указан телефон';
$L['adv_error_wrongcost'] = 'Ошибочная цена';