/**
 * Completely removes rezume data
 */

DROP TABLE IF EXISTS `cot_rezume`;

DELETE FROM `cot_structure` WHERE structure_area = 'rezume';