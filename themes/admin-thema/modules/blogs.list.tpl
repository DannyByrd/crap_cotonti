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
											
           			                            <a href="{LIST_ROW_OWNER_DETAILSLINK}">
           			                                <img class="img-responsive" src="{POST_ROW_OWNER_DETAILSLINK}">
           			                                <img class="img-responsive" src="<!-- IF {LIST_ROW_OWNER_AVATAR_SRC} -->{LIST_ROW_OWNER_AVATAR_SRC}<!-- ELSE -->datas/defaultav/blank.png<!-- ENDIF -->" class="avatar" alt="" />
           			                            </a>	
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
                                    {LIST_ROW_CATDESC}
                                <!-- ENDIF -->

                                </div>
                                    <!-- IF {PHP.usr.auth_write} -->
                                            <div class="col-md-3">
                                                <div class="block btn blue">
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




<div class="breadcrumb">{LIST_CATPATH}</div>
<!-- IF {PHP.usr.auth_write} -->
<div class="pull-right"><a class="btn btn-primary" href="{LIST_SUBMITNEWPOST_URL}">{PHP.L.post_submitnewpost}</a></div>
<!-- ENDIF -->
<h1>{LIST_CATTITLE}</h1>
<div class="row">
	<div class="span3">
		{PHP.c|cot_build_structure_blogs_tree($this, 0)}

		<!-- IF {LIST_TAG_CLOUD} -->
		<div class="block">
			<h2 class="tags">{PHP.L.Tags}</h2>
			{LIST_TAG_CLOUD}
		</div>
		<!-- ENDIF -->
	</div>
	<div class="span9">
		<!-- BEGIN: LIST_ROW -->
		<div class="media">
			<a class="pull-left thumbnail" href="{LIST_ROW_OWNER_DETAILSLINK}"><img src="{POST_ROW_OWNER_DETAILSLINK}"><img src="<!-- IF {LIST_ROW_OWNER_AVATAR_SRC} -->{LIST_ROW_OWNER_AVATAR_SRC}<!-- ELSE -->datas/defaultav/blank.png<!-- ENDIF -->" class="avatar" alt="" /></a>	
			<div class="media-body">
				<p>{LIST_ROW_OWNER_NAME}</p>
				<h4 class="media-heading"><a href="{LIST_ROW_URL}">{LIST_ROW_SHORTTITLE}</a></h4>
				<!-- IF {LIST_ROW_DESC} --><p class="small marginbottom10">{LIST_ROW_DESC}</p><!-- ENDIF -->
				<!-- IF {PHP.usr.isadmin} --><p class="small marginbottom10">{LIST_ROW_ADMIN} ({LIST_ROW_COUNT})</p><!-- ENDIF -->
				<p>
					{LIST_ROW_TEXT_CUT}
					<!-- IF {LIST_ROW_TEXT_IS_CUT} -->{LIST_ROW_MORE}<!-- ENDIF -->
				</p>
			</div>
			<!-- IF {PHP.cot_plugins_active.comments} -->
			<p class="small pull-right">{LIST_ROW_COMMENTS}</p>
			<!-- ENDIF -->
			<hr/>
		</div>			
		<!-- END: LIST_ROW -->
		<!-- IF {LIST_TOP_PAGINATION} -->
		<p class="paging clear"><span>{PHP.L.Pages} {LIST_TOP_CURRENTPAGE} {PHP.L.Of} {LIST_TOP_TOTALPAGES}</span>{LIST_TOP_PAGEPREV}{LIST_TOP_PAGINATION}{LIST_TOP_PAGENEXT}</p>
		<!-- ENDIF -->
	</div>
</div>