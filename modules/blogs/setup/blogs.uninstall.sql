/**
 * Completely removes blogs data
 */

DROP TABLE IF EXISTS `cot_blogs`;

DELETE FROM `cot_structure` WHERE structure_area = 'blogs';