<?php
/**
 * Russian Language File for the Vacancies Module (vacancies.ru.lang.php)
 *
 * @package vacancies
 * @version 0.9.6
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */

$L['cfg_autovalidatevac'] = 'Автоматическое утверждение вакансий';
$L['cfg_autovalidatevac_hint'] = 'Автоматически утверждать публикацию вакансий, созданных пользователем с правом администрирования раздела';
$L['cfg_count_admin'] = 'Считать посещения администраторов';
$L['cfg_count_admin_hint'] = 'Включить посещения администраторов в статистику посещаемости сайта';
$L['cfg_maxlistsperpage'] = 'Макс. количество категорий на странице';
$L['cfg_maxlistsperpage_hint'] = ' ';
$L['cfg_order'] = 'Поле сортировки';
$L['cfg_title_vacancies'] = 'Формат заголовка вакансии';
$L['cfg_title_vac_hint'] = 'Опции: {TITLE}, {CATEGORY}';
$L['cfg_way'] = 'Направление сортировки';
$L['cfg_truncatevactext'] = 'Ограничить размер текста в списках вакансий';
$L['cfg_truncatevactext_hint'] = '0 для отключения';
$L['cfg_allowemptyvactext'] = 'Разрешить пустой текст вакансии';
$L['cfg_keywords'] = 'Ключевые слова';

$L['info_desc'] = 'Вакансии и категории вакансий';

/**
 * Structure Confing
 */

$L['cfg_order_params'] = array(); // Redefined in cot_vacancies_config_order()
$L['cfg_way_params'] = array($L['Ascending'], $L['Descending']);

/**
 * Admin Adv Section
 */

$L['adm_queue_deleted'] = 'Вакансия удалено в корзину';
$L['adm_valqueue'] = 'В очереди на утверждение';
$L['adm_validated'] = 'Утвержденные';
$L['adm_expired'] = 'Устаревшие';
$L['adm_structure'] = 'Структура (категории)';
$L['adm_sort'] = 'Сортировать';
$L['adm_sortingorder'] = 'Порядок сортировки по умолчанию в категории';
$L['adm_showall'] = 'Показать все';
$L['adm_help_vac'] = '';

/**
 * Adv add and edit
 */

$L['vac_addtitle'] = 'Создать вакансию';
$L['vac_addsubtitle'] = 'Заполните необходимые поля и нажмите "Отправить" для продолжения';
$L['vac_edittitle'] = 'Информация о вакансии';
$L['vac_editsubtitle'] = 'Измените необходимые поля и нажмите "Отправить" для продолжения';

$L['vac_aliascharacters'] = 'Недопустимо использование символов \'+\', \'/\', \'?\', \'%\', \'#\', \'&\' в алиасах';
$L['vac_catmissing'] = 'Код категории отсутствует';
$L['vac_clone'] = 'Клонировать вакансию';
$L['vac_confirm_delete'] = 'Вы действительно хотите удалить эту вакансию?';
$L['vac_confirm_validate'] = 'Хотите утвердить эту вакансию?';
$L['vac_confirm_unvalidate'] = 'Вы действительно хотите отправить это вакансию в очередь на утверждение?';
$L['vac_drafts'] = 'Черновики';
$L['vac_drafts_desc'] = 'Вакансии, сохраненные в ваших черновиках';
$L['vac_notavailable'] = 'Вакансия будет опубликована через';
$L['vac_titletooshort'] = 'Название вакансии слишком короткое либо отсутствует';
$L['vac_validation'] = 'Ожидают утверждения';
$L['vac_validation_desc'] = 'Ваши вакансии, которые еще не утверждены администратором';

$L['vac_error_dutymissing'] = 'Не указаны обязанности соискателя';
$L['vac_error_termmissing'] = 'Не указаны условия работы';
$L['vac_error_quamissing'] = 'Не указаны требования';
$L['vac_error_salarymissing'] = 'Не указан размер зарплаты';
$L['vac_error_salaryminmax'] = 'Не правильно указан размер зарплаты';
$L['vac_error_agemissing'] = 'Не указан желаемый возраст соискателя';
$L['vac_error_ageminmax'] = 'Не правильно указан желаемый возраст соискателя';
$L['vac_error_expmissing'] = 'Не указан желаемый опыт работы';
$L['vac_error_expminmax'] = 'Не правильно указан желаемый опыт работы';

$L['vac_title'] = 'Название должности';
$L['vac_desc'] = 'Краткое описание';
$L['vac_salary'] = 'Зарплата';
$L['vac_emp'] = 'Занятость';
$L['vac_schedule'] = 'График работы';
$L['vac_duty'] = 'Обязанности';
$L['vac_term'] = 'Условия работы';
$L['vac_age'] = 'Возраст';
$L['vac_sex'] = 'Пол';
$L['vac_edu'] = 'Образование';
$L['vac_exp'] = 'Опыт работы';
$L['vac_qua'] = 'Требования к квалификации, знания и навыки';

$L['vac_ot'] = 'от';
$L['vac_do'] = 'до';
$L['vac_years'] = 'лет';

$L['vac_metakeywords'] = 'Ключевые слова';
$L['vac_metatitle'] = 'Meta-заголовок';
$L['vac_metadesc'] = 'Meta-описание';

$L['vac_formhint'] = 'После заполнения формы вакансия будет помещена в очередь на утверждение и будет скрыта до тех пор, пока модератор или администратор не утвердят ее публикацию в соответствующем разделе. Внимательно проверьте правильность заполнения полей формы. Если вам понадобится изменить содержание вакансии, то вы сможете сделать это позже, но вакансия вновь будет отправлена на утверждение.';

$L['vac_vacid'] = 'ID вакансии';
$L['vac_deletevacancies'] = 'Удалить вакансию';

$L['vac_savedasdraft'] = 'Вакансия сохранена в черновиках';

/**
 * Adv statuses
 */

$L['vac_status_draft'] = 'Черновик';
$L['vac_status_pending'] = 'На рассмотрении';
$L['vac_status_approved'] = 'Утверждена';
$L['vac_status_published'] = 'Опубликована';

/**
 * Moved from theme.lang
 */

$L['vac_linesperpage'] = 'Записей на страницу';
$L['vac_linesinthissection'] = 'Записей в разделе';

$L['Vacancies'] = "Вакансии";
$L['vacancies_catalog'] = "Каталог вакансий";
$L['vacancies_new'] = "Новые вакансии";
$L['vacancies_vip'] = "VIP-вакансии";

$Ls['vacancies'] = "вакансия,вакансии,вакансий";
$Ls['unvalidated_vacancies'] = "неутвержденная вакансия,неутвержденные вакансии,неутвержденных вакансий";
$Ls['vac_in_drafts'] = "вакансия в черновиках,вакансии в черновиках,вакансий в черновиках";

$L['vac_submitnewvac'] = 'Добавить вакансию';


$L['vac_addr'] = 'Адрес';
$L['vac_phone'] = 'Телефоны';
$L['vac_skype'] = 'Skype';
$L['vac_site'] = 'Сайт';
$L['vac_email'] = 'E-mail';
$L['vac_hidemail'] = 'Показывать email всем';
$L['vac_sendmsg'] = 'Отправить сообщение';

$L['vac_contact_name'] = 'Ваше имя';
$L['vac_contact_email'] = 'E-mail';
$L['vac_contact_phone'] = 'Телефон';
$L['vac_contact_msg'] = 'Текст сообщения';

$L['vac_contact_error_name'] = 'Не указано ваше имя';
$L['vac_contact_error_phoneoremail'] = 'Не указан телефон или email';
$L['vac_contact_error_text'] = 'Текст сообщения не должен быть пустым';

$L['vac_contact_msg_subject'] = 'Вам сообщение';
$L['vac_contact_msg_body'] = "Здравствуйте %1\$s.\n\nВам отправлено сообщение по вашей вакансии \"%2\$s\":\n\nОтправитель: %3\$s\nE-mail: %4\$s\nТелефон: %5\$s\n\nТекст сообщения: %6\$s\n";


$cot_educations = array(
	'1' => 'Начальное общее',
	'2' => 'Среднее специальное',
	'3' => 'Неоконченное высшее',
	'4' => 'Высшее'
);

$L['vac_rc_minmax_full_default'] = 'от {$min} до {$max}';
$L['vac_rc_minmax_min_default'] = 'от {$min}';
$L['vac_rc_minmax_max_default'] = 'до {$max}';
$L['vac_rc_minmax_equ_default'] = '{$max}';
$L['vac_rc_minmax_empty_default'] = 'не указано';


// Параметры поиск объявлений
$L['plu_vac_set_sec'] = 'Разделы';
$L['plu_vac_res_sort1'] = 'Дате публикации';
$L['plu_vac_res_sort2'] = 'Заголовку';
$L['plu_vac_res_sort3'] = 'Популярности';
$L['plu_vac_res_sort3'] = 'Категории';
$L['plu_vac_search_names'] = 'Поиск в названиях';
$L['plu_vac_search_desc'] = 'Поиск в кратком описании';
$L['plu_vac_search_text'] = 'Поиск в описании';
$L['plu_vac_set_subsec'] = 'Поиск в подразделах';