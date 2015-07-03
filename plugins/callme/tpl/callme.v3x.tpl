<!-- BEGIN: MAIN -->

    <!-- IF {IS_AJAX} -->

        <!-- IF {MAIL_SENDED} -->
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Success!</strong> Your message has been sent successfully.
        </div>
        <!-- ENDIF -->
    
  <form action="{PHP|cot_url('callme')}" method="post" enctype="multipart/form-data" id="callme-form" class="ajax post-callmeForm">
        <!-- IF {ERROR_PLG_CALLME_NAME} -->
        <div class="form-group has-error">
            <input value="{PLG_CALLME_NAME}" type="text" name="plg_callme_name" id="plg_callme_name" class="form-control" placeholder="Ваше имя">
            <span class="help-block">{ERROR_PLG_CALLME_NAME}</span>
        </div>
        <!-- ELSE -->
        <div class="form-group">
            <input  value="{PLG_CALLME_NAME}" type="text" name="plg_callme_name" id="plg_callme_name" class="form-control" placeholder="Ваше имя">
        </div>
        <!-- ENDIF -->

        <!-- IF {ERROR_PLG_CALLME_TEL} -->
        <div class="form-group has-error">
            <input  value="{PLG_CALLME_TEL}" type="text" name="plg_callme_tel" id="plg_callme_tel" class="form-control" placeholder="Телефон">
            <span class="help-block">{ERROR_PLG_CALLME_TEL}</span>
        </div>
        <!-- ELSE -->
        <div class="form-group">
            <input value="{PLG_CALLME_TEL}" type="text" name="plg_callme_tel" id="plg_callme_tel" class="form-control" placeholder="Телефон">
        </div>
        <!-- ENDIF -->

         <!-- IF {USE_HANDY_TIME} -->
               <div class="form-group">
                 <input value="{PLG_CALLME_HANDYTIME}" type="text" name="plg_callme_handytime" id="plg_callme_handytime" class="form-control" placeholder="удобное время">
              </div>

         <!-- ENDIF -->

        <!-- IF {ERROR_PLG_CALLME_ADDITIONAL} -->
        <div class="form-group has-error">
            <textarea class="form-control" rows="3" name="plg_callme_additional" placeholder="Дополнительная информация"> value="{PLG_CALLME_ADDITIONAL}"</textarea>
            <span class="help-block">{ERROR_PLG_CALLME_ADDITIONAL}</span>
        </div>
        <!-- ELSE -->
        <div class="form-group">
            <textarea class="form-control" rows="3" name="plg_callme_additional" placeholder="Дополнительная информация"></textarea>
        </div>
        <!-- ENDIF -->         
  </form> 

    <!-- ELSE -->
    <a data-toggle="modal" href="{PHP|cot_url('callme')}" data-target="#callmeModal" class="bn-fixed">Call me</a>

    <!-- ENDIF -->

<!-- END: MAIN -->