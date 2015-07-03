<!-- BEGIN: MAIN -->

<!-- BEGIN: WHATPAY -->
<div class="col">
	<div class="block">
		<h1>What Pay</h1>
	</div>
</div>
<span id='c_url' style="display: none">{WHATPAY_URL}</span>
<!-- IF !{ADMIN_USER} -->
<form action="{PHP|cot_url('whatpay', 'a=getcode')}" method="POST" id="get-comment-form"  class="form-horizontal">
	<label for="userCode">Введите ваш код</label>
	<input type="text" id="userCode" name="userCode">
	<input type="submit" class="btn btn-success" value="Отправить" >
	<br><br>
	<textarea id="admin_comment" rows="5" cols="36" style="resize:none; width: auto;"></textarea>

</form>
<!-- ENDIF -->
<!-- IF {ADMIN_USER} -->
<table class="table">
<!-- BEGIN: HIST_ROW -->
	   <!-- IF {WHAYPAY_USET_WHOPAID} == admin -->
	 
	   <!--ELSE -->
		
	   <!-- ENDIF -->
	<tr id='whatpay_{WHATPAY_USER_PAYID}'>
		<td id="whatpay_userid_{WHATPAY_USER_PAYID}">{WHATPAY_USER_PAYID}</td>
		<td id="whatpay_useremail_{WHATPAY_USER_PAYID}">{WHATPAY_USER_EMAIL}</td>
		<td id="whatpay_userdate_{WHATPAY_USER_PAYID}">{WHATPAY_USER_DATE|cot_date('d.m.Y H:i', $this)}</td>  
		<td id="whatpay_userdesc_{WHATPAY_USER_PAYID}">{WHATPAY_USER_DESC}</td>
		<td ><textarea  rows="5" cols="35" style="resize:none; width: auto;"
		 id="whatpay_usercomm_{WHATPAY_USER_PAYID}" >{WHATPAY_USER_COMMENT}</textarea></td>
		<td style="text-align: right;position: relative; ">
		<span id="whatpay_userprice_{WHATPAY_USER_PAYID}">{WHATPAY_USER_SUMM|number_format($this, '2', '.', ' ')} {PHP.cfg.payments.valuta}
		</span>
		<br>
		<a href="javascript:void(0)" class="btn btn-primary" id="'whatpay_btn_{WHATPAY_USER_PAYID}"
		style="position: absolute; bottom: 17px;right: 10px;" onclick="sendEmail({WHATPAY_USER_PAYID})">Написать клиенту</a>
		</td>


	</tr>
<!-- END: HIST_ROW -->
<!-- ENDIF -->
</table>



	
	<script type="text/javascript" src="plugins/whatpay/js/whatpay.js"></script>
<!-- END: WHATPAY-->



<!-- END: MAIN -->

