<?php
/* ====================
[BEGIN_COT_EXT]
Code=autoalias2
Name=AutoAlias 2
Category=navigation-structure
Description=Creates page alias from title if a user leaves it empty
Version=2.7.0
Date=2015-01-12
Author=Trustmaster
Copyright=(c) Palmirastidio 2014-2015
Notes=BSD License
Auth_guests=R
Lock_guests=W12345A
Auth_members=RW
Lock_members=12345
Recommends_modules=afisha,blogs,board,firms,page,products,rezume,vacancies
Recommends_plugins=
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
translit=01:radio::1:Transliterate non-latinic characters if possible
prepend_id=02:radio::0:Prepend page ID to alias
on_duplicate=03:select:ID,Random:ID:Number appended on duplicate alias (if prepend ID is off)
sep=04:select:-,_,.:-:Word separator
lowercase=05:radio::1:Cast to lower case
[END_COT_EXT_CONFIG]
==================== */

defined('COT_CODE') or die('Wrong URL');
