<!-- BEGIN: HEADER -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>{HEADER_TITLE}</title> 
<!-- IF {HEADER_META_DESCRIPTION} --><meta name="description" content="{HEADER_META_DESCRIPTION}" /><!-- ENDIF -->
<!-- IF {HEADER_META_KEYWORDS} --><meta name="keywords" content="{HEADER_META_KEYWORDS}" /><!-- ENDIF -->
<meta http-equiv="content-type" content="{HEADER_META_CONTENTTYPE}; charset=UTF-8" />
<meta name="generator" content="Cotonti http://www.cotonti.com" />
<link rel="canonical" href="{HEADER_CANONICAL_URL}" />
    <script src="/themes/{PHP.theme}/plug/jquery.min.js"></script>
{HEADER_BASEHREF}
{HEADER_HEAD}
<link rel="shortcut icon" href="favicon.ico" />
<link rel="apple-touch-icon" href="apple-touch-icon.png" />
</head>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-sidebar-closed-hide-logo">

<div class="page-header navbar navbar-fixed-top">
    <div class="page-header-inner">
        <div class="page-logo">
            <a href="{PHP.cgf.mainurl}">
                <img src="/themes/{PHP.theme}/img/logo-light.png" alt="logo" class="logo-default"/>
            </a>
        </div>
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>

        <div class="page-top">

            <!-- IF {PHP.cot_plugins_active.search} -->
                <form class="search-form"  action="{PHP|cot_url('plug','e=search')}" method="post">
                    <div class="input-group">
                        <input type="search" class="form-control input-sm" placeholder="Поиск..." name="sq" placeholder="Поиск:" onblur="if(this.value=='') this.value='{PHP.L.Search}...';" onfocus="if(this.value=='{PHP.L.Search}...') this.value='';"/>
                        <span class="input-group-btn">
                            <a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
                        </span>
                    </div>
                </form>
            <!-- ENDIF -->


            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown dropdown-user dropdown-dark">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <span class="username username-hide-on-mobile">{PHP.usr.profile.user_name}</span>
                            <!-- IF {PHP.usr.profile.user_avatar} -->
                                <img class="img-circle" src="{PHP.usr.profile.user_avatar}" alt="{PHP.L.Avatar}" />
                            <!-- ELSE -->
                            <img alt="" class="img-circle" src="/themes/{PHP.theme}/img/avatar1.jpg"/>
                            <!-- ENDIF -->
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <!-- BEGIN: GUEST -->
                                <li><a href="{PHP|cot_url('login')}">{PHP.L.Login}</a></li>
                                <li><a href="{PHP|cot_url('users','m=register')}">{PHP.L.Register}</a></li>
                            <!-- END: GUEST -->
                            <!-- BEGIN: USER -->
                                <li>
                                    <a href="{PHP|cot_url('profile')}"><i class="icon-user"></i> Личный кабинет</a>
                                </li>

                                <li>{HEADER_USER_PROFILE}</li>
                                <li>{HEADER_USER_PMREMINDER}</li>
                                <li>
                                    <!-- IF {PHP.cfg.payments.balance_enabled} -->
                                        <a href="{HEADER_USER_BALANCE_URL}">{PHP.L.payments_mybalance}: {HEADER_USER_BALANCE|number_format($this, '2', '.', ' ')} {PHP.cfg.payments.valuta}</a>
                                    <!-- ENDIF -->
                                </li>
                                <li>{HEADER_USER_ADMINPANEL} {HEADER_USER_LOGINOUT}</li>
                            <!-- END: USER -->
                        </ul>
                    </li>
                </ul>
<!--*********************************Вывод админской оплаты************************************************-->
 
            </div>
        </div>
    </div>
</div>
<!-- END: HEADER -->