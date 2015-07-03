/**
 * Completely removes page data
 */

DROP TABLE IF EXISTS `cot_pages`;
DROP TABLE IF EXISTS `cot_pages_in_structure`;

DELETE FROM `cot_auth` WHERE `auth_code` = 'page';
DELETE FROM `cot_structure` WHERE `structure_area` = 'page';