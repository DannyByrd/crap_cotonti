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
                                {REZ_TITLE}
                            </ul>
								<div class="row">
									<div class="col-md-3">
										<ul class="list-unstyled profile-nav">
											<li>
                                           
                                               <a href="{REZ_OWNER_DETAILSLINK}">
                                                    <img width="150px" height="150px" src="<!-- IF {REZ_OWNER_AVATAR_SRC} -->{REZ_OWNER_AVATAR_SRC}<!-- ELSE -->datas/defaultav/blank.png<!-- ENDIF -->" class="avatar" alt="" />
                                                </a>
											</li>
                                            
                                            <div class="row" style="margin:0px;text-align:left;padding-top:10px;">
                                                
                                               <h4>Контактная информация</h4>
                                                    <!-- IF {REZ_ADDR} -->
                                                    <div class="col-lg-4">{PHP.L.adv_addr}:</div>
                                                    <div class="col-lg-8">{REZ_ADDR}</div>
                                                    <!-- ENDIF -->
                                                    <!-- IF {REZ_PHONE} -->
                                                    <div class="col-lg-4">{PHP.L.adv_phone}:</div>
                                                    <div class="col-lg-8">{REZ_PHONE}</div>
                                                    <!-- ENDIF -->
                                                    <!-- IF {REZ_SITE} -->
                                                    <div class="col-lg-4">{PHP.L.adv_site}:</div>
                                                    <div class="col-lg-8">{REZ_SITE|cot_build_url($this)}</div>
                                                    <!-- ENDIF -->
                                                    <!-- IF {REZ_SKYPE} -->
                                                    <div class="col-lg-4">{PHP.L.adv_skype}:</div>
                                                    <div class="col-lg-8">{REZ_SKYPE}</div>
                                                    <!-- ENDIF -->
                                                    <!-- IF {REZ_EMAIL} AND {REZ_HIDEMAIL} -->
                                                    <div class="col-lg-4">{PHP.L.adv_email}:</div>
                                                    <div class="col-lg-8">{REZ_EMAIL}</div>
                                                    <!-- ENDIF -->
                                            </div>
										</ul>
					
									</div>
									<div class="col-md-9">
										<div class="row">
											<div class="<!-- IF {PHP.usr.isadmin} -->col-md-8 <!-- ELSE --> col-md-12 <!-- ENDIF --> profile-info">
												<h1>{REZ_SHORTTITLE}</h1>
                                               <p>{REZ_DATE_STAMP|cot_date('Y-m-d',$this)} | <a href="{REZ_CATURL}">{REZ_CATTITLE}</a> | {REZ_OWNER}</p>
                                               
                                                
                                                <div class="row rez-bug" style="margin:0px;text-align:left;padding-top:10px;">
                                                   <h4>Информация о вакансии</h4>
                                                    <div class="row">
                                                        <div class="col-lg-4"><strong>{PHP.L.vac_salary}:</strong></div>
                                                        <div class="col-lg-8">{REZ_SALARY} {PHP.cfg.payments.valuta}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4"><strong>{PHP.L.vac_qua}:</strong></div>
                                                        <div class="col-lg-8">{REZ_QUA}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4"><strong>{PHP.L.vac_edu}:</strong></div>
                                                        <div class="col-lg-8">{REZ_EDU}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4"><strong>{PHP.L.vac_age}:</strong></div>
                                                        <div class="col-lg-8">{REZ_AGE} {PHP.L.vac_years}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4"><strong>{PHP.L.vac_exp}:</strong></div>
                                                        <div class="col-lg-8">{REZ_EXP} {PHP.L.vac_years}</div>
                                                    </div>

                                                </div>
											</div>
											<!-- IF {PHP.usr.isadmin} -->
											    <div class="col-md-4">
											        <!-- BEGIN: REZ_ADMIN -->
                                                        <div class="well well-small">
                                                            <h4>{PHP.L.Adminpanel}</h4>
                                                            <ul class="bullets">
                                                                <!-- IF {PHP.usr.isadmin} -->
                                                                <li><a href="{PHP|cot_url('admin')}">{PHP.L.Adminpanel}</a></li>
                                                                <!-- ENDIF -->
                                                                <li><a href="{REZ_CAT|cot_url('rezume','m=add&c=$this')}">{PHP.L.rez_addtitle}</a></li>
                                                                <li>{REZ_ADMIN_UNVALIDATE}</li>
                                                                <li>{REZ_ADMIN_EDIT}</li>
                                                                <li>{REZ_ADMIN_CLONE}</li>
                                                                <li>{REZ_ADMIN_DELETE}</li>
                                                            </ul>
                                                        </div>
                                                    <!-- END: REZ_ADMIN -->
											    </div>
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
</div>
<!-- END: MAIN -->