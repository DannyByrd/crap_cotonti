<!-- BEGIN: HEADER -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>{HEADER_TITLE}</title> 
<!-- IF {HEADER_META_DESCRIPTION} --><meta name="description" content="{HEADER_META_DESCRIPTION}" /><!-- ENDIF -->
<!-- IF {HEADER_META_KEYWORDS} --><meta name="keywords"  content="{HEADER_META_KEYWORDS}" /><!-- ENDIF -->
<meta http-equiv="content-type" content="{HEADER_META_CONTENTTYPE}; charset=UTF-8" />
<meta name="generator" content="Cotonti http://www.cotonti.com" />
<link rel="alternate" href="{HEADER_ALTURL1}" hreflang="{HEADER_HREFLANG1}" /> 
<link rel="alternate" href="{HEADER_ALTURL}" hreflang="{HEADER_HREFLANG}" /> 

<link rel="canonical" href="{HEADER_CANONICAL_URL}" />

{HEADER_BASEHREF}
{HEADER_HEAD}
<link rel="shortcut icon" href="favicon.ico" />
<link rel="apple-touch-icon" href="apple-touch-icon.png" />
</head>

<body>
<!-- IF {PHP._GET.e} == "page" -->

<!-- ENDIF -->





	<div id="wrapper" class="container">
		<div id="header" class="row">
			<div class="span4">
			<li><a href="{PHP|cot_url('page', 'c=reviews')}">Отзывы</a></li>
				<div class="logo"><a href="{PHP.cfg.mainurl}" title="{PHP.cfg.maintitle} {PHP.cfg.separator} {PHP.cfg.subtitle}"><img src="themes/{PHP.theme}/img/logo.png"/></a></div>
			</div>
		
			<div class="span3">
				<!-- BEGIN: GUEST -->
				<div class="auth">
					<a href="{PHP|cot_url('login')}">{PHP.L.Login}</a>&nbsp;&#8226;&nbsp;<a href="{PHP|cot_url('users','m=register')}">{PHP.L.Register}</a>
				</div>
				<!-- END: GUEST -->
				<!-- BEGIN: USER -->
				<div class="auth">
					<!-- IF {PHP.cot_modules.profile} -->
					<div><a href="{PHP|cot_url('profile','m=main')}">{PHP.L.profile_profile}</a></div>
					<!-- ENDIF -->
					<div>{HEADER_USER_PROFILE}</div>
					<div>{HEADER_USER_PMREMINDER}</div>
					<!-- IF {PHP.cfg.payments.balance_enabled} -->
					<div><a href="{HEADER_USER_BALANCE_URL}">{PHP.L.payments_mybalance}: {HEADER_USER_BALANCE|number_format($this, '2', '.', ' ')} {PHP.cfg.payments.valuta}</a></div>
					<!-- ENDIF -->
					<div>{HEADER_USER_ADMINPANEL} {HEADER_USER_LOGINOUT}</div>
				</div>
				<!-- END: USER -->
				<!-- IF {PHP.cot_plugins_active.simpleorders} -->
				<div class="simpleorders-mini">
					<a href="javascript:showCartPopup('{PHP.sys.xk}');">
						<span class="simpleorders-mini-text">Корзина ({PHP.out.plg_simpleorders.total})</span>
					</a>
				</div>
				<!-- ENDIF -->
			</div>
		</div>

		<div class="navbar">
			<div class="navbar-inner">
				<ul class="nav">
					<li<!-- IF {PHP.env.ext} == 'index' --> class="active"<!-- ENDIF -->><a href="{PHP.cgf.mainurl}">{PHP.L.Home}</a></li>
					<!-- IF {PHP.cot_modules.products} -->
					<li<!-- IF {PHP.env.ext} == 'products' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('products')}">{PHP.L.Products}</a></li>
					<!-- ENDIF -->
					<li<!-- IF {PHP.env.ext} == 'users' AND ({PHP.group} == 'sellers' AND {PHP.m} == 'main' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('users', 'group=sellers')}">{PHP.L.sellers}</a></li>
					<li<!-- IF {PHP.env.ext} == 'page' AND {PHP.c} == 'news' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('page','c=news')}">{PHP.L.News}</a></li>
					<!-- IF {PHP.cot_modules.forums} -->
					<li<!-- IF {PHP.env.ext} == 'forums' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('forums')}">{PHP.L.Forums}</a></li>
					<!-- ENDIF -->
					<!-- IF {PHP.cot_modules.afisha} -->
					<li<!-- IF {PHP.env.ext} == 'afisha' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('afisha')}">Афиша</a></li>
					<!-- ENDIF -->
					<!-- IF {PHP.cot_modules.blogs} -->
					<li<!-- IF {PHP.env.ext} == 'blogs' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('blogs')}">Блоги</a></li>
					<!-- ENDIF -->
					<!-- IF {PHP.cot_modules.board} -->
					<li<!-- IF {PHP.env.ext} == 'board' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('board')}">Объявления</a></li>
					<!-- ENDIF -->
					<!-- IF {PHP.cot_modules.firms} -->
					<li<!-- IF {PHP.env.ext} == 'firms' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('firms')}">Организации</a></li>
					<!-- ENDIF -->
					<!-- IF {PHP.cot_modules.vacancies} -->
					<li<!-- IF {PHP.env.ext} == 'vacancies' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('vacancies')}">Вакансии</a></li>
					<!-- ENDIF -->
					<!-- IF {PHP.cot_modules.places} -->
					<li<!-- IF {PHP.env.ext} == 'places' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('places')}">Места</a></li>
					<!-- ENDIF -->
					<!-- IF {PHP.cot_modules.rezume} -->
					<li<!-- IF {PHP.env.ext} == 'rezume' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('rezume')}">Резюме</a></li>
					<!-- ENDIF -->
					<!-- IF {PHP.cot_plugins_active.search} -->
					<li<!-- IF {PHP.env.ext} == 'search' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('plug','e=search')}">{PHP.L.Search}</a></li>
					<!-- ENDIF -->
					<!-- IF {PHP.cot_plugins_active.contact} -->
					<li<!-- IF {PHP.env.ext} == 'contact' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('plug','e=contact')}">Контакты</a></li>
					<!-- ENDIF -->
				</ul>
			</div>
		</div>
		
		<div id="main" class="content">
		
<!-- END: HEADER -->