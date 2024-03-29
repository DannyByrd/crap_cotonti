<?php

/**
 * @package userman
 * @version 1.0
 * @author Aliaksei Kobak
 * @copyright Copyright (c) 2015 seditio.by
 */

defined('COT_CODE') or die('Wrong URL');

// Requirements
require_once cot_langfile('users', 'core');
require_once cot_incfile('users', 'module', 'resources');

$R['access'] = '<img class="icon" src="plugins/userman/inc/access.png" alt="'.$L['um_access_set'].'" title="'.$L['um_access_set'].'" />';
$R['access_off'] ='<img class="icon" src="plugins/userman/inc/access_off.png" alt="'.$L['um_access_set'].'" title="'.$L['um_access_set'].'" />';
$R['del_icon'] = '<img class="icon" src="images/icons/default/stop.png" alt="{$alt}" title="{$title}" />';



