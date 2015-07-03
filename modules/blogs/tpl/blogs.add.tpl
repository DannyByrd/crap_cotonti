<!-- BEGIN: MAIN -->

		<div class="block">
			<h2 class="board">{POSTADD_FIRMTITLE}</h2>
			{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
			<div class="customform">
				<form action="{POSTADD_FORM_SEND}" enctype="multipart/form-data" method="post" name="boardform">
					<table class="cells">
						<tr>
							<td class="width30">{PHP.L.Category}:</td>
							<td class="width70">{POSTADD_FORM_CAT}</td>
						</tr>
						<tr>
							<td>{PHP.L.post_title}:</td>
							<td>{POSTADD_FORM_TITLE}</td>
						</tr>
						<tr>
							<td>{PHP.L.post_desc}:</td>
							<td>{POSTADD_FORM_DESC}</td>
						</tr>
						<tr>
							<td>{PHP.L.Alias}:</td>
							<td>{POSTADD_FORM_ALIAS}</td>
						</tr>
						<tr>
							<td>{PHP.L.post_metakeywords}:</td>
							<td>{POSTADD_FORM_KEYWORDS}</td>
						</tr>
						<tr>
							<td>{PHP.L.post_metatitle}:</td>
							<td>{POSTADD_FORM_METATITLE}</td>
						</tr>
						<tr>
							<td>{PHP.L.post_metadesc}:</td>
							<td>{POSTADD_FORM_METADESC}</td>
						</tr>
	<!-- BEGIN: TAGS -->
						<tr>
							<td>{POSTADD_TOP_TAGS}:</td>
							<td>{POSTADD_FORM_TAGS} ({POSTADD_TOP_TAGS_HINT})</td>
						</tr>
	<!-- END: TAGS -->
						<tr>
							<td>{PHP.L.Owner}:</td>
							<td>{POSTADD_FORM_OWNER}</td>
						</tr>
						<tr>
							<td>{PHP.L.Parser}:</td>
							<td>{POSTADD_FORM_PARSER}</td>
						</tr>
						<tr>
							<td colspan="2">
								{POSTADD_FORM_TEXT}
								<!-- IF {POSTADD_FORM_PFS} -->{POSTADD_FORM_PFS}<!-- ENDIF -->
								<!-- IF {POSTADD_FORM_SFS} --><span class="spaced">{PHP.cfg.separator}</span>{POSTADD_FORM_SFS}<!-- ENDIF -->
							</td>
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
						<!-- IF {PHP.cot_plugins_active.mavatars} -->
						<tr>
							<td>{PHP.L.Image}:</td>
							<td>{POSTADD_FORM_MAVATAR}</td>
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
					</table>
				</form>
			</div>
		</div>
		<div class="help">{PHP.L.post_formhint}</div>

<!-- END: MAIN -->