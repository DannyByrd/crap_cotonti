<!-- BEGIN: MAIN -->
<div class="modal fade" id="modalCart" tabindex="-1" role="dialog" aria-labelledby="modalCartLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalCartLabel">Корзина</h4>
      </div>
      <div class="modal-body">
        <!-- IF {SIMPLEORDERS_ITEM_NUMB} -->
        <form id="cart-form">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th></th>
                <th>Название товара</th>
                <th>Цена</th>
                <th>Количество</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
          <!-- BEGIN: ITEMS -->
              <tr id="cart-row-{SIMPLEORDERS_ITEM_NUMB}">
                <th scope="row">{SIMPLEORDERS_ITEM_NUMB}</th>
                <td>

                <!-- IF {SIMPLEORDERS_ITEM_AVATAR} -->
        
                  <a href="{SIMPLEORDERS_ITEM_AVATAR.1.FILE}"><div class=""><img src="{SIMPLEORDERS_ITEM_AVATAR.1|cot_mav_thumb($this, 200, 200, width)}" /></div>
                  </a>
                  <!-- ENDIF -->
                  
                </td>
                <td>
                  {SIMPLEORDERS_ITEM_TITLE}
                  <input name="cartdata[title][]" type="hidden" value="{SIMPLEORDERS_ITEM_TITLE}">
                  </td>
                  <td>
                    {SIMPLEORDERS_ITEM_PRICE}
                  </td>
                <td><input name="cartdata[quantity][]" class="input-mini" type="number" value="{SIMPLEORDERS_ITEM_QUANTITY}"></td>
                <td><a class="btn btn-danger" href="javascript:deleteRow({SIMPLEORDERS_ITEM_NUMB})">удалить</a></td>
              </tr>
          <!-- END: ITEMS -->
            </tbody>
          </table>
        </form>
        <!-- ELSE -->        
        <h3 class="text-center text-warning">Пусто!</h3>
        <!-- ENDIF -->  
         <div class="pull-right">Итого: {SIMPLEORDERS_ITEM_TOTALPRICE}</div>      
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Продолжить покупки</button>
        <!-- IF {SIMPLEORDERS_ITEM_NUMB} -->
        <button type="button" class="btn btn-primary" id="btn-add-order">Оформить заказ</button>
        <!-- ENDIF -->        
      </div>
    </div>
  </div>
</div>
<!-- END: MAIN -->