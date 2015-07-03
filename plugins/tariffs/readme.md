
1. Заходим в модуль payments inc\payments.functions.php   

и вставляем следующею функцию для установки тарифа:


function cot_payments_setTariff($pid){

	global $db_payments, $db, $sys, $cfg, $db_x;

	$db_tariffs = $db_x."tariffs";
	$pay_sql = $db->query("SELECT * FROM $db_payments WHERE pay_id = '".(int)$pid."'")->fetch();
	

	$tar_data['tar_payid'] = $pay_sql['pay_id'];
	$tar_data['tar_userid'] = $pay_sql['pay_userid'];

	
	$summ = (int)$pay_sql['pay_summ'];
	switch ($summ ) {
		case $cfg['plugin']['tariffs']['first_tariff']: $tariff = "bronze";  break;
		case $cfg['plugin']['tariffs']['second_tariff']: $tariff = "silver";  break;
		case $cfg['plugin']['tariffs']['third_tariff']: $tariff = "gold";  break;
			
			
		
		default: $tariff = "null"; break;
			
			
	}
	
	$tar_data['tar_tariff'] = $tariff;

	$table_exist =  $db->query("SHOW TABLES LIKE '".$db_tariffs."'")->fetchAll();
	if($table_exist){

		$sql = $db->insert($db_tariffs, $tar_data);
	}
	
	
}



2. Далее необходимо вызвать эту функцию. Для этого переходим в модуль payments\payments.global.php

Находим строки: 
// Проверяем платежки на оплату пополнение счета.
if ($balancepays = cot_payments_getallpays('balance', 'paid'))
{
	foreach ($balancepays as $pay)
	{
		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$urr = $db->query("SELECT * FROM $db_users WHERE user_id=".$pay['pay_userid'])->fetch();


И вставляем ниже вызов функции:   

cot_payments_setTariff($pay['pay_id']);


3. Далее необходимо определится для какого модуля использовать тарифы. Возмем к примеру модуль pages
Создаем поле: 	page_tariff с типом enum('null', 'bronze', 'silver', 'gold')

4. Дальше предстоит долгий и нудный процесс об изменение модуля page

4.1 Переходим в page\inc\page.add.php  примерно после 150 строки вставляем код:

	$tariff_list = array();
	foreach ($cfg['plugin']['tariffs'] as $key => $value) {
		

		$tariff_list[] = $value;
	}

	 asort($tariff_list);
	 

	В конец массива $pageadd_array = array( 
	добавляем код:

	'PAGEADD_FORM_TARIFFS' => cot_selectbox($cfg['plugin']['tariffs'], 'rpagetariff', $tariff_list)

	(смотрим если нету запятой , перед нашей вставленной строкой - добавляем запятую. Иначе ругаться будет)

4.2  Переходим в page\inc\page.edit.php  примерно после 150 строки вставляем код:	

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


		В конец массива $pageadd_array = array( 
		добавляем код:

		'PAGEEDIT_FORM_TARIFFS' => cot_selectbox($pag['page_tariff'], 'rpagetariff', $tarrif_list)

4.3 Переходим в page\inc\page.functions.php 
	 В функцию cot_generate_pagetags()
	 примерно после 210 строки вставляем код:

	if(isset($page_data['page_choose_tariff'])){

				$temp_array['NEED_TARIFF'] = 1;
			}

	Далее заходим в функцию function cot_page_import()
	Находим массив $rpage и добавляем в конец
	$rpage['page_tariff']   =  cot_import('rpagetariff', $source, 'TXT');
	
	Строкой ниже дописываем код:


	$summ = (int)$rpage['page_tariff'];
		switch ($summ ) {
			case $cfg['plugin']['tariffs']['first_tariff']: $tariff = "bronze";  break;
			case $cfg['plugin']['tariffs']['second_tariff']: $tariff = "silver";  break;
			case $cfg['plugin']['tariffs']['third_tariff']: $tariff = "gold";  break;
					
			default: $tariff = "null"; break;
						
		}
		$rpage['page_tariff'] = $tariff;


4.4 	 Переходим в page\inc\page.main.php  где на 50 строке вставляем код:
			
		if($pag['page_tariff'] != 'null' && !$usr['isadmin']){

		    $db_tariffs = $db_x."tariffs";

			$sql_user = $db->query("SELECT tar_tariff FROM  $db_tariffs WHERE tar_userid = '".(int)$usr['id']."'");
			$res_user = $sql_user->fetchAll();

			$exist_tar = false;
			foreach ($res_user as $tariff) {
				
				if(in_array($pag['page_tariff'], $tariff)){
					$exist_tar = true;
					break;
					
				}
			}
			if(!$exist_tar){

				$pag['page_choose_tariff'] = true;
				$pag['page_text'] = 'YOU HAVE NO PERMISSION!';

			}
	
		}

4.5 	Переходим в modules\page\tpl\page.add.tpl  
		И добавляем строку со столбцами, примерно после 75 строки

		<tr>
			<td>{PHP.L.page_permission}:</td>
			<td>{PAGEADD_FORM_TARIFFS}</td>
		</tr>

4.6 Переходим в modules\page\tpl\page.edit.tpl  
		И добавляем строку со столбцами, примерно после 90 строки

	<tr>
			<td>{PHP.L.page_permission}:</td>
			<td>{PAGEEDIT_FORM_TARIFFS}</td>
	</tr>

5 Создание поля для выборки полей тарифа.
5.1 inc\page.functions.php в функцию function cot_page_import()
после 2х условий if() вставляем код :

	$chosen_tar = $_POST['rpagechoosentariff']; 
	$str_chosen_tar = '';
	foreach ($chosen_tar as $key_tar ) {
		if($key_tar != 'nullval'){
			$str_chosen_tar .=$key_tar.',';
		}
		
	}
	$rpage['page_settariff']   =  $str_chosen_tar;



5.2 Заходим в inc\page.add.php  перед создание массива $pageadd_array = array(
вставляем код примерно 165 строка: 

$sql_page = $db->query("SELECT * FROM $db_pages  LIMIT 1");
if($sql_page->rowCount() == 0)
{
	cot_die_message(404);
}
$row_page = $sql_page->fetch();



 $set_tarrif_list = array();
foreach ($row_page as $key => $value) {
	
	$set_tarrif_list[] = $key;
}

$need_del_items = array('page_id','page_state','page_ownerid','page_updated','page_file','page_url','page_size','page_filecount','page_tpl','page_tariff','page_settariff','page_status');

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

В массив $pageadd_array = array() в конец списка вставляем код:

'PAGEADD_FORM_CHOSEN_TARIFF' => cot_checklistbox('', 'rpagechoosentariff', array_keys($lang_tarrif_list), array_values($lang_tarrif_list)),

5.3 Заходим в inc\page.edit.php  перед создание массива $pageadd_array = array(
вставляем код примерно 190 строка: 

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

Далее В массив $pageedit_array = array() в конец списка вставляем код:
'PAGEEDIT_FORM_CHOSEN_TARIFF' => cot_checklistbox($pag['page_settariff'], 'rpagechoosentariff', array_keys($lang_tarrif_list), array_values($lang_tarrif_list)),

5.4  заходим в page.edit.tpl после 80 строки вставляем код:

					<tr>
						<td>{PHP.L.page_chosen_field}:</td>
						<td>{PAGEEDIT_FORM_CHOSEN_TARIFF}</td>
					</tr>
5.5  заходим в page.add.tpl после 80 строки вставляем код:

					<tr>
						<td>{PHP.L.page_chosen_field}:</td>
						<td>{PAGEADD_FORM_CHOSEN_TARIFF}</td>
					</tr>