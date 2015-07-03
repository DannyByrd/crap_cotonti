<!-- BEGIN: MAIN -->
<div class="page-container">
		<div class="block" style="text-align: center;">
			<h2 class="page" style="color: #000000;">{PAGEADD_PAGETITLE}</h2>
			{FILE "{PHP.cfg.themes_dir}/{PHP.usr.theme}/warnings.tpl"}
			<form action="{PAGEADD_FORM_SEND}" enctype="multipart/form-data" method="post" name="pageform">
				<table class="cells redactor-style">
					<tr>
						<td class="width30">{PHP.L.Category}:</td>
						<td class="width70">{PAGEADD_FORM_CAT}</td>
					</tr>
					<tr>
						<td>{PHP.L.Title}:</td>
						<td>{PAGEADD_FORM_TITLE}</td>
					</tr>
                    <!-- BEGIN: ADMIN -->
                    <tr>
                        <td>{PHP.L.Alias}:</td>
                        <td>{PAGEADD_FORM_ALIAS}</td>
                    </tr>
                    <!-- END: ADMIN -->
                    <tr>
                        <td>{PHP.L.page_metatitle}:</td>
                        <td>{PAGEADD_FORM_METATITLE}</td>
                    </tr>
                    <tr>
                        <td>{PHP.L.page_metadesc}:</td>
                        <td>{PAGEADD_FORM_METADESC}</td>
                    </tr>
                    <tr>
                        <td>{PHP.L.page_metakeywords}:</td>
                        <td>{PAGEADD_FORM_KEYWORDS}</td>
                    </tr>
					<tr>
						<td>{PHP.L.Author}:</td>
						<td>{PAGEADD_FORM_AUTHOR}</td>
					</tr>

<!-- BEGIN: TAGS -->
					<tr>
						<td>{PAGEADD_TOP_TAGS}:</td>
						<td>{PAGEADD_FORM_TAGS} ({PAGEADD_TOP_TAGS_HINT})</td>
					</tr>
<!-- END: TAGS -->
<!-- BEGIN: FILTERS -->
					<tr>
						<td>{PAGEEDIT_FORM_FILTER_LABEL}:</td>
						<td>{PAGEEDIT_FORM_FILTER_FLD}</td>
					</tr>
<!-- END: FILTERS -->
					<tr>
						<td>{PHP.L.Owner}:</td>
						<td>{PAGEADD_FORM_OWNER}</td>
					</tr>
					<tr>
						<td>{PHP.L.Begin}:</td>
						<td>{PAGEADD_FORM_BEGIN}</td>
					</tr>
					<tr>
						<td>{PHP.L.Expire}:</td>
						<td>{PAGEADD_FORM_EXPIRE}</td>
					</tr>
					<tr>
						<td>{PHP.L.Parser}:</td>
						<td>{PAGEADD_FORM_PARSER}</td>
					</tr>
					<tr>
                        <td></td>
						<td>
							{PAGEADD_FORM_TEXT}
							<!-- IF {PAGEADD_FORM_PFS} -->{PAGEADD_FORM_PFS}<!-- ENDIF -->
							<!-- IF {PAGEADD_FORM_SFS} --><span class="spaced">{PHP.cfg.separator}</span>{PAGEADD_FORM_SFS}<!-- ENDIF -->
						</td>
					</tr>
					<tr>
						<td>{PHP.L.page_file}:</td>
						<td>
							{PAGEADD_FORM_FILE}
							<p>{PHP.L.page_filehint}</p>
						</td>
					</tr>
					<tr>
						<td>{PHP.L.URL}:<br />{PHP.L.page_urlhint}</td>
						<td>{PAGEADD_FORM_URL}<br />{PAGEADD_FORM_URL_PFS} &nbsp; {PAGEADD_FORM_URL_SFS}</td>
					</tr>
					<tr>
						<td>Картинки:</td>
						<td>
							{PAGEADD_FORM_MAVATAR}
						</td>
					</tr>
					<tr>
                        <td></td>
						<td class="button-style">
							<!-- IF {PHP.usr_can_publish} -->
							<button class="btn btn-success" type="submit" name="rpagestate" value="0">{PHP.L.Publish}</button>
							<!-- ENDIF -->
							<button class="btn btn-success" type="submit" name="rpagestate" value="2" class="submit">{PHP.L.Saveasdraft}</button>
							<button class="btn btn-success" type="submit" name="rpagestate" value="1">{PHP.L.Submitforapproval}</button>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<div class="alert alert-info">{PHP.L.page_formhint}</div>
</div>
<!-- END: MAIN -->