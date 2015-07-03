<?php
/*
 * English Language File for User Manager plugin
 * @package userman
 * @version 1.0
 * @author Aliaksei Kobak
 * @copyright Copyright (c) 2015 seditio.by
 */

defined('COT_CODE') or die('Wrong URL');

/*
 * Plugin Info
 */

$L['title'] = 'User Manager';
$L['subtitle'] = 'Plugin for managing users';
$L['info_desc'] = 'Manage users from within the admin panel';

/*
 * Config
 */

$L['cfg_defaultlevel'] = 'Default level';
$L['cfg_defaultemail'] = 'Default E-mail';
$L['cfg_defaultname'] = 'Default username';
$L['cfg_defaultpass'] = 'Default password';
$L['cfg_defaultsign'] = 'Signature';
$L['cfg_defaultsigntext'] = 'Regards, \r\n site admin';
$L['cfg_pass'] = '1111';

/*
 * Plugin Body
 */

$L['cfg_tilltimeoptions'] = 'Settings';
$L['cfg_tilltime_defaultlgroup'] = 'Default group';
$L['cfg_tilltime_accessgroup'] = 'Available groups';

$L['um_usermanager'] = &$L['title'];
$L['um_adduser'] = 'Add user';
$L['um_settings'] = 'Users module config';
$L['um_userrights'] = 'User rights';
$L['um_extrafields'] = 'User extrafields';
$L['um_createuser'] = 'Create user';
$L['um_edituser'] = 'Edit user';
$L['um_tga'] = 'TGA';

$L['um_defaultpass'] = '( default password: ';

$L['um_access_start'] = 'Grant access since';
$L['um_access_start_reason'] = 'Reason to grant access';
$L['um_access_stop'] = 'Grant access till';
$L['um_access_stop_reason'] = "Reason to recall access";

$L['um_active'] = 'Profile active';

$L['um_deldenied'] = '1st Admin cannot be removed';

$L['um_user'] = 'User ';
$L['um_successcreation'] = ' created successfully';
$L['um_deleted'] = ' deleted';
$L['um_successupdprof'] = 'Profile updated';

$L['um_access_user_edit'] = 'To change group access for the user: ';
$L['um_access_goto'] = ' proceed to the TGA editor -> ';
 
$L['um_user_access'] = 'TGA for the user : ';
$L['um_access_set_success'] = ' is set';
$L['um_access_updated'] = ' updated';
$L['um_access_set'] = 'Edit TGA';

/*
 * Help
 */

$L['userman_help_main'] = '<br /><b>TGA</b> - Temporary Group Access (TGA)<br /> If the <b>TGA</b> field is empty, it means that TGA is not set for the user, and the record is missing from the DB. If there is icon<br /> <img class="icon" src="plugins/userman/inc/access.png" alt="TGA active" /><br />, it means that the user record is in the DB TGA table and the record is active. If the re is icon<br /> <img class="icon" src="plugins/userman/inc/access_off.png" alt="Record off" /><br />, the user is in the DB TGA table, but the record is inactive - TGA is set off for the user.<br /> To search user by E-mail enter it in the name search field.';
$L['userman_help_access'] = '<br />Temporary group access is convenient if you i.e. provide payed access to certain groups and open it temporarily for certain users for a certain period of time after the payment has been made. You can set TGA to several groups if needed. The built-in groups are not available for TGA.<br /><br /><b>Example:</b> A user is a member of the members group, and you need to provide him with a TGA to the moderators group. Just turn on the corresponding checkbox at the TGA page. Then set up the date when you need the plugin to disable the TGA to this group. You can specify the reason - this is an optional note for site admins.<br /><br /> To activate the profile make it active by using the <b>Profile active</b> checkbox. To cancel the TGA profile just uncheck all boxes and click the Update button. The user shall receive all priviledges in accordance with the user rights. The TGA data will be removed from the DB (the plugin stores the groups available to the user by default and returns them once the TGA has been recalled or the TGA profile disabled).<br />If you just need to disable TGA without removing the profile, just uncheck the <b>Profile active</b> field. If the access is disabled by the plugin after the specified period of time, the record is not removed from the DB. The profile is just disabled.<br /><br /><b>Warning:</b> if the TGA is active, user group membership can only be changed from the Admin Panel / Usermanager. You cannot alter group membership for such account elsewhere. If the profile is inactive or is not in the DB TGA table, user membership can be altered from any page that permits this.';
