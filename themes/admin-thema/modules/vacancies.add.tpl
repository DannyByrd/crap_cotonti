<!-- BEGIN: MAIN -->
<div class="page-container">
		<div class="block" style="text-align: center;">
			<h2 class="vacancies" style="color: #000;">{VACADD_FIRMTITLE}</h2>
			{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
			<div class="customform">
				<form action="{VACADD_FORM_SEND}" enctype="multipart/form-data" method="post" name="vacanciesform">
					<table class="cells redactor-style">
						<tr>
							<td class="width30">{PHP.L.Category}:</td>
							<td class="width70">{VACADD_FORM_CAT}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_title}:</td>
							<td>{VACADD_FORM_TITLE}</td>
						</tr>
                        <!-- BEGIN: ADMIN -->
                        <tr>
                            <td>{PHP.L.Alias}:</td>
                            <td>{VACADD_FORM_ALIAS}</td>
                        </tr>
                        <!-- END: ADMIN -->
                        <tr>
                            <td>{PHP.L.vac_metatitle}:</td>
                            <td>{VACADD_FORM_METATITLE}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.vac_metadesc}:</td>
                            <td>{VACADD_FORM_METADESC}</td>
                        </tr>

                        <tr>
                            <td>{PHP.L.vac_metakeywords}:</td>
                            <td>{VACADD_FORM_KEYWORDS}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.Owner}:</td>
                            <td>{VACADD_FORM_OWNER}</td>
                        </tr>
                        <tr>
							<td>{PHP.L.vac_salary}:</td>
							<td>
                                <span class="scolko">{PHP.L.vac_ot}</span>
                                <span class="zarplata">{VACADD_FORM_SALARYMIN}</span>
                                <span class="scolko">{PHP.L.vac_do}</span>
                                <span class="zarplata">{VACADD_FORM_SALARYMAX}</span>
                                <span class="scolko">{PHP.cfg.payments.valuta}</span>
                            </td>
						</tr>

						<tr>
							<td>{PHP.L.vac_duty}:</td>
							<td>{VACADD_FORM_DUTY}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_term}:</td>
							<td>{VACADD_FORM_TERM}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_qua}:</td>
							<td>{VACADD_FORM_QUA}</td>
						</tr>
					
						<tr>
							<td>{PHP.L.vac_exp}:</td>
							<td>
                                <span class="scolko">{PHP.L.vac_ot}</span>
                                <span class="zarplata">{VACADD_FORM_EXPMIN}</span>
                                <span class="scolko">{PHP.L.vac_do}</span>
                                <span class="zarplata">{VACADD_FORM_EXPMAX}</span>
                                <span class="scolko">{PHP.L.vac_years}</span>
                            </td>
						</tr>
						<tr>
							<td>{PHP.L.vac_edu}:</td>
							<td>{VACADD_FORM_EDU}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_age}:</td>
							<td>
                                <span class="scolko">{PHP.L.vac_ot}</span>
                                <span class="zarplata">{VACADD_FORM_AGEMIN}</span>
                                <span class="scolko">{PHP.L.vac_do}</span>
                                <span class="zarplata">{VACADD_FORM_AGEMAX}</span>
                                <span class="scolko">{PHP.L.vac_years}</span>
                            </td>
						</tr>
						<tr>
							<td>{PHP.L.vac_sex}:</td>
							<td>{VACADD_FORM_SEX}</td>
						</tr>
						<tr>
							<td>{PHP.L.Expire}:</td>
							<td>{VACADD_FORM_EXPIRE}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_addr}:</td>
							<td>{VACADD_FORM_ADDR}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_phone}:</td>
							<td>{VACADD_FORM_PHONE}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_skype}:</td>
							<td>{VACADD_FORM_SKYPE}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_site}:</td>
							<td>{VACADD_FORM_SITE}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_email}:</td>
							<td>{VACADD_FORM_EMAIL}</td>
						</tr>

						<tr>
                            <td></td>
							<td colspan="2" class="valid">
								<!-- IF {PHP.usr_can_publish} -->
								<button type="submit" class="btn btn-success" name="rvactate" value="0">{PHP.L.Publish}</button>
								<!-- ENDIF -->
								<button type="submit" class="btn btn-success" name="rvactate" value="2" class="submit">{PHP.L.Saveasdraft}</button>
								<button type="submit" class="btn btn-success" name="rvactate" value="1">{PHP.L.Submitforapproval}</button>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<div class="alert alert-info">{PHP.L.vac_formhint}</div>
</div>
<!-- END: MAIN -->