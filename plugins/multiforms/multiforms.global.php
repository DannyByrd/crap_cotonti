<?php

/*
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL');

function cot_multiforms_show_form($name){


	$t = new XTemplate(cot_tplfile(array('multiforms', 'form', $name), 'plug'));

	$t->assign(array(
			'MULTIFORMS_FORM_ACTION' => cot_url('multiforms'),
			'MULTIFORMS_FORM_ID' => $name,
			'MULTIFORMS_FORM_ID_HIDDEN' => cot_inputbox('hidden', 'multiforms[form_id]', $name, '')
		));

	$t->parse();

    return $t->text();
}

?>