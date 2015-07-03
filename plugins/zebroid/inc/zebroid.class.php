<?php

class Z_Import {

	var $file;
	var $template;
	var $post;
	// var $posts_list = array ();
	// var $posts_arr = array ();
	var $cats_list = array ();
	var $cats_arr = array ();
	var $categories = array ();
	var $templates = array();
	var $_not_to_add_cat = false;



	function get_tag( $string, $tag ) {
		preg_match("|<($tag).*?>(.*?)</$tag>|is", $string, $return);
		
		$return = preg_replace('|^<!\[CDATA\[(.*)\]\]>$|s', '$1', $return[2]);
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
		global $structure_name;
		$c_counter_0=0;
		foreach ($this->cats_list as $c) {
			$c_counter_0++;
			$structure_code = trim($this->get_tag( $c, 'modx:category_nicename' ));
			$structure_title = trim($this->get_tag( $c, 'modx:cat_name' ));
			$parent = trim($this->get_tag( $c, 'modx:category_parent' ));
			$structure_desc = trim($this->get_tag( $c, 'description' ));
			$structure_area = $structure_name;

			if (cot_structure_get_by_code($structure_code)) {
				cot_message("Категории не добавлены. Категория <b>".$structure_title."</b> уже существует", 'error');
				$this->_not_to_add_cat = true;
			} else{
				if($this->_not_to_add_cat) continue;
				$structure_parents = array();
				if ($parent) {
					$structure_parents = count($this->cats_arr[$parent]['structure_parents']) > 0 ? 
						array_merge($this->cats_arr[$parent]['structure_parents'],  array($parent)) :
						array($parent);

					$curr_level = count($structure_parents);
					if(!isset($c_counter_{$curr_level})) $c_counter_{$curr_level} = 0;

					$c_counter_{$curr_level}++;

					$structure_path =$this->cats_arr[$parent]['structure_path'] . '.' . $c_counter_{$curr_level};

				} else {
					$structure_path = $c_counter_0;
				}

				$this->cats_arr[$structure_code] = compact('structure_area', 'structure_code', 'structure_path', 'structure_title', 'structure_desc', 'structure_parents');
			}
		}
	}


	function create_page_arr(){
		global $usr;
		foreach($this->page_list as $item){
			$page_alias  = $this->get_tag( $item, 'alt_name' );
			$page_state = 0;
			$page_cat  = $this->get_tag( $item, 'category' ); 
			$page_title  = $this->get_tag( $item, 'title' );
			$page_text = $this->get_big_tag( $item, 'full_story');
			$page_ownerid = $usr['id'];
			$page_parser = 'html';
			$page_date = time();
			$page_begin = time();
			$page_updated = time();
			$page_expire = '0';

			$this->page_arr[] = compact('page_alias', 'page_state', 'page_cat', 'page_title', 'page_text', 'page_parser', 'page_ownerid', 'page_date', 'page_begin', 'page_expire', 'page_updated');
		}
		// var_dump($this->page_arr);
	}

	function process_structure() {
		global $structure_name, $structure_cat_name, $structure_cat_path;
		
		require_once cot_incfile('structure');

		$counter = 1;
		$path_root_sufix = 1;
		$structure_path = $structure_cat_path . '.' . $counter;

		while (cot_structure_check_path_exists($structure_name, $structure_path) !== '0') {
			$path_root_sufix = $counter*1000;
			$structure_path = $structure_cat_path . '.' . $path_root_sufix;
			$counter++;
		}

		foreach ($this->cats_arr as $cat_code => $cat_arr) {
			if(count($cat_arr['structure_parents']) == 0){
				$cat_arr['structure_path'] = $path_root_sufix;
			}
			unset($cat_arr['structure_parents']);
			$cat_arr['structure_path'] = $structure_cat_path . '.' . $cat_arr['structure_path'];

			$res = cot_structure_add($structure_name, $cat_arr);
			if ($res === true)
			{
				cot_message("Категория <b>".$cat_arr['structure_title']."</b> добавлена");
			}
			elseif (is_array($res))
			{
				cot_error($res[0], $res[1]);
			}
			else
			{
				cot_error('Error');
			}
		}

	}

	function process_page() {
		global $db,$db_pages; 
		set_time_limit( 60 );
		require_once cot_incfile('page', 'module');
		
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
					} else {
						cot_error('Error');
					}
				}
			} else {
					$res = cot_page_add($page, $usr);
					if($res !== false){
						cot_message("Страница <b>".$page['page_title']."</b> добавлена", 'ok');
					} else {
						cot_error('Error');
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

				// this doesn't check that the file is perfectly valid but will at least confirm that it's not the wrong format altogether
				if ( !$is_dxr_file && preg_match('|xmlns:modx="http://zebroid|', $importline) ) 
					$is_dxr_file = true;

				if (!$process_add_post && false !== strpos($importline, '<modx:category>') ) {
					$this->post = '';
					$doing_entry = true;
					continue;
				}
				if (!$process_add_post && false !== strpos($importline, '</modx:category>') ) {
					$doing_entry = false;
					if($this->post) $this->cats_list[] = $this->post;
					continue;
				}				

				if ($process_add_post && false !== strpos($importline, '<item>') ) {				
					$this->post = '';
					$doing_entry = true;
					continue;
				}
				if ($process_add_post && false !== strpos($importline, '</item>') ) {
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
		$this->file = $file;

		$cat_enties = $this->get_entries();
		$post_enties = $this->get_entries(true);

		if (!$cat_enties && !$post_enties){
			cot_message('Не верный формат файла', 'error');
		} else {
			if(!$this->_not_to_add_cat) $this->process_structure();
			$this->{'process_'.$structure_name}();
			// $this->get_entries(array(&$this, 'process_post'));
		} 
	}

}

?>