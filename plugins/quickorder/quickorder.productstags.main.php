<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=productstags.main,
Hooks=pagetags.main
[END_COT_EXT]
==================== */

/**
 * Will clean various things
 *
 * @package quickorder
 * @version 0.7.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die("Wrong URL.");  

	switch ($_GET['e']) {
		case 'products': $params = 'a=add&prd_id=' . $prd_data['prd_id'].'&type=products'; $title='prd_title';
			
			break;
		case 'page': $params = 'a=add&page_id=' . $page_data['page_id'].'&type=page';  $title='page_title';
			
			break;
		
		default:
			 $params = NULL;
			break;
	}

	
	$t_quickorder_button = new XTemplate(cot_tplfile('quickorder.button', 'plug'));

	$t_quickorder_button->assign(array(
		'LINK' => cot_url('quickorder', $params),
		'TITLE' => ($prd_data != NULL) ? $prd_data[$title]: $page_data[$title]
	));
	

	$t_quickorder_button->parse('MAIN');
	$temp_array['QUICKORDER_BUTTON'] = $t_quickorder_button->text();

?>