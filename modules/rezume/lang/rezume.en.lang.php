<?php
/**
 * English Language File for the rezume Module (rezume.en.lang.php)
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

$L['cfg_autovalidaterez'] = 'Autovalidate rezume';
$L['cfg_autovalidaterez_hint'] = 'Autovalidate rezume if poster has admin rights for rezume category';
$L['cfg_count_admin'] = 'Count Administrators\' hits';
$L['cfg_count_admin_hint'] = '';
$L['cfg_maxlistsperpage'] = 'Max. lists per rezume';
$L['cfg_maxlistsperpage_hint'] = ' ';
$L['cfg_order'] = 'Sorting column';
$L['cfg_title_rez'] = 'rezume title tag format';
$L['cfg_title_rez_hint'] = 'Options: {TITLE}, {CATEGORY}';
$L['cfg_way'] = 'Sorting direction';
$L['cfg_truncatereztext'] = 'Set truncated rezume text length in list';
$L['cfg_truncatereztext_hint'] = 'Zero to disable this feature';
$L['cfg_allowemptyreztext'] = 'Allow empty rezume text';
$L['cfg_keywords'] = 'Keywords';

$L['info_desc'] = 'Enables website content through rezume and rezume categories';

/**
 * Structure Confing
 */

$L['cfg_order_params'] = array(); // Redefined in cot_rez_config_order()
$L['cfg_way_params'] = array($L['Ascending'], $L['Descending']);

/**
 * Admin rezume Section
 */

$L['adm_queue_deleted'] = 'rezume was deleted in to the trash can';
$L['adm_valqueue'] = 'Waiting for validation';
$L['adm_validated'] = 'Already validated';
$L['adm_expired'] = 'Expired';
$L['adm_structure'] = 'Structure of the rezume (categories)';
$L['adm_sort'] = 'Sort';
$L['adm_sortingorder'] = 'Set a default sorting order for the categories';
$L['adm_showall'] = 'Show all';
$L['adm_help_rez'] = 'The rezume that belong to the category &quot;system&quot; are not displayed in the public listings, it\'s to make standalone rezume.';

/**
 * rezume add and edit
 */

$L['rez_addtitle'] = 'Submit new rezume';
$L['rez_addsubtitle'] = 'Fill out all required fields and hit "Sumbit" to continue';
$L['rez_edittitle'] = 'rezume properties';
$L['rez_editsubtitle'] = 'Edit all required fields and hit "Sumbit" to continue';

$L['rez_aliascharacters'] = 'Characters \'+\', \'/\', \'?\', \'%\', \'#\', \'&\' are not allowed in aliases';
$L['rez_catmissing'] = 'The category code is missing';
$L['rez_clone'] = 'Clone rezume';
$L['rez_confirm_delete'] = 'Do you really want to delete this rezume?';
$L['rez_confirm_validate'] = 'Do you want to validate this rezume?';
$L['rez_confirm_unvalidate'] = 'Do you really want to put this rezume back to the validation queue?';
$L['rez_drafts'] = 'Drafts';
$L['rez_drafts_desc'] = 'rezume saved in your drafts';
$L['rez_notavailable'] = 'This rezume will be published in ';
$L['rez_titletooshort'] = 'The rezume title is too short or missing';
$L['rez_validation'] = 'Awaiting validation';
$L['rez_validation_desc'] = 'Your rezume which have not been validated by administrator yet';

$L['rez_error_quamissing'] = 'Не указаны знания и навыки';
$L['rez_error_salarymissing'] = 'Не указан желаемый размер зарплаты';
$L['rez_error_agemissing'] = 'Не указан возраст';
$L['rez_error_expmissing'] = 'Не указан опыт работы';
$L['rez_error_studymissing'] = 'Не указаны учебные заведения';
$L['rez_error_fiomissing'] = 'Не указано ваше Имя и Фамилия';

$L['rez_fio'] = 'Фамилия Имя Отчество';
$L['rez_title'] = 'Название должности';
$L['rez_salary'] = 'Ожидаемая зарплата';
$L['rez_age'] = 'Возраст';
$L['rez_sex'] = 'Пол';
$L['rez_edu'] = 'Образование';
$L['rez_exp'] = 'Опыт работы';
$L['rez_qua'] = 'Знания и навыки';

$L['rez_years'] = 'лет';

$L['rez_metakeywords'] = 'Meta keywords';
$L['rez_metatitle'] = 'Meta title';
$L['rez_metadesc'] = 'Meta description';

$L['rez_formhint'] = 'Once your submission is done, the rezume will be placed in the validation queue and will be hidden, awaiting confirmation from a site administrator or global moderator before being displayed in the right section. Check all fields carefully. If you need to change something, you will be able to do that later. But submitting changes puts a rez into validation queue again.';

$L['rez_rezid'] = 'rezume ID';
$L['rez_deleterez'] = 'Delete this rezume';

$L['rez_savedasdraft'] = 'rezume saved as draft.';

/**
 * rezume statuses
 */

$L['rez_status_draft'] = 'Draft';
$L['rez_status_pending'] = 'Pending';
$L['rez_status_approved'] = 'Approved';
$L['rez_status_published'] = 'Published';

/**
 * Moved from theme.lang
 */

$L['rez_linesperpage'] = 'Lines per page';
$L['rez_linesinthissection'] = 'Lines in this section';

$L['Rezume'] = "rezume";
$L['rezume_catalog'] = "Catalog";
$L['rezume_new'] = "New rezume";

$Ls['rez'] = "rezume,rezume";
$Ls['unvalidated_rez'] = "unvalidated rezume,unvalidated rezume";
$Ls['rez_in_drafts'] = "rezume in drafts,rezume in drafts";

$L['rez_submitnewrez'] = 'Add rezume';


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
$L['rez_contact_msg_body'] = "Здравствуйте %1\$s.\n\nВам отправлено сообщение по вашей вакансии \"%2\$s\":\n\nОтправитель: %3\$s\nE-mail: %4\$s\nТелефон: %5\$s\n\nТекст сообщения: %6\$s\n";


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
$L['plu_rez_search_desc'] = 'Поиск в кратком описании';
$L['plu_rez_set_subsec'] = 'Поиск в подразделах';