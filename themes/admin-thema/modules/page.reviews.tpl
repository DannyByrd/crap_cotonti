<!-- BEGIN: MAIN -->
<div class="page-container">
   
   {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/sidebur.tpl"}
   
    <div class="page-content-wrapper">
		<div class="page-content">
            <div class="portlet light">
				<div class="portlet-body">
					<div class="row">
					    <div class="col-md-12 blog-page">
							<div class="row">
							    <div class="<!-- IF {PHP.usr.auth_write} -->col-md-9<!-- ELSE -->col-md-12<!-- ENDIF --> article-block">
									<h3 style="margin-top:0;">{PAGE_SHORTTITLE}</h3>
									<div class="blog-tag-data">
										
                                          <!-- IF {PAGE_MAVATAR.1} -->
                                              <img style="height: 80px;float: left;" class="img-responsive" src="{PAGE_MAVATAR.1.FILE}" />	
                                          <!-- ENDIF -->
          
										<div class="row">
											<div class="col-md-10">
												<ul class="list-inline blog-tags">
													<li style="float: left;">
														<i class="fa fa-tags"></i>
													</li>
													{PAGE_TITLE} 
												</ul><br>
												<div>
                                                    {PAGE_TEXT}
									            </div>
											</div>
										</div>
									</div>
									
									<div class="timeline-footer">
								        <a href="/index.php?e=reviews_add" class="btn blue">
									        Добавить отзыв <i class="m-icon-swapright m-icon-white"></i>
								        </a>
							        </div>
									
									<hr>
                                </div>
                                
                                <!-- BEGIN: PAGE_ADMIN -->
                                            <div class="col-md-3">
                                                <div style="margin-top: 35px;" class="block btn blue">
                                                        <ul class="nav nav-tabs nav-stacked page-style">
                                                            <!-- IF {PHP.usr.isadmin} -->
                                                            <li><a href="{PHP|cot_url('admin')}">{PHP.L.Adminpanel}</a></li>
                                                            <!-- ENDIF -->
                                                            <li><a href="{PAGE_CAT|cot_url('page','m=add&c=$this')}">{PHP.L.page_addtitle}</a></li>
                                                            <li>{PAGE_ADMIN_UNVALIDATE}</li>
                                                            <li>{PAGE_ADMIN_EDIT}</li>
                                                            <li>{PAGE_ADMIN_DELETE}</li>
                                                        </ul>
                                                </div>
  
                                            </div>
								<!-- END: PAGE_ADMIN -->
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: MAIN -->