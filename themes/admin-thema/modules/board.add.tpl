<!-- BEGIN: MAIN -->
<div class="page-container">
		<div class="block" style="text-align: center;">
			<h2 class="board" style="color: #000;">{ADVADD_FIRMTITLE}</h2>
			{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
			<div class="customform">
				<form action="{ADVADD_FORM_SEND}" enctype="multipart/form-data" method="post" name="boardform">
					<table class="cells redactor-style">
						<tr>
							<td class="width30">{PHP.L.Category}:</td>
							<td class="width70">{ADVADD_FORM_CAT}</td>
						</tr>
						<tr>
							<td>{PHP.L.adv_title}:</td>
							<td>{ADVADD_FORM_TITLE}</td>
						</tr>
                        <!-- BEGIN: ADMIN -->
                        <tr>
                            <td>{PHP.L.Alias}:</td>
                            <td>{ADVADD_FORM_ALIAS}</td>
                        </tr>
                        <!-- END: ADMIN -->
                        <tr>
                            <td>{PHP.L.adv_metatitle}:</td>
                            <td>{ADVADD_FORM_METATITLE}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.adv_metadesc}:</td>
                            <td>{ADVADD_FORM_METADESC}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.adv_metakeywords}:</td>
                            <td>{ADVADD_FORM_KEYWORDS}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.Owner}:</td>
                            <td>{ADVADD_FORM_OWNER}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.Parser}:</td>
                            <td>{ADVADD_FORM_PARSER}</td>
                        </tr>

                        <!-- BEGIN: TAGS -->
						<tr>
							<td>{ADVADD_TOP_TAGS}:</td>
							<td>{ADVADD_FORM_TAGS} ({ADVADD_TOP_TAGS_HINT})</td>
						</tr>
	<!-- END: TAGS -->

						<tr>
                            <td></td>
							<td colspan="2">
								{ADVADD_FORM_TEXT}
								<!-- IF {ADVADD_FORM_PFS} -->{ADVADD_FORM_PFS}<!-- ENDIF -->
								<!-- IF {ADVADD_FORM_SFS} --><span class="spaced">{PHP.cfg.separator}</span>{ADVADD_FORM_SFS}<!-- ENDIF -->
							</td>
						</tr>
						<tr>
							<td>{PHP.L.Images}Изображения:</td>
							<td>{ADVADD_FORM_MAVATAR}</td>
						</tr>
						<tr>
							<td>{PHP.L.adv_cost}:</td>
							<td>
                                <span style="margin-left: 0px;" class="zarplata">{ADVADD_FORM_COST}</span>
                                <span style="margin-left: 5px;" class="scolko">{PHP.cfg.payments.valuta}</span>
                            </td>
						</tr>
						<tr>
							<td>{PHP.L.Expire}:</td>
							<td>{ADVADD_FORM_EXPIRE}</td>
						</tr>
						<tr>
							<td>{PHP.L.placemarks_placeonmap}:</td>
							<td>{ADVADD_FORM_PLACEMARKS}</td>
						</tr>
						<tr>
							<td>{PHP.L.adv_addr}:</td>
							<td>{ADVADD_FORM_ADDR}</td>
						</tr>
						<tr>
							<td>{PHP.L.adv_phone}:</td>
							<td>{ADVADD_FORM_PHONE}</td>
						</tr>
						<tr>
							<td>{PHP.L.adv_skype}:</td>
							<td>{ADVADD_FORM_SKYPE}</td>
						</tr>
						<tr>
							<td>{PHP.L.adv_site}:</td>
							<td>{ADVADD_FORM_SITE}</td>
						</tr>
						<tr>
							<td>{PHP.L.adv_email}:</td>
							<td>{ADVADD_FORM_EMAIL} {ADVADD_FORM_HIDEMAIL}</td>
						</tr>
						<!-- IF {PHP.usr.id} == 0 -->
						<tr>
							<td>{ADVADD_FORM_VERIFYIMG}</td>
							<td>{ADVADD_FORM_VERIFYINPUT} *</td>
						</tr>
						<!-- ENDIF -->
						<tr>
                            <td></td>
							<td colspan="2" class="valid">
								<!-- IF {PHP.usr_can_publish} -->
								<button type="submit" class="btn btn-success" name="radvtate" value="0">{PHP.L.Publish}</button>
								<button type="submit" class="btn btn-success" name="radvtate" value="2" class="submit">{PHP.L.Saveasdraft}</button>
								<!-- ELSE -->
								<button type="submit" class="btn btn-success" name="radvtate" value="1">{PHP.L.Publish}</button>
								<!-- ENDIF -->
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<div class="alert alert-info">{PHP.L.adv_formhint}</div>
</div>
<!-- END: MAIN -->