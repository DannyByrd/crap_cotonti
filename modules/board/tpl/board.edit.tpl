<!-- BEGIN: MAIN -->

		<div class="block">
			<h2 class="board">{ADVEDIT_FIRMTITLE} #{ADVEDIT_FORM_ID}</h2>
			{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
			<div class="customform">
				<form action="{ADVEDIT_FORM_SEND}" enctype="multipart/form-data" method="post" name="boardform">
					<table class="cells">
						<tr>
							<td class="width30">{PHP.L.Category}:</td>
							<td class="width70">{ADVEDIT_FORM_CAT}</td>
						</tr>
						<tr>
							<td>{PHP.L.adv_title}:</td>
							<td>{ADVEDIT_FORM_TITLE}</td>
						</tr>
						<tr>
							<td>{PHP.L.Date}:</td>
							<td>{ADVEDIT_FORM_DATE}</td>
						</tr>
						<tr>
							<td>{PHP.L.Status}:</td>
							<td>{ADVEDIT_FORM_LOCALSTATUS}</td>
						</tr>
	<!-- BEGIN: TAGS -->
						<tr>
							<td>{ADVEDIT_TOP_TAGS}:</td>
							<td>{ADVEDIT_FORM_TAGS} ({ADVEDIT_TOP_TAGS_HINT})</td>
						</tr>
	<!-- END: TAGS -->
	<!-- BEGIN: ADMIN -->
						<tr>
							<td>{PHP.L.Alias}:</td>
							<td>{ADVEDIT_FORM_ALIAS}</td>
						</tr>
						<tr>
							<td>{PHP.L.adv_desc}:</td>
							<td>{ADVEDIT_FORM_DESC}</td>
						</tr>
						<tr>
							<td>{PHP.L.adv_metakeywords}:</td>
							<td>{ADVEDIT_FORM_KEYWORDS}</td>
						</tr>
						<tr>
							<td>{PHP.L.adv_metatitle}:</td>
							<td>{ADVEDIT_FORM_METATITLE}</td>
						</tr>
						<tr>
							<td>{PHP.L.adv_metadesc}:</td>
							<td>{ADVEDIT_FORM_METADESC}</td>
						</tr>
						<tr>
							<td>{PHP.L.Owner}:</td>
							<td>{ADVEDIT_FORM_OWNERID}</td>
						</tr>
						<tr>
							<td>{PHP.L.Hits}:</td>
							<td>{ADVEDIT_FORM_ADVCOUNT}</td>
						</tr>
	<!-- END: ADMIN -->
						<tr>
							<td>{PHP.L.Parser}:</td>
							<td>{ADVEDIT_FORM_PARSER}</td>
						</tr>
						<tr>
							<td colspan="2">
								{ADVEDIT_FORM_TEXT}
								<!-- IF {ADVEDIT_FORM_PFS} -->{ADVEDIT_FORM_PFS}<!-- ENDIF -->
								<!-- IF {ADVEDIT_FORM_SFS} --><span class="spaced">{PHP.cfg.separator}</span>{ADVEDIT_FORM_SFS}<!-- ENDIF -->
							</td>
						</tr>				
						<tr>
							<td>{PHP.L.Images}:</td>
							<td>{ADVEDIT_FORM_MAVATAR}</td>
						</tr>
						<tr>
							<td>{PHP.L.adv_cost}:</td>
							<td>{ADVEDIT_FORM_COST} {PHP.cfg.payments.valuta}</td>
						</tr>
						<tr>
							<td>{PHP.L.Expire}:</td>
							<td>{ADVEDIT_FORM_EXPIRE}</td>
						</tr>
						<tr>
							<td>{PHP.L.placemarks_placeonmap}:</td>
							<td>{ADVEDIT_FORM_PLACEMARKS}</td>
						</tr>
						<tr>
							<td>{PHP.L.adv_addr}:</td>
							<td>{ADVEDIT_FORM_ADDR}</td>
						</tr>
						<tr>
							<td>{PHP.L.adv_phone}:</td>
							<td>{ADVEDIT_FORM_PHONE}</td>
						</tr>
						<tr>
							<td>{PHP.L.adv_skype}:</td>
							<td>{ADVEDIT_FORM_SKYPE}</td>
						</tr>
						<tr>
							<td>{PHP.L.adv_site}:</td>
							<td>{ADVEDIT_FORM_SITE}</td>
						</tr>
						<tr>
							<td>{PHP.L.adv_email}:</td>
							<td>{ADVEDIT_FORM_EMAIL} {ADVEDIT_FORM_HIDEMAIL}</td>
						</tr>
						<tr>
							<td>{PHP.L.adv_deleteboard}:</td>
							<td>{ADVEDIT_FORM_DELETE}</td>
						</tr>
						<tr>
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

<!-- END: MAIN -->