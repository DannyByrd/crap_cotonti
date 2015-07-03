/**
 * Adv module DB installation
 */

-- Default categories permssions
INSERT INTO `cot_auth` (`auth_groupid`, `auth_code`, `auth_option`,
  `auth_rights`, `auth_rights_lock`, `auth_setbyuserid`) VALUES
(1, 'blogs', 'personal',	5,		0,		1),
(2, 'blogs', 'personal',	1,		254,	1),
(3, 'blogs', 'personal',	0,		255,	1),
(4, 'blogs', 'personal',	7,		0,		1),
(5, 'blogs', 'personal',	255,	255,	1),
(6, 'blogs', 'personal',	135,	0,		1);

-- Blogs table
CREATE TABLE IF NOT EXISTS `cot_blogs` (
  `post_id` int(11) unsigned NOT NULL auto_increment,
  `post_alias` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `post_state` tinyint(1) unsigned NOT NULL default '0',
  `post_cat` varchar(255) collate utf8_unicode_ci NOT NULL,
  `post_title` varchar(255) collate utf8_unicode_ci NOT NULL,
  `post_desc` MEDIUMTEXT collate utf8_unicode_ci default NULL,
  `post_keywords` varchar(255) collate utf8_unicode_ci default NULL,
  `post_metatitle` varchar(255) collate utf8_unicode_ci default NULL,
  `post_metadesc` varchar(255) collate utf8_unicode_ci default NULL,
  `post_text` TEXT collate utf8_unicode_ci NOT NULL,
  `post_parser` VARCHAR(64) NOT NULL DEFAULT '',
  `post_ownerid` int(11) NOT NULL default '0',
  `post_date` int(11) NOT NULL default '0',
  `post_updated` int(11) NOT NULL default '0',
  `post_count` mediumint(8) unsigned default '0',
  `post_rating` decimal(5,2) NOT NULL default '0.00',
  PRIMARY KEY  (`post_id`),
  KEY `post_cat` (`post_cat`),
  KEY `post_alias` (`post_alias`),
  KEY `post_state` (`post_state`),
  KEY `post_date` (`post_date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Default blogs categories
INSERT INTO `cot_structure` (`structure_area`, `structure_code`, `structure_path`, `structure_tpl`, `structure_title`, `structure_seotitle`,
   `structure_desc`, `structure_text`, `structure_icon`, `structure_locked`, `structure_count`) VALUES
('blogs', 'personal', '1', '', 'Личные блоги', 'Личные блоги', '', '', '', 0, 0);
