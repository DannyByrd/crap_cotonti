CREATE TABLE IF NOT EXISTS `cot_whatpay`(

	 `wpay_id` int(11) NOT NULL AUTO_INCREMENT,
	 `wpay_code` varchar(100) collate utf8_unicode_ci,
	 `wpay_email` varchar(100) collate utf8_unicode_ci,
	 `wpay_comment` text NOT NULL,
	  PRIMARY KEY (`wpay_id`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;