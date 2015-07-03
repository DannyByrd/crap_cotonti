<?php

	function cot_get_page_actions($count, $c){
		$count = is_null($count) ? 4 : $count;
		
		global $db, $db_pages, $extrafield_actions;

		$where = "page_" . $extrafield_actions . " != '0' AND page_" . $extrafield_actions . " > '" . time() . "'";
		if(!is_null($c)) $where .= ' AND page_cat=' . $db->quote($c);;
		$sql_page = $db->query("SELECT * FROM $db_pages WHERE $where LIMIT 0, " . $count);

		if($sql_page->rowCount() == 0){
			return false;
		}

		$action_pages = $sql_page->fetchAll();
		return $action_pages;
	}

	function cot_get_prd_actions($count, $c){
		$count = is_null($count) ? 4 : $count;
		
		global $db, $db_x, $db_products, $extrafield_actions;
		$db_products = (isset($db_products)) ? $db_products : $db_x . 'products';

		$where = "prd_" . $extrafield_actions . " != '0' AND prd_" . $extrafield_actions . " > '" . time() . "'";
		if(!is_null($c)) $where .= ' AND prd_cat=' . $db->quote($c);;
		$sql_prd = $db->query("SELECT * FROM $db_products WHERE $where LIMIT 0, " . $count);

		if($sql_prd->rowCount() == 0){
			return false;
		}

		$action_products = $sql_prd->fetchAll();
		return $action_products;
	}

	function cot_show_page_actions($count=4, $c=null){
		$count = is_null($count) ? 4 : $count;
		// $c = is_null($c) ? $_GET['c'] : $c;

		global $plg_name,$extrafield_actions, $supress_plg_action;
		if($supress_plg_actions) return;
		$tt = new XTemplate(cot_tplfile($plg_name . '.index', 'plug'));

		$all_actions = cot_get_page_actions($count, $c);
		// var_dump($all_actions);
		require_once cot_incfile('mavatars', 'plug');

		if($all_actions){
			foreach ($all_actions as $action){
		        $tmp_cutted_text = explode('<hr class="more" />', $action['page_text']);
		        $cutted_text = $tmp_cutted_text[0];
		        unset($tmp_cutted_text);

				$action['url'] = (empty($action['page_alias'])) ? cot_url('page', 'c='.$action['page_cat'].'&id='.$action['page_id']) : cot_url('page', 'c='.$action['page_cat'].'&al='.$action['page_alias']);
				$mavatar = new mavatar('page', $action['page_cat'], $action['page_id']);

				$tt->assign(array(
					'ACTION_ID' => $action['page_id'],
					'ACTION_URL' => $action['url'],
					'ACTION_TITLE' => $action['page_title'],
					'ACTION_TEXT' => $cutted_text,
					'ACTION_EXPIRY_DATE' => $action['page_'.$extrafield_actions],
					'ACTION_MAVATAR' => $mavatar->generate_mavatars_tags()
				));

				$tt->parse('MAIN.ACTIONS_ROW');
			}
		}

		$tt->parse();

		return $tt->text();
	}


	function cot_show_prd_actions($count=4, $c=null){
		$count = is_null($count) ? 4 : $count;
		// $c = is_null($c) ? $_GET['c'] : $c;

		global $plg_name,$extrafield_actions, $supress_plg_action;
		if($supress_plg_actions) return;
		$tt = new XTemplate(cot_tplfile($plg_name . '.index', 'plug'));

		$all_actions = cot_get_prd_actions($count, $c);
		if(!$all_actions) return;
		// var_dump($all_actions);

		foreach ($all_actions as $action){
			$cutted_text = mb_substr( $action['prd_text'], 0, 200, 'UTF-8');
			$action['url'] = (empty($action['prd_alias'])) ? cot_url('products', 'c='.$action['prd_cat'].'&id='.$action['prd_id']) : cot_url('products', 'c='.$action['prd_cat'].'&al='.$action['prd_alias']);

			$tt->assign(array(
				'ACTION_ID' => $action['prd_id'],
				'ACTION_URL' => $action['url'],
				'ACTION_TITLE' => $action['prd_title'],
				'ACTION_TEXT' => $cutted_text . ' ...',
				'ACTION_EXPIRY_DATE' => $action['prd_'.$extrafield_actions],
			));

			$tt->parse('MAIN.ACTIONS_ROW');
		}

		$tt->parse();

		return $tt->text();
	}

?>
