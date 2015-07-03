<?php
/**
 * 1.0.1 Adding the fields
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('vacancies', 'module');

global $db_vacancies;

if (!$db->fieldExists($db_vacancies, 'vac_salary'))
{
	$db->query("ALTER TABLE `$db_vacancies` ADD COLUMN `vac_salary` varchar(255) collate utf8_unicode_ci default NULL");
}

if (!$db->fieldExists($db_vacancies, 'vac_duty'))
{
	$db->query("ALTER TABLE `$db_vacancies` ADD COLUMN `vac_duty` MEDIUMTEXT collate utf8_unicode_ci NOT NULL");
}

if (!$db->fieldExists($db_vacancies, 'vac_term'))
{
	$db->query("ALTER TABLE `$db_vacancies` ADD COLUMN `vac_term` MEDIUMTEXT collate utf8_unicode_ci NOT NULL");
}

if (!$db->fieldExists($db_vacancies, 'vac_qua'))
{
	$db->query("ALTER TABLE `$db_vacancies` ADD COLUMN `vac_qua` MEDIUMTEXT collate utf8_unicode_ci NOT NULL");
}

if (!$db->fieldExists($db_vacancies, 'vac_age'))
{
	$db->query("ALTER TABLE `$db_vacancies` ADD COLUMN `vac_age` varchar(255) collate utf8_unicode_ci default NULL");
}

if (!$db->fieldExists($db_vacancies, 'vac_sex'))
{
	$db->query("ALTER TABLE `$db_vacancies` ADD COLUMN `vac_sex` char(1) collate utf8_unicode_ci NOT NULL default 'U'");
}

if (!$db->fieldExists($db_vacancies, 'vac_edu'))
{
	$db->query("ALTER TABLE `$db_vacancies` ADD COLUMN `vac_edu` varchar(255) collate utf8_unicode_ci default NULL");
}

if (!$db->fieldExists($db_vacancies, 'vac_exp'))
{
	$db->query("ALTER TABLE `$db_vacancies` ADD COLUMN `vac_exp` varchar(255) collate utf8_unicode_ci default NULL");
}

if (!$db->fieldExists($db_vacancies, 'vac_empl'))
{
	$db->query("ALTER TABLE `$db_vacancies` ADD COLUMN `vac_empl` varchar(255) collate utf8_unicode_ci default NULL");
}

if (!$db->fieldExists($db_vacancies, 'vac_shedule'))
{
	$db->query("ALTER TABLE `$db_vacancies` ADD COLUMN `vac_schedule` varchar(255) collate utf8_unicode_ci default NULL");
}

if (!$db->fieldExists($db_vacancies, 'vac_expire'))
{
	$db->query("ALTER TABLE `$db_vacancies` ADD COLUMN `vac_expire` int(11) NOT NULL default '0'");
}

if (!$db->fieldExists($db_vacancies, 'vac_hidemail'))
{
	$db->query("ALTER TABLE `$db_vacancies` ADD COLUMN `vac_hidemail` tinyint(1) NOT NULL default '0'");
}

?>