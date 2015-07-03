<?php
/**
 * Edit page.
 *
 * @package Page
 * @copyright (c) Cotonti Team
 * @license https://github.com/Cotonti/Cotonti/blob/master/License.txt
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forms');

$id = cot_import('id', 'G', 'INT');
$c = cot_import('c', 'G', 'TXT');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('page', 'any');

/* === Hook === */
foreach (cot_getextplugins('page.edit.first') as $pl)
{
	include $pl;
}
/* ===== */

cot_block($usr['auth_read']);

if (!$id || $id < 0)
{
	cot_die_message(404);
}
$sql_page = $db->query("SELECT * FROM $db_pages WHERE page_id=$id LIMIT 1");
if($sql_page->rowCount() == 0)
{
	cot_die_message(404);
}
$row_page = $sql_page->fetch();

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('page', $row_page['page_cat']);

$parser_list = cot_get_parsers();
$sys['parser'] = $row_page['page_parser'];

if ($a == 'update')
{
	/* === Hook === */
	foreach (cot_getextplugins('page.edit.update.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_block($usr['isadmin'] || $usr['auth_write'] && $usr['id'] == $row_page['page_ownerid']);

//	save show pages in other categories
	$oldCats = $db->query("SELECT structure_code FROM $db_pages_in_structure WHERE page_id = " . (int)$id . " GROUP BY structure_code")->fetchAll();
	$rpagecattoshow = $_POST['rpagecattoshow'];
	$rpagecattoshow[] = $row_page['page_cat'];
	$rpagecattoshow = array_unique($rpagecattoshow);
	$db->delete($db_pages_in_structure, "page_id = ?", $id);
 	foreach ($rpagecattoshow as $catToShow) {
		if($catToShow){
			$db->insert($db_pages_in_structure, array(
				'page_id' => (int)$id,
				'structure_code' => $catToShow,
			));
		}
	}
	$newCats = $db->query("SELECT structure_code FROM $db_pages_in_structure WHERE page_id = " . (int)$id . " GROUP BY structure_code")->fetchAll();
	$mergeCats = array();
// update structude counts
	foreach ($oldCats as $code) $mergeCats[] = $code['structure_code'];
	foreach ($newCats as $code) $mergeCats[] = $code['structure_code'];
	$mergeCats = array_unique($mergeCats);
	foreach ($mergeCats as $code){
		$newCount = $db->query("SELECT COUNT(*) AS count FROM $db_pages_in_structure WHERE structure_code = " . $db->quote($code))->fetch();
		// $newCount = $db->query("SELECT COUNT(*) AS count FROM $db_pages_in_structure WHERE structure_code = " . $db->quote($code) . " GROUP BY page_id")->fetch();
		$newCount = $newCount['count'];
		$db->update($db_structure, array(
			'structure_count' => (int)$newCount,
		), "structure_code = " . $db->quote($code));
	}
	$cache && $cache->clear();


	$rpage = cot_page_import('POST', $row_page, $usr);

	//var_dump($rpage); die('STP!');

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$rpagedelete = cot_import('rpagedelete', 'P', 'BOL');
	}
	else
	{
		$rpagedelete = cot_import('delete', 'G', 'BOL');
		cot_check_xg();
	}

	if ($rpagedelete)
	{
		cot_page_delete($id, $row_page);
		cot_redirect(cot_url('page', "c=" . $row_page['page_cat'], '', true));
	}

	/* === Hook === */
	foreach (cot_getextplugins('page.edit.update.import') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_page_validate($rpage);

	/* === Hook === */
	foreach (cot_getextplugins('page.edit.update.error') as $pl)
	{
		include $pl;
	}
	/* ===== */





	if (!cot_error_found())
	{
		
		cot_page_update($id, $rpage);

		switch ($rpage['page_state'])
		{
			case 0:
				$urlparams = empty($rpage['page_alias']) ?
					array('c' => $rpage['page_cat'], 'id' => $id) :
					array('c' => $rpage['page_cat'], 'al' => $rpage['page_alias']);
				$r_url = cot_url('page', $urlparams, '', true);
				break;
			case 1:
				$r_url = cot_url('message', 'msg=300', '', true);
				break;
			case 2:
				cot_message($L['page_savedasdraft']);
				$r_url = cot_url('page', 'm=edit&id=' . $id, '', true);
				break;
		}
		cot_redirect($r_url);
	}
	else
	{
		cot_redirect(cot_url('page', "m=edit&id=$id", '', true));
	}
}

$pag = $row_page;

$pag['page_status'] = cot_page_status($pag['page_state'], $pag['page_begin'],$pag['page_expire']);

cot_block($usr['isadmin'] || $usr['auth_write'] && $usr['id'] == $pag['page_ownerid']);

$out['subtitle'] = $L['page_edittitle'];
$out['head'] .= $R['code_noindex'];
$sys['sublocation'] = $structure['page'][$pag['page_cat']]['title'];

$mskin = cot_tplfile(array('page', 'edit', $structure['page'][$pag['page_cat']]['tpl']));

/* === Hook === */
foreach (cot_getextplugins('page.edit.main') as $pl)
{
	include $pl;
}
/* ===== */

$tarrif_list = array();
foreach ($cfg['plugin']['tariffs'] as $key => $value) {
	

	$tarrif_list[] = $value;
}

 asort($tarrif_list);


 	
	switch ($pag['page_tariff']) {
		case  "bronze": $tariff =  $cfg['plugin']['tariffs']['first_tariff']; break;
		case  "silver":  $tariff = $cfg['plugin']['tariffs']['second_tariff'];  break;
		case  "gold":   $tariff = $cfg['plugin']['tariffs']['third_tariff'];  break;
				
		default: $tariff = "null"; break;
					
	}
	$pag['page_tariff'] = $tariff;
	
$set_tarrif_list = array();
foreach ($pag as $key => $value) {
	
	$set_tarrif_list[] = $key;
}


$need_del_items = array('page_id','page_state','page_ownerid','page_expire','page_updated','page_file','page_url','page_size','page_filecount','page_tpl','page_tariff','page_settariff','page_status');

foreach ($need_del_items as $key_del) {
		$res_search = array_search ($key_del,$set_tarrif_list);
	     if(is_int($res_search)){
	     	unset($set_tarrif_list[$res_search]);
	     }
	
}

$lang_tarrif_list = array();


foreach ($set_tarrif_list as $key ) {

	$lang_tarrif_list[$key] = (!is_null($L[$key])) ? $L[$key] : $key;

}


$pag['page_settariff'] = explode(',',$pag['page_settariff'] );


require_once $cfg['system_dir'].'/header.php';
$t = new XTemplate($mskin);

$pageedit_array = array(
	'PAGEEDIT_PAGETITLE' => $L['page_edittitle'],
	'PAGEEDIT_SUBTITLE' => $L['page_editsubtitle'],
	'PAGEEDIT_FORM_SEND' => cot_url('page', "m=edit&a=update&id=".$pag['page_id']),
	'PAGEEDIT_FORM_ID' => $pag['page_id'],
	'PAGEEDIT_FORM_STATE' => $pag['page_state'],
	'PAGEEDIT_FORM_STATUS' => $pag['page_status'],
	'PAGEEDIT_FORM_LOCALSTATUS' => $L['page_status_'.$pag['page_status']],
	'PAGEEDIT_FORM_CAT' => cot_selectbox_structure('page', $pag['page_cat'], 'rpagecat'),
	'PAGEEDIT_FORM_CAT_SHORT' => cot_selectbox_structure('page', $pag['page_cat'], 'rpagecat', $c),
	'PAGEEDIT_FORM_KEYWORDS' => cot_inputbox('text', 'rpagekeywords', $pag['page_keywords'], array('size' => '32', 'maxlength' => '255')),
	'PAGEEDIT_FORM_METATITLE' => cot_inputbox('text', 'rpagemetatitle', $pag['page_metatitle'], array('size' => '64', 'maxlength' => '255')),
	'PAGEEDIT_FORM_METADESC' => cot_textarea('rpagemetadesc', $pag['page_metadesc'], 2, 64, array('maxlength' => '255')),
	'PAGEEDIT_FORM_ALIAS' => cot_inputbox('text', 'rpagealias', $pag['page_alias'], array('size' => '32', 'maxlength' => '255')),
	'PAGEEDIT_FORM_TPL' => cot_inputbox('text', 'rpagetpl', $pag['page_tpl'], array('size' => '32', 'maxlength' => '120')),
	'PAGEEDIT_FORM_TITLE' => cot_inputbox('text', 'rpagetitle', $pag['page_title'], array('size' => '64', 'maxlength' => '255')),
	'PAGEEDIT_FORM_DESC' => cot_textarea('rpagedesc', $pag['page_desc'], 2, 64, '', 'input_textarea_editor'),
	'PAGEEDIT_FORM_AUTHOR' => cot_inputbox('text', 'rpageauthor', $pag['page_author'], array('size' => '24', 'maxlength' => '100')),
	'PAGEEDIT_FORM_DATE' => cot_selectbox_date($pag['page_date'], 'long', 'rpagedate').' '.$usr['timetext'],
	'PAGEEDIT_FORM_DATENOW' => cot_checkbox(0, 'rpagedatenow'),
	'PAGEEDIT_FORM_BEGIN' => cot_selectbox_date($pag['page_begin'], 'long', 'rpagebegin').' '.$usr['timetext'],
	'PAGEEDIT_FORM_EXPIRE' => cot_selectbox_date($pag['page_expire'], 'long', 'rpageexpire').' '.$usr['timetext'],
	'PAGEEDIT_FORM_UPDATED' => cot_date('datetime_full', $pag['page_updated']).' '.$usr['timetext'],
	'PAGEEDIT_FORM_FILE' => cot_selectbox($pag['page_file'], 'rpagefile', range(0, 2), array($L['No'], $L['Yes'], $L['Members_only']), false),
	'PAGEEDIT_FORM_URL' => cot_inputbox('text', 'rpageurl', $pag['page_url'], array('size' => '56', 'maxlength' => '255')),
	'PAGEEDIT_FORM_SIZE' => cot_inputbox('text', 'rpagesize', $pag['page_size'], array('size' => '56', 'maxlength' => '255')),
	'PAGEEDIT_FORM_TEXT' => cot_textarea('rpagetext', $pag['page_text'], 24, 120, '', 'input_textarea_editor'),
	'PAGEEDIT_FORM_DELETE' => cot_radiobox(0, 'rpagedelete', array(1, 0), array($L['Yes'], $L['No'])),
	'PAGEEDIT_FORM_PARSER' => cot_selectbox($pag['page_parser'], 'rpageparser', cot_get_parsers(), cot_get_parsers(), false),

	'PAGEEDIT_FORM_TARIFFS' => cot_selectbox($pag['page_tariff'], 'rpagetariff', $tarrif_list),
	'PAGEEDIT_FORM_CHOSEN_TARIFF' => cot_checklistbox($pag['page_settariff'], 'rpagechoosentariff', array_keys($lang_tarrif_list), array_values($lang_tarrif_list)),
	

);







//	assign show pages in other categories
$cats = (is_array($structure['page'])) ? $structure['page'] : array();
$cats_selected = array();
$data_arr = $db->query("SELECT ps.structure_code
FROM `$db_pages_in_structure` AS ps
WHERE ps.page_id = " . $db->quote($id))->fetchAll();
foreach($data_arr as $row){
	$cats_selected[] = $row['structure_code'];
}

$res = '';
foreach ($cats as $key => $value) {
	$perm = cot_auth('page', $key, 'W');
	if($perm){
		$checked = in_array($key, $cats_selected);
		$res .= cot_checkbox($checked, 'rpagecattoshow[]', $value['tpath'], 'style="margin: -2px 5px 0 0"', $key);
	}
}
$pageedit_array['PAGEEDIT_FORM_CATS_TO_SHOW'] = $res;

if ($usr['isadmin'])
{
	$pageedit_array += array(
		'PAGEEDIT_FORM_OWNERID' => cot_inputbox('text', 'rpageownerid', $pag['page_ownerid'], array('size' => '24', 'maxlength' => '24')),
		'PAGEEDIT_FORM_PAGECOUNT' => cot_inputbox('text', 'rpagecount', $pag['page_count'], array('size' => '8', 'maxlength' => '8')),
		'PAGEEDIT_FORM_FILECOUNT' => cot_inputbox('text', 'rpagefilecount', $pag['page_filecount'], array('size' => '8', 'maxlength' => '8'))
	);
}

$t->assign($pageedit_array);

// Extra fields
foreach($cot_extrafields[$db_pages] as $exfld)
{
	$uname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields('rpage'.$exfld['field_name'], $exfld, $pag['page_'.$exfld['field_name']]);
	$exfld_title = isset($L['page_'.$exfld['field_name'].'_title']) ?  $L['page_'.$exfld['field_name'].'_title'] : $exfld['field_description'];

	if($exfld ["field_type"] == 'filter' && (in_array('all', $cats_allowed) ||  in_array($pag['page_cat'], $cats_allowed))){

		$cats_allowed = unserialize($exfld ["field_cats"]);
		foreach ($cats_allowed as $key => $cat) {
			if(strpos($cat, '.')){
				$tmp = explode('.', $cat);
				unset($cats_allowed[$key]);
				foreach ($tmp as $key2 => $value2) {
					$cats_allowed[] = $value2;
				}
			}
		}

		$t->assign(array(
			'PAGEEDIT_FORM_FILTER_LABEL' => $exfld_title,
			'PAGEEDIT_FORM_FILTER_FLD' => $exfld_val,
		));
		$t->parse('MAIN.FILTERS');
	} else {
		$t->assign(array(
			'PAGEEDIT_FORM_'.$uname => $exfld_val,
			'PAGEEDIT_FORM_'.$uname.'_TITLE' => $exfld_title,
			'PAGEEDIT_FORM_EXTRAFLD' => $exfld_val,
			'PAGEEDIT_FORM_EXTRAFLD_TITLE' => $exfld_title
		));
		$t->parse('MAIN.EXTRAFLD');
	}

}

// Error and message handling
cot_display_messages($t);

/* === Hook === */
foreach (cot_getextplugins('page.edit.tags') as $pl)
{
	include $pl;
}
/* ===== */

if ($usr['isadmin'])
{
	if ($cfg['page']['autovalidate']) $usr_can_publish = TRUE;
	$t->parse('MAIN.ADMIN');
}

$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'].'/footer.php';
