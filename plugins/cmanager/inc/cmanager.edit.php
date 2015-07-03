<?php
defined('COT_CODE') or die('Wrong URL.');

global $cfg, $db_x, $db;




	$id =  cot_import('id', 'G', 'INT');


	$where = "cmanager.cm_id = ".$id ;

	
	$query = $db->query("SELECT * FROM  cot_cmanager AS cmanager 
					   LEFT JOIN cot_mavatars AS mavatars
					   ON cmanager.cm_mav_id = mavatars.mav_id
					   WHERE $where   LIMIT 1");


	$res = $query->fetch();					   
	

	$t = new XTemplate(cot_tplfile('cmanager.edit', 'plug'));
	$t->assign(array(
		
			'CMANAGER_FORM_ACTION'=> cot_url('cmanager', "a=edit&id=".$id),
			'CMANAGER_TITLE_VALUE'=> $res['cm_title'],
			'CMANAGER_TEXT_VALUE'=> $res['cm_text'],

		
		
		));

	if(isset($cot_plugins_active['mavatars']) ){

			$mavatar = new mavatar('contentmanager', 'cm',$res['mav_code']);
			$mavatars_tags = $mavatar->generate_mavatars_tags();

			
			
			 $t->assign(array(
			 	'CMANAGER_PAGE_MAVATAR'		=> $mavatars_tags,
			 ));
		}

	

	    if($_POST){


		$title =  cot_import('title_name', 'P', 'TXT');
		$text =  cot_import('text_name', 'P', 'TXT');


		if(!empty($title) && !empty($text)){

			  $sql = "UPDATE  $db_x"."cmanager SET cm_title = ?, cm_text = ? WHERE cm_id = ?";
			  $query = $db->prepare($sql); 
			  $query->execute(array($title,$text,$id));

		}

	   	cot_redirect(cot_url('cmanager', "a=edit&id=".$id));	

	    }//if($_POST)

	    //http://crap_cotonti/cmanager/5/?a=edit
	    if(cot_plugin_active('mavatars'))
		{
			$mavatar = new mavatar('contentmanager', 'cm', $id);
			$t->assign('CMEDIT_FORM_MAVATAR', $mavatar->generate_upload_form());
		}

		$t->parse('MAIN.CMANAGER');


		
	    $t->parse('MAIN');


	//return $t->text();
		/*

foreach ($_POST['mavatar_enabled'] as $key => $value) {
		
			
			if(!$value){

				$query = $db->query("SELECT * FROM cot_mavatars WHERE mav_id = '".$db->prep($key) ."' LIMIT 1");
				$res = $query->fetch();
				
				$file =$res['mav_filepath'].$res['mav_fileorigname'].'.'.$res['mav_fileext'];
				$db->delete('cot_mavatars', "mav_id=".$res['mav_id']);
				
				if (file_exists($file) && is_writable($file))
				{
					
					@unlink($file);
				}
				
	      
			}
		}
*/
	


