<!-- BEGIN: MAIN -->

<!-- BEGIN: CMANAGER -->
<div class="col">
	<div class="block">
		<h1>Edit field</h1>
	</div>
</div>

<div>

<form action="{CMANAGER_FORM_ACTION}" method="POST" class="form-horizontal">
<label for="cmtitle">Название поля</label><input type="text" name="title_name" id="cmtitle" value="{CMANAGER_TITLE_VALUE}">

<label for="cmtext">Описание поля</label><textarea name="text_name" id="cmtext">{CMANAGER_TEXT_VALUE}</textarea>
<br><br>


	<img src="{CMANAGER_PAGE_MAVATAR.1|cot_mav_thumb($this, 200, 200)}"/>

	<p>{PHP.L.Image}:</p>
	<div>{CMEDIT_FORM_MAVATAR}</div>

	
<br><br>
	<input type="submit" value="Сохранить">

</form>
</div>

<!-- END: CMANAGER-->



<!-- END: MAIN -->