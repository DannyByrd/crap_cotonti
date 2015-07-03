<!-- BEGIN: MAIN -->
<div class="page-lock">
    <div class="page-logo">
        <a class="brand" href="index.html">
            <img src="/themes/{PHP.theme}/img/logo-big.png" alt="logo"/>
        </a>
    </div>
    <div class="page-body">
        {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
        <div class="lock-head">
            {USERS_AUTH_TITLE}
        </div>
        <div class="lock-body">
            <div class="pull-left lock-avatar-block">
                <img src="/themes/{PHP.theme}/img/photo3.jpg" class="lock-avatar">
                <!-- IF {PHP.usr.profile.user_avatar} -->
                    <img src="{PHP.usr.profile.user_avatar}" alt="{PHP.L.Avatar}" />
                <!-- ENDIF -->
            </div>
            <form class="lock-form pull-left" name="login" action="{USERS_AUTH_SEND}" method="post">
                <div class="form-group">
                  <!--  <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password"/>-->
                    {USERS_AUTH_USER}
                </div>
                <div class="form-group">
                    {USERS_AUTH_PASSWORD}
                </div>
                <div class="form-group">
                    {USERS_AUTH_REMEMBER}&nbsp; <span style="color: #fff;">{PHP.L.users_rememberme}</span>
                </div>
                <div class="form-actions">
                    <button type="submit" name="rlogin" class="btn btn-success uppercase">Войти</button>
                </div>
            </form>
        </div>
        <div class="lock-bottom">
            <a href="{PHP|cot_url('users','m=register')}">{PHP.L.Register}</a>
        </div>
    </div>
</div>
<!-- END: MAIN -->