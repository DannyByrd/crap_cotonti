<!-- BEGIN: MAIN -->
                <div class="col-md-12">
                   <div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cubes"></i><a style="color: #fff !important;" href="{PHP|cot_url('products')}">{PHP.L.products}</a>
							</div>
						</div>
						<div class="portlet-body">
	                       <!-- BEGIN: LIST_ROW -->
				                <div class="alert alert-block alert-info fade in" style="min-height: 155px;">
                                    <button type="button" class="close" data-dismiss="alert"></button>
                                    <h4 class="alert-heading"><a href="{LIST_ROW_URL}">{LIST_ROW_SHORTTITLE}</a></h4>
                                    
                                    <!-- IF {LIST_ROW_MAVATAR.1} -->
                                         <a class="pull-left thumbnail" style="margin-right: 10px;" href="{LIST_ROW_URL}"><img src="{LIST_ROW_MAVATAR.1|cot_mav_thumb($this, 60, 60)}" /></a>	
                                    <!-- ENDIF -->
                                    
                                     <p>
                                      {LIST_ROW_TEXT_CUT|cot_cutstring($this, 300)}
                                    </p>
                                    <p style="float: left;margin-top:15px;">
                                        <span class="label <!-- IF {LIST_ROW_STATUS} == 'published' -->label-success<!-- ENDIF -->
                                            <!-- IF {LIST_ROW_STATUS} == 'pending' -->label-warning<!-- ENDIF -->">{LIST_ROW_LOCALSTATUS}
                                        </span>	
                                        <!-- IF {PHP.usr.isadmin} --><p class="small marginbottom10" style="float: left;margin-top:10px;">{LIST_ROW_ADMIN} ({LIST_ROW_COUNT})</p><!-- ENDIF -->
                                        <span style="float: right;margin-top: 10px;"><a href="{LIST_ROW_URL}" style="background:#60C0BB;padding: 3px 10px;" class="btn purple">	Далее </a></span>
                                    </p>
                                    <div class="row">
                                        <div class=""col-lg-12>
                                            <ul class="vip-class">
                                                <li>{LIST_ROW_PAYVIP}</li>
                                                <li>{LIST_ROW_PAYTOP}</li>
    <!--                                        <li>{LIST_ROW_PAYBOLD}</li>-->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
	                       <!-- END: LIST_ROW -->
                        </div>
                    </div>
                </div>
<!-- END: MAIN -->