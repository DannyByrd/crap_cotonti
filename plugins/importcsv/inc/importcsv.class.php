<?php

class ICSV_Import {

	var $file;
	var $template;
	var $post;
	var $posts_added=0;
	var $posts_updated=0;
	var $cats_counter = 0;
	var $cats_updated = 0;
	var $cats_list = array ();
	var $templates = array();
	var $csv_with_header = true;
	var $csv_delimiter = ';';
	var $csv_enclosure = '"';
	var	$path_start = 999;
	var	$path_last;
	var $map = array(
		'title',	// Наименование
		'keyword',  // для ЧПУ - если пустое, то перевеодится в транслит с помощью автоалиаса
		'short_desc',
		'desc',
		'price',
		'seotitle',
		'metakeys',
		'metadesc',
		'images',
	);

	private $__currentCatPath = array();
	private $__categories = array();
	private $__root_category = '';

	function __construct(){
		global $structure, $structure_name, $structure_cat_name;
		$this->__categories = &$structure[$structure_name];
		$this->__root_category = $structure_cat_name;
		if(!empty($this->__root_category)){
			$this->__currentCatPath = explode('.', $this->__categories[$this->__root_category]['path']);
			$this->start_level = count($this->__currentCatPath);
		}
	}

	private function getCorrecrData($c){
		$c['title'] = str_replace('!', '', $c['title']);
		return $c;
	}

	private function detectLevel($title){
		$title_len = strlen($title);
		$pos = 1;
		$simbol = '';

		$next_pos = $pos;
		while ($title_len != $next_pos) {
			$next_simbol = substr($title, $next_pos-1, 1);
			if($next_simbol != '!'){
				$pos = $next_pos;
				break;
			}
		
			$next_pos++;

		}

		$pos += $this->start_level;

		return $pos;
	}

	private function changePath($cat){
		$title = $cat['title'];
		$level = count($this->__currentCatPath);
		$new_level = $this->detectLevel($title);

		if($new_level == $level+1){
			$this->__currentCatPath[] = $cat['keyword'];
			return true;
		} else if($new_level == $level){
			array_pop($this->__currentCatPath);
			$this->__currentCatPath[] = $cat['keyword'];
			return true;
		} elseif ($new_level == 1) {
			$this->__currentCatPath = array($cat['keyword']);
			return true;
		} elseif ($new_level < $level) {
			$level_diff = $level - $new_level;
			for($i=0; $i<$level_diff; $i++){
				array_pop($this->__currentCatPath);
			}
			array_pop($this->__currentCatPath);
			$this->__currentCatPath[] = $cat['keyword'];

			return true;
		}
		
		return false;
	}

	function getParentCat(){
		$count = count($this->__currentCatPath);
		if($count > 1){
			$parent_keyword = $this->__currentCatPath[$count-2];
			return $this->__categories[$parent_keyword];
		} else {
			return false;
		}

	}

	private function getStructurePath($cat){
		return implode('.', $this->__currentCatPath);
	}

	private function getStructurePaths($cat){
		if(isset($this->__categories[$cat['keyword']])){

			$cat2 = $this->__categories[$cat['keyword']];
			$structure_rpath = $cat2['rpath'];
			$structure_tpath = $cat2['tpath'];
			$structure_path  = $cat2['path'];

		} else {

			if($parent = $this->getParentCat()){
				$mtch = $parent['path'].'.';
				$mtchlen = mb_strlen($mtch);
				$mtchlvl = mb_substr_count($mtch,".");
				$children_counter = 0;
				foreach ($this->__categories as $i => $x){
					if(mb_substr($x['path'], 0, $mtchlen) == $mtch && mb_substr_count($x['path'],".") == $mtchlvl){
						$children_counter++;
					}
				}
				$structure_rpath = $parent['rpath'] . '.' . ($children_counter+1);
				$structure_tpath = $parent['tpath'] . ' / ' . $cat['title'];
			} else{
				if(is_null($this->path_last)){
					$this->path_last = $this->path_start+1;
				} else {
					$this->path_last++;
				}
				$structure_rpath = $this->path_last;
				$structure_tpath = $cat['title'];
			}

			$structure_path = $this->getStructurePath($cat);

		}

		return compact('structure_path','structure_rpath','structure_tpath');
	}


	private function addCategoryData($data){
		global $usr,$structure_name;
		$this->__categories[$data['structure_code']] = array(
					'path' =>  $data['path'],
					'rpath' =>  $data['rpath'],
					'tpath' => $data['tpath'],
					'id'	=> time(),
					'tpl' => $data['structure_code'],
					'title' => $data['structure_title'],
					'seotitle' => '',
					'desc' => '',
					'metadesc' => '',
					'icon' => '',
					'locked' => 0,
					'count' => 0,
				);
		$usr['auth'][$structure_name][$data['structure_code']] = 255;
	}

	function process_cats(){

		global $structure, $structure_name;

		if($this->cats_list)
		foreach ($this->cats_list as $c) {
			if(!$c) continue;

			array_map('trim', $c);

			$this->changePath($c);
			$c = $this->getCorrecrData($c);

			$structure_area 	= $structure_name;
			$structure_title 	= $c['title'];
			$structure_code 	= $c['keyword'];
			$structure_desc 	= $c['short_desc'];
			$structure_text 	= $c['desc'];
			$structure_seotitle = $c['seotitle'];
			$structure_metadesc = $c['metadesc'];

			$paths = $this->getStructurePaths($c);
			$structure_path 	= $paths['structure_rpath'];

			$data = compact(
							'structure_area', 
							'structure_code', 
							'structure_path', 
							'structure_title', 
							'structure_desc', 
							'structure_text', 
							'structure_seotitle', 
							'structure_metadesc'
					);
			$c['images'] = trim($c['images']);
			$images = !empty($c['images']) ? explode(',', $c['images']) : array();

			$rpath 	= $paths['structure_rpath'];
			$tpath 	= $paths['structure_tpath'];
			$path 	= $paths['structure_path'];

			$dataToAdd = compact(
							'structure_area', 
							'structure_code', 
							'structure_title', 
							'structure_desc', 
							'structure_text', 
							'structure_seotitle', 
							'structure_metadesc',
							'rpath',
							'tpath',
							'path'
					);

		    if (!isset($this->__categories[$structure_code])){
		        if(icsv_create_structure($data, $images)){
					$this->addCategoryData($dataToAdd);	
					$this->cats_counter++;
		        };
		    } else {
		        if(icsv_update_structure($data, $images)){
		         	$this->cats_updated++;
		        };
		    }
		}
	}

	function process_page() {
		global $db,$db_pages,$structure_name,$usr;

		$query = $db->query("SELECT * FROM `$db_pages` LIMIT 1;")->fetch();
		$db_pages_cols = array_keys($query);

		set_time_limit( 60 );
		require_once cot_incfile('page', 'module');
		
		if($this->page_list)
		foreach ($this->page_list as $page) {
			$prices = explode(',', $page['price']);
			$prices = array_map('trim', $prices);
			$page_state = 0;
			$page_cat  		= $page['cat'];
			$page_alias		= $page['keyword'];
			$page_title  	= $page['title']; 
			$page_desc  	= $page['short_desc']; 
			$page_text  	= $page['desc']; 
			$page_ownerid = $usr['id'];
			$page_parser = 'html';
			$page_date = time();
			$page_begin = time();
			$page_updated = time();
			$page_expire = '0';

			$data = compact(
				'page_alias',
				'page_state',
				'page_cat',
				'page_title',
				'page_text',
				'page_desc',
				'page_parser',
				'page_ownerid',
				'page_date',
				'page_begin',
				'page_expire',
				'page_updated'
			);

			foreach ($prices as $key => $value) {
				$extra_field = 'price' . ($key+1);
				if(!in_array('page_' . $extra_field, $db_pages_cols)){
					cot_error("Екстраполе <b>$extra_field</b> не найдено в модуле " . $structure_name);
					continue;
				}

				$data['page_'.$extra_field] = $value;
			}

			$page['images'] = trim($page['images']);
			$images = !empty($page['images']) ? explode(',', $page['images']) : array();


			$page_count = $db->query("SELECT COUNT(*) FROM $db_pages WHERE page_alias = ?", $data['page_alias'])->fetchColumn();
			if ($page_count > 0)
			{	
				if(icsv_update_page($data,$images)){
					cot_message("Страница <b>".$data['page_title']."</b> обновлена", 'ok');
					$this->posts_updated++;
				}
			} else{
				if(icsv_create_page($data,$images)){
					cot_message("Страница <b>".$data['page_title']."</b> добавлена", 'ok');
					$this->posts_added++;
				}
			}
		}

		return true;
	}

	function process_products(){
		global $usr,$structure,$structure_name, $db, $db_x;
		
		$db_products 		= $db_x . 'products';

		$query = $db->query("SELECT * FROM `$db_products` LIMIT 1;")->fetch();
		$db_products_cols = array_keys($query);

		require_once cot_incfile('autoalias2', 'plug');
		require_once cot_incfile('products', 'module');

		if($this->products_list)
		foreach($this->products_list as $item){
			$item = array_map('trim', $item);
			$prices = explode(',', $item['price']);
			$prices = array_map('trim', $prices);
			$prd_state 	= 0;
			$prd_cat  	= $item['cat'];
			$prd_title  = $item['title'];
			$prd_desc 	= $item['short_desc'];
			$prd_text 	= $item['desc'];
			$prd_cost 	= $item['price'];
			$prd_ownerid = $usr['id'];
			$prd_parser = 'html';
			$prd_date = time();
			$prd_date = time();
			$prd_updated = time();
			$prd_count = 100;
			$prd_alias = $item['keyword'];

			$data = compact(
				'prd_alias',
				'prd_state',
				'prd_cat',
				'prd_title',
				'prd_desc',
				'prd_text',
				'prd_cost',
				'prd_parser',
				'prd_ownerid',
				'prd_date',
				'prd_begin',
				'prd_expire',
				'prd_updated'
			);

			foreach ($prices as $key => $value) {
				$extra_field = 'price' . ($key+1);
				if(!in_array('prd_' . $extra_field, $db_products_cols)){
					cot_error("Екстраполе <b>$extra_field</b> не найдено в модуле " . $structure_name);
					continue;
				}

				$data['prd_'.$extra_field] = $value;
			}
			$item['images'] = trim($item['images']);
			$images = !empty($item['images']) ? explode(',', $item['images']) : array();

			$prd_count = $db->query("SELECT COUNT(*) FROM $db_products WHERE prd_alias = ?", $data['prd_alias'])->fetchColumn();
			if ($prd_count > 0)
			{
				if(icsv_update_products($data,$images)){
					cot_message("Продукт <b>".$data['prd_title']."</b> обновлен", 'ok');
					$this->posts_updated++;
				}
			} else{
				if(icsv_create_products($data,$images)){
					cot_message("Продукт <b>".$data['prd_title']."</b> добавлен", 'ok');
					$this->posts_added++;
				}
			}

		}
	}

	function process_board() {
		global $db,$db_board,$structure_name, $usr; 
		set_time_limit( 60 );

		require_once cot_incfile('board', 'module');

		if($this->board_list)
		foreach ($this->board_list as $adv) {

			$adv_state 		= 0;
			$adv_cat  		= $adv['cat'];
			$adv_title  	= $adv['title'];
			$adv_desc 		= $adv['short_desc'];
			$adv_text 		= $adv['desc'];
			$adv_cost 		= $adv['price'];
			$adv_ownerid 	= $usr['id'];
			$adv_parser 	= 'html';
			$adv_date 		= time();
			$adv_updated 	= time();
			$adv_count 		= 100;
			$adv_expire		= '0';
			$adv_alias		= $adv['keyword'];

			$data = compact(
				'adv_alias',
				'adv_state',
				'adv_cat',
				'adv_title',
				'adv_desc',
				'adv_text',
				'adv_cost',
				'adv_parser',
				'adv_ownerid',
				'adv_date',
				'adv_expire',
				'adv_updated'
				);

			$adv['images'] = trim($adv['images']);
			$images = !empty($adv['images']) ? explode(',', $adv['images']) : array();

			$adv_count = $db->query("SELECT COUNT(*) FROM $db_board WHERE adv_alias = ?", $data['adv_alias'])->fetchColumn();
			if ($adv_count > 0){
				if(icsv_update_board($data,$images)){
					cot_message("Обьявление <b>".$data['adv_title']."</b> обновлено", 'ok');
					$this->posts_updated++;
				}
			} else{
				if(icsv_create_board($data,$images)){
					cot_message("Обьявление <b>".$data['adv_title']."</b> добавлено", 'ok');
					$this->posts_added++;
				}
			}
		}

		return true;
	}

	function get_entries() {	
		global $structure_name;

		$row = 1;
		$all_data = array();
		$header_titles = array();
		
		$handle = fopen($this->file, "r");

		require_once cot_incfile('autoalias2', 'plug');

		while(!feof($handle)){
			$data=fgetcsv($handle,0,$this->csv_delimiter,$this->csv_enclosure);
			if(!$data) continue;
			$curr_data = array();

			if($this->csv_with_header && $row == 1){
				foreach ($data as $value) {
					$header_titles[] = iconv('windows-1251', 'utf-8', $value);
				}
			}else{
				foreach ($data as $key=>$value) {
					$map = isset($this->map[$key]) ? $this->map[$key] : $key;
					$curr_data[$map] = iconv('windows-1251', 'utf-8', $value);
				}

				$price = trim($curr_data['price']);
				if($price === ''){
					$curr_data['keyword'] = $curr_data['keyword'] == '' ? autoalias2_convert($curr_data['title']) : $curr_data['keyword'];
					$this->cats_list[] = $curr_data;
					$last_cat = $curr_data;
				} else {
					$curr_data['keyword'] = $curr_data['keyword'] == '' ? autoalias2_convert($curr_data['title']) : $curr_data['keyword'];
					$curr_data['cat'] = $last_cat['keyword'];
					$this->{$structure_name.'_list'}[] = $curr_data;
				}
			}

		    $row++;
		}

		fclose($handle);

		return true;

	}

	function import_file($file) {
		global $structure_name;
		$file_inc = cot_incfile('importcsv', 'plug', "functions.$structure_name");
		// var_dump($file_inc, file_exists($file_inc));
		if(!method_exists('ICSV_Import', 'process_'.$structure_name) || !file_exists($file_inc)){
			cot_error('Импорт в модуль <b>'.$structure_name . '</b> не поддерживается плагином. Обратитесь к разработчикам.');
			return false;
		}
		$this->file = $file;
		$this->get_entries();
		return true;
	}

	function start_import(){
		global $structure_name,$usr;
		$this->process_cats();
		require_once cot_incfile('importcsv', 'plug', "functions.$structure_name");
		$this->{'process_' . $structure_name}();

		// show statistik
		$cats_added = $this->cats_counter;
		$cats_updated = $this->cats_updated;
		$posts_added = $this->posts_added;
		$posts_updated = $this->posts_updated;

		cot_message('---------------------------------------', 'ok');
		cot_message('Категорий добавленно:  <b>' . $cats_added . '</b>', 'ok');
		cot_message('Категорий обновлено:  <b>' . $cats_updated . '</b>', 'ok');
		cot_message('Страниц добавленно: <b>' . $posts_added . '</b>', 'ok');
		cot_message('Страниц обновлено: <b>' . $posts_updated . '</b>', 'ok');
	}

}

?>