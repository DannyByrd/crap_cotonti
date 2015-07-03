<!-- BEGIN: MAIN -->
<div class="page-container">
		<div class="block" style="text-align: center;">
			<h2 class="rezume" style="color: #000;">{REZADD_FIRMTITLE}</h2>
			{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
			<div class="customform">
				<form action="{REZADD_FORM_SEND}" enctype="multipart/form-data" method="post" name="rezumeform">
					<table class="cells redactor-style">
						<tr>
							<td class="width30">{PHP.L.Category}:</td>
							<td class="width70">{REZADD_FORM_CAT}</td>
						</tr>
						<tr>
							<td>{PHP.L.rez_title}:</td>
							<td>{REZADD_FORM_TITLE}</td>
						</tr>
                        <!-- BEGIN: ADMIN -->
                        <tr>
                            <td>{PHP.L.Alias}:</td>
                            <td>{REZADD_FORM_ALIAS}</td>
                        </tr>
                        <!-- END: ADMIN -->
                        <tr>
                            <td>{PHP.L.rez_metatitle}:</td>
                            <td>{REZADD_FORM_METATITLE}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.rez_metadesc}:</td>
                            <td>{REZADD_FORM_METADESC}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.rez_metakeywords}:</td>
                            <td>{REZADD_FORM_KEYWORDS}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.Owner}:</td>
                            <td>{REZADD_FORM_OWNER}</td>
                        </tr>
                        <tr>
							<td>{PHP.L.rez_salary}:</td>
							<td>
                                <span style="margin-left: 0px;" class="zarplata">{REZADD_FORM_SALARY}</span>
                                <span class="scolko">{PHP.cfg.payments.valuta}</span>
                            </td>
						</tr>
						<tr>
							<td>{PHP.L.rez_age}:</td>
							<td>
                                <span style="margin-left: 0px;" class="zarplata">{REZADD_FORM_AGE}</span>
                                <span class="scolko">{PHP.L.rez_years}</span>
                            </td>
						</tr>
						<tr>
							<td>{PHP.L.rez_sex}:</td>
							<td>{REZADD_FORM_SEX}</td>
						</tr>
						<tr>
							<td style="text-align: center;" colspan="2"><h4>{PHP.L.rez_opyt}</h4></td>
						</tr>
						<tr>
							<td>{PHP.L.rez_exp}:</td>
							<td>
                                <span style="margin-left: 0px;" class="zarplata">{REZADD_FORM_EXP}</span>
                                <span class="scolko">{PHP.L.rez_years}</span>
                            </td>
						</tr>
						<tr>
							<td>{PHP.L.rez_works}:</td>
							<td>{REZADD_FORM_WORKS}</td>
						</tr>
						<tr>
							<td style="text-align: center;" colspan="2"><h4>{PHP.L.rez_edu}</h4></td>
						</tr>
						<tr>
							<td>{PHP.L.rez_edu}:</td>
							<td>{REZADD_FORM_EDU}</td>
						</tr>
						<tr>
							<td>{PHP.L.rez_study}:</td>
							<td>{REZADD_FORM_STUDY}</td>
						</tr>
						<tr>
							<td>{PHP.L.rez_qua}:</td>
							<td>{REZADD_FORM_QUA}</td>
						</tr>
						<tr>
							<td style="text-align: center;" colspan="2"><h4>{PHP.L.rez_contacts}</h4></td>
						</tr>
						<tr>
							<td>{PHP.L.rez_fio}:</td>
							<td>{REZADD_FORM_FIO}</td>
						</tr>
						<tr>
							<td>{PHP.L.rez_addr}:</td>
							<td>{REZADD_FORM_ADDR}</td>
						</tr>
						<tr>
							<td>{PHP.L.rez_phone}:</td>
							<td>{REZADD_FORM_PHONE}</td>
						</tr>
						<tr>
							<td>{PHP.L.rez_skype}:</td>
							<td>{REZADD_FORM_SKYPE}</td>
						</tr>
						<tr>
							<td>{PHP.L.rez_site}:</td>
							<td>{REZADD_FORM_SITE}</td>
						</tr>
						<tr>
							<td>{PHP.L.rez_email}:</td>
							<td>{REZADD_FORM_EMAIL}</td>
						</tr>
						<tr>
							<td>{PHP.L.Expire}:</td>
							<td>{REZADD_FORM_EXPIRE}</td>
						</tr>

						<tr>
                            <td></td>
							<td colspan="2" class="valid">
								<!-- IF {PHP.usr_can_publish} -->
								<button type="submit" class="btn btn-success" name="rreztate" value="0">{PHP.L.Publish}</button>
								<!-- ENDIF -->
								<button type="submit" class="btn btn-success" name="rreztate" value="2" class="submit">{PHP.L.Saveasdraft}</button>
								<button type="submit" class="btn btn-success" name="rreztate" value="1">{PHP.L.Submitforapproval}</button>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<div class="alert alert-info">{PHP.L.rez_formhint}</div>
</div>
<!-- END: MAIN -->