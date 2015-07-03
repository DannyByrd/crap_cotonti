<!-- BEGIN: MAIN -->
<div class="page-container">
   
    {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/sidebur.tpl"}
    
    <div class="page-content-wrapper">
		<div class="page-content">
            <div class="portlet light">
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-12 blog-page">
						
						    <ul class="list-inline blog-tags">
								<li style="float: left;">
									<i class="fa fa-tags"></i>
								</li>
								{LIST_CATPATH}
							</ul>
						
							<div class="row">
							<div class="col-md-9 col-sm-8 article-block">
								<h1 style="margin-top:0px">{PHP.L.vacancies}</h1>
									
				                <!-- BEGIN: LIST_ROW -->
									<div class="row">
										<div class="col-md-3 blog-img blog-tag-data">
                                            <a href="{LIST_ROW_OWNER_DETAILSLINK}">
                                                <img width="150px" height="150px" src="<!-- IF {LIST_ROW_OWNER_AVATAR_SRC} -->{LIST_ROW_OWNER_AVATAR_SRC}<!-- ELSE -->datas/defaultav/blank.png<!-- ENDIF -->" class="avatar" alt="" />
                                            </a>
           
											<ul class="list-inline" style="text-align: center;">
												<li>
													<i class="fa fa-calendar"></i>
												    {LIST_ROW_DATE_STAMP|cot_date('Y-m-d',$this)}
												</li>
											</ul>
										</div>
										
										<div class="col-md-8 blog-article">
											<h3 style="margin-top: 0px;">
											    <a href="{LIST_ROW_URL}">{LIST_ROW_SHORTTITLE} </a>
											</h3>
											<p>
                                               <strong>{PHP.L.vac_duty}:</strong> {LIST_ROW_DUTY}
											</p>

											<a class="btn blue" href="{LIST_ROW_URL}">
											    {PHP.L.products-list}
                                                <i class="m-icon-swapright m-icon-white"></i>
											</a>
											
											<!-- IF {LIST_ROW_COST} > 0 -->
                                                <div style="margim-top:20px;" class="pull-right"><span style="display: block;margin-top: 10px;" class="label label-success">{LIST_ROW_COST|cot_products_costformat($this)} {PHP.L.valuta}</span></div>
                                            <!-- ENDIF -->
										</div>
									</div>
									<hr>
								<!-- END: LIST_ROW -->
                               
                                <!-- IF (!{PHP._GET.d}) -->
                                    {LIST_ROW_CATDESC}
                                <!-- ENDIF -->
                               
                                </div>
                                   
                                <div class="col-md-3">
                                   <h3 style="text-align:center;">Категории</h3>
                                    <div class="block btn blue" style="width: 100%;">
                                        {PHP.c|cot_build_structure_vacancies_tree($this, 0)}
                                    </div>
                                        <!-- IF {PHP.usr.auth_write} -->
                                            <ul style="margin-top:20px;" class="nav nav-tabs nav-stacked page-style">
                                                <li><a class="btn btn-primary dobavit" href="{LIST_SUBMITNEWPRD_URL}">{PHP.L.prd_submitnewprd}</a></li>
                                        <!-- ELSE -->
                                                <li><a class="btn btn-primary dobavit" href="{PHP|cot_url('login')}">{PHP.L.prd_submitnewprd}</a></li>
                                            </ul>
                                        <!-- ENDIF -->
                                </div>
                            </div>
                            <div class="pagination-style">
                                <ul class="pagination pull-right">
                                    {LIST_TOP_PAGEPREV}{LIST_TOP_PAGINATION}{LIST_TOP_PAGENEXT}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: MAIN -->