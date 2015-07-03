<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');
if($data = cot_import('multiforms', 'P', 'ARR')){
	if($formId = $data['form_id']){
		// var_dump($data);
		$files = array();
		if($_FILES){
			foreach ($_FILES['multiforms_files'] as $param_name => $params_val) {
				foreach ($params_val as $num => $value) {
					if(empty($value)) break;
					$files[$num][$param_name] = $value;
				}
			}
		}

		$formHandler = cot_incfile('multiforms', 'plug', 'handler.' . $formId);
		$formHandlerDefault = cot_incfile('multiforms', 'plug', 'handler.default');
		if(file_exists($formHandler)){
			require_once $formHandler;
		} else {
			require_once $formHandlerDefault;
		}

	} else {
		cot_die_message(404);
	}
} else{
	cot_die_message(404);
}