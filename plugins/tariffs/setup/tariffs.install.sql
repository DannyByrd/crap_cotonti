CREATE TABLE IF NOT EXISTS `cot_tariffs` (
  `tar_id` int(11) NOT NULL AUTO_INCREMENT,
  `tar_payid` int(11) NOT NULL,
  `tar_userid` int(11) NOT NULL,
  `tar_tariff` varchar(255) NOT NULL,
  PRIMARY KEY (`tar_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;