
CREATE TABLE IF NOT EXISTS `cot_cities` (

	`city_id` int(11) NOT NULL AUTO_INCREMENT,
	`city_curid` int(11) NOT NULL,
	`city_country` varchar(150) collate utf8_unicode_ci,
	`city_name` varchar(150) collate utf8_unicode_ci,
		PRIMARY KEY (`city_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
