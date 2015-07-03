<!-- BEGIN: MAIN -->

		<div class="block">
			<h2 class="blogs">{POSTEDIT_FIRMTITLE} #{POSTEDIT_FORM_ID}</h2>
			{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
			<div class="customform">
				<form action="{POSTEDIT_FORM_SEND}" enctype="multipart/form-data" method="post" name="blogsform">
					<table class="cells">
						<tr>
							<td class="width30">{PHP.L.Category}:</td>
							<td class="width70">{POSTEDIT_FORM_CAT}</td>
						</tr>
						<tr>
							<td>{PHP.L.post_title}:</td>
							<td>{POSTEDIT_FORM_TITLE}</td>
						</tr>
						<tr>
							<td>{PHP.L.post_desc}:</td>
							<td>{POSTEDIT_FORM_DESC}</td>
						</tr>
						<tr>
							<td>{PHP.L.Date}:</td>
							<td>{POSTEDIT_FORM_DATE}</td>
						</tr>
						<tr>
							<td>{PHP.L.Status}:</td>
							<td>{POSTEDIT_FORM_LOCALSTATUS}</td>
						</tr>
						<tr>
							<td>{PHP.L.Alias}:</td>
							<td>{POSTEDIT_FORM_ALIAS}</td>
						</tr>
						<tr>
							<td>{PHP.L.post_metakeywords}:</td>
							<td>{POSTEDIT_FORM_KEYWORDS}</td>
						</tr>
						<tr>
							<td>{PHP.L.post_metatitle}:</td>
							<td>{POSTEDIT_FORM_METATITLE}</td>
						</tr>
						<tr>
							<td>{PHP.L.post_metadesc}:</td>
							<td>{POSTEDIT_FORM_METADESC}</td>
						</tr>
	<!-- BEGIN: TAGS -->
						<tr>
							<td>{POSTEDIT_TOP_TAGS}:</td>
							<td>{POSTEDIT_FORM_TAGS} ({POSTEDIT_TOP_TAGS_HINT})</td>
						</tr>
	<!-- END: TAGS -->
	<!-- BEGIN: ADMIN -->
						<tr>
							<td>{PHP.L.Owner}:</td>
							<td>{POSTEDIT_FORM_OWNERID}</td>
						</tr>
						<tr>
							<td>{PHP.L.Hits}:</td>
							<td>{POSTEDIT_FORM_POSTCOUNT}</td>
						</tr>
						<tr>
							<td>{PHP.L.Image}:</td>
							<td>{POSTEDIT_FORM_MAVATAR}</td>
						</tr>

	<!-- END: ADMIN -->
						<tr>
							<td>{PHP.L.Parser}:</td>
							<td>{POSTEDIT_FORM_PARSER}</td>
						</tr>
						<tr>
							<td colspan="2">
								{POSTEDIT_FORM_TEXT}
								<!-- IF {POSTEDIT_FORM_PFS} -->{POSTEDIT_FORM_PFS}<!-- ENDIF -->
								<!-- IF {POSTEDIT_FORM_SFS} --><span class="spaced">{PHP.cfg.separator}</span>{POSTEDIT_FORM_SFS}<!-- ENDIF -->
							</td>
						</tr>	
						<tr>
							<td>{PHP.L.post_deleteblogs}:</td>
							<td>{POSTEDIT_FORM_DELETE}</td>
						</tr>
						<tr>
							<td colspan="2" class="valid">
								<!-- IF {PHP.usr_can_publish} -->
								<button type="submit" name="rposttate" value="0">{PHP.L.Publish}</button>
								<!-- ENDIF -->
								<button type="submit" name="rposttate" value="2" class="submit">{PHP.L.Saveasdraft}</button>
								<button type="submit" name="rposttate" value="1">{PHP.L.Submitforapproval}</button>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>

<!-- END: MAIN -->