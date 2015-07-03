<?php


defined('COT_CODE') or die('Wrong URL.');

	switch ($_GET['type']) {
		case 'products': $table = 'products'; $table_id = 'prd_id'; $TBL_ID = 'PRD_ID'; $TBL_TITLE = 'PRD_TITLE';
			
			break;
		case 'page':     $table = 'pages'; $table_id = 'page_id'; $TBL_ID = 'PAGE_ID'; $TBL_TITLE = 'PAGE_TITLE';
			
			break;
		
		default:
			 $params = NULL;
			break;
	}

global $db_x, $db, $db_tables;

$db_tables = isset($db_tables) ? $db_tables : $db_x . $table;

$t = new XTemplate(cot_tplfile('quickorder.popup', 'plug'));


if(COT_AJAX){ 
	$tables_id = cot_import($table_id, 'G', 'INT');
    
	if($tables_id){

		$sql = $db->query("SELECT * FROM " . $db_tables . " WHERE ".$table_id." = '" . (int) $tables_id . "' LIMIT 1");
		$table_data = $sql->fetch();
		$t_modal_body = new XTemplate(cot_tplfile('quickorder.add.form', 'plug'));

		if($cfg['plugin']['quickorder']['use_field_name']){
					
			$t_modal_body->assign(array(
				'USE_FIELD_NAME' => 1,
			));
		}
		if($cfg['plugin']['quickorder']['use_field_phone']){
					
			$t_modal_body->assign(array(
				'USE_FIELD_PHONE' => 1,
			));
		}
		if($cfg['plugin']['quickorder']['use_field_email']){
					
			$t_modal_body->assign(array(
				'USE_FIELD_EMAIL' => 1,
			));
		}
		if($cfg['plugin']['quickorder']['use_field_text']){
					
			$t_modal_body->assign(array(
				'USE_FIELD_TEXT' => 1,
			));
		}
		if($cfg['plugin']['quickorder']['use_field_text2']){
					
			$t_modal_body->assign(array(
				'USE_FIELD_TEXT2' => 1,
			));
		}


		

		$t_modal_body->assign(array(
			$TBL_ID => $table_data[$table_id],
		));

		$t_modal_body->parse();
		// echo cot_tplfile('quickorder.add.form', 'plug');
		// echo $t_modal_body->text();


	

		$t->assign(array(
			$TBL_TITLE => $table_data[strtolower($TBL_TITLE)],
			'MODAL_BODY' => $t_modal_body->text()
		));

		$t->parse();
		echo $t->text();
	}

} else {
    cot_die_message(404);
}
?>
