<!-- BEGIN: MAIN -->

<div class="col">
	<div class="block">
		<h1>ADD new field</h1>
	</div>
</div>
<!-- BEGIN: CMANAGER -->

<form action="{PHP|cot_url('cmanager', 'a=add')}" method="POST" class="form-horizontal">
<input type="hidden" value="{CMANAGER_ID}" name="idField">
<label for="cmtitle">Название поля</label><input type="text" name="title_name" id="cmtitle" value="{CMANAGER_TITLE_VALUE}">
<label for="cmtext">Описание поля</label><textarea name="text_name" id="cmtext">{CMANAGER_TEXT_VALUE}</textarea>

<br><br>
	<!-- IF {PHP.cot_plugins_active.mavatars} -->
		
			{PHP.L.Image}:
			{CMANMADD_FORM_MAVATAR}
		
		
	<!-- ENDIF -->

	<br>
<input type="submit" value="Сохранить">

</form>

<!-- END: CMANAGER-->



<!-- END: MAIN -->