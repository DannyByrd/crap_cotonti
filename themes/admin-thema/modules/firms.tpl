<!-- BEGIN: MAIN -->
<div class="page-container">
   {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/sidebur.tpl"}
    <div class="page-content-wrapper">
		<div class="page-content">
		    <div class="row profile">
		        <div class="col-md-12">
		            <div class="tabbable tabbable-custom tabbable-noborder">
		                <div class="tab-content">
		                    <div class="tab-pane active" id="tab_1_1">
		                    <ul class="page-breadcrumb breadcrumb">
                                {FIRM_TITLE}
                            </ul>
								<div class="row">
									<div class="col-md-3">
										<ul class="list-unstyled profile-nav">
											<li>
                                               <!-- IF {FIRM_MAVATAR.1} -->
                                                   <img class="img-responsive" src="{FIRM_MAVATAR.1.FILE}" />
                                               <!-- ENDIF -->
											</li>
                                            
                                            <div class="row" style="margin:0px;text-align:center;padding-top:10px;">
                                                
                                               <h4>Контактная информация</h4>
                                                    <!-- IF {FIRM_ADDR} -->
                                                    <div class="col-lg-4">{PHP.L.firm_addr}:</div>
                                                    <div class="col-lg-8">{FIRM_ADDR}</div>
                                                    <!-- ENDIF -->
                                                    <!-- IF {FIRM_PHONE} -->
                                                    <div class="col-lg-4">{PHP.L.firm_phone}:</div>
                                                    <div class="col-lg-8">{FIRM_PHONE}</div>
                                                    <!-- ENDIF -->
                                                    <!-- IF {FIRM_SITE} -->
                                                    <div class="col-lg-4">{PHP.L.firm_site}:</div>
                                                    <div class="col-lg-8">{FIRM_SITE|cot_build_url($this)}</div>
                                                    <!-- ENDIF -->
                                                    <!-- IF {FIRM_SKYPE} -->
                                                    <div class="col-lg-4">{PHP.L.firm_skype}:</div>
                                                    <div class="col-lg-8">{FIRM_SKYPE}</div>
                                                    <!-- ENDIF -->
                                                    <!-- IF {FIRM_EMAIL} -->
                                                    <div class="col-lg-4">{PHP.L.firm_email}:</div>
                                                    <div class="col-lg-8">{FIRM_EMAIL}</div>
                                                    <!-- ENDIF -->                                                  
                                            </div>
										</ul>
									</div>
									<div class="col-md-9">
										<div class="row">
											<div class="<!-- IF {PHP.usr.isadmin} -->col-md-8 <!-- ELSE --> col-md-12 <!-- ENDIF --> profile-info">
												<h1>{FIRM_SHORTTITLE}</h1>
                                               <p>{FIRM_DATE_STAMP|cot_date('Y-m-d',$this)} | <a href="{FIRM_CATURL}">{FIRM_CATTITLE}</a> | {FIRM_OWNER}</p>
                                               
                                                {FIRM_TEXT}
											</div>
											<!-- IF {PHP.usr.isadmin} -->
											    <div class="col-md-4">
											        <!-- BEGIN: FIRM_ADMIN -->
                                                        <div class="well well-small">
                                                            <h4>{PHP.L.Adminpanel}</h4>
                                                            <ul class="bullets">
                                                                <!-- IF {PHP.usr.isadmin} -->
                                                                <li><a href="{PHP|cot_url('admin')}">{PHP.L.Adminpanel}</a></li>
                                                                <!-- ENDIF -->
                                                                <li><a href="{FIRM_CAT|cot_url('firms','m=add&c=$this')}">{PHP.L.adv_addtitle}</a></li>
                                                                <li>{FIRM_ADMIN_UNVALIDATE}</li>
                                                                <li>{FIRM_ADMIN_EDIT}</li>
                                                                <li>{FIRM_ADMIN_CLONE}</li>
                                                                <li>{FIRM_ADMIN_DELETE}</li>
                                                            </ul>
                                                        </div>
                                                    <!-- END: FIRM_ADMIN -->
											    </div>
											<!-- ENDIF -->
										</div>
									</div>
								</div>
								<div class="row">
								    <div class="col-lg-12">
                                        <!-- IF {FIRM_PLACEMARKS} -->
                                            {FIRM_PLACEMARKS}
                                        <!-- ENDIF -->
								    </div>
								</div>
							</div>
				        </div>
				    </div>
				</div>
           </div>
        </div>
    </div>
</div>
	
<!-- END: MAIN -->


<div class="breadcrumb">{FIRM_TITLE}</div>
	<div class="row">
		<div class="span9">
			<h1>{FIRM_SHORTTITLE}</h1>
			<!-- IF {FIRM_DESC} --><p class="small">{FIRM_DESC}</p><!-- ENDIF -->
			<div class="row">
				<!-- IF {FIRM_MAVATAR} -->
				<div class="span2 thumbnail">
				<div class="pull-left marginright10">
					<!-- IF {FIRM_MAVATAR.1} -->
					<a href="{FIRM_MAVATAR.1.FILE}"><div class="thumbnail"><img src="{FIRM_MAVATAR.1|cot_mav_thumb($this, 200, 200, width)}" /></div></a>
					<!-- ENDIF -->

					<!-- IF {FIRM_MAVATARCOUNT} -->
					<p>&nbsp;</p>
					<div class="row">
						<!-- FOR {KEY}, {VALUE} IN {FIRM_MAVATAR} -->
						<!-- IF {KEY} != 1 -->
						<a href="{VALUE.FILE}" class="span1 pull-left"><img src="{VALUE|cot_mav_thumb($this, 100, 100)}" /></a>
						<!-- ENDIF -->
						<!-- ENDFOR -->
					</div>
					<!-- ENDIF -->
				</div>	
				</div>
				<!-- ENDIF -->
				<div class="span6">
					{FIRM_TEXT}
					
					
					
					{FIRM_COMMENTS_DISPLAY}
				</div>
			</div>
		</div>
		<div class="span3">
<!-- BEGIN: FIRM_ADMIN -->
			<div class="well well-small">
				<h4>{PHP.L.Adminpanel}</h4>
				<ul class="bullets">
					<!-- IF {PHP.usr.isadmin} -->
					<li><a href="{PHP|cot_url('admin')}">{PHP.L.Adminpanel}</a></li>
					<!-- ENDIF -->
					<li><a href="{FIRM_CAT|cot_url('firms','m=add&c=$this')}">{PHP.L.firm_addtitle}</a></li>
					<li>{FIRM_ADMIN_UNVALIDATE}</li>
					<li>{FIRM_ADMIN_EDIT}</li>
					<li>{FIRM_ADMIN_CLONE}</li>
					<li>{FIRM_ADMIN_DELETE}</li>
				</ul>
			</div>
<!-- END: FIRM_ADMIN -->
		</div>
	</div>