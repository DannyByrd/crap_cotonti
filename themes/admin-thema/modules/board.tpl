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
                                               <!-- IF {ADV_MAVATAR.1} -->
                                                   <img class="img-responsive" src="{ADV_MAVATAR.1.FILE}" />
                                               <!-- ENDIF -->
											</li>
											
											<li>
											    <!-- IF {ADV_COST} > 0 -->
                                                   <div style="text-align:center;"><br/>
                                                       <span class="label label-success large">{ADV_COST} {PHP.cfg.payments.valuta}</span>
                                                   </div>
                                               <!-- ENDIF -->
                                            </li>
                                            
                                            <div class="row" style="margin:0px;text-align:center;padding-top:10px;">
                                                
                                               <h4>Контактная информация</h4>
                                                    <!-- IF {ADV_PLACEMARKS} -->
                                                    <div class="col-lg-4">{PHP.L.placemarks_placeonmap}:</div>
                                                    <div class="col-lg-8">{ADV_PLACEMARKS}</div>
                                                    <!-- ENDIF -->
                                                    <!-- IF {ADV_ADDR} -->
                                                    <div class="col-lg-4">{PHP.L.adv_addr}:</div>
                                                    <div class="col-lg-8">{ADV_ADDR}</div>
                                                    <!-- ENDIF -->
                                                    <!-- IF {ADV_PHONE} -->
                                                    <div class="col-lg-4">{PHP.L.adv_phone}:</div>
                                                    <div class="col-lg-8">{ADV_PHONE}</div>
                                                    <!-- ENDIF -->
                                                    <!-- IF {ADV_SITE} -->
                                                    <div class="col-lg-4">{PHP.L.adv_site}:</div>
                                                    <div class="col-lg-8">{ADV_SITE|cot_build_url($this)}</div>
                                                    <!-- ENDIF -->
                                                    <!-- IF {ADV_SKYPE} -->
                                                    <div class="col-lg-4">{PHP.L.adv_skype}:</div>
                                                    <div class="col-lg-8">{ADV_SKYPE}</div>
                                                    <!-- ENDIF -->
                                                    <!-- IF {ADV_EMAIL} AND {ADV_HIDEMAIL} -->
                                                    <div class="col-lg-4">{PHP.L.adv_email}:</div>
                                                    <div class="col-lg-8">{ADV_EMAIL}</div>
                                                    <!-- ENDIF -->
                                            </div>
										</ul>
									</div>
									<div class="col-md-9">
										<div class="row">
											<div class="<!-- IF {PHP.usr.isadmin} -->col-md-8 <!-- ELSE --> col-md-12 <!-- ENDIF --> profile-info">
												<h1>{ADV_SHORTTITLE}</h1>
                                               <p>{ADV_DATE_STAMP|cot_date('Y-m-d',$this)} | <a href="{ADV_CATURL}">{ADV_CATTITLE}</a> | {ADV_OWNER}</p>
                                               
                                                {ADV_TEXT}
											</div>
											<!-- IF {PHP.usr.isadmin} -->
											    <div class="col-md-4">
											        <!-- BEGIN: ADV_ADMIN -->
                                                        <div class="well well-small">
                                                            <h4>{PHP.L.Adminpanel}</h4>
                                                            <ul class="bullets">
                                                                <!-- IF {PHP.usr.isadmin} -->
                                                                <li><a href="{PHP|cot_url('admin')}">{PHP.L.Adminpanel}</a></li>
                                                                <!-- ENDIF -->
                                                                <li><a href="{ADV_CAT|cot_url('board','m=add&c=$this')}">{PHP.L.adv_addtitle}</a></li>
                                                                <li>{ADV_ADMIN_UNVALIDATE}</li>
                                                                <li>{ADV_ADMIN_EDIT}</li>
                                                                <li>{ADV_ADMIN_CLONE}</li>
                                                                <li>{ADV_ADMIN_DELETE}</li>
                                                            </ul>
                                                        </div>
                                                    <!-- END: ADV_ADMIN -->
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


<!-- BEGIN: CONTACTFORM -->
			<div id="contactform">
				<h4>{PHP.L.adv_sendmsg}</h4>
				{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
				<div class="customform">
					<form action="{ADV_CONTACT_FORM_ACTION}" method="post" name="msgform">
						<table class="table-bordered table">
							<tr>
								<td>{PHP.L.adv_contact_name}:</td>
								<td>{ADV_CONTACT_FORM_NAME}</td>
							</tr>
							<tr>
								<td>{PHP.L.adv_contact_email}:</td>
								<td>{ADV_CONTACT_FORM_EMAIL}</td>
							</tr>
							<tr>
								<td>{PHP.L.adv_contact_phone}:</td>
								<td>{ADV_CONTACT_FORM_PHONE}</td>
							</tr>
							<tr>
								<td>{PHP.L.adv_contact_msg}:</td>
								<td>{ADV_CONTACT_FORM_TEXT}</td>
							</tr>

							<tr>
								<td></td>
								<td>
									<button type="submit" class="btn btn-success" name="submitmsg" value="1">{PHP.L.Submit}</button>
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
			<!-- END: CONTACTFORM -->
<!-- END: MAIN -->