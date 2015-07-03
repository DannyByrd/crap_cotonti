<!-- BEGIN: MAIN -->
<div class="page-container">
		<div class="block" style="text-align: center;">
			<h2 class="rezume" style="color: #000;">{REZEDIT_FIRMTITLE} #{REZEDIT_FORM_ID}</h2>
			{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
			<div class="customform">
				<form action="{REZEDIT_FORM_SEND}" enctype="multipart/form-data" method="post" name="rezumeform">
					<table class="cells redactor-style">
						<tr>
							<td class="width30">{PHP.L.Category}:</td>
							<td class="width70">{REZEDIT_FORM_CAT}</td>
						</tr>
						<tr>
							<td>{PHP.L.rez_title}:</td>
							<td>{REZEDIT_FORM_TITLE}</td>
						</tr>
                        
                        <tr>
                            <td>{PHP.L.Alias}:</td>
                            <td>{REZEDIT_FORM_ALIAS}</td>
                        </tr>
                        <!-- BEGIN: ADMIN -->
                        <!-- END: ADMIN -->
                        <tr>
                            <td>{PHP.L.rez_metatitle}:</td>
                            <td>{REZEDIT_FORM_METATITLE}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.rez_metadesc}:</td>
                            <td>{REZEDIT_FORM_METADESC}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.rez_metakeywords}:</td>
                            <td>{REZEDIT_FORM_KEYWORDS}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.Date}:</td>
                            <td>{REZEDIT_FORM_DATE}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.Owner}:</td>
                            <td>{REZEDIT_FORM_OWNERID}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.Hits}:</td>
                            <td>{REZEDIT_FORM_rezCOUNT}</td>
                        </tr>
                        <tr>
                            <td>{PHP.L.Status}:</td>
                            <td>{REZEDIT_FORM_LOCALSTATUS}</td>
                        </tr>
						<tr>
							<td>{PHP.L.rez_salary}:</td>
							<td>
                                <span style="margin-left: 0px;" class="zarplata">{REZEDIT_FORM_SALARY}</span>
                                <span style="margin-left: 5px;" class="scolko">{PHP.cfg.payments.valuta}</span>
                            </td>
						</tr>
						<tr>
							<td>{PHP.L.rez_age}:</td>
							<td>
                                <span style="margin-left: 0px;" class="zarplata">{REZEDIT_FORM_AGE}</span>
                                <span style="margin-left: 5px;" class="scolko">{PHP.L.rez_years}</span>
                            </td>
						</tr>
						<tr>
							<td>{PHP.L.rez_sex}:</td>
							<td>{REZEDIT_FORM_SEX}</td>
						</tr>
						<tr>
							<td style="text-align: center;" colspan="2"><h4>{PHP.L.rez_opyt}</h4></td>
						</tr>
						<tr>
							<td>{PHP.L.rez_exp}:</td>
							<td>
                                <span style="margin-left: 0px;" class="zarplata">{REZEDIT_FORM_EXP}</span>
                            </td>
						</tr>
						<tr>
							<td>{PHP.L.rez_works}:</td>
							<td>{REZEDIT_FORM_WORKS}</td>
						</tr>
						<tr>
							<td style="text-align: center;" colspan="2"><h4>{PHP.L.rez_edu}</h4></td>
						</tr>
						<tr>
							<td>{PHP.L.rez_edu}:</td>
							<td>{REZEDIT_FORM_EDU}</td>
						</tr>
						<tr>
							<td>{PHP.L.rez_study}:</td>
							<td>{REZEDIT_FORM_STUDY}</td>
						</tr>
						<tr>
							<td>{PHP.L.rez_qua}:</td>
							<td>{REZEDIT_FORM_QUA}</td>
						</tr>
						<tr>
							<td style="text-align: center;" colspan="2"><h4>{PHP.L.rez_contacts}</h4></td>
						</tr>
						<tr>
							<td>{PHP.L.rez_fio}:</td>
							<td>{REZEDIT_FORM_FIO}</td>
						</tr>
						<tr>
							<td>{PHP.L.rez_addr}:</td>
							<td>{REZEDIT_FORM_ADDR}</td>
						</tr>
						<tr>
							<td>{PHP.L.rez_phone}:</td>
							<td>{REZEDIT_FORM_PHONE}</td>
						</tr>
						<tr>
							<td>{PHP.L.rez_skype}:</td>
							<td>{REZEDIT_FORM_SKYPE}</td>
						</tr>
						<tr>
							<td>{PHP.L.rez_site}:</td>
							<td>{REZEDIT_FORM_SITE}</td>
						</tr>
						<tr>
							<td>{PHP.L.rez_email}:</td>
							<td>{REZEDIT_FORM_EMAIL}</td>
						</tr>
						<tr>
							<td>{PHP.L.Expire}:</td>
							<td>{REZEDIT_FORM_EXPIRE}</td>
						</tr>

						<tr>
							<td>{PHP.L.rez_deleterezume}:</td>
							<td>{REZEDIT_FORM_DELETE}</td>
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
</div>
<!-- END: MAIN -->