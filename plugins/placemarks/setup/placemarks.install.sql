/**
 * Placemarks module DB installation
 */
CREATE TABLE IF NOT EXISTS `cot_placemarks` (
  `mark_id` int(10) unsigned NOT NULL auto_increment,
  `mark_area` varchar(20) collate utf8_unicode_ci NOT NULL,
  `mark_code` int(11) NOT NULL,
  `mark_coord` varchar(255) collate utf8_unicode_ci NOT NULL,
  `mark_zoom` int(11) NOT NULL,
  PRIMARY KEY  (`mark_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;