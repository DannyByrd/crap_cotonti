<!-- BEGIN: MAIN -->

<div>Заказы</div>



 
  <table class="table">
    <thead>
        <tr>
           <th># заказа</th>
           <th>Имя покупателя</th>
           <th>Статус</th>
           <th>Итого</th>
           <th>Дата добавления</th>
                            
         </tr>
   </thead>
<!-- BEGIN: ORDER_ROW -->
		<tr>
			<td>{SIMPLEORDERS_ORDER_ID}</td>
			<td>{SIMPLEORDERS_ORDER_UNAME}</td>
			<td>{SIMPLEORDERS_ORDER_STATUS}</td>
			<td>{SIMPLEORDERS_ORDER_TOTAL}</td>
			<td>{SIMPLEORDERS_ORDER_DATEADDED}</td>
			<td></td>
			<td><a href="{SIMPLEORDERS_ORDER_EDIT}">Изменить</a></td>
		</tr>
		

<!-- END: ORDER_ROW -->

   </table>

<!-- END: MAIN -->