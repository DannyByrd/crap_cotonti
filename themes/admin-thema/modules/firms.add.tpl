<!-- BEGIN: MAIN -->
<div class="page-container">
		<div class="block" style="text-align: center;">
			<h2 class="firms" style="color: #000;">{FIRMADD_FIRMTITLE}</h2>
			{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
			<div class="customform">
				<form action="{FIRMADD_FORM_SEND}" enctype="multipart/form-data" method="post" name="firmsform">
					<table class="cells redactor-style">
						<tr>
							<td class="width30">{PHP.L.Category}:</td>
							<td class="width70">{FIRMADD_FORM_CAT}</td>
						</tr>
                        <tr>
                            <td>{PHP.L.firm_title}:</td>
                            <td>{FIRMADD_FORM_TITLE}</td>
                        </tr>
                        <!-- BEGIN: ADMIN -->
                        <tr>
                            <td>{PHP.L.Alias}:</td>
                            <td>{FIRMADD_FORM_ALIAS}</td>
                        </tr>
                        <!-- END: ADMIN -->
                        <tr>
                            <td>{PHP.L.firm_metatitle}:</td>
                            <td>{FIRMADD_FORM_METATITLE}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.firm_metadesc}:</td>
                            <td>{FIRMADD_FORM_METADESC}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.firm_metakeywords}:</td>
                            <td>{FIRMADD_FORM_KEYWORDS}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="2">
                                {FIRMADD_FORM_TEXT}
                                <!-- IF {FIRMADD_FORM_PFS} -->{FIRMADD_FORM_PFS}<!-- ENDIF -->
                                <!-- IF {FIRMADD_FORM_SFS} --><span class="spaced">{PHP.cfg.separator}</span>{FIRMADD_FORM_SFS}<!-- ENDIF -->
                            </td>
                        </tr>
                    <!-- IF {PHP.cot_plugins_active.mavatars} -->
						<tr>
							<td>Изображения:</td>
							<td>{FIRMADD_FORM_MAVATAR}</td>
						</tr>
                    <!-- ENDIF -->

	                <!-- BEGIN: TAGS -->
						<tr>
							<td>{FIRMADD_TOP_TAGS}:</td>
							<td>{FIRMADD_FORM_TAGS} ({FIRMADD_TOP_TAGS_HINT})</td>
						</tr>
	                <!-- END: TAGS -->
						<tr>
							<td>{PHP.L.Owner}:</td>
							<td>{FIRMADD_FORM_OWNER}</td>
						</tr>
						<tr>
							<td>{PHP.L.Parser}:</td>
							<td>{FIRMADD_FORM_PARSER}</td>
						</tr>

				<!-- IF {PHP.cot_plugins_active.placemarks} -->
						<tr>
							<td>{PHP.L.placemarks_placeonmap}:</td>
							<td>{FIRMADD_FORM_PLACEMARKS}</td>
						</tr>
				<!-- ELSE -->
					<tr>
						<td colspan="2">
							<span style="color: #b94a48;">Плагин <a style="color: #b94a48;" href="{PHP|cot_url('admin', 'm=extensions&a=details&pl=placemarks')}" target="_blank"><b>placemarks</b></a> не установлен</span> 
						</td>
					</tr>
				<!-- ENDIF -->
						<tr>
							<td>{PHP.L.firm_addr}:</td>
							<td>{FIRMADD_FORM_ADDR}</td>
						</tr>
						<tr>
							<td>{PHP.L.firm_phone}:</td>
							<td>{FIRMADD_FORM_PHONE}</td>
						</tr>
						<tr>
							<td>{PHP.L.firm_skype}:</td>
							<td>{FIRMADD_FORM_SKYPE}</td>
						</tr>
						<tr>
							<td>{PHP.L.firm_site}:</td>
							<td>{FIRMADD_FORM_SITE}</td>
						</tr>
						<tr>
							<td>{PHP.L.firm_email}:</td>
							<td>{FIRMADD_FORM_EMAIL}</td>
						</tr>
						<tr>
                            <td></td>
							<td colspan="2" class="valid">
								<!-- IF {PHP.usr_can_publish} -->
								<button class="btn btn-success" type="submit" name="rfirmtate" value="0">{PHP.L.Publish}</button>
								<!-- ENDIF -->
								<button class="btn btn-success" type="submit" name="rfirmtate" value="2" class="submit">{PHP.L.Saveasdraft}</button>
								<button class="btn btn-success" type="submit" name="rfirmtate" value="1">{PHP.L.Submitforapproval}</button>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<div class="alert alert-info">{PHP.L.firm_formhint}</div>
</div>
<!-- END: MAIN -->