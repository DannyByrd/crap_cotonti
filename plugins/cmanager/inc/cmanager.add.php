<?php
defined('COT_CODE') or die('Wrong URL.');

global $cfg, $db_x, $db;


	$t = new XTemplate(cot_tplfile('cmanager.add', 'plug'));

	$query = $db->query("SELECT cm_id FROM $db_x"."cmanager ORDER BY cm_id DESC LIMIT 1");
	
	$lastId = $query->fetch();
	
	$lastId = $lastId['cm_id'] + 1;

	
		
	

	if($_POST){

		
		//var_dump($_POST);
		$id =  cot_import('idField', 'P', 'INT');
		$title =  cot_import('title_name', 'P', 'TXT');
		$text =  cot_import('text_name', 'P', 'TXT');


		
		
		
		if(!empty($id) && !empty($title) && !empty($text)){

		 $query = $db->query("SELECT mav_id FROM $db_x"."mavatars  WHERE mav_category = 'cm_".$db->prep($id)."' AND mav_code = 'new' ");
		 $res_id = $query->fetch();
		

		
		$cm_data = array();
		$cm_data['cm_mav_id'] = (int)$res_id['mav_id'];
		$cm_data['cm_title'] = $title;
		$cm_data['cm_text'] = $text;

		$db->insert($db_x."cmanager", $cm_data);
		
		$Lid = $db->lastInsertId();
		
		
		$sql = "UPDATE  $db_x"."mavatars SET mav_code = ?, mav_category = ? WHERE mav_id = ?";
		$query = $db->prepare($sql); 
		//$query->execute(array('cm_'.$res_id['mav_id'],'cm',$res_id['mav_id']));
		$query->execute(array($Lid,'cm',$res_id['mav_id']));




		
		
		cot_redirect(cot_url('cmanager', 'a=edit&id='.$id));
		

		}else{

			$t->assign(array(
		
			'CMANAGER_TITLE_VALUE'=> $title,
			'CMANAGER_TEXT_VALUE'=> $text,
		
		
		));


		}
		
	}

	

	
	
	if(cot_plugin_active('mavatars'))
	{

		$mavatar = new mavatar('contentmanager', 'cm_'.$lastId, 'new');
		$t->assign('CMANMADD_FORM_MAVATAR', $mavatar->generate_upload_form());

	}

	//$mavatar = new mavatar('contentmanager','', 'cm_head');
	//$mavatars_tags = $mavatar->generate_mavatars_tags();

	$t->assign(array(
		'CMANAGER_ID'=> $lastId,
		'CMANAGER_TITLE_NAME'=> 'titleName_'.$lastId,
		'CMANAGER_TEXT_NAME'=> 'textName_'.$lastId,
		
		
		));


   

	$t->parse('MAIN.CMANAGER');

	$t->parse('MAIN');