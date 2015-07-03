<!-- BEGIN: MAIN -->

<!-- BEGIN: CMANAGER -->
<div class="col">
	<div class="block">
		<h1>Content Manager</h1>
	</div>
</div>

<a href="{PHP|cot_url('cmanager', 'a=add)}" class="btn btn-primary"> Добавить </a>

<br><br>


<!-- http://crap_cotonti/whatpay/?a=getcode&userCode= -->
	<form action="{PHP|cot_url('cmanager', 'a=edit')}" method="POST" class="form-horizontal">
	<table id="cells">
	<tr class="newscat">
	<input type="text" name="header">
	<!-- IF {PHP.cot_plugins_active.mavatars} -->
	
		<tr>
			<td>{PHP.L.Image}:</td>
			<td>{CMANMADD_FORM_MAVATAR}</td>
		</tr>

		<tr><h2>Изображение</h2>
			<td>
				<a href="{ICON.1.FILE}"><div class=""><img src="{ICON.1|cot_mav_thumb($this, 200, 200, width)}" /></div></a>

			</td>
		</tr>
	</tr>	
	<b>Hello</b><p>, how are you?</p>
	<p>HERE</p>		
	<!-- ENDIF -->
	<input type="submit" value="Сохранить">
	</table>
</form>

<span class="btn btn-primary" id="addField">Добавить поле</span>
<!-- END: CMANAGER-->


<script type="text/javascript" src="plugins/cmanager/js/cmanager.js"></script>
<!-- END: MAIN -->