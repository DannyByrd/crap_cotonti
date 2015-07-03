<?php
/**
 * English Language File for the Firm Module (firms.en.lang.php)
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

$L['cfg_autovalidatefirm'] = 'Autovalidate firms';
$L['cfg_autovalidatefirm_hint'] = 'Autovalidate firms if poster has admin rights for firms category';
$L['cfg_count_admin'] = 'Count Administrators\' hits';
$L['cfg_count_admin_hint'] = '';
$L['cfg_maxlistsperpage'] = 'Max. lists per firms';
$L['cfg_maxlistsperpage_hint'] = ' ';
$L['cfg_order'] = 'Sorting column';
$L['cfg_title_firms'] = 'Firm title tag format';
$L['cfg_title_firm_hint'] = 'Options: {TITLE}, {CATEGORY}';
$L['cfg_way'] = 'Sorting direction';
$L['cfg_truncatefirmtext'] = 'Set truncated firms text length in list';
$L['cfg_truncatefirmtext_hint'] = 'Zero to disable this feature';
$L['cfg_allowemptyfirmtext'] = 'Allow empty firms text';
$L['cfg_keywords'] = 'Keywords';

$L['info_desc'] = 'Enables website content through firms and firms categories';

/**
 * Structure Confing
 */

$L['cfg_order_params'] = array(); // Redefined in cot_firms_config_order()
$L['cfg_way_params'] = array($L['Ascending'], $L['Descending']);

/**
 * Admin Firm Section
 */

$L['adm_queue_deleted'] = 'Firm was deleted in to the trash can';
$L['adm_valqueue'] = 'Waiting for validation';
$L['adm_validated'] = 'Already validated';
$L['adm_expired'] = 'Expired';
$L['adm_structure'] = 'Structure of the firms (categories)';
$L['adm_sort'] = 'Sort';
$L['adm_sortingorder'] = 'Set a default sorting order for the categories';
$L['adm_showall'] = 'Show all';
$L['adm_help_firms'] = 'The firms that belong to the category &quot;system&quot; are not displayed in the public listings, it\'s to make standalone firms.';

/**
 * Firm add and edit
 */

$L['firm_addtitle'] = 'Submit new firms';
$L['firm_addsubtitle'] = 'Fill out all required fields and hit "Sumbit" to continue';
$L['firm_edittitle'] = 'Firm properties';
$L['firm_editsubtitle'] = 'Edit all required fields and hit "Sumbit" to continue';

$L['firm_aliascharacters'] = 'Characters \'+\', \'/\', \'?\', \'%\', \'#\', \'&\' are not allowed in aliases';
$L['firm_catmissing'] = 'The category code is missing';
$L['firm_clone'] = 'Clone firms';
$L['firm_confirm_delete'] = 'Do you really want to delete this firms?';
$L['firm_confirm_validate'] = 'Do you want to validate this firms?';
$L['firm_confirm_unvalidate'] = 'Do you really want to put this firms back to the validation queue?';
$L['firm_drafts'] = 'Drafts';
$L['firm_drafts_desc'] = 'Firms saved in your drafts';
$L['firm_notavailable'] = 'This firms will be published in ';
$L['firm_textmissing'] = 'The text about firm must not be empty';
$L['firm_titletooshort'] = 'The firm title is too short or missing';
$L['firm_validation'] = 'Awaiting validation';
$L['firm_validation_desc'] = 'Your firms which have not been validated by administrator yet';

$L['firm_title'] = 'Firm title';
$L['firm_desc'] = 'Short description';
$L['firm_logo'] = 'Logo';

$L['firm_metakeywords'] = 'Meta keywords';
$L['firm_metatitle'] = 'Meta title';
$L['firm_metadesc'] = 'Meta description';

$L['firm_formhint'] = 'Once your submission is done, the firms will be placed in the validation queue and will be hidden, awaiting confirmsation from a site administrator or global moderator before being displayed in the right section. Check all fields carefully. If you need to change something, you will be able to do that later. But submitting changes puts a firms into validation queue again.';

$L['firm_firmsid'] = 'Firm ID';
$L['firm_deletefirms'] = 'Delete this firms';

$L['firm_savedasdraft'] = 'Firm saved as draft.';

/**
 * Firm statuses
 */

$L['firm_status_draft'] = 'Draft';
$L['firm_status_pending'] = 'Pending';
$L['firm_status_approved'] = 'Approved';
$L['firm_status_published'] = 'Published';

$L['firm_logo_notvalid'] = 'File is not image';

/**
 * Moved from theme.lang
 */

$L['firm_linesperfirm'] = 'Lines per firms';
$L['firm_linesinthissection'] = 'Lines in this section';

$L['Firms'] = "Firms";
$L['firm_catalog'] = "Firms catalog";
$L['firm_new'] = "New firms";

$Ls['firms'] = "firms,firms";
$Ls['unvalidated_firms'] = "unvalidated firms,unvalidated firms";
$Ls['firm_in_drafts'] = "firms in drafts,firms in drafts";

$L['firm_submitnewfirm'] = 'Add firm';


$L['firm_addr'] = 'Address';
$L['firm_phone'] = 'Phones';
$L['firm_skype'] = 'Skype';
$L['firm_site'] = 'Website';
$L['firm_email'] = 'E-mail';