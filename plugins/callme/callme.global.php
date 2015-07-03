<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=global
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');


	switch ($cfg['plugin']['callme']['bootstrap_version_support']) {
		case '2.x':
			$tplfile = cot_tplfile('callme.v2x', 'plug');
	  	 break;

		default: 
			$tplfile = cot_tplfile('callme.v3x', 'plug');
		 break;
	}

	$tt = new XTemplate($tplfile);
	$tt->assign(array(
		'AJAX_URL' => cot_url('page', 'e=callme'),
		'TPLFILE' => $tplfile,
	));
	
	$tt->parse('MAIN');
	$out['callme'] = $tt->text('MAIN');

	$tt = new XTemplate(cot_tplfile('callme.window', 'plug'));
	$tt->parse();
	
	$out['callmeWindow'] = $tt->text();

?>
