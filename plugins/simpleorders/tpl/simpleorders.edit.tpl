<!-- BEGIN: MAIN -->

<div>Управление заказом # {SIMPLEORDERS_DATA_ORDER_ID}</div> <br>
<div>Данные покупателя</div>

<!-- BEGIN: CUSTOMER_DATA -->
<form action="{SIMPLEORDERS_FORM_ACTION}" method="POST">
  <table class="table">

  <tr>
  	<td>Дата заказа</td><td>{SIMPLEORDERS_DATA_ORDER_DATEADDED}</td>
  </tr>
  <tr>
  	<td>ФИО заказчика</td><td>{SIMPLEORDERS_DATA_ORDER_FIO}</td>
  </tr>
  <tr>
  	<td> Телефон</td><td>{SIMPLEORDERS_DATA_ORDER_TEL}</td>
  </tr>
  <tr>
  	<td> E-Mail</td><td>{SIMPLEORDERS_DATA_ORDER_EMAIL}</td>
  </tr>
  <tr>
  	<td>Статус заказа</td><td>{SIMPLEORDERS_DATA_ORDER_STATUS}</td>
  </tr>

  </table>
	
  

<!-- END:  CUSTOMER_DATA-->
<hr>
<div>Заказанные товары</div>

<table class="table">
    <thead>
        <tr>
           
           <th>Товар</th>
           <th>Модуль</th>
           <th>Кол-во</th>
           <th>Цена за единицу</th>
           <th>Итого</th>
                                       
         </tr>
   </thead>
<!-- BEGIN:  GOODS_DATA -->

	
	<tr>
			
			<td>{SIMPLEORDERS_DATA_GOODS_NAME}</td>
      <td>{SIMPLEORDERS_DATA_GOODS_MODULE}</td>
			<td>{SIMPLEORDERS_DATA_GOODS_QUANTITY}</td>
			<td>{SIMPLEORDERS_DATA_GOODS_PRICE}</td>
			<td>{SIMPLEORDERS_DATA_GOODS_TOTAL}</td>
      <td></td>
      <td><a href="javascript:deleteOrder('1');" class="btn btn-danger">Удалить</a></td>
			
	</tr>


<!-- END: GOODS_DATA -->

</table>
<input type="submit" class="btn btn-primary" value='Редактировать'> 
</form>

<!-- END: MAIN -->