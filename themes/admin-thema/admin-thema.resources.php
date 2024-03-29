<?php

$R['code_title_page_num'] = ' (' . $L['Page'] . ' {$num})';
$R['link_pagenav_current'] = '<li class="active"><a href="{$url}"{$event}{$rel}>{$num}</a></li>';
$R['link_pagenav_first'] = '<a href="{$url}"{$event}{$rel}></a>';
$R['link_pagenav_gap'] = '<li>...</li>';
$R['link_pagenav_last'] = '<a href="{$url}"{$event}{$rel}></a>';

$R['link_pagenav_main'] = '<li><a href="{$url}"{$event}{$rel}>{$num}</a></li>';
$R['link_pagenav_next'] = '<li><a href="{$url}"{$event}{$rel}>'.$L['pagenav_next'].'</a></li>';
$R['link_pagenav_prev'] = '<li><a href="{$url}"{$event}{$rel}>'.$L['pagenav_prev'].'</a></li>';

$R['input_checkbox'] = '<input type="hidden" name="{$name}" value="{$value_off}" /><label><input type="checkbox" name="{$name}" value="{$value}"{$checked}{$attrs} /> {$title}</label>';
$R['input_check'] = '<label><input type="checkbox" name="{$name}" value="{$value}"{$checked}{$attrs} /> {$title}</label>';
$R['input_default'] = '<input type="{$type}" name="{$name}" class="form-control" value="{$value}"{$attrs} />{$error}';
$R['input_contact-email'] = '<input type="{$type}" name="{$name}" class="form-control mi-email" value="{$value}"{$attrs} />{$error}';

$R['input_contact-subject'] = '<input type="{$type}" name="{$name}" class="form-control mi-subject" value="{$value}"{$attrs} />{$error}';

$R['input_option'] = '<option value="{$value}"{$selected}>{$title}</option>';
$R['input_radio'] = '<label><input type="radio" name="{$name}" value="{$value}"{$checked}{$attrs} /> {$title}</label>';
$R['input_radio_separator'] = ' ';
$R['input_select'] = '<select class="form-control" name="{$name}"{$attrs}>{$options}</select>{$error}';
$R['input_submit'] = '<button class="btn btn-default" type="submit" name="{$name}" {$attrs}>{$value}</button>';
$R['input_text'] = '<input type="text" name="{$name}" class="form-control" value="{$value}" {$attrs} />{$error}';
//$R['input_link'] = '<input type="text" name="{$name}" class="form-control2222222222" placeholder="kkkk" value="{$value}" {$attrs} />{$error}';
$R['input_textarea'] = '<textarea class="form-control" name="{$name}" rows="{$rows}" cols="{$cols}"{$attrs}>{$value}</textarea>{$error}';
$R['input_textarea_editor'] =  '<textarea class="editor form-control" name="{$name}" class="form-control" rows="{$rows}" cols="{$cols}"{$attrs}>{$value}</textarea>{$error}';
$R['input_textarea_medieditor'] =  '<textarea class="medieditor form-control" name="{$name}" class="form-control" rows="{$rows}" cols="{$cols}"{$attrs}>{$value}</textarea>{$error}';
$R['input_textarea_minieditor'] =  '<textarea class="minieditor form-control" name="{$name}" class="form-control" rows="{$rows}" cols="{$cols}"{$attrs}>{$value}</textarea>{$error}';
$R['input_filebox'] = '<a href="{$filepath}">{$value}</a><br /><input type="file" name="{$name}" {$attrs} /><br /><label><input class="form-control" type="checkbox" name="{$delname}" value="1" />'.$L['Delete'].'</label>{$error}';
$R['input_filebox_empty'] = '<input class="form-control" type="file" name="{$name}" {$attrs} />{$error}';

$R['input_date'] =  '<div class="form-group form-inline">{$day} {$month} {$year} {$hour}: {$minute}</div>';
$R['input_date_short'] =  '<div class="form-group form-inline">{$day} {$month} {$year}</div>';


// Breadcrumbs
$R['breadcrumbs_container'] = '{$crumbs}';
$R['breadcrumbs_separator'] = '<i style="font-size: 6px;" class="fa fa-circle"></i>&nbsp;';
$R['breadcrumbs_link'] = '<li style="margin-right: 10px; list-style-type: none;"><a href="{$url}" title="{$title}">{$title}</a></li>';
$R['breadcrumbs_plain'] = '<li style="list-style-type: none;">{$title}</li>';
$R['breadcrumbs_crumb'] = '<li>{$crumb}</li>';
$R['breadcrumbs_first'] = '{$crumb}';
$R['breadcrumbs_last'] = '<li>{$crumb}</li>';

?>


