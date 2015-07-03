<?php
/**
 * English Language File for the Afisha Module (afisha.en.lang.php)
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

$L['cfg_autovalidateevent'] = 'Autovalidate event';
$L['cfg_autovalidateevent_hint'] = 'Autovalidate event if poster has admin rights for event category';
$L['cfg_count_admin'] = 'Count Administrators\' hits';
$L['cfg_count_admin_hint'] = '';
$L['cfg_maxlistsperpage'] = 'Max. lists per event';
$L['cfg_maxlistsperpage_hint'] = ' ';
$L['cfg_order'] = 'Sorting column';
$L['cfg_title_event'] = 'Event title tag format';
$L['cfg_title_event_hint'] = 'Options: {TITLE}, {CATEGORY}';
$L['cfg_way'] = 'Sorting direction';
$L['cfg_truncateeventtext'] = 'Set truncated event text length in list';
$L['cfg_truncateeventtext_hint'] = 'Zero to disable this feature';
$L['cfg_allowemptyeventtext'] = 'Allow empty event text';
$L['cfg_keywords'] = 'Keywords';

$L['info_desc'] = 'Enables website content through event and event categories';

/**
 * Structure Confing
 */

$L['cfg_order_params'] = array(); // Redefined in cot_event_config_order()
$L['cfg_way_params'] = array($L['Ascending'], $L['Descending']);

/**
 * Admin Adv Section
 */

$L['adm_queue_deleted'] = 'Event was deleted in to the trash can';
$L['adm_valqueue'] = 'Waiting for validation';
$L['adm_validated'] = 'Already validated';
$L['adm_expired'] = 'Expired';
$L['adm_structure'] = 'Structure of the event (categories)';
$L['adm_sort'] = 'Sort';
$L['adm_sortingorder'] = 'Set a default sorting order for the categories';
$L['adm_showall'] = 'Show all';
$L['adm_help_event'] = 'The event that belong to the category &quot;system&quot; are not displayed in the public listings, it\'s to make standalone event.';

/**
 * Adv add and edit
 */

$L['event_addtitle'] = 'Submit new event';
$L['event_addsubtitle'] = 'Fill out all required fields and hit "Sumbit" to continue';
$L['event_edittitle'] = 'Event properties';
$L['event_editsubtitle'] = 'Edit all required fields and hit "Sumbit" to continue';

$L['event_aliascharacters'] = 'Characters \'+\', \'/\', \'?\', \'%\', \'#\', \'&\' are not allowed in aliases';
$L['event_catmissing'] = 'The category code is missing';
$L['event_clone'] = 'Clone event';
$L['event_confirm_delete'] = 'Do you really want to delete this event?';
$L['event_confirm_validate'] = 'Do you want to validate this event?';
$L['event_confirm_unvalidate'] = 'Do you really want to put this event back to the validation queue?';
$L['event_drafts'] = 'Drafts';
$L['event_drafts_desc'] = 'Event saved in your drafts';
$L['event_notavailable'] = 'This event will be published in ';
$L['event_textmissing'] = 'The text about event must not be empty';
$L['event_titletooshort'] = 'The event title is too short or missing';
$L['event_validation'] = 'Awaiting validation';
$L['event_validation_desc'] = 'Your event which have not been validated by administrator yet';

$L['event_title'] = 'Event title';
$L['event_desc'] = 'Short description';

$L['event_metakeywords'] = 'Meta keywords';
$L['event_metatitle'] = 'Meta title';
$L['event_metadesc'] = 'Meta description';

$L['event_cost'] = 'Цена';

$L['event_formhint'] = 'Once your submission is done, the event will be placed in the validation queue and will be hidden, awaiting confirmation from a site administrator or global moderator before being displayed in the right section. Check all fields carefully. If you need to change something, you will be able to do that later. But submitting changes puts a event into validation queue again.';

$L['event_eventid'] = 'Event ID';
$L['event_deleteevent'] = 'Delete this event';

$L['event_savedasdraft'] = 'Event saved as draft.';

/**
 * Adv statuses
 */

$L['event_status_draft'] = 'Draft';
$L['event_status_pending'] = 'Pending';
$L['event_status_approved'] = 'Approved';
$L['event_status_published'] = 'Published';
$L['event_status_expired'] = 'Expired';

/**
 * Moved from theme.lang
 */

$L['event_linesperpage'] = 'Lines per page';
$L['event_linesinthissection'] = 'Lines in this section';

$L['Afisha'] = "Afisha";
$L['afisha_catalog'] = "Events catalog";
$L['afisha_new'] = "New events";
$L['afisha_vip'] = "VIP event";

$Ls['event'] = "event,event";
$Ls['unvalidated_event'] = "unvalidated event,unvalidated event";
$Ls['event_in_drafts'] = "event in drafts,event in drafts";

$L['event_submitnewevent'] = 'Add event';

// Параметры поиск объявлений
$L['plu_afisha_set_sec'] = 'Разделы';
$L['plu_afisha_res_sort1'] = 'Дате публикации';
$L['plu_afisha_res_sort2'] = 'Заголовку';
$L['plu_afisha_res_sort3'] = 'Популярности';
$L['plu_afisha_res_sort3'] = 'Категории';
$L['plu_afisha_search_names'] = 'Поиск в названиях';
$L['plu_afisha_search_desc'] = 'Поиск в кратком описании';
$L['plu_afisha_search_text'] = 'Поиск в описании';
$L['plu_afisha_set_subsec'] = 'Поиск в подразделах';
