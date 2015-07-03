<?php
/**
 * English Language File for the Vacancies Module (vacancies.en.lang.php)
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

$L['cfg_autovalidatevac'] = 'Autovalidate vac';
$L['cfg_autovalidatevac_hint'] = 'Autovalidate vac if poster has admin rights for vac category';
$L['cfg_count_admin'] = 'Count Administrators\' hits';
$L['cfg_count_admin_hint'] = '';
$L['cfg_maxlistsperpage'] = 'Max. lists per vac';
$L['cfg_maxlistsperpage_hint'] = ' ';
$L['cfg_order'] = 'Sorting column';
$L['cfg_title_vac'] = 'Vacancy title tag format';
$L['cfg_title_vac_hint'] = 'Options: {TITLE}, {CATEGORY}';
$L['cfg_way'] = 'Sorting direction';
$L['cfg_truncatevactext'] = 'Set truncated vac text length in list';
$L['cfg_truncatevactext_hint'] = 'Zero to disable this feature';
$L['cfg_allowemptyvactext'] = 'Allow empty vac text';
$L['cfg_keywords'] = 'Keywords';

$L['info_desc'] = 'Enables website content through vac and vac categories';

/**
 * Structure Confing
 */

$L['cfg_order_params'] = array(); // Redefined in cot_vac_config_order()
$L['cfg_way_params'] = array($L['Ascending'], $L['Descending']);

/**
 * Admin Vacancy Section
 */

$L['adm_queue_deleted'] = 'Vacancy was deleted in to the trash can';
$L['adm_valqueue'] = 'Waiting for validation';
$L['adm_validated'] = 'Already validated';
$L['adm_expired'] = 'Expired';
$L['adm_structure'] = 'Structure of the vacancies (categories)';
$L['adm_sort'] = 'Sort';
$L['adm_sortingorder'] = 'Set a default sorting order for the categories';
$L['adm_showall'] = 'Show all';
$L['adm_help_vac'] = 'The vacancy that belong to the category &quot;system&quot; are not displayed in the public listings, it\'s to make standalone vac.';

/**
 * Vacancy add and edit
 */

$L['vac_addtitle'] = 'Submit new vacancy';
$L['vac_addsubtitle'] = 'Fill out all required fields and hit "Sumbit" to continue';
$L['vac_edittitle'] = 'Vacancy properties';
$L['vac_editsubtitle'] = 'Edit all required fields and hit "Sumbit" to continue';

$L['vac_aliascharacters'] = 'Characters \'+\', \'/\', \'?\', \'%\', \'#\', \'&\' are not allowed in aliases';
$L['vac_catmissing'] = 'The category code is missing';
$L['vac_clone'] = 'Clone vacancy';
$L['vac_confirm_delete'] = 'Do you really want to delete this vacancy?';
$L['vac_confirm_validate'] = 'Do you want to validate this vacancy?';
$L['vac_confirm_unvalidate'] = 'Do you really want to put this vacancy back to the validation queue?';
$L['vac_drafts'] = 'Drafts';
$L['vac_drafts_desc'] = 'Vacancy saved in your drafts';
$L['vac_notavailable'] = 'This vacancy will be published in ';
$L['vac_titletooshort'] = 'The vacancy title is too short or missing';
$L['vac_validation'] = 'Awaiting validation';
$L['vac_validation_desc'] = 'Your vacancy which have not been validated by administrator yet';

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

$L['vac_metakeywords'] = 'Meta keywords';
$L['vac_metatitle'] = 'Meta title';
$L['vac_metadesc'] = 'Meta description';

$L['vac_formhint'] = 'Once your submission is done, the vac will be placed in the validation queue and will be hidden, awaiting confirmation from a site administrator or global moderator before being displayed in the right section. Check all fields carefully. If you need to change something, you will be able to do that later. But submitting changes puts a vac into validation queue again.';

$L['vac_vacid'] = 'Vacancy ID';
$L['vac_deletevac'] = 'Delete this vac';

$L['vac_savedasdraft'] = 'Vacancy saved as draft.';

/**
 * Vacancy statuses
 */

$L['vac_status_draft'] = 'Draft';
$L['vac_status_pending'] = 'Pending';
$L['vac_status_approved'] = 'Approved';
$L['vac_status_published'] = 'Published';

/**
 * Moved from theme.lang
 */

$L['vac_linesperpage'] = 'Lines per page';
$L['vac_linesinthissection'] = 'Lines in this section';

$L['Vacancies'] = "Vacancies";
$L['vacancies_catalog'] = "Catalog";
$L['vacancies_new'] = "New vacancies";
$L['vacancies_vip'] = "VIP-vacancies";

$Ls['vac'] = "vacancy,vacancy";
$Ls['unvalidated_vac'] = "unvalidated vacancy,unvalidated vacancy";
$Ls['vac_in_drafts'] = "vacancy in drafts,vacancy in drafts";

$L['vac_submitnewvac'] = 'Add vacancy';


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