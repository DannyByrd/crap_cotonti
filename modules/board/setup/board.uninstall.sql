/**
 * Completely removes board data
 */

DROP TABLE IF EXISTS `cot_board`;

DELETE FROM `cot_structure` WHERE structure_area = 'board';