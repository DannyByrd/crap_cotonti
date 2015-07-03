<?php
/**
 * English Language File for the Board Module (board.en.lang.php)
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

$L['cfg_autovalidateadv'] = 'Autovalidate adv';
$L['cfg_autovalidateadv_hint'] = 'Autovalidate adv if poster has admin rights for adv category';
$L['cfg_count_admin'] = 'Count Administrators\' hits';
$L['cfg_count_admin_hint'] = '';
$L['cfg_maxlistsperpage'] = 'Max. lists per adv';
$L['cfg_maxlistsperpage_hint'] = ' ';
$L['cfg_order'] = 'Sorting column';
$L['cfg_title_adv'] = 'Adv title tag format';
$L['cfg_title_adv_hint'] = 'Options: {TITLE}, {CATEGORY}';
$L['cfg_way'] = 'Sorting direction';
$L['cfg_truncateadvtext'] = 'Set truncated adv text length in list';
$L['cfg_truncateadvtext_hint'] = 'Zero to disable this feature';
$L['cfg_allowemptyadvtext'] = 'Allow empty adv text';
$L['cfg_keywords'] = 'Keywords';

$L['info_desc'] = 'Enables website content through adv and adv categories';

/**
 * Structure Confing
 */

$L['cfg_order_params'] = array(); // Redefined in cot_adv_config_order()
$L['cfg_way_params'] = array($L['Ascending'], $L['Descending']);

/**
 * Admin Adv Section
 */

$L['adm_queue_deleted'] = 'Adv was deleted in to the trash can';
$L['adm_valqueue'] = 'Waiting for validation';
$L['adm_validated'] = 'Already validated';
$L['adm_expired'] = 'Expired';
$L['adm_structure'] = 'Structure of the adv (categories)';
$L['adm_sort'] = 'Sort';
$L['adm_sortingorder'] = 'Set a default sorting order for the categories';
$L['adm_showall'] = 'Show all';
$L['adm_help_adv'] = 'The adv that belong to the category &quot;system&quot; are not displayed in the public listings, it\'s to make standalone adv.';

/**
 * Adv add and edit
 */

$L['adv_addtitle'] = 'Submit new adv';
$L['adv_addsubtitle'] = 'Fill out all required fields and hit "Sumbit" to continue';
$L['adv_edittitle'] = 'Adv properties';
$L['adv_editsubtitle'] = 'Edit all required fields and hit "Sumbit" to continue';

$L['adv_aliascharacters'] = 'Characters \'+\', \'/\', \'?\', \'%\', \'#\', \'&\' are not allowed in aliases';
$L['adv_catmissing'] = 'The category code is missing';
$L['adv_clone'] = 'Clone adv';
$L['adv_confirm_delete'] = 'Do you really want to delete this adv?';
$L['adv_confirm_validate'] = 'Do you want to validate this adv?';
$L['adv_confirm_unvalidate'] = 'Do you really want to put this adv back to the validation queue?';
$L['adv_drafts'] = 'Drafts';
$L['adv_drafts_desc'] = 'Adv saved in your drafts';
$L['adv_notavailable'] = 'This adv will be published in ';
$L['adv_textmissing'] = 'The text about adv must not be empty';
$L['adv_titletooshort'] = 'The adv title is too short or missing';
$L['adv_validation'] = 'Awaiting validation';
$L['adv_validation_desc'] = 'Your adv which have not been validated by administrator yet';

$L['adv_title'] = 'Adv title';
$L['adv_desc'] = 'Short description';

$L['adv_metakeywords'] = 'Meta keywords';
$L['adv_metatitle'] = 'Meta title';
$L['adv_metadesc'] = 'Meta description';

$L['adv_cost'] = 'Цена';

$L['adv_formhint'] = 'Once your submission is done, the adv will be placed in the validation queue and will be hidden, awaiting confirmation from a site administrator or global moderator before being displayed in the right section. Check all fields carefully. If you need to change something, you will be able to do that later. But submitting changes puts a adv into validation queue again.';

$L['adv_advid'] = 'Adv ID';
$L['adv_deleteadv'] = 'Delete this adv';

$L['adv_savedasdraft'] = 'Adv saved as draft.';

/**
 * Adv statuses
 */

$L['adv_status_draft'] = 'Draft';
$L['adv_status_pending'] = 'Pending';
$L['adv_status_approved'] = 'Approved';
$L['adv_status_published'] = 'Published';
$L['adv_status_expired'] = 'Expired';

/**
 * Moved from theme.lang
 */

$L['adv_linesperpage'] = 'Lines per page';
$L['adv_linesinthissection'] = 'Lines in this section';

$L['Board'] = "Объявления";
$L['board_catalog'] = "Каталог объявлений";
$L['board_new'] = "New ads";
$L['board_vip'] = "VIP ads";

$Ls['adv'] = "adv,adv";
$Ls['unvalidated_adv'] = "unvalidated adv,unvalidated adv";
$Ls['adv_in_drafts'] = "adv in drafts,adv in drafts";

$L['adv_submitnewadv'] = 'Add adv';


$L['adv_addr'] = 'Address';
$L['adv_phone'] = 'Phones';
$L['adv_skype'] = 'Skype';
$L['adv_site'] = 'Website';
$L['adv_email'] = 'E-mail';
$L['adv_hidemail'] = 'Show email for all';
$L['adv_sendmsg'] = 'Send message';

$L['adv_contact_name'] = 'Your name';
$L['adv_contact_email'] = 'E-mail';
$L['adv_contact_phone'] = 'Phone';
$L['adv_contact_msg'] = 'Text';

$L['adv_contact_error_name'] = 'Empty name';
$L['adv_contact_error_phoneoremail'] = 'Empty email or phone';
$L['adv_contact_error_text'] = 'Empty text';

$L['adv_contact_msg_subject'] = 'Message';
$L['adv_contact_msg_body'] = "Hi %1\$s.\n\nYou sent a message on your ad \"%2\$s\":\n\nSender: %3\$s\nE-mail: %4\$s\nPhone: %5\$s\n\nText:\n%6\$s\n";

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

$L['adv_error_emptyphone'] = 'Phone number is empty';
$L['adv_error_wrongcost'] = 'Invalid cost';