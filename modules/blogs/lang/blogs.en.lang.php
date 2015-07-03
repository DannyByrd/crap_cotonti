<?php
/**
 * English Language File for the Blogs Module (blogs.en.lang.php)
 *
 * @package blogs
 * @version 0.9.6
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */

$L['cfg_autovalidatepost'] = 'Autovalidate post';
$L['cfg_autovalidatepost_hint'] = 'Autovalidate post if poster has admin rights for post category';
$L['cfg_count_admin'] = 'Count Administrators\' hits';
$L['cfg_count_admin_hint'] = '';
$L['cfg_maxlistsperpage'] = 'Max. lists per post';
$L['cfg_maxlistsperpage_hint'] = ' ';
$L['cfg_order'] = 'Sorting column';
$L['cfg_title_post'] = 'Post title tag format';
$L['cfg_title_post_hint'] = 'Options: {TITLE}, {CATEGORY}';
$L['cfg_way'] = 'Sorting direction';
$L['cfg_truncateposttext'] = 'Set truncated post text length in list';
$L['cfg_truncateposttext_hint'] = 'Zero to disable this feature';
$L['cfg_allowemptyposttext'] = 'Allow empty post text';
$L['cfg_keywords'] = 'Keywords';

$L['info_desc'] = 'Enables website content through blogs';

/**
 * Structure Confing
 */

$L['cfg_order_params'] = array(); // Redefined in cot_post_config_order()
$L['cfg_way_params'] = array($L['Ascending'], $L['Descending']);

/**
 * Admin Post Section
 */

$L['adm_queue_deleted'] = 'Post was deleted in to the trash can';
$L['adm_valqueue'] = 'Waiting for validation';
$L['adm_validated'] = 'Already validated';
$L['adm_expired'] = 'Expired';
$L['adm_structure'] = 'Structure of the post (categories)';
$L['adm_sort'] = 'Sort';
$L['adm_sortingorder'] = 'Set a default sorting order for the categories';
$L['adm_showall'] = 'Show all';
$L['adm_help_post'] = 'The post that belong to the category &quot;system&quot; are not displayed in the public listings, it\'s to make standalone post.';

/**
 * Post add and edit
 */

$L['post_addtitle'] = 'Submit new post';
$L['post_addsubtitle'] = 'Fill out all required fields and hit "Sumbit" to continue';
$L['post_edittitle'] = 'Post properties';
$L['post_editsubtitle'] = 'Edit all required fields and hit "Sumbit" to continue';

$L['post_aliascharacters'] = 'Characters \'+\', \'/\', \'?\', \'%\', \'#\', \'&\' are not allowed in aliases';
$L['post_catmissing'] = 'The category code is missing';
$L['post_clone'] = 'Clone post';
$L['post_confirm_delete'] = 'Do you really want to delete this post?';
$L['post_confirm_validate'] = 'Do you want to validate this post?';
$L['post_confirm_unvalidate'] = 'Do you really want to put this post back to the validation queue?';
$L['post_drafts'] = 'Drafts';
$L['post_drafts_desc'] = 'Post saved in your drafts';
$L['post_notavailable'] = 'This post will be published in ';
$L['post_textmissing'] = 'The text about post must not be empty';
$L['post_titletooshort'] = 'The post title is too short or missing';
$L['post_validation'] = 'Awaiting validation';
$L['post_validation_desc'] = 'Your post which have not been validated by administrator yet';

$L['post_title'] = 'Post title';
$L['post_desc'] = 'Short description';

$L['post_metakeywords'] = 'Meta keywords';
$L['post_metatitle'] = 'Meta title';
$L['post_metadesc'] = 'Meta description';

$L['post_formhint'] = 'Once your submission is done, the post will be placed in the validation queue and will be hidden, awaiting confirmation from a site administrator or global moderator before being displayed in the right section. Check all fields carefully. If you need to change something, you will be able to do that later. But submitting changes puts a post into validation queue again.';

$L['post_postid'] = 'Post ID';
$L['post_deletepost'] = 'Delete this post';

$L['post_savedasdraft'] = 'Post saved as draft.';

/**
 * Post statuses
 */

$L['post_status_draft'] = 'Draft';
$L['post_status_pending'] = 'Pending';
$L['post_status_approved'] = 'Approved';
$L['post_status_published'] = 'Published';

/**
 * Moved from theme.lang
 */

$L['post_linesperpage'] = 'Lines per page';
$L['post_linesinthissection'] = 'Lines in this section';

$L['Blogs'] = "Blogs";
$L['blogs_catalog'] = "Blogs";
$L['blogs_new'] = "New post";

$Ls['post'] = "post,posts";
$Ls['unvalidated_post'] = "unvalidated post,unvalidated posts";
$Ls['post_in_drafts'] = "post in drafts,posts in drafts";

$L['post_submitnewpost'] = 'Add post';
