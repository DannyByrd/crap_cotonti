1)В файле  board/inc/board.functions.php меняем старую версию функции cot_build_structure_board_tree на новую :

function cot_build_structure_board_tree($c = '', $allsublev = true, $custom_tpl = '', $col = 'all')
{
	global $cot_extrafields, $db_structure, $structure, $cfg, $db, $sys;
	$t1 = new XTemplate(cot_tplfile(array('board', 'tree', $custom_tpl), 'module'));
	
	$kk = 0;
	
	
	$allsub = (empty($c)) ? cot_structure_children('board', '', $allsublev, false, true, false,$new_col) : cot_structure_children('board', $c, $allsublev, false, true, false,$new_col);
	$subcat = array_slice($allsub, $dc, $cfg['board']['maxlistsperpage']);
	
	/* === Hook - Part1 : Set === */
	$extp = cot_getextplugins('board.tree.rowcat.loop');
	/* ===== */
	foreach ($subcat as $x)
	{	
		$mtch = $structure['board'][$x]['path'].'.';
		$mtchlen = mb_strlen($mtch);
		$mtchlvl = mb_substr_count($mtch,".");

		if(empty($c) && !$allsublev && $mtchlvl == 1 || !empty($c))
		{
			$cats[] = $x;
		}
	}

	
	$colcount = floor(count($cats)/((int)$col + 1)) + 1;

	if($col === 'all'){
		$new_col = count($cats);
	}else{
		$new_col = $col;
	}
	
	if(is_array($cats))
	{

		foreach($cats as $cat)
		{
			$kk++;

			$cat_childs = cot_structure_children('board', $cat);
			$sub_count = 0;
			foreach ($cat_childs as $cat_child)
			{
				$sub_count += (int)$structure['board'][$cat_child]['count'];
			}

			$sub_url_path = $list_url_path;
			$sub_url_path['c'] = $cat;
			$t1->assign(array(
				'LIST_ROWCAT_URL' => cot_url('board', $sub_url_path),
				'LIST_ROWCAT_TITLE' => $structure['board'][$cat]['title'],
				'LIST_ROWCAT_DESC' => $structure['board'][$cat]['desc'],
				'LIST_ROWCAT_ICON' => $structure['board'][$cat]['icon'],
				'LIST_ROWCAT_COUNT' => $sub_count,
				'LIST_ROWCAT_ODDEVEN' => cot_build_oddeven($kk),
				'LIST_ROWCAT_NUM' => $kk,
				'LIST_ROWCAT_COL' => ($kk % $colcount == 0) ? 1 : 0,
				'LIST_ROWCAT_COUNT_VIEW' =>$new_col
			));

			// Extra fields for structure
			foreach ($cot_extrafields[$db_structure] as $exfld)
			{
				$uname = strtoupper($exfld['field_name']);
				$t1->assign(array(
					'LIST_ROWCAT_'.$uname.'_TITLE' => isset($L['structure_'.$exfld['field_name'].'_title']) ?  $L['structure_'.$exfld['field_name'].'_title'] : $exfld['field_description'],
					'LIST_ROWCAT_'.$uname => cot_build_extrafields_data('structure', $exfld, $structure['board'][$cat][$exfld['field_name']]),
					'LIST_ROWCAT_'.$uname.'_VALUE' => $structure['board'][$cat][$exfld['field_name']],
				));
			}

			/* === Hook - Part2 : Include === */
			foreach ($extp as $pl)
			{
				include $pl;
			}
			/* ===== */

			$t1->parse('MAIN.LIST_ROWCAT');
		}
	}
	
	$t1->parse("MAIN");
	return $t1->text("MAIN");
}


2)Для вывода всех категорий из модуля Board  необходим шаблон категорий:

<!-- BEGIN: MAIN -->
<div class="row">
	<ul class="pull-left span3">
		<!-- BEGIN: LIST_ROWCAT -->
		<!-- IF {LIST_ROWCAT_COUNT_VIEW} AND {LIST_ROWCAT_NUM} <= {LIST_ROWCAT_COUNT_VIEW} -->
		<li>{LIST_ROWCAT_NUM}<a href="{LIST_ROWCAT_URL}" title="{LIST_ROWCAT_TITLE}">{LIST_ROWCAT_TITLE}</a> ({LIST_ROWCAT_COUNT})</li>
	<!-- IF {LIST_ROWCAT_COL} -->
	<!-- ENDIF -->

	</ul>
	<ul class="pull-right span3">
	<!-- ENDIF -->
		<!-- END: LIST_ROWCAT -->
	</ul>
</div>	
<div class="clear"></div>

<!-- END: MAIN -->

Его мы помещаем в файл board.tree.index.tpl в корневой папке модуля board/tplе

3) На выбранной нам странице (например на главной index.tpl) помещаем следующий код:

{PHP|cot_build_structure_board_tree('', 0, 'index',5)}

 '' - взять все категории модуля Board
 0 - не брать подкатегории
 'index' - говорит что мы хотим взять взять шаблон board.tree.index.tpl
 5 - лимт вывода категорий. Если не передавать цифру то возмет все категории Board

