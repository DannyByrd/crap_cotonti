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
									<h3 style="margin-top:0;">{EVT_SHORTTITLE}</h3>
									<div class="blog-tag-data">
                                          <!-- IF {EVT_MAVATAR.1} -->
                                              <img style="  width: 100%;max-height: 400px;" class="img-responsive" src="{EVT_MAVATAR.1.FILE}" />	
                                          <!-- ENDIF -->
										<div class="row">
											<div class="col-md-10">
												<ul class="list-inline blog-tags">
													<li style="float: left;">
														<i class="fa fa-tags"></i>
													</li>
													{EVT_TITLE}
												</ul>
											</div>
											<div class="col-md-2 blog-tag-data-inner">
												<ul class="list-inline">
													<li>
														<i class="fa fa-calendar"></i>
														<a href="#">
														{EVT_DATE_STAMP|cot_date('Y-m-d',$this)}
                                                        </a>
													</li>
												</ul>
											</div>
										</div>
									</div>
									<div>
                                        {EVT_TEXT}
									</div>
									<hr>
                               {PHP|cot_build_structure_afisha_tree($this,0, 0)}
                               
                                </div>
                                
                                <!-- BEGIN: EVT_ADMIN -->
                                            <div class="col-md-3">
                                                <div style="margin-top: 35px;" class="block btn blue">
                                                        <ul class="nav nav-tabs nav-stacked page-style">
                                                           <!-- IF {PHP.usr.isadmin} -->
                                                            <li><a href="{PHP|cot_url('admin')}">{PHP.L.Adminpanel}</a></li>
                                                            <!-- ENDIF -->
                                                            <li><a href="{EVT_CAT|cot_url('afisha','m=add&c=$this')}">{PHP.L.event_addtitle}</a></li>
                                                            <li>{EVT_ADMIN_UNVALIDATE}</li>
                                                            <li>{EVT_ADMIN_EDIT}</li>
                                                            <li>{EVT_ADMIN_CLONE}</li>
                                                            <li>{EVT_ADMIN_DELETE}</li>
                                                        </ul>
                                                </div>
                                            </div>
								<!-- END: EVT_ADMIN -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: MAIN -->