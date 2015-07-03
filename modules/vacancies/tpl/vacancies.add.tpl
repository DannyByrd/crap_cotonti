<!-- BEGIN: MAIN -->

		<div class="block">
			<h2 class="vacancies">{VACADD_FIRMTITLE}</h2>
			{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
			<div class="customform">
				<form action="{VACADD_FORM_SEND}" enctype="multipart/form-data" method="post" name="vacanciesform">
					<table class="cells">
						<tr>
							<td class="width30">{PHP.L.Category}:</td>
							<td class="width70">{VACADD_FORM_CAT}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_title}:</td>
							<td>{VACADD_FORM_TITLE}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_salary}:</td>
							<td>{PHP.L.vac_ot} {VACADD_FORM_SALARYMIN} {PHP.L.vac_do} {VACADD_FORM_SALARYMAX} {PHP.cfg.payments.valuta}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_desc}:</td>
							<td>{VACADD_FORM_DESC}</td>
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
							<td>{PHP.L.vac_ot} {VACADD_FORM_EXPMIN} {PHP.L.vac_do} {VACADD_FORM_EXPMAX} {PHP.L.vac_years}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_edu}:</td>
							<td>{VACADD_FORM_EDU}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_age}:</td>
							<td>{PHP.L.vac_ot} {VACADD_FORM_AGEMIN} {PHP.L.vac_do} {VACADD_FORM_AGEMAX} {PHP.L.vac_years}</td>
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
	<!-- BEGIN: ADMIN -->	
						<tr>
							<td>{PHP.L.vac_metakeywords}:</td>
							<td>{VACADD_FORM_KEYWORDS}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_metatitle}:</td>
							<td>{VACADD_FORM_METATITLE}</td>
						</tr>
						<tr>
							<td>{PHP.L.vac_metadesc}:</td>
							<td>{VACADD_FORM_METADESC}</td>
						</tr>					
						<tr>
							<td>{PHP.L.Owner}:</td>
							<td>{VACADD_FORM_OWNER}</td>
						</tr>
							<!-- IF {PHP.cot_plugins_active.mavatars} -->
						<tr>
							<td>{PHP.L.Image}:</td>
							<td>{VACADD_FORM_MAVATAR}</td>
						</tr>
						<tr>
							<td>{PHP.L.placemarks_placeonmap}:</td>
							<td>{ADVADD_FORM_PLACEMARKS}</td>
						</tr>
						<!-- ENDIF -->
						<tr>
							<td colspan="2">
								<!-- IF {PHP.usr_can_publish} -->
								<button type="submit" class="btn btn-success" name="rprdtate" value="0">{PHP.L.Publish}</button>
								<button type="submit" class="btn btn-success" name="rprdtate" value="2" class="submit">{PHP.L.Saveasdraft}</button>
								<!-- ELSE -->
								<button type="submit" class="btn btn-success" name="rprdtate" value="1">{PHP.L.Publish}</button>
								<!-- ENDIF -->
							</td>
						</tr>
	<!-- END: ADMIN -->						
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
		<div class="help">{PHP.L.vac_formhint}</div>

<!-- END: MAIN -->