<!-- BEGIN: MAIN -->
<div class="page-container">
		<div class="block" style="text-align: center;">
			<h2 class="board">{POSTADD_FIRMTITLE}</h2>
			{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
			<div class="customform">
				<form action="{POSTADD_FORM_SEND}" enctype="multipart/form-data" method="post" name="boardform">
					<table class="cells redactor-style">
						<tr>
							<td class="width30">{PHP.L.Category}:</td>
							<td class="width70">{POSTADD_FORM_CAT}</td>
						</tr>
						<tr>
							<td>{PHP.L.post_title}:</td>
							<td>{POSTADD_FORM_TITLE}</td>
						</tr>
                        <!-- BEGIN: ADMIN -->
						<tr>
							<td>{PHP.L.Alias}:</td>
							<td>{POSTADD_FORM_ALIAS}</td>
						</tr>
                        <!-- END: ADMIN -->
						<tr>
							<td>{PHP.L.post_metatitle}:</td>
							<td>{POSTADD_FORM_METATITLE}</td>
						</tr>
						<tr>
							<td>{PHP.L.post_metadesc}:</td>
							<td>{POSTADD_FORM_METADESC}</td>
						</tr>
                        <tr>
                            <td>{PHP.L.post_metakeywords}:</td>
                            <td>{POSTADD_FORM_KEYWORDS}</td>
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
                            <td></td>
							<td colspan="2">
								{POSTADD_FORM_TEXT}
								<!-- IF {POSTADD_FORM_PFS} -->{POSTADD_FORM_PFS}<!-- ENDIF -->
								<!-- IF {POSTADD_FORM_SFS} --><span class="spaced">{PHP.cfg.separator}</span>{POSTADD_FORM_SFS}<!-- ENDIF -->
							</td>
						</tr>
						<tr>
                            <td></td>
							<td colspan="2" class="valid" style="margin-bottom: 15px;">
								<!-- IF {PHP.usr_can_publish} -->
								<button class="btn btn-success" type="submit" name="rposttate" value="0">{PHP.L.Publish}</button>
								<!-- ENDIF -->
								<button class="btn btn-success" type="submit" name="rposttate" value="2" class="submit">{PHP.L.Saveasdraft}</button>
								<button class="btn btn-success" type="submit" name="rposttate" value="1">{PHP.L.Submitforapproval}</button>
							</td>
						</tr>
					</table>
                    <div class="alert alert-info">{PHP.L.post_formhint}</div>
				</form>
			</div>
		</div>


<!-- END: MAIN -->