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

//Blocks in the upper part
$L['cfg_boxsep_shapka'] = '<div>&#9650; Blocks in the upper part of the site (top header)</div>';
$L['cfg_box_shapka1'] = 'Block is displayed in the upper portion with help tag<br /><div' . $L['style_my'] . '>' . $L['box_shapka1_my'] .
	'</div><input onclick="this.select();" readonly value="{PHP.box_shapka1}" />';
$L['cfg_box_shapka2'] = 'Block is displayed in the upper portion with help tag<br /><div' . $L['style_my'] . '>' . $L['box_shapka2_my'] .
	'</div><input onclick="this.select();" readonly value="{PHP.box_shapka2}" />';

//Blocks in the center part
$L['cfg_boxsep_index'] = '<div>&#9775; Blocks in the center part of the site (index)</div>';
$L['cfg_box_index1'] = 'Block is displayed in the center portion with help tag<br /><div' . $L['style_my'] . '>' . $L['box_index1_my'] .
	'</div><input onclick="this.select();" readonly value="{PHP.box_index1}" />';
$L['cfg_box_index2'] = 'Block is displayed in the center portion with help tag<br /><div' . $L['style_my'] . '>' . $L['box_index2_my'] .
	'</div><input onclick="this.select();" readonly value="{PHP.box_index2}" />';
$L['cfg_box_index3'] = 'Block is displayed in the center portion with help tag<br /><div' . $L['style_my'] . '>' . $L['box_index3_my'] .
	'</div><input onclick="this.select();" readonly value="{PHP.box_index3}" />';
$L['cfg_box_index4'] = 'Block is displayed in the center portion with help tag<br /><div' . $L['style_my'] . '>' . $L['box_index4_my'] .
	'</div><input onclick="this.select();" readonly value="{PHP.box_index4}" />';

//Blocks in the sidebar part
$L['cfg_boxsep_sidebar'] = '<div>&#9664;&#9654; Blocks in the sidebar part of the site (side)</div>';
$L['cfg_box_sidebar1'] = 'Block is displayed in the side portion with help tag<br /><div' . $L['style_my'] . '>' . $L['box_sidebar1_my'] .
	'</div><input onclick="this.select();" readonly value="{PHP.box_sidebar1}" />';
$L['cfg_box_sidebar2'] = 'Block is displayed in the side portion with help tag<br /><div' . $L['style_my'] . '>' . $L['box_sidebar2_my'] .
	'</div><input onclick="this.select();" readonly value="{PHP.box_sidebar2}" />';

//Blocks in the lower part
$L['cfg_boxsep_footer'] = '<div>&#9660; Blocks in the lower part of the site (footer)</div>';
$L['cfg_box_footer1'] = 'Block is displayed in the footer portion with help tag<br /><div' . $L['style_my'] . '>' . $L['box_footer1_my'] .
	'</div><input onclick="this.select();" readonly value="{PHP.box_footer1}" />';
$L['cfg_box_footer2'] = 'Block is displayed in the footer portion with help tag<br /><div' . $L['style_my'] . '>' . $L['box_footer2_my'] .
	'</div><input onclick="this.select();" readonly value="{PHP.box_footer2}" />';

//Additional blocks of any part
$L['cfg_boxsep_else'] = '<div style="border-top:2px solid grey">Additional blocks of any part (all)</div>';
$L['cfg_box1'] = '<h3>Дополнительный блок №1</h3><div' . $L['style_my'] . '>' . $L['box1_my'] . '</div><input onclick="this.select();" readonly value="{PHP.box1}" />';
$L['cfg_box2'] = '<h3>Дополнительный блок №2</h3><div' . $L['style_my'] . '>' . $L['box2_my'] . '</div><input onclick="this.select();" readonly value="{PHP.box2}" />';
$L['cfg_box3'] = '<h3>Дополнительный блок №3</h3><div' . $L['style_my'] . '>' . $L['box3_my'] . '</div><input onclick="this.select();" readonly value="{PHP.box3}" />';
$L['cfg_box4'] = '<h3>Дополнительный блок №4</h3><div' . $L['style_my'] . '>' . $L['box4_my'] . '</div><input onclick="this.select();" readonly value="{PHP.box4}" />';
$L['cfg_box5'] = '<h3>Дополнительный блок №5</h3><div' . $L['style_my'] . '>' . $L['box5_my'] . '</div><input onclick="this.select();" readonly value="{PHP.box5}" />';

//Connecting external scripts
$L['cfg_boxsep_external'] = '<div style="border-top:2px solid grey">Connecting external scripts and styles</div>';
$L['cfg_box_headerlist'] =
	'Block is displayed in the header.tpl with help tag<br /><input onclick="this.select();" readonly value="{HEADER_BOXES}" /><br />insert before &lt;/head>';
$L['cfg_box_footerlist'] =
	'Block is displayed in the footer.tpl with help tag<br /><input onclick="this.select();" readonly value="{FOOTER_BOXES}" /><br />insert before &lt;/body>';
