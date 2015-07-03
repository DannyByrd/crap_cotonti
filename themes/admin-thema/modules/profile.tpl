<!-- BEGIN: MAIN -->
<div class="page-container">
{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/sidebur.tpl"}
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-sidebar" style="width: 250px;">
                        <div class="portlet light profile-sidebar-portlet" style="padding-bottom: 20px !important;">
                            <div class="profile-userpic">
                                <!-- IF {PHP.usr.profile.user_avatar} -->
                                    <img class="img-responsive" src="{PHP.usr.profile.user_avatar}" alt="{PHP.L.Avatar}" />
                                <!-- ENDIF -->
                            </div>
                            <div class="profile-usertitle">
                                <div class="profile-usertitle-name">
                                    {PHP.usr.profile.user_name}
                                </div>
                                <div class="profile-usertitle-job">
                                <p>Ваш счет: {PHP.usr.id|cot_payments_getuserbalance($this)} {PHP.L.valuta}</p>
                                </div>
                            </div>
                        </div>
                        <div class="dashboard-stat2" style="margina: 0px; padding-bottom: 1px;">
                            <div class="display">
                                <div class="profile-userbuttons" style="margin: 5px 0px 15px 0px;">
                                    <a class="btn btn-circle green-haze adminbot" href="/index.php?e=payments&m=balance&n=billing">Пополнить счет</a>
                                    <a class="btn btn-circle btn-danger adminbot" href="/index.php?e=payments&m=balance&n=payouts">Вывод со счета</a>
                                    <a class="btn btn-circle green-haze adminbot" href="/index.php?e=payments&m=balance&n=history">История операций</a>
                                    <a class="btn btn-circle btn-danger adminbot" href="/index.php?e=payments&m=balance&n=transfer">Перевод пользователю</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-content">
                        <div class="row">
                            <div class="col-md-12" style="background: #fff;">
                                <div class="portlet light ">
                                    <div class="portlet-title" style="border: 0px;">
                                        <div class="actions">
                                            <div class="btn-group btn-group-devided">
                                                <div class="profile-usermenu button44">
                                                    <ul class="nav glavna" style="border-bottom: 2px solid #EEEEEE;">
                                                        <!-- BEGIN: MENU -->
                                                        <!-- BEGIN: MENU_ROW -->
                                                        <li style="border: none;" <!-- IF {PHP.m} == {MENU_ROW_ID} --> class="active"<!-- ENDIF -->>
                                                        <a class="link-profile" href="{MENU_ROW_URL}">{MENU_ROW_TITLE}</a>
                                                        </li>
                                                        <!-- END: MENU_ROW -->
                                                        <!-- END: MENU -->
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        {PROFILE_CONTENT}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: MAIN -->