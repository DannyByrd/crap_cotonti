/**
 * Adv module DB installation
 */

-- Default categories permssions
INSERT INTO `cot_auth` (`auth_groupid`, `auth_code`, `auth_option`, `auth_rights`, `auth_rights_lock`, `auth_setbyuserid`) VALUES
(1, 'afisha', 'art-cafe', 1, 128, 1),
(2, 'afisha', 'art-cafe', 1, 254, 1),
(3, 'afisha', 'art-cafe', 0, 255, 1),
(4, 'afisha', 'art-cafe', 3, 0, 1),
(5, 'afisha', 'art-cafe', 255, 255, 1),
(6, 'afisha', 'art-cafe', 3, 0, 1),
(1, 'afisha', 'autodealers', 1, 128, 1),
(2, 'afisha', 'autodealers', 1, 254, 1),
(3, 'afisha', 'autodealers', 0, 255, 1),
(4, 'afisha', 'autodealers', 3, 0, 1),
(5, 'afisha', 'autodealers', 255, 255, 1),
(6, 'afisha', 'autodealers', 3, 0, 1),
(1, 'afisha', 'baths', 1, 128, 1),
(2, 'afisha', 'baths', 1, 254, 1),
(3, 'afisha', 'baths', 0, 255, 1),
(4, 'afisha', 'baths', 3, 0, 1),
(5, 'afisha', 'baths', 255, 255, 1),
(6, 'afisha', 'baths', 3, 0, 1),
(1, 'afisha', 'billiard-halls', 1, 128, 1),
(2, 'afisha', 'billiard-halls', 1, 254, 1),
(3, 'afisha', 'billiard-halls', 0, 255, 1),
(4, 'afisha', 'billiard-halls', 3, 0, 1),
(5, 'afisha', 'billiard-halls', 255, 255, 1),
(6, 'afisha', 'billiard-halls', 3, 0, 1),
(1, 'afisha', 'bowling', 1, 128, 1),
(2, 'afisha', 'bowling', 1, 254, 1),
(3, 'afisha', 'bowling', 0, 255, 1),
(4, 'afisha', 'bowling', 3, 0, 1),
(5, 'afisha', 'bowling', 255, 255, 1),
(6, 'afisha', 'bowling', 3, 0, 1),
(1, 'afisha', 'cafe', 5, 0, 1),
(2, 'afisha', 'cafe', 1, 254, 1),
(3, 'afisha', 'cafe', 0, 255, 1),
(4, 'afisha', 'cafe', 7, 0, 1),
(5, 'afisha', 'cafe', 255, 255, 1),
(6, 'afisha', 'cafe', 135, 0, 1),
(1, 'afisha', 'cinema', 5, 0, 1),
(2, 'afisha', 'cinema', 1, 254, 1),
(3, 'afisha', 'cinema', 0, 255, 1),
(4, 'afisha', 'cinema', 7, 0, 1),
(5, 'afisha', 'cinema', 255, 255, 1),
(6, 'afisha', 'cinema', 135, 0, 1),
(1, 'afisha', 'circus', 1, 128, 1),
(2, 'afisha', 'circus', 1, 254, 1),
(3, 'afisha', 'circus', 0, 255, 1),
(4, 'afisha', 'circus', 3, 0, 1),
(5, 'afisha', 'circus', 255, 255, 1),
(6, 'afisha', 'circus', 3, 0, 1),
(1, 'afisha', 'coffee-house', 1, 128, 1),
(2, 'afisha', 'coffee-house', 1, 254, 1),
(3, 'afisha', 'coffee-house', 0, 255, 1),
(4, 'afisha', 'coffee-house', 3, 0, 1),
(5, 'afisha', 'coffee-house', 255, 255, 1),
(6, 'afisha', 'coffee-house', 3, 0, 1),
(1, 'afisha', 'concert-halls', 1, 128, 1),
(2, 'afisha', 'concert-halls', 1, 254, 1),
(3, 'afisha', 'concert-halls', 0, 255, 1),
(4, 'afisha', 'concert-halls', 3, 0, 1),
(5, 'afisha', 'concert-halls', 255, 255, 1),
(6, 'afisha', 'concert-halls', 3, 0, 1),
(1, 'afisha', 'concerts', 1, 128, 1),
(2, 'afisha', 'concerts', 1, 254, 1),
(3, 'afisha', 'concerts', 0, 255, 1),
(4, 'afisha', 'concerts', 3, 0, 1),
(5, 'afisha', 'concerts', 255, 255, 1),
(6, 'afisha', 'concerts', 3, 0, 1),
(1, 'afisha', 'courses', 1, 128, 1),
(2, 'afisha', 'courses', 1, 254, 1),
(3, 'afisha', 'courses', 0, 255, 1),
(4, 'afisha', 'courses', 3, 0, 1),
(5, 'afisha', 'courses', 255, 255, 1),
(6, 'afisha', 'courses', 3, 0, 1),
(1, 'afisha', 'dolphinarium', 1, 128, 1),
(2, 'afisha', 'dolphinarium', 1, 254, 1),
(3, 'afisha', 'dolphinarium', 0, 255, 1),
(4, 'afisha', 'dolphinarium', 3, 0, 1),
(5, 'afisha', 'dolphinarium', 255, 255, 1),
(6, 'afisha', 'dolphinarium', 3, 0, 1),
(1, 'afisha', 'exhibition', 1, 128, 1),
(2, 'afisha', 'exhibition', 1, 254, 1),
(3, 'afisha', 'exhibition', 0, 255, 1),
(4, 'afisha', 'exhibition', 3, 0, 1),
(5, 'afisha', 'exhibition', 255, 255, 1),
(6, 'afisha', 'exhibition', 3, 0, 1),
(1, 'afisha', 'films', 1, 128, 1),
(2, 'afisha', 'films', 1, 254, 1),
(3, 'afisha', 'films', 0, 255, 1),
(4, 'afisha', 'films', 3, 0, 1),
(5, 'afisha', 'films', 255, 255, 1),
(6, 'afisha', 'films', 3, 0, 1),
(1, 'afisha', 'fitness', 1, 128, 1),
(2, 'afisha', 'fitness', 1, 254, 1),
(3, 'afisha', 'fitness', 0, 255, 1),
(4, 'afisha', 'fitness', 3, 0, 1),
(5, 'afisha', 'fitness', 255, 255, 1),
(6, 'afisha', 'fitness', 3, 0, 1),
(1, 'afisha', 'galleries', 5, 0, 1),
(2, 'afisha', 'galleries', 1, 254, 1),
(3, 'afisha', 'galleries', 0, 255, 1),
(4, 'afisha', 'galleries', 7, 0, 1),
(5, 'afisha', 'galleries', 255, 255, 1),
(6, 'afisha', 'galleries', 135, 0, 1),
(1, 'afisha', 'hotels', 1, 128, 1),
(2, 'afisha', 'hotels', 1, 254, 1),
(3, 'afisha', 'hotels', 0, 255, 1),
(4, 'afisha', 'hotels', 3, 0, 1),
(5, 'afisha', 'hotels', 255, 255, 1),
(6, 'afisha', 'hotels', 3, 0, 1),
(1, 'afisha', 'ice-rink', 1, 128, 1),
(2, 'afisha', 'ice-rink', 1, 254, 1),
(3, 'afisha', 'ice-rink', 0, 255, 1),
(4, 'afisha', 'ice-rink', 3, 0, 1),
(5, 'afisha', 'ice-rink', 255, 255, 1),
(6, 'afisha', 'ice-rink', 3, 0, 1),
(1, 'afisha', 'karaoke-clubs', 1, 128, 1),
(2, 'afisha', 'karaoke-clubs', 1, 254, 1),
(3, 'afisha', 'karaoke-clubs', 0, 255, 1),
(4, 'afisha', 'karaoke-clubs', 3, 0, 1),
(5, 'afisha', 'karaoke-clubs', 255, 255, 1),
(6, 'afisha', 'karaoke-clubs', 3, 0, 1),
(1, 'afisha', 'museums', 1, 128, 1),
(2, 'afisha', 'museums', 1, 254, 1),
(3, 'afisha', 'museums', 0, 255, 1),
(4, 'afisha', 'museums', 3, 0, 1),
(5, 'afisha', 'museums', 255, 255, 1),
(6, 'afisha', 'museums', 3, 0, 1),
(1, 'afisha', 'party', 1, 128, 1),
(2, 'afisha', 'party', 1, 254, 1),
(3, 'afisha', 'party', 0, 255, 1),
(4, 'afisha', 'party', 3, 0, 1),
(5, 'afisha', 'party', 255, 255, 1),
(6, 'afisha', 'party', 3, 0, 1),
(1, 'afisha', 'performances', 1, 128, 1),
(2, 'afisha', 'performances', 1, 254, 1),
(3, 'afisha', 'performances', 0, 255, 1),
(4, 'afisha', 'performances', 3, 0, 1),
(5, 'afisha', 'performances', 255, 255, 1),
(6, 'afisha', 'performances', 3, 0, 1),
(1, 'afisha', 'pizzeria', 1, 128, 1),
(2, 'afisha', 'pizzeria', 1, 254, 1),
(3, 'afisha', 'pizzeria', 0, 255, 1),
(4, 'afisha', 'pizzeria', 3, 0, 1),
(5, 'afisha', 'pizzeria', 255, 255, 1),
(6, 'afisha', 'pizzeria', 3, 0, 1),
(1, 'afisha', 'restaurants', 5, 0, 1),
(2, 'afisha', 'restaurants', 1, 254, 1),
(3, 'afisha', 'restaurants', 0, 255, 1),
(4, 'afisha', 'restaurants', 7, 0, 1),
(5, 'afisha', 'restaurants', 255, 255, 1),
(6, 'afisha', 'restaurants', 135, 0, 1),
(1, 'afisha', 'saunas', 1, 128, 1),
(2, 'afisha', 'saunas', 1, 254, 1),
(3, 'afisha', 'saunas', 0, 255, 1),
(4, 'afisha', 'saunas', 3, 0, 1),
(5, 'afisha', 'saunas', 255, 255, 1),
(6, 'afisha', 'saunas', 3, 0, 1),
(1, 'afisha', 'shops', 1, 128, 1),
(2, 'afisha', 'shops', 1, 254, 1),
(3, 'afisha', 'shops', 0, 255, 1),
(4, 'afisha', 'shops', 3, 0, 1),
(5, 'afisha', 'shops', 255, 255, 1),
(6, 'afisha', 'shops', 3, 0, 1),
(1, 'afisha', 'sport', 1, 128, 1),
(2, 'afisha', 'sport', 1, 254, 1),
(3, 'afisha', 'sport', 0, 255, 1),
(4, 'afisha', 'sport', 3, 0, 1),
(5, 'afisha', 'sport', 255, 255, 1),
(6, 'afisha', 'sport', 3, 0, 1),
(1, 'afisha', 'summer-clubs', 1, 128, 1),
(2, 'afisha', 'summer-clubs', 1, 254, 1),
(3, 'afisha', 'summer-clubs', 0, 255, 1),
(4, 'afisha', 'summer-clubs', 3, 0, 1),
(5, 'afisha', 'summer-clubs', 255, 255, 1),
(6, 'afisha', 'summer-clubs', 3, 0, 1),
(1, 'afisha', 'sushi', 1, 128, 1),
(2, 'afisha', 'sushi', 1, 254, 1),
(3, 'afisha', 'sushi', 0, 255, 1),
(4, 'afisha', 'sushi', 3, 0, 1),
(5, 'afisha', 'sushi', 255, 255, 1),
(6, 'afisha', 'sushi', 3, 0, 1),
(1, 'afisha', 'taxi', 1, 128, 1),
(2, 'afisha', 'taxi', 1, 254, 1),
(3, 'afisha', 'taxi', 0, 255, 1),
(4, 'afisha', 'taxi', 3, 0, 1),
(5, 'afisha', 'taxi', 255, 255, 1),
(6, 'afisha', 'taxi', 3, 0, 1),
(1, 'afisha', 'theaters', 5, 0, 1),
(2, 'afisha', 'theaters', 1, 254, 1),
(3, 'afisha', 'theaters', 0, 255, 1),
(4, 'afisha', 'theaters', 7, 0, 1),
(5, 'afisha', 'theaters', 255, 255, 1),
(6, 'afisha', 'theaters', 135, 0, 1),
(1, 'afisha', 'tickets', 1, 128, 1),
(2, 'afisha', 'tickets', 1, 254, 1),
(3, 'afisha', 'tickets', 0, 255, 1),
(4, 'afisha', 'tickets', 3, 0, 1),
(5, 'afisha', 'tickets', 255, 255, 1),
(6, 'afisha', 'tickets', 3, 0, 1),
(1, 'afisha', 'tourist', 1, 128, 1),
(2, 'afisha', 'tourist', 1, 254, 1),
(3, 'afisha', 'tourist', 0, 255, 1),
(4, 'afisha', 'tourist', 3, 0, 1),
(5, 'afisha', 'tourist', 255, 255, 1),
(6, 'afisha', 'tourist', 3, 0, 1),
(1, 'afisha', 'winter-clubs', 1, 128, 1),
(2, 'afisha', 'winter-clubs', 1, 254, 1),
(3, 'afisha', 'winter-clubs', 0, 255, 1),
(4, 'afisha', 'winter-clubs', 3, 0, 1),
(5, 'afisha', 'winter-clubs', 255, 255, 1),
(6, 'afisha', 'winter-clubs', 3, 0, 1),
(1, 'afisha', 'zoo', 1, 128, 1),
(2, 'afisha', 'zoo', 1, 254, 1),
(3, 'afisha', 'zoo', 0, 255, 1),
(4, 'afisha', 'zoo', 3, 0, 1),
(5, 'afisha', 'zoo', 255, 255, 1),
(6, 'afisha', 'zoo', 3, 0, 1);
 

-- Afisha table
CREATE TABLE IF NOT EXISTS `cot_afisha` (
  `event_id` int(11) unsigned NOT NULL auto_increment,
  `event_alias` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `event_state` tinyint(1) unsigned NOT NULL default '0',
  `event_cat` varchar(255) collate utf8_unicode_ci NOT NULL,
  `event_title` varchar(255) collate utf8_unicode_ci NOT NULL,
  `event_desc` MEDIUMTEXT collate utf8_unicode_ci default NULL,
  `event_keywords` varchar(255) collate utf8_unicode_ci default NULL,
  `event_metatitle` varchar(255) collate utf8_unicode_ci default NULL,
  `event_metadesc` varchar(255) collate utf8_unicode_ci default NULL,
  `event_text` TEXT collate utf8_unicode_ci NOT NULL,
  `event_parser` VARCHAR(64) NOT NULL DEFAULT '',
  `event_ownerid` int(11) NOT NULL default '0',
  `event_date` int(11) NOT NULL default '0',
  `event_updated` int(11) NOT NULL default '0',
  `event_expire` int(11) NOT NULL default '0',
  `event_count` mediumint(8) unsigned default '0',
  `event_rating` decimal(5,2) NOT NULL default '0.00',
  `event_cost` float(16,2) default NULL,
  `event_addr` varchar(255) collate utf8_unicode_ci default NULL,
  `event_phone` varchar(255) collate utf8_unicode_ci default NULL,
  `event_skype` varchar(50) collate utf8_unicode_ci default NULL,
  `event_site` varchar(255) collate utf8_unicode_ci default NULL,
  `event_email` varchar(50) collate utf8_unicode_ci default NULL,
  `event_hidemail` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`event_id`),
  KEY `event_cat` (`event_cat`),
  KEY `event_alias` (`event_alias`),
  KEY `event_state` (`event_state`),
  KEY `event_date` (`event_date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Default afisha categories
INSERT INTO `cot_structure` (`structure_area`, `structure_code`, `structure_path`, `structure_tpl`, `structure_title`, `structure_seotitle`, `structure_desc`, `structure_metadesc`, `structure_text`, `structure_icon`, `structure_locked`, `structure_count`) VALUES
('afisha', 'cinema',          '1',  '', 'Кинотеатры', 'Кинотеатры', '', '', '', '', 0, 0),
('afisha', 'theaters',        '2',  '', 'Театры', 'Театры', '', '', '', '', 0, 0),
('afisha', 'cafe',            '3',  '', 'Кафе', 'Кафе', '', '', '', '', 0, 0),
('afisha', 'restaurants',     '4',  '', 'Рестораны', 'Рестораны', '', '', '', '', 0, 0),
('afisha', 'galleries',       '5',  '', 'Галереи', 'Галереи', '', '', '', '', 0, 0),
('afisha', 'pizzeria',        '6',  '', 'Пиццерии', 'Пиццерии', '', '', '', '', 0, 0),
('afisha', 'art-cafe',        '7',  '', 'Арт-кафе', 'Арт-кафе', '', '', '', '', 0, 0),
('afisha', 'coffee-house',    '8',  '', 'Кофейни', 'Кофейни', '', '', '', '', 0, 0),
('afisha', 'billiard-halls',  '9',  '', 'Бильярдные залы', 'Бильярдные залы', '', '', '', '', 0, 0),
('afisha', 'bowling',         '10', '', 'Боулинги', 'Боулинги', '', '', '', '', 0, 0),
('afisha', 'ice-rink',        '11', '', 'Катки', 'Катки', '', '', '', '', 0, 0),
('afisha', 'karaoke-clubs',   '12', '', 'Караоке-клубы', 'Караоке-клубы', '', '', '', '', 0, 0),
('afisha', 'sushi',           '13', '', 'Суши', 'Суши', '', '', '', '', 0, 0),
('afisha', 'winter-clubs',    '14', '', 'Зимние клубы', 'Зимние клубы', '', '', '', '', 0, 0),
('afisha', 'summer-clubs',    '15', '', 'Летние клубы', 'Летние клубы', '', '', '', '', 0, 0),
('afisha', 'concert-halls',   '16', '', 'Концертные залы', 'Концертные залы', '', '', '', '', 0, 0),
('afisha', 'saunas',          '17', '', 'Сауны', 'Сауны', '', '', '', '', 0, 0),
('afisha', 'baths',           '18', '', 'Бани', 'Бани', '', '', '', '', 0, 0),
('afisha', 'dolphinarium',    '19', '', 'Дельфинарий', 'Дельфинарий', '', '', '', '', 0, 0),
('afisha', 'circus',          '20', '', 'Цирк', 'Цирк', '', '', '', '', 0, 0),
('afisha', 'zoo',             '21', '', 'Зоопарки', 'Зоопарки', '', '', '', '', 0, 0),
('afisha', 'exhibition',      '22', '', 'Выставки', 'Выставки', '', '', '', '', 0, 0),
('afisha', 'performances',    '23', '', 'Спектакли', 'Спектакли', '', '', '', '', 0, 0),
('afisha', 'concerts',        '24', '', 'Концерты', 'Концерты', '', '', '', '', 0, 0),
('afisha', 'party',           '25', '', 'Вечеринки', 'Вечеринки', '', '', '', '', 0, 0),
('afisha', 'tickets',         '34', '', 'Заказ билетов', 'Заказ билетов', '', '', '', '', 0, 0),
('afisha', 'sport',           '26', '', 'Спорт', 'Спорт', '', '', '', '', 0, 0),
('afisha', 'museums',         '27', '', 'Музеи', 'Музеи', '', '', '', '', 0, 0),
('afisha', 'fitness',         '28', '', 'Фитнес-клубы', 'Фитнес-клубы', '', '', '', '', 0, 0),
('afisha', 'hotels',          '29', '', 'Гонтиницы', 'Гонтиницы', '', '', '', '', 0, 0),
('afisha', 'tourist',         '30', '', 'Турагенства', 'Турагенства', '', '', '', '', 0, 0),
('afisha', 'shops',           '31', '', 'Магазины', 'Магазины', '', '', '', '', 0, 0),
('afisha', 'autodealers',     '32', '', 'Автосалоны', 'Автосалоны', '', '', '', '', 0, 0),
('afisha', 'taxi',            '33', '', 'Такси', 'Такси', '', '', '', '', 0, 0),
('afisha', 'courses',         '36', '', 'Курсы', 'Курсы', '', '', '', '', 0, 0),
('afisha', 'films',           '35', '', 'Фильмы', 'Фильмы', '', '', '', '', 0, 0);