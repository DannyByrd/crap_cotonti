<!-- BEGIN: MAIN -->

	<div class="block">
		<h3>Тестовая форма</h3>
		<form id="multiforms-{MULTIFORMS_FORM_ID}" method="post" action="{MULTIFORMS_FORM_ACTION}" enctype="multipart/form-data">
			<div class="form-group">			
				<div id="ajaxBlock"></div>
				<input class="form-control" type="text" name="multiforms[my_name]" value="" placeholder="Ваше имя">
			</div>
			<div class="form-group">			
				<textarea name="multiforms[text]" placeholder="Ваше сообщение"></textarea>
			</div>
			<div class="form-group">			
				<input type="file" name="multiforms_files[]">
			</div>
			<div class="form-group">			
				<input type="file" name="multiforms_files[]">
			</div>
			<div class="form-group">			
				<input type="file" name="multiforms_files[]">
			</div>
			{MULTIFORMS_FORM_ID_HIDDEN}
			<button type="submit">Отправить</button>
		</form>
	</div>

<!-- END: MAIN -->