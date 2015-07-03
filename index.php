<?php
/**
 * Index loader
 *
 * @package Cotonti
 * @copyright (c) Cotonti Team
 * @license https://github.com/Cotonti/Cotonti/blob/master/License.txt
 */

if (php_sapi_name() == 'cli-server')
{
	// Embedded PHP webserver routing
	$tmp = explode('?', $_SERVER['REQUEST_URI']);
	$REQUEST_FILENAME = mb_substr($tmp[0], 1);
	unset($tmp);
	if (file_exists($REQUEST_FILENAME) && !preg_match('#\.php$#', $REQUEST_FILENAME))
	{
		// Transfer static file if exists
		return false;
	}
	// Language selector
	$langs = array_map(
		create_function('$dir', 'return str_replace("lang/", "", $dir);'),
		glob('lang/??', GLOB_ONLYDIR)
	);
	if (preg_match('#^(' . join('|', $langs) . ')/(.*)$#', $REQUEST_FILENAME, $mt))
	{
		$REQUEST_FILENAME = $mt[2];
		$_GET['l'] = $mt[1];
	}
	// Sitemap shortcut
	if ($REQUEST_FILENAME === 'sitemap.xml')
	{
		$_GET['r'] = 'sitemap';
	}
	// Admin area and message are special scripts
	if (preg_match('#^admin/([a-z0-9]+)#', $REQUEST_FILENAME, $mt))
	{
		$_GET['m'] = $mt[1];
		include 'admin.php';
		exit;
	}
	if (preg_match('#^(admin|login|message)(/|$)#', $REQUEST_FILENAME, $mt))
	{
		include $mt[1].'.php';
		exit;
	}
	// PHP files have priority
	if (preg_match('#\.php$#', $REQUEST_FILENAME) && $REQUEST_FILENAME !== 'index.php')
	{
		include $REQUEST_FILENAME;
		exit;
	}
	// All the rest goes through standard rewrite gateway
	if ($REQUEST_FILENAME !== 'index.php')
	{
		$_GET['rwr'] = $REQUEST_FILENAME;
	}
	unset($REQUEST_FILENAME, $langs, $mt);
}

// Redirect to install if config is missing
if (!file_exists('./datas/config.php'))
{
	header('Location: install.php');
	exit;
}

// Let the include files know that we are Cotonti
define('COT_CODE', true);

// Load vital core configuration from file
require_once './datas/config.php';

// If it is a new install, redirect
if (isset($cfg['new_install']) && $cfg['new_install'])
{
	header('Location: install.php');
	exit;
}

if(isset($cfg['aceptsecondtheme'])){
	foreach ($cfg['aceptsecondtheme'] as $row) {
		if(is_array($row)){
			$count_cond = count($row);
			foreach ($row as $key => $value) {
				if(isset($_GET[$key]) && $_GET[$key] == $value){
					$count_cond--;
				}
			}
			if($count_cond == 0) $cfg['defaulttheme'] = $cfg['defaultthemesecond'];	
		}
	}
}

// Load the Core API, the template engine
require_once $cfg['system_dir'] . '/functions.php';
require_once $cfg['system_dir'] . '/cotemplate.php';

// Bootstrap
require_once $cfg['system_dir'] . '/common.php';

// Support for ajax and popup hooked plugins
if (empty($_GET['e']) && !empty($_GET['r']))
{
	$_GET['e'] = $_GET['r'];
}
if (empty($_GET['e']) && !empty($_GET['o']))
{
	$_GET['e'] = $_GET['o'];
}

if(isset($_GET['err']) && is_numeric($_GET['err'])){
	$err_num = $_GET['err'];
	cot_die_message($err_num);
	exit;
}

// check valid url else show page 404

	$preset_name = $cfg['plugin']['urleditor']['preset'];

	if(in_array($curr_module, $url_rules_for_extansions)){
		switch($preset_name){
			case 'handy':
				if(mb_substr($_GET['rwr'], -1) == '/') {
					cot_die_message(404);
					exit;
				}
				break;

			case 'handyslash':
				if(mb_substr($_GET['rwr'], -1) != '/') {
					 cot_die_message(404);
					exit;
				}
				break;

			case 'handyhtml':
				if(mb_substr($_GET['rwr'], -5) != '.html') {
					 cot_die_message(404);
					exit;
				}
				break;
		}
	}
// Detect selected extension
if (empty($_GET['e']))
{
	// Default environment for index module
	define('COT_MODULE', true);
	$env['type'] = 'module';
	$env['ext'] = 'index';
}
else
{
	$found = false;
	if (preg_match('`^\w+$`', $_GET['e']))
	{
		$module_found = false;
		$plugin_found = false;
		if (file_exists($cfg['modules_dir'] . '/' . $_GET['e']) && isset($cot_modules[$_GET['e']]))
		{
			$module_found = true;
			$found = true;
		}
		if (file_exists($cfg['plugins_dir'] . '/' . $_GET['e']))
		{
			$plugin_found = true;
			$found = true;
		}
		if ($module_found && $plugin_found)
		{
			// Need to query the db to check which one is installed
			$res = $db->query("SELECT ct_plug FROM $db_core WHERE ct_code = ? LIMIT 1", $_GET['e']);
			if ($res->rowCount() == 1)
			{
				if ((int)$res->fetchColumn())
				{
					$module_found = false;
				}
				else
				{
					$plugin_found = false;
				}
			}
			else
			{
				$found = false;
			}
		}
		if ($module_found)
		{
			$env['type'] = 'module';
			define('COT_MODULE', true);
		}
		elseif ($plugin_found)
		{
			$env['type'] = 'plug';
			$env['location'] = 'plugins';
			define('COT_PLUG', true);
		}
	}
	if ($found)
	{
		$env['ext'] = $_GET['e'];
	}
	else
	{
		// Error page
		cot_die_message(404);
		exit;
	}
}

/*************** Page **********************/
	require_once cot_incfile('page', 'module');
	$t = new XTemplate(cot_tplfile('index','module'));
	global $structure;

	$kk = 0; 
	$allsub = cot_structure_children('page', '', false, false, true, false);
	$subcat = array_slice($allsub, $dc, $cfg['page']['maxlistsperpage']);

	/* === Hook === */
	foreach (cot_getextplugins('page.list.rowcat.first') as $pl)
	{
		include $pl;
	}
	 //===== 

	// /* === Hook - Part1 : Set === */
	  $extp = cot_getextplugins('page.list.rowcat.loop');
	/* ===== */
	foreach ($subcat as $x)
	{
		$kk++;
		$cat_childs = cot_structure_children('page', $x);
		$sub_count = 0;
		foreach ($cat_childs as $cat_child)
		{
			$sub_count += (int)$structure['page'][$cat_child]['count'];
		}

		$sub_url_path = $list_url_path;
		$sub_url_path['c'] = $x;

		
	
		$t->assign(array(
			'LIST_ROWCAT_ID' => $structure['page'][$x]['id'],
			'LIST_ROWCAT_URL' => cot_url('page', $sub_url_path),
			'LIST_ROWCAT_TITLE' => $structure['page'][$x]['title'],
			'LIST_ROWCAT_DESC' => $structure['page'][$x]['desc'],
			'LIST_ROWCAT_ICON' => $structure['page'][$x]['icon'],
			'LIST_ROWCAT_COUNT' => $sub_count,
			'LIST_ROWCAT_ODDEVEN' => cot_build_oddeven($kk),
			'LIST_ROWCAT_NUM' => $kk,
			
			//'LIST_ROWCAT_NUM' => $kk,
		));



		
		$t->parse('MAIN.LIST_ROWCAT');
	}


	/**************************************/


// Load the requested extension
if ($env['type'] == 'plug')
{
	require_once $cfg['system_dir'] . '/plugin.php';
}
else
{
	require_once $cfg['modules_dir'] . '/' . $env['ext'] . '/' . $env['ext'] . '.php';
}
