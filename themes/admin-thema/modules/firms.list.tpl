<!-- BEGIN: MAIN -->
<div class="page-container">
   {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/sidebur.tpl"}
    <div class="page-content-wrapper">
        <div class="page-content"> 
            <div class="row">
               <!-- IF {PHP.usr.auth_write} -->
                    <div class="col-md-12">
                        <div style="margin: 0px 15px 15px;"><a class="btn btn-primary" href="{LIST_SUBMITNEWFIRM_URL}">{PHP.L.firm_submitnewfirm}</a></div>
                <!-- ELSE -->       
                        <div style="margin: 0px 15px 15px;"><a class="btn btn-primary" href="{PHP|cot_url('login')}">{PHP.L.firm_submitnewfirm}</a></div>
                    </div>
                <!-- ENDIF -->
                <div class="col-md-12">
                    <div class="tabbable tabbable-custom tabbable-noborder">   
						<div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
								<div class="margin-top-10">
									<div class="row mix-grid">
									{PHP.c|cot_build_structure_firms_tree($this, 0)}
									<!-- BEGIN: LIST_ROW -->
										<div class="col-md-3 col-sm-4 mix category_1">
											<div class="mix-inner">
												
                                                <!-- IF {LIST_ROW_MAVATAR.1} -->
                                                    <a href="{LIST_ROW_URL}"><img class="img-responsive img-firm-style" src="{LIST_ROW_MAVATAR.1.FILE}" /></a>	
                                                <!-- ENDIF -->
            
												<div class="mix-details">
													<h4><a href="{LIST_ROW_URL}">{LIST_ROW_SHORTTITLE}</a></h4>
												</div>
											</div>
										</div>
                                    <!-- END: LIST_ROW -->
                                
									</div>
								</div>
								
								<!-- IF (!{PHP._GET.d}) -->
                                    {LIST_ROW_CATDESC}
                                <!-- ENDIF -->
								
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
    </div>
</div>
<!-- END: MAIN -->