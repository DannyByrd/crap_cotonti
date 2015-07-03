<?php

define('COT_CODE', TRUE);
//$cfg['mainurl']
$path = '../../../datas/config.php';
require_once($path);

$cfg['system_dir']=$_SERVER['DOCUMENT_ROOT'].mb_substr($cfg['system_dir'], 1);

$this->CFG['my_db'] = $cfg['mysqldb'];
$this->CFG['lang'] = $cfg['defaultlang'];
$this->CFG['my_user'] = $cfg['mysqluser'];
$this->CFG['my_host'] = $cfg['mysqlhost'];
$this->CFG['my_pass'] = $cfg['mysqlpassword'];
$this->CFG['backup_path'] = $_SERVER['DOCUMENT_ROOT'].'/plugins/sypex/sxd_2.0.11/backup/';
$this->CFG['backup_url'] = $cfg['mainurl'] . '/plugins/sypex/sxd_2.0.11/backup/';

$auth = 0;
if ($this->connect($cfg['mysqlhost'], $cfg['mysqlport'], $cfg['mysqluser'], $cfg['mysqlpassword']) && (int)$_GET['sid'] > 0)
{
	$db_online = 'cot_online';
	$db_users = 'cot_users';

	mysql_selectdb($cfg['mysqldb']);
  if($r = mysql_query("SELECT u.user_id FROM $db_online AS o LEFT JOIN $db_users AS u ON u.user_name=o.online_name
    WHERE user_id = '".(int)$_GET['uid']."' AND user_sid = '".$_GET['sid']."' AND online_location = 'Administration' AND user_maingrp='5'"))
  {

  		while ($row=mysql_fetch_assoc($r))
		{
			if($row['user_id'] == (int)$_GET['uid']){
				$auth = 1;
			} 
		}
  }
}
?>
