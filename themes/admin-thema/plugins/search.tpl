<!-- BEGIN: MAIN -->
<div class="page-container">
		<div class="block" style="text-align: center;">
			<h2 class="stats">{PLUGIN_TITLE}</h2>
			<div class="customform" style="  max-width: 620px; margin: 0px auto;">
					<form id="search" name="search" action="{PLUGIN_SEARCH_ACTION}" method="get">
						<input type="hidden" name="e" value="search" />
						<ul class="nav nav-tabs">
							<li<!-- IF !{PHP.tab} --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('plug','e=search')}">{PHP.L.plu_tabs_all}</a></li>
							<li<!-- IF {PHP.tab} == 'frm' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('plug','e=search&amp;tab=frm')}">{PHP.L.Forums}</a></li>
							<li<!-- IF {PHP.tab} == 'pag' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('plug','e=search&amp;tab=pag')}">{PHP.L.Pages}</a></li>
							<li<!-- IF {PHP.tab} == 'products' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('plug','e=search&amp;tab=products')}">{PHP.L.Products}</a></li>
							<li<!-- IF {PHP.tab} == 'board' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('plug','e=search&amp;tab=board')}">{PHP.L.Board}</a></li>
							<li<!-- IF {PHP.tab} == 'afisha' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('plug','e=search&amp;tab=afisha')}">{PHP.L.Afisha}</a></li>
							<li<!-- IF {PHP.tab} == 'blogs' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('plug','e=search&amp;tab=blogs')}">{PHP.L.Blogs}</a></li>
							<li<!-- IF {PHP.tab} == 'firms' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('plug','e=search&amp;tab=firms')}">{PHP.L.Firms}</a></li>
							<li<!-- IF {PHP.tab} == 'rezume' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('plug','e=search&amp;tab=rezume')}">{PHP.L.Rezume}</a></li>
							<li<!-- IF {PHP.tab} == 'vacancies' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('plug','e=search&amp;tab=vacancies')}">{PHP.L.Vacancies}</a></li>
						</ul>

						<p class="margin10">
                            <div class="input-append">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <span>{PHP.L.plu_search_req}:</span>
                                    </div>
                                    <div class="col-lg-9">
                                        <span>{PLUGIN_SEARCH_TEXT}</span>
                                        <span><button type="submit" class="btn btn-success" >{PHP.L.plu_search_key}</button></span><br/><br/><br/>
                                    </div>
                                </div>
                            </div>
                        </p>
						<p class="margin10 input-append">
                            <div class="row">
                                <div class="col-lg-3">
                                    <span>{PHP.L.plu_other_date}:</span>
                                </div>
                                <div class="col-lg-9">
                                    <span>{PLUGIN_SEARCH_DATE_SELECT} {PLUGIN_SEARCH_DATE_FROM} - {PLUGIN_SEARCH_DATE_TO}</span>
                                </div>
                            </div>
                        </p>
						<p class="margin10 input-append">
                        <div class="row">
                            <div class="col-lg-3">
                                <span>{PHP.L.plu_other_userfilter}:</span>
                            </div>
                            <div class="col-lg-9">
                                <span>{PLUGIN_SEARCH_USER}</span>
                            </div>
                        </p>
<!-- BEGIN: PAGES_OPTIONS -->

                        <div class="row center-st">
						    <h3>{PHP.L.Pages}</h3>
                            <div class="col-lg-6">
                                <div>
                                    <p class="strong">{PHP.L.plu_pag_set_sec}:</p>
                                    <p>{PLUGIN_PAGE_SEC_LIST}</p>
                                    <p>{PLUGIN_PAGE_SEARCH_SUBCAT}</p>
                                    <p class="small">{PHP.L.plu_ctrl_list}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 center-left">
                                <p class="strong">{PHP.L.plu_other_opt}:</p>
                                <p><label>{PLUGIN_PAGE_SEARCH_NAMES}</label></p>
                                <p>{PLUGIN_PAGE_SEARCH_DESC}</p>
                                <p>{PLUGIN_PAGE_SEARCH_TEXT}</p>
                                <p>{PLUGIN_PAGE_SEARCH_FILE}</p>
                                <p class="strong">{PHP.L.plu_res_sort}:</p>
                                <p>{PLUGIN_PAGE_RES_SORT}</p>
                                <p>{PLUGIN_PAGE_RES_SORT_WAY}</p>
                            </div>
                        </div>
<!-- END: PAGES_OPTIONS -->
<!-- BEGIN: FORUMS_OPTIONS -->
						<h3>{PHP.L.Forums}</h3>
						<table class="main">
							<tr>
								<td class="width50">
									<p class="strong">{PHP.L.plu_frm_set_sec}:</p>
									<p>{PLUGIN_FORUM_SEC_LIST}</p>
									<p>{PLUGIN_FORUM_SEARCH_SUBCAT}</p>
									<div class="small">{PHP.L.plu_ctrl_list}</div>
								</td>
								<td class="width50">
									<p class="strong">{PHP.L.plu_other_opt}:</p>
									<p>{PLUGIN_FORUM_SEARCH_NAMES}</p>
									<p>{PLUGIN_FORUM_SEARCH_POST}</p>
									<p>{PLUGIN_FORUM_SEARCH_ANSW}</p>
									<p class="strong">{PHP.L.plu_res_sort}:</p>
									<p>{PLUGIN_FORUM_RES_SORT}</p>
									<p>{PLUGIN_FORUM_RES_SORT_WAY}</p>

								</td>
							</tr>
						</table>
<!-- END: FORUMS_OPTIONS -->
<!-- BEGIN: PRODUCTS_OPTIONS -->
						<h3>{PHP.L.Products}</h3>
						<table class="main">
							<tr>
								<td class="width50">
									<p class="strong">{PHP.L.plu_products_set_sec}:</p>
									<p>{PLUGIN_PRODUCTS_SEC_LIST}</p>
									<p>{PLUGIN_PRODUCTS_SEARCH_SUBCAT}</p>
									<p class="small">{PHP.L.plu_ctrl_list}</p>
								</td>
								<td class="width50">
									<p class="strong">{PHP.L.plu_other_opt}:</p>
									<p><label>{PLUGIN_PRODUCTS_SEARCH_NAMES}</label></p>
									<p>{PLUGIN_PRODUCTS_SEARCH_DESC}</p>
									<p>{PLUGIN_PRODUCTS_SEARCH_TEXT}</p>
									<p>{PLUGIN_PRODUCTS_SEARCH_FILE}</p>
									<p class="strong">{PHP.L.plu_res_sort}:</p>
									<p>{PLUGIN_PRODUCTS_RES_SORT}</p>
									<p>{PLUGIN_PRODUCTS_RES_SORT_WAY}</p>
								</td>
							</tr>
						</table>
<!-- END: PRODUCTS_OPTIONS -->

					</form>
				</div>

				{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}

<!-- BEGIN: RESULTS -->
<!-- BEGIN: PAGES -->
				<h3>{PHP.L.Pages}</h3>
				<table class="cells redactor-style">
					<tr>
						<td colspan="2" class="coltop">{PHP.L.plu_result}: {PHP.L.plu_tabs_pag}
						</td>
					</tr>
                    <!-- BEGIN: ITEM -->
					<tr>
						<td colspan="2" class="{PLUGIN_PR_ODDEVEN}">{PLUGIN_PR_TITLE}</td>
					</tr>
					<tr>
						<td colspan="2" class="{PLUGIN_PR_ODDEVEN}">{PLUGIN_PR_TEXT}</td>
					</tr>
					<tr>
						<td class="{PLUGIN_PR_ODDEVEN} width50"><p class="small">{PHP.L.plu_last_date}: {PLUGIN_PR_TIME}</p></td>
						<td class="{PLUGIN_PR_ODDEVEN} textright width50"><p class="small">{PHP.L.plu_section}: {PLUGIN_PR_CATEGORY}</p></td>
					</tr>
                    <!-- END: ITEM -->
				</table>
<!-- END: PAGES -->

<!-- BEGIN: FORUMS -->
				<h3>{PHP.L.Forums}</h3>
				<table class="cells">
					<tr>
						<td colspan="2" class="coltop">{PHP.L.plu_result}: {PHP.L.plu_tabs_frm}
						</td>
					</tr>
                    <!-- BEGIN: ITEM -->
					<tr>
						<td colspan="2" class="{PLUGIN_FR_ODDEVEN}">{PLUGIN_FR_TITLE}</td>
					</tr>
					<!-- IF {PLUGIN_FR_TEXT} --><tr>
						<td colspan="2" class="{PLUGIN_FR_ODDEVEN}">{PLUGIN_FR_TEXT}</td>
					</tr><!-- ENDIF -->
					<tr>
						<td class="{PLUGIN_FR_ODDEVEN} width50"><p class="small">{PHP.L.plu_last_date}: {PLUGIN_FR_TIME}</p></td>
						<td class="{PLUGIN_FR_ODDEVEN} textright width50"><p class="small">{PHP.L.plu_section}: {PLUGIN_FR_CATEGORY}</p></td>
					</tr>
                    <!-- END: ITEM -->
				</table>

<!-- END: FORUMS -->

<!-- BEGIN: PRODUCTS -->
				<h3>{PHP.L.Products}</h3>
				<table class="cells">
					<tr>
						<td colspan="2" class="coltop">{PHP.L.plu_result}: {PHP.L.Products}
						</td>
					</tr>
                    <!-- BEGIN: ITEM -->
					<tr>
						<td colspan="2" class="{PLUGIN_PRODUCTSRES_ODDEVEN}">{PLUGIN_PRODUCTSRES_TITLE}</td>
					</tr>
					<tr>
						<td colspan="2" class="{PLUGIN_PRODUCTSRES_ODDEVEN}">{PLUGIN_PRODUCTSRES_TEXT}</td>
					</tr>
					<tr>
						<td class="{PLUGIN_PRODUCTSRES_ODDEVEN} width50"><p class="small">{PHP.L.plu_last_date}: {PLUGIN_PRODUCTSRES_TIME}</p></td>
						<td class="{PLUGIN_PRODUCTSRES_ODDEVEN} textright width50"><p class="small">{PHP.L.plu_section}: {PLUGIN_PRODUCTSRES_CATEGORY}</p></td>
					</tr>
                    <!-- END: ITEM -->
				</table>
<!-- END: PRODUCTS -->
<!-- BEGIN: BOARD -->
				<h3>{PHP.L.Board}</h3>
				<table class="cells">
					<tr>
						<td colspan="2" class="coltop">{PHP.L.plu_result}: {PHP.L.Board}
						</td>
					</tr>
                    <!-- BEGIN: ITEM -->
					<tr>
						<td colspan="2" class="{PLUGIN_BOARDRES_ODDEVEN}">{PLUGIN_BOARDRES_TITLE}</td>
					</tr>
					<tr>
						<td colspan="2" class="{PLUGIN_BOARDRES_ODDEVEN}">{PLUGIN_BOARDRES_TEXT}</td>
					</tr>
					<tr>
						<td class="{PLUGIN_BOARDRES_ODDEVEN} width50"><p class="small">{PHP.L.plu_last_date}: {PLUGIN_BOARDRES_TIME}</p></td>
						<td class="{PLUGIN_BOARDRES_ODDEVEN} textright width50"><p class="small">{PHP.L.plu_section}: {PLUGIN_BOARDRES_CATEGORY}</p></td>
					</tr>
                    <!-- END: ITEM -->
				</table>
<!-- END: BOARD -->
<!-- BEGIN: AFISHA -->
				<h3>{PHP.L.Afisha}</h3>
				<table class="cells">
					<tr>
						<td colspan="2" class="coltop">{PHP.L.plu_result}: {PHP.L.Afisha}
						</td>
					</tr>
                    <!-- BEGIN: ITEM -->
					<tr>
						<td colspan="2" class="{PLUGIN_AFISHARES_ODDEVEN}">{PLUGIN_AFISHARES_TITLE}</td>
					</tr>
					<tr>
						<td colspan="2" class="{PLUGIN_AFISHARES_ODDEVEN}">{PLUGIN_AFISHARES_TEXT}</td>
					</tr>
					<tr>
						<td class="{PLUGIN_AFISHARES_ODDEVEN} width50"><p class="small">{PHP.L.plu_last_date}: {PLUGIN_AFISHARES_TIME}</p></td>
						<td class="{PLUGIN_AFISHARES_ODDEVEN} textright width50"><p class="small">{PHP.L.plu_section}: {PLUGIN_AFISHARES_CATEGORY}</p></td>
					</tr>
                    <!-- END: ITEM -->
				</table>
<!-- END: AFISHA -->
<!-- BEGIN: BLOGS -->
				<h3>{PHP.L.Blogs}</h3>
				<table class="cells">
					<tr>
						<td colspan="2" class="coltop">{PHP.L.plu_result}: {PHP.L.Blogs}
						</td>
					</tr>
                    <!-- BEGIN: ITEM -->
					<tr>
						<td colspan="2" class="{PLUGIN_BLOGSRES_ODDEVEN}">{PLUGIN_BLOGSRES_TITLE}</td>
					</tr>
					<tr>
						<td colspan="2" class="{PLUGIN_BLOGSRES_ODDEVEN}">{PLUGIN_BLOGSRES_TEXT}</td>
					</tr>
					<tr>
						<td class="{PLUGIN_BLOGSRES_ODDEVEN} width50"><p class="small">{PHP.L.plu_last_date}: {PLUGIN_BLOGSRES_TIME}</p></td>
						<td class="{PLUGIN_BLOGSRES_ODDEVEN} textright width50"><p class="small">{PHP.L.plu_section}: {PLUGIN_BLOGSRES_CATEGORY}</p></td>
					</tr>
                    <!-- END: ITEM -->
				</table>
<!-- END: BLOGS -->
<!-- BEGIN: FIRMS -->
				<h3>{PHP.L.Firms}</h3>
				<table class="cells">
					<tr>
						<td colspan="2" class="coltop">{PHP.L.plu_result}: {PHP.L.Firms}
						</td>
					</tr>
                    <!-- BEGIN: ITEM -->
					<tr>
						<td colspan="2" class="{PLUGIN_FIRMSRES_ODDEVEN}">{PLUGIN_FIRMSRES_TITLE}</td>
					</tr>
					<tr>
						<td colspan="2" class="{PLUGIN_FIRMSRES_ODDEVEN}">{PLUGIN_FIRMSRES_TEXT}</td>
					</tr>
					<tr>
						<td class="{PLUGIN_FIRMSRES_ODDEVEN} width50"><p class="small">{PHP.L.plu_last_date}: {PLUGIN_FIRMSRES_TIME}</p></td>
						<td class="{PLUGIN_FIRMSRES_ODDEVEN} textright width50"><p class="small">{PHP.L.plu_section}: {PLUGIN_FIRMSRES_CATEGORY}</p></td>
					</tr>
                    <!-- END: ITEM -->
				</table>
<!-- END: FIRMS -->
<!-- BEGIN: REZUME -->
				<h3>{PHP.L.Rezume}</h3>
				<table class="cells">
					<tr>
						<td colspan="2" class="coltop">{PHP.L.plu_result}: {PHP.L.Rezume}
						</td>
					</tr>
                    <!-- BEGIN: ITEM -->
					<tr>
						<td colspan="2" class="{PLUGIN_REZUMERES_ODDEVEN}">{PLUGIN_REZUMERES_TITLE}</td>
					</tr>
					<tr>
						<td colspan="2" class="{PLUGIN_REZUMERES_ODDEVEN}">{PLUGIN_REZUMERES_TEXT}</td>
					</tr>
					<tr>
						<td class="{PLUGIN_REZUMERES_ODDEVEN} width50"><p class="small">{PHP.L.plu_last_date}: {PLUGIN_REZUMERES_TIME}</p></td>
						<td class="{PLUGIN_REZUMERES_ODDEVEN} textright width50"><p class="small">{PHP.L.plu_section}: {PLUGIN_REZUMERES_CATEGORY}</p></td>
					</tr>
                    <!-- END: ITEM -->
				</table>
<!-- END: REZUME -->
<!-- BEGIN: VAC -->
				<h3>{PHP.L.Vacancies}</h3>
				<table class="cells">
					<tr>
						<td colspan="2" class="coltop">{PHP.L.plu_result}: {PHP.L.Vacancies}
						</td>
					</tr>
                    <!-- BEGIN: ITEM -->
					<tr>
						<td colspan="2" class="{PLUGIN_VACRES_ODDEVEN}">{PLUGIN_VACRES_TITLE}</td>
					</tr>
					<tr>
						<td colspan="2" class="{PLUGIN_VACRES_ODDEVEN}">{PLUGIN_VACRES_TEXT}</td>
					</tr>
					<tr>
						<td class="{PLUGIN_VACRES_ODDEVEN} width50"><p class="small">{PHP.L.plu_last_date}: {PLUGIN_VACRES_TIME}</p></td>
						<td class="{PLUGIN_VACRES_ODDEVEN} textright width50"><p class="small">{PHP.L.plu_section}: {PLUGIN_VACRES_CATEGORY}</p></td>
					</tr>
                    <!-- END: ITEM -->
				</table>
<!-- END: VAC -->

<!-- END: RESULTS -->
				<div class="pagination"><ul>{PLUGIN_PAGEPREV}{PLUGIN_PAGENAV}{PLUGIN_PAGENEXT}</ul></div>
		</div>

<!-- END: MAIN -->