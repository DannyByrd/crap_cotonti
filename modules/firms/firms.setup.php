<?php
/* ====================
[BEGIN_COT_EXT]
Name=Firms
Description=Firms catalog
Version=1.0.0
Date=2013-04-10
Author=CMSWorks Team
Copyright=(c) CMSWorks Team 2010-2013
Notes=BSD License
Auth_guests=R
Lock_guests=A
Auth_members=RW1
Lock_members=
Admin_icon=img/adminmenu_firms.png
Recommends_modules=
Recommends_plugins=placemarks
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
markup=01:radio::1:
parser=02:callback:cot_get_parsers():html:
count_admin=03:radio::0:
autovalidatefirm=04:radio::1:
maxlistsperpage=06:select:5,10,15,20,25,30,40,50,60,70,100,200,500:30:
title_firms=07:string::{TITLE} - {CATEGORY}:
logowidth=08:string::200:Logotip image width
logoheight=09:string::200:Logotip image height
logocrop=10:string:::Logotip image crop setting
firmssitemap=11:radio::1:Включить вывод в sitemap
firmssitemap_freq=12:select:default,always,hourly,daily,weekly,monthly,yearly,never:default:Firms change frequency
firmssitemap_prio=13:select:0.0,0.1,0.2,0.3,0.4,0.5,0.6,0.7,0.8,0.9,1.0:0.5:Firms priority
description=12:string:::Описание модуля (meta-description по-умолчанию)
seo_title=13:string:::Meta title модуля по-умолчанию
[END_COT_EXT_CONFIG]

[BEGIN_COT_EXT_CONFIG_STRUCTURE]
order=01:callback:cot_firms_config_order():title:
way=02:select:asc,desc:asc:
maxrowsperpage=03:string::30:
truncatefirmtext=04:string::0:
allowemptyfirmtext=05:radio::0:
keywords=06:string:::
[END_COT_EXT_CONFIG_STRUCTURE]
==================== */
