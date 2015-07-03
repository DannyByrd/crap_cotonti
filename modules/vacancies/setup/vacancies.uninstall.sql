/**
 * Completely removes vacancies data
 */

DROP TABLE IF EXISTS `cot_vacancies`;

DELETE FROM `cot_structure` WHERE structure_area = 'vacancies';