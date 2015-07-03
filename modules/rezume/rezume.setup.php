<?php
/* ====================
[BEGIN_COT_EXT]
Name=Rezume
Description=rezume
Version=1.0.1
Date=2013-05-25
Author=CMSWorks Team
Copyright=(c) CMSWorks Team 2010-2013
Notes=BSD License
Auth_guests=R
Lock_guests=A
Auth_members=RW1
Lock_members=
Admin_icon=img/adminmenu_rezume.png
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
markup=01:radio::1:
parser=02:callback:cot_get_parsers():html:
count_admin=03:radio::0:
autovalidaterez=04:radio::1:
maxlistsperpage=06:select:5,10,15,20,25,30,40,50,60,70,100,200,500:30:
title_rezume=07:string::{TITLE} - {CATEGORY}:
rezumesitemap=08:radio::1:Включить вывод в sitemap
rezumesitemap_freq=09:select:default,always,hourly,daily,weekly,monthly,yearly,never:default:rezume change frequency
rezumesitemap_prio=10:select:0.0,0.1,0.2,0.3,0.4,0.5,0.6,0.7,0.8,0.9,1.0:0.5:rezume priority
description=11:string:::Описание модуля (meta-description по-умолчанию)
seo_title=12:string:::Meta title модуля по-умолчанию
[END_COT_EXT_CONFIG]

[BEGIN_COT_EXT_CONFIG_STRUCTURE]
order=01:callback:cot_rezume_config_order():date:
way=02:select:asc,desc:desc:
maxrowsperpage=03:string::30:
keywords=06:string:::
[END_COT_EXT_CONFIG_STRUCTURE]
==================== */
