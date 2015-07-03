<!-- BEGIN: MAIN -->
<div class="page-container">
		<div class="block" style="text-align: center;">
			<h2 class="afisha" style="color: #000;">{EVTEDIT_FIRMTITLE} #{EVTEDIT_FORM_ID}</h2>
			{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
			<div class="customform">
				<form action="{EVTEDIT_FORM_SEND}" enctype="multipart/form-data" method="post" name="afishaform">
					<table class="cells redactor-style">
						<tr>
							<td class="width30">{PHP.L.Category}:</td>
							<td class="width70">{EVTEDIT_FORM_CAT}</td>
						</tr>
						<tr>
							<td>{PHP.L.event_title}:</td>
							<td>{EVTEDIT_FORM_TITLE}</td>
						</tr>
                        
                        <tr>
                            <td>{PHP.L.Alias}:</td>
                            <td>{EVTEDIT_FORM_ALIAS}</td>
                        </tr>
                        <!-- BEGIN: ADMIN -->
                        <!-- END: ADMIN -->
                        <tr>
                            <td>{PHP.L.event_metatitle}:</td>
                            <td>{EVTEDIT_FORM_METATITLE}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.event_metadesc}:</td>
                            <td>{EVTEDIT_FORM_METADESC}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.event_metakeywords}:</td>
                            <td>{EVTEDIT_FORM_KEYWORDS}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="2">
                                {EVTEDIT_FORM_TEXT}
                                <!-- IF {EVTEDIT_FORM_PFS} -->{EVTEDIT_FORM_PFS}<!-- ENDIF -->
                                <!-- IF {EVTEDIT_FORM_SFS} --><span class="spaced">{PHP.cfg.separator}</span>{EVTEDIT_FORM_SFS}<!-- ENDIF -->
                            </td>
                        </tr>

						<tr>
							<td>{PHP.L.Date}:</td>
							<td>{EVTEDIT_FORM_DATE}</td>
						</tr>
                        <tr>
                            <td>{PHP.L.Expire}:</td>
                            <td>{EVTEDIT_FORM_EXPIRE}</td>
                        </tr>
						<tr>
							<td>{PHP.L.Status}:</td>
							<td>{EVTEDIT_FORM_LOCALSTATUS}</td>
						</tr>
	<!-- BEGIN: TAGS -->
						<tr>
							<td>{EVTEDIT_TOP_TAGS}:</td>
							<td>{EVTEDIT_FORM_TAGS} ({EVTEDIT_TOP_TAGS_HINT})</td>
						</tr>
	<!-- END: TAGS -->
	<!-- BEGIN: ADMIN -->

						<tr>
							<td>{PHP.L.Owner}:</td>
							<td>{EVTEDIT_FORM_OWNERID}</td>
						</tr>
						<tr>
							<td>{PHP.L.Hits}:</td>
							<td>{EVTEDIT_FORM_ADVCOUNT}</td>
						</tr>
	<!-- END: ADMIN -->
						<tr>
							<td>{PHP.L.Parser}:</td>
							<td>{EVTEDIT_FORM_PARSER}</td>
						</tr>

<!-- IF {PHP.cot_plugins_active.mavatars} -->
						<tr>
							<td>{PHP.L.Images}Изображения:</td>
							<td>{EVTEDIT_FORM_MAVATAR}</td>
						</tr>
<!-- ENDIF -->

						<tr>
							<td>{PHP.L.event_deleteevent}:</td>
							<td>{EVTEDIT_FORM_DELETE}</td>
						</tr>
						<tr>
                            <td></td>
							<td colspan="2" class="valid">
								<!-- IF {PHP.usr_can_publish} -->
								<button type="submit" class="btn btn-success" name="reventtate" value="0">{PHP.L.Publish}</button>
								<button type="submit" class="btn btn-success" name="reventtate" value="2" class="submit">{PHP.L.Saveasdraft}</button>
								<!-- ELSE -->
								<button type="submit" class="btn btn-success" name="reventtate" value="1">{PHP.L.Publish}</button>
								<!-- ENDIF -->
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>

<!-- END: MAIN -->