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
                                {ADV_TITLE}
                            </ul>
								<div class="row">
									<div class="col-md-3">
										<ul class="list-unstyled profile-nav">
											<li>
                                           
                                               <a href="{VAC_OWNER_DETAILSLINK}">
                                                    <img width="150px" height="150px" src="<!-- IF {VAC_OWNER_AVATAR_SRC} -->{VAC_OWNER_AVATAR_SRC}<!-- ELSE -->datas/defaultav/blank.png<!-- ENDIF -->" class="avatar" alt="" />
                                                </a>
											</li>
                                            
                                            <div class="row" style="margin:0px;text-align:left;padding-top:10px;">
                                                
                                               <h4>Контактная информация</h4>
                                                    <!-- IF {VAC_ADDR} -->
                                                    <div class="col-lg-4">{PHP.L.adv_addr}:</div>
                                                    <div class="col-lg-8">{VAC_ADDR}</div>
                                                    <!-- ENDIF -->
                                                    <!-- IF {VAC_PHONE} -->
                                                    <div class="col-lg-4">{PHP.L.adv_phone}:</div>
                                                    <div class="col-lg-8">{VAC_PHONE}</div>
                                                    <!-- ENDIF -->
                                                    <!-- IF {VAC_SITE} -->
                                                    <div class="col-lg-4">{PHP.L.adv_site}:</div>
                                                    <div class="col-lg-8">{VAC_SITE|cot_build_url($this)}</div>
                                                    <!-- ENDIF -->
                                                    <!-- IF {VAC_SKYPE} -->
                                                    <div class="col-lg-4">{PHP.L.adv_skype}:</div>
                                                    <div class="col-lg-8">{VAC_SKYPE}</div>
                                                    <!-- ENDIF -->
                                                    <!-- IF {VAC_EMAIL} AND {VAC_HIDEMAIL} -->
                                                    <div class="col-lg-4">{PHP.L.adv_email}:</div>
                                                    <div class="col-lg-8">{VAC_EMAIL}</div>
                                                    <!-- ENDIF -->
                                            </div>
										</ul>
					
									</div>
									<div class="col-md-9">
										<div class="row">
											<div class="<!-- IF {PHP.usr.isadmin} -->col-md-8 <!-- ELSE --> col-md-12 <!-- ENDIF --> profile-info">
												<h1>{VAC_SHORTTITLE}</h1>
                                               <p>{VAC_DATE_STAMP|cot_date('Y-m-d',$this)} | <a href="{VAC_CATURL}">{VAC_CATTITLE}</a> | {VAC_OWNER}</p>
                                               
                                                
                                                <div class="row" style="margin:0px;text-align:left;padding-top:10px;">
                                                   <h4>Информация о вакансии</h4>
                                                    <div class="col-lg-4">{PHP.L.vac_salary}:</div>
                                                    <div class="col-lg-8">{VAC_SALARY} {PHP.cfg.payments.valuta}</div>
                                                    <div class="col-lg-4">{PHP.L.vac_duty}:</div>
                                                    <div class="col-lg-8">{VAC_DUTY}</div>
                                                    <div class="col-lg-4">{PHP.L.vac_term}:</div>
                                                    <div class="col-lg-8">{VAC_TERM}</div>
                                                    <div class="col-lg-4">{PHP.L.vac_qua}:</div>
                                                    <div class="col-lg-8">{VAC_QUA}</div>
                                                    <div class="col-lg-4">{PHP.L.vac_edu}:</div>
                                                    <div class="col-lg-8">{VAC_EDU}</div>
                                                    <div class="col-lg-4">{PHP.L.vac_age}:</div>
                                                    <div class="col-lg-8">{VAC_AGE} {PHP.L.vac_years}</div>
                                                    <div class="col-lg-4">{PHP.L.vac_exp}:</div>
                                                    <div class="col-lg-8">{VAC_EXP} {PHP.L.vac_years}</div>
                                                    <div class="col-lg-4">{PHP.L.vac_sex}:</div>
                                                    <div class="col-lg-8">{VAC_SEX}</div>
                                                </div>
											</div>
											<!-- IF {PHP.usr.isadmin} -->
											    <div class="col-md-4">
											        <!-- BEGIN: VAC_ADMIN -->
                                                        <div class="well well-small">
                                                            <h4>{PHP.L.Adminpanel}</h4>
                                                            <ul class="bullets">
                                                                <!-- IF {PHP.usr.isadmin} -->
                                                                <li><a href="{PHP|cot_url('admin')}">{PHP.L.Adminpanel}</a></li>
                                                                <!-- ENDIF -->
                                                                <li><a href="{VAC_CAT|cot_url('vacancies','m=add&c=$this')}">{PHP.L.vac_addtitle}</a></li>
                                                                <li>{VAC_ADMIN_UNVALIDATE}</li>
                                                                <li>{VAC_ADMIN_EDIT}</li>
                                                                <li>{VAC_ADMIN_CLONE}</li>
                                                                <li>{VAC_ADMIN_DELETE}</li>
                                                            </ul>
                                                        </div>
                                                    <!-- END: VAC_ADMIN -->
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