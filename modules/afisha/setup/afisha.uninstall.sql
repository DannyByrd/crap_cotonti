/**
 * Completely removes afisha data
 */

DROP TABLE IF EXISTS `cot_afisha`;

DELETE FROM `cot_structure` WHERE structure_area = 'afisha';