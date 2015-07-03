<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL.');

global $L,$cfg;

$adding_error = array();

			require_once cot_incfile('reviews_add', 'plug');

			$page_cat = 'reviews';

			$rpage = array(
				'page_title' => cot_import('rpagetitle', 'P', 'TXT'),
				'page_text' => cot_import('rpagetext', 'P', 'TXT'),
				'page_ownerid' => 1,
				'page_cat' => $page_cat,
				'page_keywords' => '',
				'page_metatitle' => '',
				'page_metadesc' => '',
				'page_parser' => 'html',
				'page_author' => 'admin',
				'page_date' => time(),
				'page_begin' => time(),
				'page_updated' => time(),

			);

			if($_POST['rpagestate'] == 1 && empty($rpage['page_title'])) $adding_error['page_title'] = $L['error_page_title'];
			if($_POST['rpagestate'] == 1 && empty($rpage['page_text'])) $adding_error['page_text'] = $L['error_page_text'];

			if($adding_error){
				foreach ($adding_error as $value) {
					$t->assign('ERROR_ROW_MSG', $value);
					$t->parse('MAIN.ERROR.ERROR_ROW');
				}
				$t->parse('MAIN.ERROR');

			}elseif(pageAdd($rpage) === true){
				$t->assign('DONE_ROW_MSG', $L['add_success']);
				$t->parse('MAIN.DONE.DONE_ROW');
				$t->parse('MAIN.DONE');


			}

			$t->assign(array(
				'REVIEWS_FORM_TITLE' => cot_inputbox('text', 'rpagetitle', $rpage['page_title']),
				'REVIEWS_FORM_DESC' => cot_textarea('rpagetext', $rpage['page_text'], 10, 64, 'style="width:90%;resize: vertical;"'),
			));

			if(cot_plugin_active('mavatars')){
				require_once cot_incfile('mavatars', 'plug');
				$mavatar = new mavatar('page', $page_cat, 0);
				$t->assign('REVIEWS_FORM_MAVATAR', $mavatar->generate_upload_form());
			}
