<?php
/**
 * Boxes plugin
 *
 * @package boxes
 * @version 1.0.0
 * @author  PRoHtml
 * @copyright Copyright(c) 2015 http://prohtml.net/webmaster/cotonti/boxes
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

//Вывод блоков в шапке
$L['cfg_boxsep_shapka'] = '<div>&#9650; Вывод блоков в верхней части сайта (шапка)</div>';
$L['cfg_box_shapka1'] = '<span style="font-size: 15px;">Вывод лайков социальных сетей</span><br /><div' . $L['style_my'] . '>' . $L['box_shapka1_my'] .
	'</div><input onclick="this.select();" readonly value="{PHP.box_shapka1}" />';
$L['cfg_box_shapka2'] = 'Содержимое выводится в верхней части тегом<br /><div' . $L['style_my'] . '>' . $L['box_shapka2_my'] .
	'</div><input onclick="this.select();" readonly value="{PHP.box_shapka2}" />';

//Вывод блоков
$L['cfg_boxsep_index'] = '<div>&#9775; Вывод блоков</div>';
$L['cfg_box_index1'] = '<span style="font-size: 15px;">Вставка кода Google Analytics</span><br /><div' . $L['style_my'] . '>' . $L['box_index1_my'] .
	'</div><input onclick="this.select();" readonly value="{PHP.box_index1}" />';
$L['cfg_box_index2'] = '<span style="font-size: 15px;">Вставка кода Yandex.Metrika</span><br /><div' . $L['style_my'] . '>' . $L['box_index2_my'] .
	'</div><input onclick="this.select();" readonly value="{PHP.box_index2}" />';
$L['cfg_box_index3'] = '<span style="font-size: 15px;">Вставка кода LiveInternet</span><br /><div' . $L['style_my'] . '>' . $L['box_index3_my'] .
	'</div><input onclick="this.select();" readonly value="{PHP.box_index3}" />';
$L['cfg_box_index4'] = 'Содержимое выводится в центральной части сайта тегом<br /><div' . $L['style_my'] . '>' . $L['box_index4_my'] .
	'</div><input onclick="this.select();" readonly value="{PHP.box_index4}" />';

//Вывод блоков в сайдбар
$L['cfg_boxsep_sidebar'] = '<div>&#9664;&#9654; Вывод блоков в боковой части сайта (сайдбар)</div>';
$L['cfg_box_sidebar1'] = 'Содержимое выводится в сайдбар тегом<br /><div' . $L['style_my'] . '>' . $L['box_sidebar1_my'] .
	'</div><input onclick="this.select();" readonly value="{PHP.box_sidebar1}" />';
$L['cfg_box_sidebar2'] = 'Содержимое выводится в сайдбар тегом<br /><div' . $L['style_my'] . '>' . $L['box_sidebar2_my'] .
	'</div><input onclick="this.select();" readonly value="{PHP.box_sidebar2}" />';

//Вывод блоков в футере
$L['cfg_boxsep_footer'] = '<div>&#9660; Вывод блоков в нижней части сайта (футер)</div>';
$L['cfg_box_footer1'] = 'Содержимое выводится в нижней части тегом<br /><div' . $L['style_my'] . '>' . $L['box_footer1_my'] .
	'</div><input onclick="this.select();" readonly value="{PHP.box_footer1}" />';
$L['cfg_box_footer2'] = 'Содержимое выводится в нижней части тегом<br /><div' . $L['style_my'] . '>' . $L['box_footer2_my'] .
	'</div><input onclick="this.select();" readonly value="{PHP.box_footer2}" />';



$L['cfg_box_footer3'] = '555555555555555<br /><div' . $L['style_my'] . '>' . $L['box_footer3_my'] .
	'</div><input onclick="this.select();" readonly value="{PHP.box_footer3}" />';

//Дополнительные блоки
$L['cfg_boxsep_else'] = '<div style="border-top:2px solid grey">Дополнительные блоки для любой части</div>';
$L['cfg_box1'] = '<h3>Дополнительный блок №1</h3><div' . $L['style_my'] . '>' . $L['box1_my'] . '</div><input onclick="this.select();" readonly value="{PHP.box1}" />';
$L['cfg_box2'] = '<h3>Дополнительный блок №2</h3><div' . $L['style_my'] . '>' . $L['box2_my'] . '</div><input onclick="this.select();" readonly value="{PHP.box2}" />';
$L['cfg_box3'] = '<h3>Дополнительный блок №3</h3><div' . $L['style_my'] . '>' . $L['box3_my'] . '</div><input onclick="this.select();" readonly value="{PHP.box3}" />';
$L['cfg_box4'] = '<h3>Дополнительный блок №4</h3><div' . $L['style_my'] . '>' . $L['box4_my'] . '</div><input onclick="this.select();" readonly value="{PHP.box4}" />';
$L['cfg_box5'] = '<h3>Дополнительный блок №5</h3><div' . $L['style_my'] . '>' . $L['box5_my'] . '</div><input onclick="this.select();" readonly value="{PHP.box5}" />';

//Подключение внешних скриптов
$L['cfg_boxsep_external'] = '<div style="border-top:2px solid grey">Подключение внешних скриптов и стилей</div>';
$L['cfg_box_headerlist'] =
	'Содержимое выводится в header.tpl тегом<br /><input onclick="this.select();" readonly value="{HEADER_BOXES}" /><br />вставьте перед &lt;/head>';
$L['cfg_box_footerlist'] =
	'Содержимое выводится в footer.tpl тегом<br /><input onclick="this.select();" readonly value="{FOOTER_BOXES}" /><br />вставьте перед &lt;/body>';
