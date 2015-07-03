<?php
/* ====================
[BEGIN_COT_EXT]
Code=boxes
Hooks=header.tags,footer.tags
Tags=header.tpl:{HEADER_BOXES};footer.tpl:{FOOTER_BOXES}
Order=10
[END_COT_EXT]
==================== */
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

if (!empty($cfg['plugin']['boxes']['box_headerlist']))
{
	$box_headerlist = array();
	foreach (preg_split('#\r?\n#',$cfg['plugin']['boxes']['boxes_headerlist']) as $bhdc)
	{
		$box_headerlist = array_merge($box_headerlist,explode("\n",$bhdc));
	}
}
else
{
	$box_headerlist = false;
}

if (!empty($cfg['plugin']['boxes']['box_footerlist']))
{
	$box_footerlist = array();
	foreach (preg_split('#\r?\n#',$cfg['plugin']['boxes']['boxes_footerlist']) as $bftc)
	{
		$box_footerlist = array_merge($box_footerlist,explode("\n",$bftc));
	}
}
else
{
	$box_footerlist = false;
}

$box_connectsh = $cfg['plugin']['boxes']['box_headerlist'];
$box_connectsf = $cfg['plugin']['boxes']['box_footerlist'];

$t->assign('HEADER_BOXES',$box_connectsh);
$t->assign('FOOTER_BOXES',$box_connectsf);
