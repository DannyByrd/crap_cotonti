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
								<h1 style="margin-top:0px">{PHP.L.pages}</h1>
									
				                <!-- BEGIN: LIST_ROW -->
									<div class="row">
										<div class="col-md-3 blog-img blog-tag-data">
											
                                           <!-- IF {LIST_ROW_MAVATAR.1} -->
                                               <a href="{LIST_ROW_URL}"><img class="img-responsive" src="{LIST_ROW_MAVATAR.1.FILE}" alt="{LIST_ROW_MAVATAR.1.DESC1}" title="{LIST_ROW_MAVATAR.1.DESC2}"/></a>	
                                           <!-- ENDIF -->
           
											<ul class="list-inline">
												<li>
													<i class="fa fa-calendar"></i>
												    {LIST_ROW_DATE_STAMP|cot_date('Y-m-d',$this)}
                                                    
												</li>
												<li>
													<span style="margin-left: 20px;">{LIST_ROW_COMMENTS}</span>
												</li>
											</ul>
										</div>
										
										<div class="col-md-8 blog-article">
											<h3 style="margin-top: 0px;">
											    <a href="{LIST_ROW_URL}">{LIST_ROW_SHORTTITLE} </a>
											</h3>
											<p>
                                               {LIST_ROW_TEXT_CUT|cot_cutstring($this, 350)}
											</p>
											<a class="btn blue" href="{LIST_ROW_URL}">
											Read more <i class="m-icon-swapright m-icon-white"></i>
											</a>
										</div>

									</div>
									<hr>
								<!-- END: LIST_ROW -->

                                <!-- IF (!{PHP._GET.d}) -->
                                    {LIST_CATDESC}
                                <!-- ENDIF -->
                               
                                </div>
                                    <!-- IF {PHP.usr.auth_write} -->
                                            <div class="col-md-3">
                                                <div class="block btn blue" style="background:#DDDFE0;">
                                                    <div class="mboxHD admin">{PHP.L.Admin}</div>
                                                    <ul class="nav nav-tabs nav-stacked page-style">
                                                        <!-- IF {PHP.usr.isadmin} -->
                                                        <li><a href="{PHP|cot_url('admin')}">{PHP.L.Adminpanel}</a></li>
                                                        <!-- ENDIF -->
                                                        <li>{LIST_SUBMITNEWPAGE}</li>
                                                    </ul>
                                                </div>
                                            </div>
								    <!-- ENDIF -->
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