<?php

defined('COT_CODE') or die('Wrong URL');


function cot_latestnews_config_pagecat(){

	global $db;
	 
	$where = "structure_area = 'page' AND structure_code NOT LIKE 'system' ";
	$query = $db->query("SELECT * FROM cot_structure WHERE $where ");
	$res = $query->fetchAll();
	
	$options_page = array();
	
	foreach ($res as $value) {

	   $options_page[] =$value['structure_title'];
	}
	
	return array_values($options_page);
  
}
function cot_latestnews_config_blogscat(){

	global $db;
	
	$where = "structure_area = 'blogs' AND structure_code NOT LIKE 'system' ";
	$query = $db->query("SELECT * FROM cot_structure WHERE $where ");
	$res = $query->fetchAll();
	
	$options_page = array();
	
	foreach ($res as $value) {

	   $options_page[] =$value['structure_title'];
	}
	
	return array_values($options_page);
  
}
function cot_latestnews_config_vacanciescat(){

	global $db;
	
	$where = "structure_area = 'vacancies' AND structure_code NOT LIKE 'system' ";
	$query = $db->query("SELECT * FROM cot_structure WHERE $where ");
	$res = $query->fetchAll();
	
	$options_page = array();



	foreach ($res as $value) {

	   $options_page[] =$value['structure_title'];
	}
	
	return array_values($options_page);
}
  

function cot_latestnews_config_rezumecat(){

	global $db;
	
	$where = "structure_area = 'rezume' AND structure_code NOT LIKE 'system' ";
	$query = $db->query("SELECT * FROM cot_structure WHERE $where ");
	$res = $query->fetchAll();
	
	$options_page = array();
	
	foreach ($res as $value) {

	   $options_page[] =$value['structure_title'];
	}
	
	return array_values($options_page);
  
}
function cot_latestnews_config_afishacat(){

	global $db;
	
	$where = "structure_area = 'afisha' AND structure_code NOT LIKE 'system' ";
	$query = $db->query("SELECT * FROM cot_structure WHERE $where ");
	$res = $query->fetchAll();
	
	$options_page = array();
	
	foreach ($res as $value) {

	   $options_page[] =$value['structure_title'];
	}
	
	return array_values($options_page);
  
}
function cot_latestnews_config_prdcat(){

	global $db;
	
	$where = "structure_area = 'products' AND structure_code NOT LIKE 'system' ";
	$query = $db->query("SELECT * FROM cot_structure WHERE $where ");
	$res = $query->fetchAll();
	
	$options_page = array();
	
	foreach ($res as $value) {

	   $options_page[] =$value['structure_title'];
	}
	
	return array_values($options_page);
  
}
function cot_latestnews_config_firmscat(){

	global $db;
	
	$where = "structure_area = 'firms' AND structure_code NOT LIKE 'system' ";
	$query = $db->query("SELECT * FROM cot_structure WHERE $where ");
	$res = $query->fetchAll();
	
	$options_page = array();
	
	foreach ($res as $value) {

	   $options_page[] =$value['structure_title'];
	}
	
	return array_values($options_page);
  
}
function cot_latestnews_config_boardcat(){

	global $db;
	
	$where = "structure_area = 'board' AND structure_code NOT LIKE 'system' ";
	$query = $db->query("SELECT * FROM cot_structure WHERE $where ");
	$res = $query->fetchAll();

	$options_page = array();
	
	foreach ($res as $value) {

	   $options_page[] =$value['structure_title'];
	}
	
	return array_values($options_page);
  
}


function cot_show_latestnews($limit=5,$cur_module = null){

	global $db, $db_x, $cfg, $cot_plugins_active;

	//$cur_module = cot_import('e','G','TXT');
	if(is_null($cur_module))
		$cur_module = 'page';
	
	$now = time();

	//$hmm = $cfg['plugin']['latestnews']['order'];
	
	$cat_array = array();
	$cat_array['board']  = (!empty($cfg['plugin']['latestnews']['boardcat'])) ? $cfg['plugin']['latestnews']['boardcat']:0;
	$cat_array['page']  =  (!empty($cfg['plugin']['latestnews']['pagecat'])) ? $cfg['plugin']['latestnews']['pagecat']: 0;
	$cat_array['firms']  = (!empty($cfg['plugin']['latestnews']['firmscat'])) ? $cfg['plugin']['latestnews']['firmscat']: 0;
	$cat_array['products']  =  (!empty($cfg['plugin']['latestnews']['prdcat'])) ? ($cfg['plugin']['latestnews']['prdcat']): 0;
	$cat_array['blogs'] =  (!empty($cfg['plugin']['latestnews']['blogscat'])) ? ($cfg['plugin']['latestnews']['blogscat']): 0;
	$cat_array['afisha'] = (!empty($cfg['plugin']['latestnews']['afishacat'])) ? ($cfg['plugin']['latestnews']['afishacat']): 0;
	$cat_array['rezume'] = (!empty($cfg['plugin']['latestnews']['rezumecat'])) ? ($cfg['plugin']['latestnews']['rezumecat']): 0;
	$cat_array['vacancies'] = (!empty($cfg['plugin']['latestnews']['vacanciescat'])) ? ($cfg['plugin']['latestnews']['vacanciescat']): 0;



	foreach ($cat_array as $key => &$value) {
		
			 $query = $db->query("SELECT structure_code FROM ".$db_x."structure WHERE  structure_area LIKE '".$key."' AND structure_title LIKE '".$value."'");
			 $cat = $query->fetch();
			 
			
			 if(is_array($cat)){
			  	
			  	foreach ($cat as $key) {
			  		
			  	//	var_dump($key);
			  		$value = $key;
			  	}
			 	
			  }else
			     $value = $cat;
		

			
	}	
	unset($value);
	
	
	

	
//	$query = $db->query("SELECT structure_code FROM ".$db_x.$cur_module." WHERE structure_title = ");

	$where_adv = "adv_state = 0  AND  (adv_expire LIKE '0' OR adv_expire > $now) AND  adv_cat LIKE '".$cat_array['board']."' ";
	$where_afisha = "event_state = 0  AND  (event_expire LIKE '0' OR event_expire > $now) AND  event_cat LIKE '".$cat_array['afisha']."' ";
	$where_rezume = "rez_state = 0  AND  rez_cat LIKE '".$cat_array['rezume']."' ";
	$where_vac = "vac_state = 0  AND  vac_cat LIKE '".$cat_array['vacancies']."' ";
    $where_firm = "firm_state = 0 AND  firm_cat LIKE '".$cat_array['firms']."' ";
    $where_prd = "prd_state = 0  AND  prd_cat LIKE '".$cat_array['products']."' ";
    $where_blogs = "post_state = 0  AND  post_cat LIKE '".$cat_array['blogs']."' ";
	$where_page = "page_state = 0 AND page_begin < $now AND (page_expire LIKE '0' OR page_expire > $now ) AND page_cat LIKE '".$cat_array['page']."'";
   
	
	
	switch ($cur_module) {
		case 'page'     : $db_pages = $db_x.'pages'; $table_id = 'page_id'; $order = 'page_date DESC'; $where = $where_page; $tcat = 'page_cat'; $tid = 'page_id'; $alias = 'page_alias'; $t_text = 'page_text'; $parser = 'page_parser'; $t_title ='page_title'; $t_desc = 'page_desc'; $date = 'page_date'; $count = 'page_count'; break;
		case 'board'    : $db_pages = $db_x.'board'; $table_id = 'adv_id';  $order = 'adv_date DESC';  $where = $where_adv; $tcat = 'adv_cat'; $tid = 'adv_id';$alias = 'adv_alias'; $t_text = 'adv_text'; $parser = 'adv_parser'; $t_title ='adv_title'; $t_desc = 'adv_desc'; $date = 'adv_date'; $count = 'adv_count'; break;
		case 'firms'    : $db_pages = $db_x.'firms'; $table_id = 'firm_id';  $order = 'firm_date DESC'; $where = $where_firm; $tcat = 'firm_cat'; $tid = 'firm_id';$alias = 'firm_alias'; $t_text = 'firm_text'; $parser = 'firm_parser'; $t_title ='firm_title'; $t_desc = 'firm_desc'; $date = 'firm_date'; $count = 'firm_count'; break;
		case 'products' : $db_pages = $db_x.'products'; $table_id = 'prd_id'; $order = 'prd_date DESC'; $where = $where_prd; $tcat = 'prd_cat'; $tid = 'prd_id'; $alias = 'prd_alias';$t_text = 'prd_text'; $parser = 'prd_parser'; $t_title ='prd_title'; $t_desc = 'prd_desc'; $date = 'prd_date'; $count = 'prd_count'; break;
		case 'afisha'   : $db_pages = $db_x.'afisha'; $table_id = 'event_id'; $order = 'event_date DESC'; $where = $where_afisha; $tcat = 'event_cat'; $tid = 'event_id'; $alias = 'event_alias';$t_text = 'event_text'; $parser = 'event_parser'; $t_title ='event_title'; $t_desc = 'event_desc'; $date = 'event_date'; $count = 'event_count'; break;
		case 'rezume'   : $db_pages = $db_x.'rezume'; $table_id = 'rez_id'; $order = 'rez_date DESC'; $where = $where_rezume; $tcat = 'rez_cat'; $tid = 'rez_id'; $alias = 'rez_alias';$age = 'rez_age'; $salary = 'rez_salary'; $t_title ='rez_title'; $t_desc = 'rez_desc'; $rez_sex='rez_sex'; $rez_exp='rez_exp'; $work='rez_works'; $study_term='rez_study'; $rez_qua='rez_qua'; $fio='rez_fio';$addr='rez_addr'; $phone='rez_phone'; $skype='rez_skype'; $site='rez_site'; $email='rez_email'; $text=''; $date = 'rez_date'; $count = 'rez_count'; break;
	    case 'vacancies': $db_pages = $db_x.'vacancies'; $table_id = 'vac_id'; $order = 'vac_date DESC'; $where = $where_vac; $tcat = 'vac_cat'; $tid = 'vac_id'; $alias = 'vac_alias';$age = 'vac_age'; $salary = 'vac_salary'; $t_title ='vac_title'; $t_desc = 'vac_desc'; $rez_sex='vac_sex'; $rez_exp='vac_exp'; $work='vac_duty'; $study_term='vac_term'; $rez_qua='vac_qua'; $fio='';$addr='vac_addr'; $phone='vac_phone'; $skype='vac_skype'; $site='vac_site'; $email='vac_email'; $text=''; $date = 'vac_date';  $count = 'vac_count'; break;
	    case 'blogs'    : $db_pages = $db_x.'blogs'; $table_id = 'post_id';  $order = 'post_date DESC'; $where = $where_blogs; $tcat = 'post_cat'; $tid = 'post_id';$alias = 'post_alias'; $t_text = 'post_text'; $parser = 'post_parser'; $t_title ='post_title'; $t_desc = 'post_desc'; $date = 'post_date'; $count = 'post_count'; break;

			
	}
	
       
	
	$query = $db->query("SELECT * FROM  $db_pages AS modules 
					   LEFT JOIN cot_mavatars AS mavatars
					   ON modules.".$table_id." = mavatars.mav_code
					   WHERE $where GROUP BY $table_id ORDER BY $order LIMIT 0,".(int)$limit);
	$news = $query->fetchAll();
	
  
    
	//$t = new XTemplate(cot_tplfile('latestnews', 'plug'));
	$t = new XTemplate(cot_tplfile('latestnews.'.$cur_module, 'plug'));
	
	if(isset($cot_plugins_active['mavatars']) && $cot_plugins_active['mavatars'] === true){
		require_once cot_incfile('mavatars', 'plug');
	}


	foreach ($news as $page) {

		
		
		if(isset($cot_plugins_active['mavatars']) && $cot_plugins_active['mavatars'] === true){

			$mavatar = new mavatar($cur_module, $page[$tcat], $page[$tid]);
			$mavatars_tags = $mavatar->generate_mavatars_tags();
			
			 $t->assign(array(
			 	'LATESTNEWS_PAGE_MAVATAR'		=> $mavatars_tags,
			 	'LATESTNEWS_PAGE_MAVATARCOUNT'	=> count($mavatars_tags)
			 ));
		}

		$correctDate =  date( 'Y-m-d H:i', $page[$date]*1);
		if($cur_module === 'rezume' || $cur_module === 'vacancies'){

			 $t->assign(array(
			 	'LATESTNEWS_PAGE_SEX'		=> $page[$rez_sex],
			 	'LATESTNEWS_PAGE_EXP'		=> $page[$rez_exp],
			 	'LATESTNEWS_PAGE_WORK'		=> $page[$work],
			  	'LATESTNEWS_PAGE_STDTERM'	=> $page[$study_term],
			 	'LATESTNEWS_PAGE_QUA'		=> $page[$rez_qua],
			 	'LATESTNEWS_PAGE_FIO'		=> $page[$fio],
			 	'LATESTNEWS_PAGE_ADDR'		=> $page[$addr],
			 	'LATESTNEWS_PAGE_PHONE'		=> $page[$phone],
			 	'LATESTNEWS_PAGE_SKYPE'		=> $page[$skype],
			 	'LATESTNEWS_PAGE_SITE'		=> $page[$site],
			 	'LATESTNEWS_PAGE_EMAIL'		=> $page[$email],
			 	'LATESTNEWS_PAGE_DATE'      => $correctDate,
			 	'LATESTNEWS_PAGE_COUNT'     => $page[$count],
			 	
			 	
			 ));


		}

		$url_params = 'c='.$page[$tcat];
		$url_params .= empty($page[$alias]) ? '&id=' . $page[$alias] : '&al=' . $page[$alias];
		$text = cot_parse($page[$t_text], $cfg[$cur_module]['markup'], $page[$parser]);
		
		$text_cut = cot_cut_more($text);
		if ($textlength > 0 && mb_strlen($text_cut) > $textlength)
		{
			$text_cut = cot_string_truncate($text_cut, $textlength);
		}
		$cutted = (mb_strlen($text) > mb_strlen($text_cut)) ? true : false;
		$cat_url = cot_url($cur_module, 'c=' . $page[$tcat]);

	
		 $t->assign(array(
		 	'LATESTNEWS_PAGE_ID'		=>$page[$table_id],
		 	'LATESTNEWS_PAGE_ALIAS'		=>$page[$alias],
			'LATESTNEWS_PAGE_TITLE'     => htmlspecialchars($page[$t_title], ENT_COMPAT, 'UTF-8', false),
		 	'LATESTNEWS_PAGE_DESC'		=>$page[$t_desc],
		 	'LATESTNEWS_PAGE_TEXT'		=>$text,
			'LATESTNEWS_PAGE_TEXT_CUT'  => $text_cut,
		 	//'LATESTNEWS_PAGE_AUTHOR'	=>$page['page_author'],
		 //	'LATESTNEWS_PAGE_BEGIN'		=>$page['page_begin'],
		 	'LATESTNEWS_PAGE_URL'		=>cot_url($cur_module, $url_params),
			'LATESTNEWS_PAGE_CATURL'    => $cat_url,
			'LATESTNEWS_PAGE_DATE'      => $correctDate,
			'LATESTNEWS_PAGE_COUNT'     => $page[$count],

		 ));

		$t->parse('MAIN.LATESTNEWS_ROW');
	}
	 

	$t->parse();

	return $t->text();

}

