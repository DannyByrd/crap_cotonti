<!-- BEGIN: MAIN -->
<div class="page-container">
    <div class="block" style="text-align: center;">
			<h2 class="page" style="color: #000;">{PAGEEDIT_PAGETITLE} #{PAGEEDIT_FORM_ID}</h2>
			{FILE "{PHP.cfg.themes_dir}/{PHP.usr.theme}/warnings.tpl"}
			<form action="{PAGEEDIT_FORM_SEND}" enctype="multipart/form-data" method="post" name="pageform">
				<table class="cells redactor-style">
					<tr>
						<td class="width30">{PHP.L.Category}:</td>
						<td class="width70">{PAGEEDIT_FORM_CAT}</td>
					</tr>
					<tr>
						<td>{PHP.L.Title}:</td>
						<td>{PAGEEDIT_FORM_TITLE}</td>
					</tr>
                    
                    <tr>
                        <td>{PHP.L.Alias}:</td>
                        <td>{PAGEEDIT_FORM_ALIAS}</td>
                    </tr>
                    <!-- BEGIN: ADMIN -->
                    <!-- END: ADMIN -->
                    <tr>
                        <td>{PHP.L.page_metatitle}:</td>
                        <td>{PAGEEDIT_FORM_METATITLE}</td>
                    </tr>
                    <tr>
                        <td>{PHP.L.page_metadesc}:</td>
                        <td>{PAGEEDIT_FORM_METADESC}</td>
                    </tr>
                    <tr>
                        <td>{PHP.L.page_metakeywords}:</td>
                        <td>{PAGEEDIT_FORM_KEYWORDS}</td>
                    </tr>
					<tr>
						<td>{PHP.L.Author}:</td>
						<td>{PAGEEDIT_FORM_AUTHOR}</td>
					</tr>
					<tr>
						<td>{PHP.L.Date}:</td>
						<td>
							{PAGEEDIT_FORM_DATE}
							<p class="small">{PAGEEDIT_FORM_DATENOW} {PHP.L.page_date_now}</p>
						</td>
					</tr>
					<tr>
						<td>{PHP.L.Begin}:</td>
						<td>{PAGEEDIT_FORM_BEGIN}</td>
					</tr>
					<tr>
						<td>{PHP.L.Expire}:</td>
						<td>{PAGEEDIT_FORM_EXPIRE}</td>
					</tr>
					<tr>
						<td>{PHP.L.Status}:</td>
						<td>{PAGEEDIT_FORM_LOCALSTATUS}</td>
					</tr>



<!-- BEGIN: TAGS -->
					<tr>
						<td>{PAGEEDIT_TOP_TAGS}:</td>
						<td>{PAGEEDIT_FORM_TAGS} ({PAGEEDIT_TOP_TAGS_HINT})</td>
					</tr>
<!-- END: TAGS -->
<!-- BEGIN: ADMIN -->
					<tr>
						<td>{PHP.L.Owner}:</td>
						<td>{PAGEEDIT_FORM_OWNERID}</td>
					</tr>
					<tr>
						<td>{PHP.L.Hits}:</td>
						<td>{PAGEEDIT_FORM_PAGECOUNT}</td>
					</tr>
<!-- END: ADMIN -->
<!-- BEGIN: FILTERS -->
					<tr>
						<td>{PAGEEDIT_FORM_FILTER_LABEL}:</td>
						<td>{PAGEEDIT_FORM_FILTER_FLD}</td>
					</tr>
<!-- END: FILTERS -->
					<tr>
						<td>{PHP.L.Parser}:</td>
						<td>{PAGEEDIT_FORM_PARSER}</td>
					</tr>
					<tr>
                        <td></td>
						<td>
							{PAGEEDIT_FORM_TEXT}
							<!-- IF {PAGEEDIT_FORM_PFS} -->{PAGEEDIT_FORM_PFS}<!-- ENDIF -->
							<!-- IF {PAGEEDIT_FORM_SFS} --><span class="spaced">{PHP.cfg.separator}</span>{PAGEEDIT_FORM_SFS}<!-- ENDIF -->
						</td>
					</tr>
					<tr>
						<td>{PHP.L.page_file}:<br />
							{PHP.themelang.pageadd.Filehint}</td>
						<td>{PAGEEDIT_FORM_FILE}</td>
					</tr>
					<tr>
						<td>{PHP.L.URL}:<br />{PHP.L.page_urlhint}</td>
						<td>{PAGEEDIT_FORM_URL}<br />{PAGEEDIT_FORM_URL_PFS} &nbsp; {PAGEEDIT_FORM_URL_SFS}</td>
					</tr>
					<tr>
						<td>{PHP.L.page_filesize}:<br />{PHP.L.page_filesizehint}</td>
						<td>{PAGEEDIT_FORM_SIZE}</td>
					</tr>
					<tr>
						<td>{PHP.L.page_filehitcount}:<br />{PHP.L.page_filehitcounthint}</td>
						<td>{PAGEEDIT_FORM_FILECOUNT}</td>
					</tr>
					<tr>
						<td>Картинки:</td>
						<td>{PAGEEDIT_FORM_MAVATAR}</td>
					</tr>
					<tr>
						<td>{PHP.L.page_deletepage}:</td>
						<td>{PAGEEDIT_FORM_DELETE}</td>
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
</div>

<!-- END: MAIN -->