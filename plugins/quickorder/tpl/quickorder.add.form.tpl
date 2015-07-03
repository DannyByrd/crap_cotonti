<!-- BEGIN: MAIN -->

            <!-- IF {MAIL_SENDED} -->
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Success!</strong> Your message has been sent successfully.
            </div>
            <!-- ENDIF -->
            
        <form method="post" id="add-quick-form" action="{PHP|cot_url('quickorder', 'a=sendorder')}" class="form-horizontal">

                 

            <!-- IF {USE_FIELD_NAME} == 1 -->
            <!-- IF {ERROR_USER_NAME} -->
            <div class="form-group has-error">
                    <div class="control-label">{ERROR_USER_NAME}</div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" value="{USER_NAME}" class="form-control" id="user_name" name="user_name" placeholder="Ваше имя">
                    </div>
            </div>
            <!-- ELSE -->
            <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" value="{USER_NAME}" class="form-control" id="user_name" name="user_name" placeholder="Ваше имя">
                    </div>
            </div>
            <!-- ENDIF -->
            <!-- ENDIF -->

            <!-- IF {USE_FIELD_PHONE} == 1 -->
            <!-- IF {ERROR_USER_PHONE} -->
            <div class="form-group has-error">
                    <div class="control-label">{ERROR_USER_PHONE}</div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" value="{USER_PHONE}" class="form-control" id="user_phone" name="user_phone" placeholder="Какой у Вас номер телефона?">
                    </div>
            </div>
            <!-- ELSE -->
            <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                        <input type="text" value="{USER_PHONE}" class="form-control" id="user_phone" name="user_phone" placeholder="Какой у Вас номер телефона?">
                    </div>
            </div>
            <!-- ENDIF -->
            <!-- ENDIF -->

            <!-- IF {USE_FIELD_EMAIL} == 1 -->
            <!-- IF {ERROR_USER_EMAIL} -->
            <div class="form-group has-error">
                    <div class="control-label">{ERROR_USER_EMAIL}</div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input type="text" value="{USER_EMAIL}" class="form-control" id="user_email" name="user_email" placeholder="Какой у Вас адрес электронной почты?">
                    </div>
            </div>
            <!-- ELSE -->
            <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input type="text" value="{USER_EMAIL}" class="form-control" id="user_email" name="user_email" placeholder="Какой у Вас адрес электронной почты?">
                    </div>
            </div>
            <!-- ENDIF -->
            <!-- ENDIF -->

            <!-- IF {USE_FIELD_TEXT} == 1 -->
            <!-- IF {ERROR_USER_TEXT} -->
            <div class="form-group has-error">
                 <div class="control-label">{ERROR_USER_TEXT}</div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input type="text" value="{USER_TEXT}" class="form-control" id="user_text" name="user_text" placeholder="Тут некий текст для отправки">
                    </div>
            </div>
            <!-- ELSE -->
            <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input type="text" value="{USER_TEXT}" class="form-control" id="user_text" name="user_text" placeholder="Тут некий текст для отправки">
                    </div>
            </div>

            <!-- ENDIF -->
            <!-- ENDIF -->

            <!-- IF {USE_FIELD_TEXT2} == 1 -->
            <!-- IF {ERROR_USER_TEXT2} -->
            <div class="form-group has-error">
                 <div class="control-label">{ERROR_USER_TEXT2}</div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input type="text" value="{USER_TEXT2}" class="form-control" id="user_text" name="user_text" placeholder="Тут некий текст2 для отправки">
                    </div>
            </div>
            <!-- ELSE -->
            <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input type="text" value="{USER_TEXT2}" class="form-control" id="user_text2" name="user_text2" placeholder="Тут некий текст2 для отправки">
                    </div>
            </div>

            <!-- ENDIF -->
            <!-- ENDIF -->

            <input type="hidden" name="prd_id" value="{PRD_ID}" />
        </form>
<!-- END: MAIN -->