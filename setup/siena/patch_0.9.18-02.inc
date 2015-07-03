<?php
/* 0.9.18-02 */
defined('COT_CODE') && defined('COT_UPDATE') or die('Wrong URL');

global $cfg, $db, $db_x;
$dbname = $cfg['mysqldb'];
$db_afisha 		= $db_x . 'afisha';
$db_pages 		= $db_x . 'pages';
$db_products 	= $db_x . 'products';
$db_blogs 		= $db_x . 'blogs';
$db_board 		= $db_x . 'board';
$db_firms 		= $db_x . 'firms';
$db_vacancies 	= $db_x . 'vacancies';
$query = $db->query("SHOW tables in `$dbname`")->fetchAll();
$tables = array();
$sql_patch = '';
$patches = array(
		$db_afisha 		=> "ALTER TABLE  `$db_afisha` 	CHANGE  `event_desc`  `event_desc` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ;",
		$db_pages 		=> "ALTER TABLE  `$db_pages` 	CHANGE  `page_desc`  `page_desc` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ;",
		$db_products 	=> "ALTER TABLE  `$db_products` CHANGE  `prd_desc`  `prd_desc` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ;",
		$db_blogs 		=> "ALTER TABLE  `$db_blogs` 	CHANGE  `post_desc`  `post_desc` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ;",
		$db_board 		=> "ALTER TABLE  `$db_board` 	CHANGE  `adv_desc`  `adv_desc` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ;",
		$db_firms  		=> "ALTER TABLE  `$db_firms` 	CHANGE  `firm_desc`  `firm_desc` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ;",
		$db_vacancies 	=> "ALTER TABLE  `$db_vacancies`CHANGE  `vac_desc`  `vac_desc` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ;",
	);


foreach ($query as $value) {
	$value = array_values($value);
	$tables[] = $value[0];
	$table = $value[0];
	if(isset($patches[$table])){
		$sql_patch .= $patches[$table];
	}
}

if(!empty($sql_patch)){
	$db->query($sql_patch);
}
?>
