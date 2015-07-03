<?php

class Z_Import {

	var $file;
	var $template;
	var $post;
	var $post_counter=0;
	var $cats_counter = 0;
	var $cats_list = array ();
	var $cats_arr = array ();
	var $categories = array ();
	var $templates = array();

	function get_tag( $string, $tag ) {
		preg_match("|<($tag).*?>(.*?)</$tag>|is", $string, $return);
		
		$return = preg_replace('|^<!\[CDATA\[(.*)\]\]>$|s', '$1', $return[2]);
		$return = trim($return);
		return $return;
	}

	function get_big_tag($string, $tag ) {
		$return = '';
		
		$pos = stripos($string, "<$tag>");
		if($pos !== FALSE){
			$pos2 = strripos($string, "</$tag>");
			
			$start = $pos + strlen("<$tag>");
			$length = $pos2 - $start;

			$return = substr($string, $start, $length);		
			
			$pos = stripos($return, '<![CDATA[');		
			if($pos !== FALSE){
				$pos2 = strripos($return, ']]>');
				$start = $pos + strlen('<![CDATA[');
				$length = $pos2 - $start;
				$return = substr($return, $start, $length);
			}
		}
		
		return $return;
	}

	function create_cats_arr(){
		global $structure, $structure_name;

		require_once cot_incfile('autoalias2', 'plug');
		foreach ($this->cats_list as $c) {
			$c = trim($c);
			if(!$c) continue;

			$categorynames = $this->get_tag( $c, 'import:categoryname' );
			$categorytitles = $this->get_tag( $c, 'import:categorytitle' );

			if(empty($categorynames) || empty($categorytitles)) continue;

			$categorynames = explode('>',$categorynames);
			foreach ($categorynames as $key => $value) {
				$tmp_name_arr = explode('|', $value);
				$tmp_name = trim($tmp_name_arr[0]);
				$tmp_name = autoalias2_convert($tmp_name);
				$categorynames[$key] = $tmp_name;
			}

			$categorytitles = explode('>',$categorytitles);
			foreach ($categorytitles as $key => $value) {
				$tmp_title_arr = explode('|', $value);
				$tmp_title = trim($tmp_title_arr[0]);
				$categorytitles[$key] = $tmp_title;
			}
			
			foreach ($categorynames as $k=>$cat_code) {
				if(isset($added[$cat_code])) continue;

				$structure_code = $cat_code;
				$structure_title = $categorytitles[$k];
				$structure_desc = '';
				$structure_parent_code = $k == 0 ? '' :  $categorynames[$k-1];

				$this->cats_arr[$structure_code] = compact('structure_area', 'structure_code', 'structure_title', 'structure_desc', 'structure_parent_code');
			}														
		}

	}

	function create_page_arr(){
		global $usr;
		foreach($this->page_list as $item){
			$page_state = 0;
			$page_cat  = $this->get_tag( $item, 'import:category' ); 
			$page_title  = $this->get_tag( $item, 'import:title' );
			$page_text = $this->get_big_tag( $item, 'import:text');
			$page_ownerid = $usr['id'];
			$page_parser = 'html';
			$page_date = time();
			$page_begin = time();
			$page_updated = time();
			$page_expire = '0';

			$tmp_cats = explode('>', $page_cat);
			$page_cat = end($tmp_cats);

			$tmp_cats = explode('|', $page_cat);
			$page_cat = reset($tmp_cats);

			if(!$page_title || !$page_cat) continue;

			$this->page_arr[] = compact(
				// 'page_alias',
				'page_state',
				'page_cat',
				'page_title',
				'page_text',
				'page_parser',
				'page_ownerid',
				'page_date',
				'page_begin',
				'page_expire',
				'page_updated'
				);
		}
	}

	function create_products_arr(){
		global $usr;
		foreach($this->products_list as $item){
			$prd_state = 0;
			$prd_cat  = $this->get_tag( $item, 'import:category' ); 
			$prd_title  = $this->get_tag( $item, 'import:title' );
			$prd_text = $this->get_big_tag( $item, 'import:text');
			$prd_ownerid = $usr['id'];
			$prd_parser = 'html';
			$prd_date = time();
			$prd_date = time();
			$prd_updated = time();
			$prd_count = 100;
			// $prd_expire = '0';

			$tmp_cats = explode('>', $prd_cat);
			$prd_cat = end($tmp_cats);

			$tmp_cats = explode('|', $prd_cat);
			$prd_cat = reset($tmp_cats);

			if(!$prd_title || !$prd_cat) continue;

			$this->products_arr[] = compact(
				// 'prd_alias',
				'prd_state',
				'prd_cat',
				'prd_title',
				'prd_text',
				'prd_parser',
				'prd_ownerid',
				'prd_date',
				'prd_begin',
				'prd_expire',
				'prd_updated'
				);
		}
	}

	function create_board_arr(){
		global $usr;

		foreach($this->board_list as $item){
			$adv_state = 0;
			$adv_cat  = $this->get_tag( $item, 'import:category' ); 
			$adv_title  = $this->get_tag( $item, 'import:title' );
			$adv_text = $this->get_big_tag( $item, 'import:text');
			$adv_ownerid = $usr['id'];
			$adv_parser = 'html';
			$adv_date = time();
			$adv_date = time();
			$adv_updated = time();
			$adv_count = 100;
			$adv_expire = '0';

			$tmp_cats = explode('>', $adv_cat);
			$adv_cat = end($tmp_cats);

			$tmp_cats = explode('|', $adv_cat);
			$adv_cat = reset($tmp_cats);

			if(!$adv_title || !$adv_cat) continue;

			$this->board_arr[] = compact(
				// 'adv_alias',
				'adv_state',
				'adv_cat',
				'adv_title',
				'adv_text',
				'adv_parser',
				'adv_ownerid',
				'adv_date',
				// 'adv_begin',
				'adv_expire',
				'adv_updated'
				);
		}
	}

	function process_structure(){
		global $structure, $structure_name, $cache;

		$root_counter = 0;
		$tmp_counter = 0;
		$path_start = 999;

		foreach ($this->cats_arr as $data) {
			$structure_parent_code = $data['structure_parent_code'];
			$data['structure_area'] = $structure_name;
			unset($data['structure_parent_code']);

			if($structure_parent_code){
				$mtch = $structure[$structure_name][$structure_parent_code]['path'].'.';
				$mtchlen = mb_strlen($mtch);
				$mtchlvl = mb_substr_count($mtch,".");
				$children_counter = 0;
				foreach ($structure[$structure_name] as $i => $x){
					if(mb_substr($x['path'], 0, $mtchlen) == $mtch && mb_substr_count($x['path'],".") == $mtchlvl){
						$children_counter++;
					}
				}
				$rpath = $structure[$structure_name][$structure_parent_code]['rpath'] . '.'   . ($children_counter+1);
				$tpath = $structure[$structure_name][$structure_parent_code]['tpath'] . ' / ' . $data['structure_title'];
				$path  = $structure[$structure_name][$structure_parent_code]['path']  . '.'   . $data['structure_code'];
				$data['structure_path'] = $rpath;
			} else if(!$structure_parent_code || !cot_structure_check_by_code($data['structure_code'])){
				// root structur
				$root_counter++;
				$data['structure_path'] = $path_start+$root_counter;
				$rpath = $path_start+$root_counter;
				$tpath = $data['structure_title'];
				$path = $data['structure_code'];
			}

			if(create_structure($data)){
				$structure[$structure_name][$data['structure_code']] = array(
					'path' => $path,
					'tpath' => $tpath,
					'rpath' => $rpath,
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
				var_dump($structure[$structure_name][$data['structure_code']],$structure_parent_code, $children);
			};
			$tmp_counter++;
		}
	}

	function process_page() {
		global $db,$db_pages,$structure_name; 
		set_time_limit( 60 );
		require_once cot_incfile('page', 'module');
		
		$this->{$structure_name.'_counter'} = 0;
		foreach ($this->page_arr as $page) {
			list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('page', $page['page_cat']);

			if (!empty($page['page_alias']))
			{
				$page_count = $db->query("SELECT COUNT(*) FROM $db_pages WHERE page_alias = ?", $page['page_alias'])->fetchColumn();
				if ($page_count > 0)
				{
					cot_error("Страница <b>".$page['page_title']."</b> уже существует");
				} else{
					$res = cot_page_add($page, $usr);
					if($res !== false){
						cot_message("Страница <b>".$page['page_title']."</b> добавлена", 'ok');
						$this->{$structure_name.'_counter'}++;
					} else {
						cot_error('Error');
					}
				}
			} else {
					$res = cot_page_add($page, $usr);
					if($res !== false){
						cot_message("Страница <b>".$page['page_title']."</b> добавлена", 'ok');
						$this->{$structure_name.'_counter'}++;
					} else {
						cot_error("Страница <b>".$page['page_title']."</b> уже существует");
					}
			}
		}

		return true;
	}

	function process_products() {
		global $db,$db_products,$structure_name, $usr; 
		set_time_limit( 60 );

		require_once cot_incfile('products', 'module');

		$this->{$structure_name.'_counter'} = 0;
		foreach ($this->products_arr as $product) {

			if (!empty($product['prd_alias']))
			{
				$prd_count = $db->query("SELECT COUNT(*) FROM $db_products WHERE prd_alias = ?", $product['prd_alias'])->fetchColumn();
				if ($prd_count > 0)
				{
					cot_error("Продукт <b>".$product['prd_title']."</b> уже существует");
				} else{
					$res = cot_products_add($product);
					if($res !== false){
						cot_message("Продукт <b>".$product['prd_title']."</b> добавлен", 'ok');
						$this->{$structure_name.'_counter'}++;
					} 
				}
			} else {
					$res = cot_products_add($product);
					if($res !== false){
						cot_message("Продукт <b>".$product['prd_title']."</b> добавлен", 'ok');
						$this->{$structure_name.'_counter'}++;
					} 
			}
		}

		return true;
	}


	function process_board() {
		global $db,$db_board,$structure_name, $usr; 
		set_time_limit( 60 );

		require_once cot_incfile('board', 'module');

		$this->{$structure_name.'_counter'} = 0;
		foreach ($this->board_arr as $adv) {

			if (!empty($adv['adv_alias']))
			{
				$adv_count = $db->query("SELECT COUNT(*) FROM $db_board WHERE adv_alias = ?", $adv['adv_alias'])->fetchColumn();
				if ($adv_count > 0)
				{
					cot_error("Обьявление <b>".$adv['adv_title']."</b> уже существует");
				} else{
					$res = cot_board_add($adv);
					if($res !== false){
						cot_message("Обьявление <b>".$adv['adv_title']."</b> добавлено", 'ok');
						$this->{$structure_name.'_counter'}++;
					} 
				}
			} else {
					$res = cot_board_add($adv);
					if($res !== false){
						cot_message("Обьявление <b>".$adv['adv_title']."</b> добавлено", 'ok');
						$this->{$structure_name.'_counter'}++;
					} 
			}
		}

		return true;
	}

	function get_entries($process_add_post = NULL) {	
		global $structure_name;

		@set_magic_quotes_runtime(false);
		ini_set('magic_quotes_runtime', 0);

		$doing_entry = false;
		$is_dxr_file = false;

		$fp = fopen($this->file, 'r');
		if ($fp) {
			while ( !feof($fp) ) {
				$importline = rtrim(fgets($fp));

			$is_dxr_file = true;

				if (!$process_add_post && false !== strpos($importline, '<import:categoryitem>') ) {
					$this->post = '';
					$doing_entry = true;
					continue;
				}
				if (!$process_add_post && false !== strpos($importline, '</import:categoryitem>') ) {
					$doing_entry = false;
					if($this->post) $this->cats_list[] = $this->post;
					continue;
				}				

				if ($process_add_post && false !== strpos($importline, '<import:postitem>') ) {				
					$this->post = '';
					$doing_entry = true;
					continue;
				}
				if ($process_add_post && false !== strpos($importline, '</import:postitem>') ) {
					$doing_entry = false;
					if($this->post) $this->{$structure_name.'_list'}[] = $this->post;
					continue;
				}
				if ( $doing_entry ) {
					$this->post .= $importline . "\n";
				}
			}

			fclose($fp);
		}
		if($process_add_post){
			$this->{'create_' . $structure_name . '_arr'}();
		}else{
			$this->create_cats_arr();
		}

		return $is_dxr_file;

	}

	function import_file($file) {
		global $structure_name;
		if(!method_exists('Z_Import', 'process_'.$structure_name) || !method_exists('Z_Import', 'create_'.$structure_name.'_arr')){
			cot_error('Импорт в модуль <b>'.$structure_name . '</b> не поддерживается плагином. Обратитесь к разработчикам.');
			return false;
		}

		$this->file = $file;

		$cat_enties = $this->get_entries();
		$post_enties = $this->get_entries(true);

		if (!$cat_enties && !$post_enties){
			cot_message('Не верный формат файла', 'error');
		} else {
			$this->process_structure();
			// $this->{'process_'.$structure_name}();

			// show statistik
			$cats_added = $this->cats_counter;
			$posts_added = $this->{$structure_name.'_counter'};

			cot_message('Категорий добавленно:  <b>' . $cats_added . '</b>', 'ok');
			cot_message('Страниц в модуль <b>'.$structure_name.'</b> добавленно: <b>' . $posts_added . '</b>', 'ok');
		} 
	}

}

?>