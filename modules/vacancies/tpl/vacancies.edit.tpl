<!-- BEGIN: MAIN -->

		<div class="block">
			<h2 class="vacancies">{VACEDIT_FIRMTITLE} #{VACEDIT_FORM_ID}</h2>
			{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
			<div class="customform">
				<form action="{VACEDIT_FORM_SEND}" enctype="multipart/form-data" method="post" name="vacanciesform">
					<table class="cells">
						<tr>
							<td class="width30">{PHP.L.Category}:</td>
							<td class="width70">{VACEDIT_FORM_CAT}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_title}:</td>
							<td>{VACEDIT_FORM_TITLE}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_salary}:</td>
							<td>{PHP.L.vac_ot} {VACEDIT_FORM_SALARYMIN} {PHP.L.vac_do} {VACEDIT_FORM_SALARYMAX} {PHP.cfg.payments.valuta}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_desc}:</td>
							<td>{VACEDIT_FORM_DESC}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_duty}:</td>
							<td>{VACEDIT_FORM_DUTY}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_term}:</td>
							<td>{VACEDIT_FORM_TERM}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_qua}:</td>
							<td>{VACEDIT_FORM_QUA}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_exp}:</td>
							<td>{PHP.L.vac_ot} {VACEDIT_FORM_EXPMIN} {PHP.L.vac_do} {VACEDIT_FORM_EXPMAX} {PHP.L.vac_years}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_edu}:</td>
							<td>{VACEDIT_FORM_EDU}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_age}:</td>
							<td>{PHP.L.vac_ot} {VACEDIT_FORM_AGEMIN} {PHP.L.vac_do} {VACEDIT_FORM_AGEMAX} {PHP.L.vac_years}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_sex}:</td>
							<td>{VACEDIT_FORM_SEX}</td>
						</tr>
						<tr>
							<td>{PHP.L.Expire}:</td>
							<td>{VACEDIT_FORM_EXPIRE}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_addr}:</td>
							<td>{VACEDIT_FORM_ADDR}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_phone}:</td>
							<td>{VACEDIT_FORM_PHONE}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_skype}:</td>
							<td>{VACEDIT_FORM_SKYPE}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_site}:</td>
							<td>{VACEDIT_FORM_SITE}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_email}:</td>
							<td>{VACEDIT_FORM_EMAIL}</td>
						</tr>
	<!-- BEGIN: ADMIN -->
						<tr>
							<td>{PHP.L.Date}:</td>
							<td>{VACEDIT_FORM_DATE}</td>
						</tr>
						<tr>
							<td>{PHP.L.Owner}:</td>
							<td>{VACEDIT_FORM_OWNERID}</td>
						</tr>
						<tr>
							<td>{PHP.L.Hits}:</td>
							<td>{VACEDIT_FORM_VACCOUNT}</td>
						</tr>
						<tr>
							<td>{PHP.L.Status}:</td>
							<td>{VACEDIT_FORM_LOCALSTATUS}</td>
						</tr>
						<tr>
							<td>{PHP.L.Alias}:</td>
							<td>{VACEDIT_FORM_ALIAS}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_metakeywords}:</td>
							<td>{VACEDIT_FORM_KEYWORDS}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_metatitle}:</td>
							<td>{VACEDIT_FORM_METATITLE}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_metadesc}:</td>
							<td>{VACEDIT_FORM_METADESC}</td>
						</tr>
						<tr>
							<td>{PHP.L.Image}:</td>
							<td>{VACEDIT_FORM_MAVATAR}</td>
						</tr>
	<!-- END: ADMIN -->
						<tr>
							<td>{PHP.L.vac_deletevacancies}:</td>
							<td>{VACEDIT_FORM_DELETE}</td>
						</tr>
						<tr>
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

<!-- END: MAIN -->