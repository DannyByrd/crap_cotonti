<!-- BEGIN: MAIN -->
<div class="page-container">
    {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/sidebur.tpl"}
    <div class="page-content-wrapper">
		<div class="page-content">
            <div class="portlet light">
				<div class="portlet-body">
					
                   <ul class="list-inline blog-tags">
						<li style="float: left;">
							<i class="fa fa-tags"></i>
						</li>
						{PRD_CATPATH}
					</ul>
                  
                   <div class="row margin-bottom-30">
						<div class="col-md-6">
						    <h1 style="font-size: 25px;">{PRD_SHORTTITLE}</h1>
							<p>{PRD_TEXT}</p>
                            <!-- IF {PRD_COST} --><div class="pull-right"><br/><span class="label label-success large">{PRD_COST|cot_products_costformat($this)} {PHP.L.valuta}</span></div><!-- ENDIF -->
                            {PRD_QUICKORDER_BUTTON}
                            <span class="btn btn-circle blue btn-sm" style="margin-top:10px;cursor:auto;">{PRD_DATE_STAMP|cot_date('Y-m-d',$this)}</span>
						</div>
						<div class="col-md-6">
                        <!-- IF {PRD_MAVATAR.1} -->
                            <img style="width:100%;height:auto;" src="{PRD_MAVATAR.1.FILE}" />	
                        <!-- ENDIF -->
						</div>
						
                       
                        <div class="headline" style="margin: 0px 0px 30px 15px;">
						    <h3>Галерея</h3>
					    </div>
                        <div class="row thumbnails" style="margin:0px;">
                            <!-- IF {PRD_MAVATARCOUNT} -->
                               <!-- FOR {KEY}, {VALUE} IN {PRD_MAVATAR} -->
                                    <div class="col-md-3">
                                        <div class="meet-our-team">
                                           <!-- IF {KEY} != 0 -->
                                                <img style="height: 165px;width: 100%;margin-bottom: 20px;" class="img-responsive" src="{VALUE.FILE}" />
                                            <!-- ENDIF -->
                                        </div>
                                    </div>
                                <!-- ENDFOR -->
                            <!-- ENDIF -->
                        </div>
                        {PHP|cot_build_structure_products_tree($this,0, 0)}
                        <!-- BEGIN: PRD_ADMIN -->
                            <div class="col-md-3 well well-small" style="margin-top: 20px;">
                                <h4>{PHP.L.Adminpanel}</h4>
                                <ul class="nav">
                                    <!-- IF {PHP.usr.isadmin} -->
                                    <li><a href="{PHP|cot_url('admin')}">{PHP.L.Adminpanel}</a></li>
                                    <!-- ENDIF -->
                                    <li><a href="{PRD_CAT|cot_url('products','m=add&c=$this')}">{PHP.L.prd_addtitle}</a></li>
                                    <li>{PRD_ADMIN_UNVALIDATE}</li>
                                    <li>{PRD_ADMIN_EDIT}</li>
                                    <li>{PRD_ADMIN_CLONE}</li>
                                    <li>{PRD_ADMIN_DELETE}</li>
                                </ul>
                            </div>
                        <!-- END: PRD_ADMIN -->
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: MAIN -->