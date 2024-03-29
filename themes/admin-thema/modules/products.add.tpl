<!-- BEGIN: MAIN -->
<div class="page-container">
		<div class="block" style="text-align: center;">
			<h2 class="products" style="color: #000000;">{PRDADD_FIRMTITLE}</h2>
			{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
			<div class="customform" style="  width: 75%; margin: 0px auto;">
				<form action="{PRDADD_FORM_SEND}" enctype="multipart/form-data" method="post" name="productsform">
					<table class="table redactor-style">
						<tr>
							<td class="width30">{PHP.L.Category}:</td>
							<td class="width70">{PRDADD_FORM_CAT}</td>
						</tr>
						<tr>
							<td>{PHP.L.prd_title}:</td>
							<td>{PRDADD_FORM_TITLE}</td>
						</tr>
                    <!-- BEGIN: ADMIN -->
                    <tr>
                        <td>{PHP.L.Alias}:</td>
                        <td>{PRDADD_FORM_ALIAS}</td>
                    </tr>
                    <!-- END: ADMIN -->
                    <tr>
                        <td>{PHP.L.prd_metatitle}:</td>
                        <td>{PRDADD_FORM_METATITLE}</td>
                    </tr>
                    <tr>
                        <td>{PHP.L.prd_metadesc}:</td>
                        <td>{PRDADD_FORM_METADESC}</td>
                    </tr>
                        <tr>
                            <td>{PHP.L.prd_metakeywords}:</td>
                            <td>{PRDADD_FORM_KEYWORDS}</td>
                        </tr>
                    <tr>
                        <td>{PHP.L.Owner}:</td>
                        <td>{PRDADD_FORM_OWNER}</td>
                    </tr>
                    <tr>
                        <td>{PHP.L.Parser}:</td>
                        <td>{PRDADD_FORM_PARSER}</td>
                    </tr>

	<!-- BEGIN: TAGS -->
						<tr>
							<td>{PRDADD_TOP_TAGS}:</td>
							<td>{PRDADD_FORM_TAGS} ({PRDADD_TOP_TAGS_HINT})</td>
						</tr>
	<!-- END: TAGS -->

	<!-- BEGIN: FILTERS -->
						<tr>
							<td>{PRDEDIT_FORM_FILTER_LABEL}:</td>
							<td>{PRDEDIT_FORM_FILTER_FLD}</td>
						</tr>
	<!-- END: FILTERS -->				
						<tr>
                            <td></td>
							<td colspan="2">
								{PRDADD_FORM_TEXT}
								<!-- IF {PRDADD_FORM_PFS} -->{PRDADD_FORM_PFS}<!-- ENDIF -->
								<!-- IF {PRDADD_FORM_SFS} --><span class="spaced">{PHP.cfg.separator}</span>{PRDADD_FORM_SFS}<!-- ENDIF -->
							</td>
						</tr>
						<tr>
							<td>{PHP.L.prd_cost}:</td>
							<td><div class="form-inline">{PRDADD_FORM_COST} {PHP.L.valuta}</div></td>
						</tr>

                        <!-- IF {PHP.cot_plugins_active.sample} -->
                        <tr>
                            <td>Тариф:</td>
                            <td>{PRDADD_FORM_SAMPLE}</td>
                        </tr>
                        <!-- ENDIF -->

						<!-- IF {PHP.cot_plugins_active.mavatars} -->
						<tr>
							<td>{PHP.L.Image}:</td>
							<td>{PRDADD_FORM_MAVATAR}</td>
						</tr>
						<!-- ENDIF -->
						<tr>
                            <td></td>
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
		<div class="alert alert-info">{PHP.L.prd_formhint}</div>
</div>
<!-- END: MAIN -->