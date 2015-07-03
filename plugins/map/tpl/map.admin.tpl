<!-- BEGIN: MAIN -->
<div class="block button-toolbar">
    <a href="#" class="button">Кнопка</a>
</div>

{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}

<h2 class="tags">Map</h2>

<div class="customform">
	<form action="{MAPEDIT_FORM_SEND}" enctype="multipart/form-data" method="post" name="mapform">
		<table class="cells margintop10">
		    <tr>
		        <td class="coltop">
		        	<div style="font-size: 14px;">Настройка зума и коодинат карты</div>
					<div  style="font-size: 13px;" class="help">
						Отзумируйте карту скролом мыши и кликнете на цетр города. Затем нажмите сохранить.
					</div>
		        	</td>
		    </tr>
		    <tr>
		    	<td>
		    		<input type="submit" value="Сохранить">
		    	</td>
		    </tr>
		    <tr>
		    	<td class="odd centerall">
		    		{MAPEDIT_FORM_PLACEMARKS}
		    	</td>
		    </tr>
		    <tr>
		    	<td>
		    		<input type="submit" value="Сохранить">
		    	</td>
		    </tr>
		</table>
	</form>
</div>

<!-- END: MAIN -->