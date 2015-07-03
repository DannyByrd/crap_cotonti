<?php
/**
 * Russian Language File for the rezume Module (rezume.ru.lang.php)
 *
 * @package rezume
 * @version 0.9.6
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */

$L['cfg_autovalidaterez'] = 'Автоматическое утверждение резюме';
$L['cfg_autovalidaterez_hint'] = 'Автоматически утверждать публикацию резюме, созданных пользователем с правом администрирования раздела';
$L['cfg_count_admin'] = 'Считать посещения администраторов';
$L['cfg_count_admin_hint'] = 'Включить посещения администраторов в статистику посещаемости сайта';
$L['cfg_maxlistsperpage'] = 'Макс. количество категорий на странице';
$L['cfg_maxlistsperpage_hint'] = ' ';
$L['cfg_order'] = 'Поле сортировки';
$L['cfg_title_rezume'] = 'Формат заголовка резюме';
$L['cfg_title_rez_hint'] = 'Опции: {TITLE}, {CATEGORY}';
$L['cfg_way'] = 'Направление сортировки';
$L['cfg_truncatereztext'] = 'Ограничить размер текста в списках резюме';
$L['cfg_truncatereztext_hint'] = '0 для отключения';
$L['cfg_allowemptyreztext'] = 'Разрешить пустой текст резюме';
$L['cfg_keywords'] = 'Ключевые слова';

$L['info_desc'] = 'Модуль для размещения резюме';

/**
 * Structure Confing
 */

$L['cfg_order_params'] = array(); // Redefined in cot_rezume_config_order()
$L['cfg_way_params'] = array($L['Ascending'], $L['Descending']);

/**
 * Admin Adv Section
 */

$L['adm_queue_deleted'] = 'Резюме удалено в корзину';
$L['adm_valqueue'] = 'В очереди на утверждение';
$L['adm_validated'] = 'Утвержденные';
$L['adm_expired'] = 'Устаревшие';
$L['adm_structure'] = 'Структура (категории)';
$L['adm_sort'] = 'Сортировать';
$L['adm_sortingorder'] = 'Порядок сортировки по умолчанию в категории';
$L['adm_showall'] = 'Показать все';
$L['adm_help_rez'] = '';

/**
 * Adv add and edit
 */

$L['rez_addtitle'] = 'Создать резюме';
$L['rez_addsubtitle'] = 'Заполните необходимые поля и нажмите "Отправить" для продолжения';
$L['rez_edittitle'] = 'Информация о резюме';
$L['rez_editsubtitle'] = 'Измените необходимые поля и нажмите "Отправить" для продолжения';

$L['rez_aliascharacters'] = 'Недопустимо использование символов \'+\', \'/\', \'?\', \'%\', \'#\', \'&\' в алиасах';
$L['rez_catmissing'] = 'Код категории отсутствует';
$L['rez_clone'] = 'Клонировать резюме';
$L['rez_confirm_delete'] = 'Вы действительно хотите удалить это резюме?';
$L['rez_confirm_validate'] = 'Хотите утвердить это резюме?';
$L['rez_confirm_unvalidate'] = 'Вы действительно хотите отправить это резюме в очередь на утверждение?';
$L['rez_drafts'] = 'Черновики';
$L['rez_drafts_desc'] = 'Резюме, сохраненные в ваших черновиках';
$L['rez_notavailable'] = 'Резюме будет опубликована через';
$L['rez_titletooshort'] = 'Название резюме слишком короткое либо отсутствует';
$L['rez_validation'] = 'Ожидают утверждения';
$L['rez_validation_desc'] = 'Ваши резюме, которые еще не утверждены администратором';

$L['rez_error_quamissing'] = 'Не указаны знания и навыки';
$L['rez_error_salarymissing'] = 'Не указан желаемый размер зарплаты';
$L['rez_error_agemissing'] = 'Не указан возраст';
$L['rez_error_expmissing'] = 'Не указан опыт работы';
$L['rez_error_studymissing'] = 'Не указаны учебные заведения';
$L['rez_error_fiomissing'] = 'Не указано ваше Имя и Фамилия';

$L['rez_fio'] = 'Имя Фамилия';
$L['rez_title'] = 'Название должности';
$L['rez_salary'] = 'Ожидаемая зарплата';
$L['rez_age'] = 'Возраст';
$L['rez_sex'] = 'Пол';
$L['rez_edu'] = 'Образование';
$L['rez_study'] = 'Учебные заведения';
$L['rez_opyt'] = 'Опыт работы';
$L['rez_exp'] = 'Стаж';
$L['rez_works'] = 'Места работы';
$L['rez_qua'] = 'Знания и навыки';
$L['rez_contacts'] = 'Контактные данные';

$L['rez_years'] = 'лет';

$L['rez_metakeywords'] = 'Ключевые слова';
$L['rez_metatitle'] = 'Meta-заголовок';
$L['rez_metadesc'] = 'Meta-описание';

$L['rez_formhint'] = 'После заполнения формы резюме будет помещено в очередь на утверждение и будет скрыто до тех пор, пока модератор или администратор не утвердят ее публикацию в соответствующем разделе. Внимательно проверьте правильность заполнения полей формы. Если вам понадобится изменить содержание резюме, то вы сможете сделать это позже, но резюме вновь будет отправлена на утверждение.';

$L['rez_rezid'] = 'ID резюме';
$L['rez_deleterezume'] = 'Удалить резюме';

$L['rez_savedasdraft'] = 'Резюме сохранено в черновиках';

/**
 * Adv statuses
 */

$L['rez_status_draft'] = 'Черновик';
$L['rez_status_pending'] = 'На рассмотрении';
$L['rez_status_approved'] = 'Утверждена';
$L['rez_status_published'] = 'Опубликована';

/**
 * Moved from theme.lang
 */

$L['rez_linesperpage'] = 'Записей на страницу';
$L['rez_linesinthissection'] = 'Записей в разделе';

$L['Rezume'] = "Резюме";
$L['rezume_catalog'] = "Каталог резюме";
$L['rezume_new'] = "Новые резюме";

$Ls['rezume'] = "резюме,резюме,резюме";
$Ls['unvalidated_rezume'] = "неутвержденное резюме,неутвержденные резюме,неутвержденных резюме";
$Ls['rez_in_drafts'] = "резюме в черновиках,резюме в черновиках,резюме в черновиках";

$L['rez_submitnewrez'] = 'Добавить резюме';


$L['rez_addr'] = 'Адрес';
$L['rez_phone'] = 'Телефоны';
$L['rez_skype'] = 'Skype';
$L['rez_site'] = 'Сайт';
$L['rez_email'] = 'E-mail';
$L['rez_hidemail'] = 'Показывать email всем';
$L['rez_sendmsg'] = 'Отправить сообщение';

$L['rez_contact_name'] = 'Ваше имя';
$L['rez_contact_email'] = 'E-mail';
$L['rez_contact_phone'] = 'Телефон';
$L['rez_contact_msg'] = 'Текст сообщения';

$L['rez_contact_error_name'] = 'Не указано ваше имя';
$L['rez_contact_error_phoneoremail'] = 'Не указан телефон или email';
$L['rez_contact_error_text'] = 'Текст сообщения не должен быть пустым';

$L['rez_contact_msg_subject'] = 'Вам сообщение';
$L['rez_contact_msg_body'] = "Здравствуйте %1\$s.\n\nВам отправлено сообщение по вашему резюме \"%2\$s\":\n\nОтправитель: %3\$s\nE-mail: %4\$s\nТелефон: %5\$s\n\nТекст сообщения: %6\$s\n";


$cot_educations = array(
	'1' => 'Начальное общее',
	'2' => 'Среднее специальное',
	'3' => 'Неоконченное высшее',
	'4' => 'Высшее'
);


// Параметры поиск объявлений
$L['plu_rez_set_sec'] = 'Разделы';
$L['plu_rez_res_sort1'] = 'Дате публикации';
$L['plu_rez_res_sort2'] = 'Заголовку';
$L['plu_rez_res_sort3'] = 'Популярности';
$L['plu_rez_res_sort3'] = 'Категории';
$L['plu_rez_search_names'] = 'Поиск в названиях';
$L['plu_rez_search_works'] = 'Поиск в предыдущих местах работы';
$L['plu_rez_search_study'] = 'Поиск в местах учебы';
$L['plu_rez_search_qua'] = 'Поиск в навыках';
$L['plu_rez_set_subsec'] = 'Поиск в подразделах';