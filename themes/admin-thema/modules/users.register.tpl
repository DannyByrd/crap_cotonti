<!-- BEGIN: MAIN -->
<div class="login" style="margin-top: 130px;background-color: transparent !important;">
   <div class="container">
       {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
   </div>
    <div class="content">
        
        <form class="login-form" name="login" action="{USERS_REGISTER_SEND}" method="post" enctype="multipart/form-data">
            <h3>{USERS_REGISTER_TITLE}</h3>
            <p class="hint">
                Введите свои личные данные ниже:
            </p>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Имя</label>
                {USERS_REGISTER_USER}
            </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">E-mail</label>
                {USERS_REGISTER_EMAIL}
            </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Пароль</label>
                {USERS_REGISTER_PASSWORD}
            </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Пароль</label>
                {USERS_REGISTER_PASSWORDREPEAT}
            </div>
            <!--<div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Username</label>
                {USERS_REGISTER_VERIFYIMG}
                {USERS_REGISTER_VERIFYINPUT}
            </div> -->
            <div class="form-actions">
                <button type="submit" class="btn btn-success uppercase pull-right">Отправить</button>
            </div>
        </form>





    </div>
</div>
<!-- END: MAIN -->