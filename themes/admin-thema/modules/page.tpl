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
                                              <img style="  width: 100%;max-height: 400px;" class="img-responsive" src="{PAGE_MAVATAR.1.FILE}" alt="{PAGE_MAVATAR.1.DESC1}" title="{PAGE_MAVATAR.1.DESC2}" />	
                                          <!-- ENDIF -->
          
										<div class="row">
											<div class="col-md-12">
												<ul class="list-inline blog-tags">
													<li style="float: left;">
														<i class="fa fa-tags"></i>
													</li>
													{PAGE_TITLE}
												</ul>
                                                
											</div>
											<div class="col-md-12 blog-tag-data-inner" style="text-align:center;">
												<ul class="list-inline">
													<li>
														<i class="fa fa-calendar"></i>
														<a href="#">
														{PAGE_DATE_STAMP|cot_date('Y-m-d',$this)}
                                                        </a>
													</li>
													<li>
														{PAGE_COMMENTS}
													</li>
												</ul>
											</div>
										</div>
									</div>
									<div>
                                        {PAGE_TEXT}
									</div>
									<hr>
									<div class="media">
										<h3>Коментарии</h3>
										<a href="#" class="pull-left">
										<img alt="" src="../../assets/admin/pages/media/blog/9.jpg" class="media-object">
										</a>
										<div class="media-body">
											<h4 class="media-heading">Media heading <span>
											5 hours ago / <a href="#">
											Reply </a>
											</span>
											</h4>
											<p>
												 Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.
											</p>
											<hr>
											<div class="media">
												<a href="#" class="pull-left">
												<img alt="" src="../../assets/admin/pages/media/blog/5.jpg" class="media-object">
												</a>
												<div class="media-body">
													<h4 class="media-heading">Media heading <span>
													17 hours ago / <a href="#">
													Reply </a>
													</span>
													</h4>
													<p>
														 Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.
													</p>
												</div>
											</div>
											<hr>
											<div class="media">
												<a href="#" class="pull-left">
												<img alt="" src="../../assets/admin/pages/media/blog/7.jpg" class="media-object">
												</a>
												<div class="media-body">
													<h4 class="media-heading">Media heading <span>
													2 days ago / <a href="#">
													Reply </a>
													</span>
													</h4>
													<p>
														 Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.
													</p>
												</div>
											</div>
										</div>
									</div>
									<div class="media">
										<a href="#" class="pull-left">
										<img alt="" src="../../assets/admin/pages/media/blog/6.jpg" class="media-object">
										</a>
										<div class="media-body">
											<h4 class="media-heading">Media heading <span>
											July 5,2013 / <a href="#">
											Reply </a>
											</span>
											</h4>
											<p>
												 Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.
											</p>
										</div>
									</div>
									<!--end media-->
									<hr>
									<div class="post-comment">
										<h3>Leave a Comment</h3>
										<form role="form" action="#">
											<div class="form-group">
												<label class="control-label">Name <span class="required">
												* </span>
												</label>
												<input type="text" class="form-control">
											</div>
											<div class="form-group">
												<label class="control-label">Email <span class="required">
												* </span>
												</label>
												<input type="text" class="form-control">
											</div>
											<div class="form-group">
												<label class="control-label">Message <span class="required">
												* </span>
												</label>
												<textarea class="col-md-10 form-control" rows="8"></textarea>
											</div>
											<button class="margin-top-20 btn blue" type="submit">Post a Comment</button>
										</form>
									</div>
                                </div>
                                
                                <!-- BEGIN: PAGE_ADMIN -->
                                            <div class="col-md-3">
                                                <div style="margin-top: 35px;background:#DDDFE0;" class="block btn blue">
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
                                                <div class="quickord">{PAGE_QUICKORDER_BUTTON}</div>
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