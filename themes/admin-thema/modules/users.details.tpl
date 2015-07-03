<!-- BEGIN: MAIN -->
<div class="page-container">
   
    {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/sidebur.tpl"}
    
    <div class="page-content-wrapper">
		<div class="page-content">
            <div class="portlet light">
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-12 blog-page">
                           
                            <div class="breadcrumb">{USERS_DETAILS_TITLE}</div>
                            <h1>{USERS_DETAILS_NAME}</h1>
                            <div class="row">
                                <div class="col-lg-2">
                                    <div style="float:left;" class="thumbnail">{USERS_DETAILS_AVATAR}</div>
                                </div>
                                <div class="col-lg-5">
                                    {PHP.L.Maingroup}:{USERS_DETAILS_MAINGRP} <br>

                                    {PHP.L.Groupsmembership}: <br>


                                    {PHP.L.Country}:{USERS_DETAILS_COUNTRYFLAG} {USERS_DETAILS_COUNTRY}<br>
                                    {PHP.L.Timezone}:{USERS_DETAILS_TIMEZONE}<br>
                                    {PHP.L.Birthdate}:{USERS_DETAILS_BIRTHDATE}<br>
                                </div>   
                                <div class="col-lg-5">
                                    {PHP.L.Age}:<br>
                                    {USERS_DETAILS_AGE}{PHP.L.Gender}:<br>
                                    {USERS_DETAILS_GENDER}<br>
                                    {PHP.L.Signature}:{USERS_DETAILS_TEXT} <br>
                                    {PHP.L.Registered}:{USERS_DETAILS_REGDATE}
                                </div>


                                
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="span9">
                                        {PHP.urr.user_id|cot_products_list(10, '', 'index', 'prd_ownerid='$this, "prd_date DESC", true)}
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