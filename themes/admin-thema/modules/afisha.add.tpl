<!-- BEGIN: MAIN -->
<div class="page-container">
		<div class="block"  style="text-align: center;">
			<h2 class="afisha" style="color: #000;">{EVTADD_FIRMTITLE}</h2>
			{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
			<div class="customform">
				<form action="{EVTADD_FORM_SEND}" enctype="multipart/form-data" method="post" name="afishaform">
					<table class="cells redactor-style">
						<tr>
							<td class="width30">{PHP.L.Category}:</td>
							<td class="width70">{EVTADD_FORM_CAT}</td>
						</tr>
						<tr>
							<td>{PHP.L.event_title}:</td>
							<td>{EVTADD_FORM_TITLE}</td>
						</tr>
                        <!-- BEGIN: ADMIN -->
                        <tr>
                            <td>{PHP.L.Alias}:</td>
                            <td>{EVTADD_FORM_ALIAS}</td>
                        </tr>
                        <!-- END: ADMIN -->
                        <tr>
                            <td>{PHP.L.event_metatitle}:</td>
                            <td>{EVTADD_FORM_METATITLE}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.event_metadesc}:</td>
                            <td>{EVTADD_FORM_METADESC}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.event_metakeywords}:</td>
                            <td>{EVTADD_FORM_KEYWORDS}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.Owner}:</td>
                            <td>{EVTADD_FORM_OWNER}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.Parser}:</td>
                            <td>{EVTADD_FORM_PARSER}</td>
                        </tr>


                    <!-- BEGIN: TAGS -->
						<tr>
							<td>{EVTADD_TOP_TAGS}:</td>
							<td>{EVTADD_FORM_TAGS} ({EVTADD_TOP_TAGS_HINT})</td>
						</tr>
	                <!-- END: TAGS -->

						<tr>
                            <td></td>
							<td colspan="2">
								{EVTADD_FORM_TEXT}
								<!-- IF {EVTADD_FORM_PFS} -->{EVTADD_FORM_PFS}<!-- ENDIF -->
								<!-- IF {EVTADD_FORM_SFS} --><span class="spaced">{PHP.cfg.separator}</span>{EVTADD_FORM_SFS}<!-- ENDIF -->
							</td>
						</tr>
                <!-- IF {PHP.cot_plugins_active.mavatars} -->
						<tr>
							<td>{PHP.L.Images}Изображения:</td>
							<td>{EVTADD_FORM_MAVATAR}</td>
						</tr>
                <!-- ENDIF -->
						<tr>
							<td>{PHP.L.Expire}:</td>
							<td>{EVTADD_FORM_EXPIRE}</td>
						</tr>
						<tr>
                            <td></td>
							<td colspan="2" class="valid">
								<!-- IF {PHP.usr_can_publish} -->
								<button class="btn btn-success" type="submit" class="btn btn-success" name="reventtate" value="0">{PHP.L.Publish}</button>
								<button class="btn btn-success" type="submit" class="btn btn-success" name="reventtate" value="2" class="submit">{PHP.L.Saveasdraft}</button>
								<!-- ELSE -->
								<button class="btn btn-success" type="submit" class="btn btn-success" name="reventtate" value="1">{PHP.L.Publish}</button>
								<!-- ENDIF -->
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<div class="alert alert-info">{PHP.L.event_formhint}</div>

<!-- END: MAIN -->