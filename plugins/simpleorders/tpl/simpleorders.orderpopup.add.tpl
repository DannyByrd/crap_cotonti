<!-- BEGIN: MAIN -->
<div class="modal fade" id="modalAddOrder" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalAddLabel">Оформиление заказа</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="add-order-form">
            <div class="control-group">
              <label class="control-label" for="inputName">Фамилия Имя</label>
              <div class="controls">
                <input type="text" id="inputName" placeholder="Фамилия Имя" name="formData[name]" class="required">
                <label id="input-name-error" class="error" for="inputName"></label>
              </div>
            </div>
           
            <!-- IF {USER_LOGGED} == 0 -->
            <div class="control-group">
              <label class="control-label" for="inputEmail">Емайл</label>
              <div class="controls">
                <input type="email" id="inputEmail" placeholder="Емайл" name="formData[email]" class="required">
                 <label id="input-email-error" class="error" for="inputEmail"></label>
              </div>
            </div>
            <!-- ENDIF -->
            <div class="control-group">
              <label class="control-label" for="inputTel">Телефон</label>
              <div class="controls">
                <input type="text" id="inputTel" placeholder="Телефон" name="formData[tel]" class="required" minlength="7">
                <label id="input-tel-error" class="error" for="inputTel"></label>
              </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Продолжить покупки</button>
        <button type="button" class="btn btn-primary" id="btn-add-order" name="btn-order">Оформить заказ</button>
      </div>
    </div>
  </div>
</div>
<!-- END: MAIN -->