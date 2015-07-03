/**
 * Completely removes firms data
 */

DROP TABLE IF EXISTS `cot_firms`;

DELETE FROM `cot_structure` WHERE structure_area = 'firms';