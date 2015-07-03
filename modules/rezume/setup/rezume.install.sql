/**
 * Adv module DB installation
 */

-- Default categories permssions
INSERT INTO `cot_auth` (`auth_groupid`, `auth_code`, `auth_option`,
  `auth_rights`, `auth_rights_lock`, `auth_setbyuserid`) VALUES
(1, 'rezume', 'accountant', 1, 128, 1),
(2, 'rezume', 'accountant', 1, 254, 1),
(3, 'rezume', 'accountant', 0, 255, 1),
(4, 'rezume', 'accountant', 3, 0, 0),
(5, 'rezume', 'accountant', 255, 255, 1),
(6, 'rezume', 'accountant', 3, 0, 0),
(1, 'rezume', 'agro', 1, 128, 1),
(2, 'rezume', 'agro', 1, 254, 1),
(3, 'rezume', 'agro', 0, 255, 1),
(4, 'rezume', 'agro', 3, 0, 0),
(5, 'rezume', 'agro', 255, 255, 1),
(6, 'rezume', 'agro', 3, 0, 0),
(1, 'rezume', 'bank', 1, 128, 1),
(2, 'rezume', 'bank', 1, 254, 1),
(3, 'rezume', 'bank', 0, 255, 1),
(4, 'rezume', 'bank', 3, 0, 0),
(5, 'rezume', 'bank', 255, 255, 1),
(6, 'rezume', 'bank', 3, 0, 0),
(1, 'rezume', 'chief', 1, 128, 1),
(2, 'rezume', 'chief', 1, 254, 1),
(3, 'rezume', 'chief', 0, 255, 1),
(4, 'rezume', 'chief', 3, 0, 0),
(5, 'rezume', 'chief', 255, 255, 1),
(6, 'rezume', 'chief', 3, 0, 0),
(1, 'rezume', 'construction', 1, 128, 1),
(2, 'rezume', 'construction', 1, 254, 1),
(3, 'rezume', 'construction', 0, 255, 1),
(4, 'rezume', 'construction', 3, 0, 0),
(5, 'rezume', 'construction', 255, 255, 1),
(6, 'rezume', 'construction', 3, 0, 0),
(1, 'rezume', 'design-poligraph', 1, 128, 1),
(2, 'rezume', 'design-poligraph', 1, 254, 1),
(3, 'rezume', 'design-poligraph', 0, 255, 1),
(4, 'rezume', 'design-poligraph', 3, 0, 0),
(5, 'rezume', 'design-poligraph', 255, 255, 1),
(6, 'rezume', 'design-poligraph', 3, 0, 0),
(1, 'rezume', 'education', 1, 128, 1),
(2, 'rezume', 'education', 1, 254, 1),
(3, 'rezume', 'education', 0, 255, 1),
(4, 'rezume', 'education', 3, 0, 0),
(5, 'rezume', 'education', 255, 255, 1),
(6, 'rezume', 'education', 3, 0, 0),
(1, 'rezume', 'farma', 1, 128, 1),
(2, 'rezume', 'farma', 1, 254, 1),
(3, 'rezume', 'farma', 0, 255, 1),
(4, 'rezume', 'farma', 3, 0, 0),
(5, 'rezume', 'farma', 255, 255, 1),
(6, 'rezume', 'farma', 3, 0, 0),
(1, 'rezume', 'freelance', 1, 128, 1),
(2, 'rezume', 'freelance', 1, 254, 1),
(3, 'rezume', 'freelance', 0, 255, 1),
(4, 'rezume', 'freelance', 3, 0, 0),
(5, 'rezume', 'freelance', 255, 255, 1),
(6, 'rezume', 'freelance', 3, 0, 0),
(1, 'rezume', 'hr', 5, 0, 0),
(2, 'rezume', 'hr', 1, 254, 1),
(3, 'rezume', 'hr', 0, 255, 1),
(4, 'rezume', 'hr', 7, 0, 0),
(5, 'rezume', 'hr', 255, 255, 1),
(6, 'rezume', 'hr', 135, 0, 0),
(1, 'rezume', 'insurance', 1, 128, 1),
(2, 'rezume', 'insurance', 1, 254, 1),
(3, 'rezume', 'insurance', 0, 255, 1),
(4, 'rezume', 'insurance', 3, 0, 0),
(5, 'rezume', 'insurance', 255, 255, 1),
(6, 'rezume', 'insurance', 3, 0, 0),
(1, 'rezume', 'IT', 1, 128, 1),
(2, 'rezume', 'IT', 1, 254, 1),
(3, 'rezume', 'IT', 0, 255, 1),
(4, 'rezume', 'IT', 3, 0, 0),
(5, 'rezume', 'IT', 255, 255, 1),
(6, 'rezume', 'IT', 3, 0, 0),
(1, 'rezume', 'job-students', 1, 128, 1),
(2, 'rezume', 'job-students', 1, 254, 1),
(3, 'rezume', 'job-students', 0, 255, 1),
(4, 'rezume', 'job-students', 3, 0, 0),
(5, 'rezume', 'job-students', 255, 255, 1),
(6, 'rezume', 'job-students', 3, 0, 0),
(1, 'rezume', 'lawyer', 1, 128, 1),
(2, 'rezume', 'lawyer', 1, 254, 1),
(3, 'rezume', 'lawyer', 0, 255, 1),
(4, 'rezume', 'lawyer', 3, 0, 0),
(5, 'rezume', 'lawyer', 255, 255, 1),
(6, 'rezume', 'lawyer', 3, 0, 0),
(1, 'rezume', 'logistics', 1, 128, 1),
(2, 'rezume', 'logistics', 1, 254, 1),
(3, 'rezume', 'logistics', 0, 255, 1),
(4, 'rezume', 'logistics', 3, 0, 0),
(5, 'rezume', 'logistics', 255, 255, 1),
(6, 'rezume', 'logistics', 3, 0, 0),
(1, 'rezume', 'manufacturing', 1, 128, 1),
(2, 'rezume', 'manufacturing', 1, 254, 1),
(3, 'rezume', 'manufacturing', 0, 255, 1),
(4, 'rezume', 'manufacturing', 3, 0, 0),
(5, 'rezume', 'manufacturing', 255, 255, 1),
(6, 'rezume', 'manufacturing', 3, 0, 0),
(1, 'rezume', 'marketing-pr', 1, 128, 1),
(2, 'rezume', 'marketing-pr', 1, 254, 1),
(3, 'rezume', 'marketing-pr', 0, 255, 1),
(4, 'rezume', 'marketing-pr', 3, 0, 0),
(5, 'rezume', 'marketing-pr', 255, 255, 1),
(6, 'rezume', 'marketing-pr', 3, 0, 0),
(1, 'rezume', 'medicine', 1, 128, 1),
(2, 'rezume', 'medicine', 1, 254, 1),
(3, 'rezume', 'medicine', 0, 255, 1),
(4, 'rezume', 'medicine', 3, 0, 0),
(5, 'rezume', 'medicine', 255, 255, 1),
(6, 'rezume', 'medicine', 3, 0, 0),
(1, 'rezume', 'mlm', 1, 128, 1),
(2, 'rezume', 'mlm', 1, 254, 1),
(3, 'rezume', 'mlm', 0, 255, 1),
(4, 'rezume', 'mlm', 3, 0, 0),
(5, 'rezume', 'mlm', 255, 255, 1),
(6, 'rezume', 'mlm', 3, 0, 0),
(1, 'rezume', 'other', 1, 128, 1),
(2, 'rezume', 'other', 1, 254, 1),
(3, 'rezume', 'other', 0, 255, 1),
(4, 'rezume', 'other', 3, 0, 0),
(5, 'rezume', 'other', 255, 255, 1),
(6, 'rezume', 'other', 3, 0, 0),
(1, 'rezume', 'procurement', 1, 128, 1),
(2, 'rezume', 'procurement', 1, 254, 1),
(3, 'rezume', 'procurement', 0, 255, 1),
(4, 'rezume', 'procurement', 3, 0, 0),
(5, 'rezume', 'procurement', 255, 255, 1),
(6, 'rezume', 'procurement', 3, 0, 0),
(1, 'rezume', 'publishing', 1, 128, 1),
(2, 'rezume', 'publishing', 1, 254, 1),
(3, 'rezume', 'publishing', 0, 255, 1),
(4, 'rezume', 'publishing', 3, 0, 0),
(5, 'rezume', 'publishing', 255, 255, 1),
(6, 'rezume', 'publishing', 3, 0, 0),
(1, 'rezume', 'radio-tv', 1, 128, 1),
(2, 'rezume', 'radio-tv', 1, 254, 1),
(3, 'rezume', 'radio-tv', 0, 255, 1),
(4, 'rezume', 'radio-tv', 3, 0, 0),
(5, 'rezume', 'radio-tv', 255, 255, 1),
(6, 'rezume', 'radio-tv', 3, 0, 0),
(1, 'rezume', 'real-estate', 1, 128, 1),
(2, 'rezume', 'real-estate', 1, 254, 1),
(3, 'rezume', 'real-estate', 0, 255, 1),
(4, 'rezume', 'real-estate', 3, 0, 0),
(5, 'rezume', 'real-estate', 255, 255, 1),
(6, 'rezume', 'real-estate', 3, 0, 0),
(1, 'rezume', 'restaurant', 1, 128, 1),
(2, 'rezume', 'restaurant', 1, 254, 1),
(3, 'rezume', 'restaurant', 0, 255, 1),
(4, 'rezume', 'restaurant', 3, 0, 0),
(5, 'rezume', 'restaurant', 255, 255, 1),
(6, 'rezume', 'restaurant', 3, 0, 0),
(1, 'rezume', 'sales', 1, 128, 1),
(2, 'rezume', 'sales', 1, 254, 1),
(3, 'rezume', 'sales', 0, 255, 1),
(4, 'rezume', 'sales', 3, 0, 0),
(5, 'rezume', 'sales', 255, 255, 1),
(6, 'rezume', 'sales', 3, 0, 0),
(1, 'rezume', 'secretary', 1, 128, 1),
(2, 'rezume', 'secretary', 1, 254, 1),
(3, 'rezume', 'secretary', 0, 255, 1),
(4, 'rezume', 'secretary', 3, 0, 0),
(5, 'rezume', 'secretary', 255, 255, 1),
(6, 'rezume', 'secretary', 3, 0, 0),
(1, 'rezume', 'security', 1, 128, 1),
(2, 'rezume', 'security', 1, 254, 1),
(3, 'rezume', 'security', 0, 255, 1),
(4, 'rezume', 'security', 3, 0, 0),
(5, 'rezume', 'security', 255, 255, 1),
(6, 'rezume', 'security', 3, 0, 0),
(1, 'rezume', 'service-industry', 1, 128, 1),
(2, 'rezume', 'service-industry', 1, 254, 1),
(3, 'rezume', 'service-industry', 0, 255, 1),
(4, 'rezume', 'service-industry', 3, 0, 0),
(5, 'rezume', 'service-industry', 255, 255, 1),
(6, 'rezume', 'service-industry', 3, 0, 0),
(1, 'rezume', 'show', 1, 128, 1),
(2, 'rezume', 'show', 1, 254, 1),
(3, 'rezume', 'show', 0, 255, 1),
(4, 'rezume', 'show', 3, 0, 0),
(5, 'rezume', 'show', 255, 255, 1),
(6, 'rezume', 'show', 3, 0, 0),
(1, 'rezume', 'travel-tourism', 1, 128, 1),
(2, 'rezume', 'travel-tourism', 1, 254, 1),
(3, 'rezume', 'travel-tourism', 0, 255, 1),
(4, 'rezume', 'travel-tourism', 3, 0, 0),
(5, 'rezume', 'travel-tourism', 255, 255, 1),
(6, 'rezume', 'travel-tourism', 3, 0, 0),
(1, 'rezume', 'vehicles-car', 1, 128, 1),
(2, 'rezume', 'vehicles-car', 1, 254, 1),
(3, 'rezume', 'vehicles-car', 0, 255, 1),
(4, 'rezume', 'vehicles-car', 3, 0, 0),
(5, 'rezume', 'vehicles-car', 255, 255, 1),
(6, 'rezume', 'vehicles-car', 3, 0, 1);

-- rezume table
CREATE TABLE IF NOT EXISTS `cot_rezume` (
  `rez_id` int(11) unsigned NOT NULL auto_increment,
  `rez_alias` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `rez_state` tinyint(1) unsigned NOT NULL default '0',
  `rez_cat` varchar(255) collate utf8_unicode_ci NOT NULL,
  `rez_title` varchar(255) collate utf8_unicode_ci NOT NULL,
  `rez_desc` varchar(255) collate utf8_unicode_ci default NULL,
  `rez_keywords` varchar(255) collate utf8_unicode_ci default NULL,
  `rez_metatitle` varchar(255) collate utf8_unicode_ci default NULL,
  `rez_metadesc` varchar(255) collate utf8_unicode_ci default NULL,
  `rez_ownerid` int(11) NOT NULL default '0',
  `rez_date` int(11) NOT NULL default '0',
  `rez_updated` int(11) NOT NULL default '0',
  `rez_count` mediumint(8) unsigned default '0',
  `rez_rating` decimal(5,2) NOT NULL default '0.00',
  `rez_age` int(11) NOT NULL default '0',
  `rez_sex` char(1) collate utf8_unicode_ci NOT NULL default 'U',
  `rez_edu` varchar(255) collate utf8_unicode_ci default NULL,
  `rez_study` MEDIUMTEXT collate utf8_unicode_ci NOT NULL,
  `rez_exp` int(11) NOT NULL default '0',
  `rez_works` MEDIUMTEXT collate utf8_unicode_ci NOT NULL,
  `rez_qua` MEDIUMTEXT collate utf8_unicode_ci NOT NULL,
  `rez_salary` int(11) NOT NULL default '0',
  `rez_fio` varchar(255) collate utf8_unicode_ci default NULL,
  `rez_addr` varchar(255) collate utf8_unicode_ci default NULL,
  `rez_phone` varchar(255) collate utf8_unicode_ci default NULL,
  `rez_skype` varchar(50) collate utf8_unicode_ci default NULL,
  `rez_site` varchar(255) collate utf8_unicode_ci default NULL,
  `rez_email` varchar(50) collate utf8_unicode_ci default NULL,
  `rez_expire` int(11) NOT NULL default '0',
  `rez_hidemail` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`rez_id`),
  KEY `rez_cat` (`rez_cat`),
  KEY `rez_alias` (`rez_alias`),
  KEY `rez_state` (`rez_state`),
  KEY `rez_date` (`rez_date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Default rezume categories
INSERT INTO `cot_structure` (`structure_area`, `structure_code`, `structure_path`, `structure_tpl`, `structure_title`, `structure_seotitle`,
   `structure_desc`, `structure_text`, `structure_icon`, `structure_locked`, `structure_count`) VALUES
('rezume', 'hr', '1', '', 'HR специалисты и Бизнес-тренеры', '', '', '', '', 0, 0),
('rezume', 'IT', '2', '', 'IT', '', '', '', '', 0, 0),
('rezume', 'agro', '3', '', 'Агропромышленный комплекс', '', '', '', '', 0, 0),
('rezume', 'bank', '4', '', 'Банки - Финансы - Лизинг', '', '', '', '', 0, 0),
('rezume', 'accountant', '5', '', 'Бухгалтерия - Аудит - Финансы предприятия', '', '', '', '', 0, 0),
('rezume', 'restaurant', '6', '', 'Гостиницы - Рестораны - Кафе', '', '', '', '', 0, 0),
('rezume', 'design-poligraph', '7', '', 'Дизайнерское дело', '', '', '', '', 0, 0),
('rezume', 'procurement', '8', '', 'Закупки и снабжение', '', '', '', '', 0, 0),
('rezume', 'show', '9', '', 'Культура - Мода - Развлечения - Спорт', '', '', '', '', 0, 0),
('rezume', 'logistics', '10', '', 'Логистика - Таможня - Склад', '', '', '', '', 0, 0),
('rezume', 'marketing-pr', '11', '', 'Маркетинг - Реклама - PR', '', '', '', '', 0, 0),
('rezume', 'publishing', '12', '', 'Медиа - Издательское дело', '', '', '', '', 0, 0),
('rezume', 'medicine', '13', '', 'Медицина - Здравоохранение', '', '', '', '', 0, 0),
('rezume', 'education', '14', '', 'Наука - Образование - Перевод', '', '', '', '', 0, 0),
('rezume', 'real-estate', '15', '', 'Недвижимость', '', '', '', '', 0, 0),
('rezume', 'security', '16', '', 'Охрана и безопасность', '', '', '', '', 0, 0),
('rezume', 'manufacturing', '17', '', 'Промышленность - Производство', '', '', '', '', 0, 0),
('rezume', 'secretary', '18', '', 'Секретариат - Офис - АХО', '', '', '', '', 0, 0),
('rezume', 'mlm', '19', '', 'Сетевой маркетинг-MLM', '', '', '', '', 0, 0),
('rezume', 'insurance', '20', '', 'Страхование', '', '', '', '', 0, 0),
('rezume', 'construction', '21', '', 'Строительство и Архитектура', '', '', '', '', 0, 0),
('rezume', 'service-industry', '22', '', 'Сфера обслуживания', '', '', '', '', 0, 0),
('rezume', 'radio-tv', '23', '', 'Телекоммуникации и связь', '', '', '', '', 0, 0),
('rezume', 'chief', '24', '', 'ТОП-Менеджмент', '', '', '', '', 0, 0),
('rezume', 'sales', '25', '', 'Торговля и Продажи', '', '', '', '', 0, 0),
('rezume', 'vehicles-car', '26', '', 'Транспорт - Авто - Сервисное обслуживание', '', '', '', '', 0, 0),
('rezume', 'travel-tourism', '27', '', 'Туризм-Путешествия', '', '', '', '', 0, 0),
('rezume', 'farma', '28', '', 'Фармация', '', '', '', '', 0, 0),
('rezume', 'lawyer', '29', '', 'Юриспруденция', '', '', '', '', 0, 0),
('rezume', 'job-students', '31', '', 'Работа для студентов', '', '', '', '', 0, 0),
('rezume', 'freelance', '31', '', 'Фриланс и Удаленная работа', '', '', '', '', 0, 0),
('rezume', 'other', '32', '', 'Другие виды заработка', '', '', '', '', 0, 0);