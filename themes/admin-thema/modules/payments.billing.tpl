<!-- BEGIN: MAIN -->
<div class="page-container">
   
   {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/sidebur.tpl"}
   
    <div class="page-content-wrapper">
		<div class="page-content">
            <div class="portlet light">
				<div class="portlet-body">
					<div class="row">
					    <div class="col-md-12 blog-page">
							

                        <!-- BEGIN: BILLINGS -->
                            <h4>{PHP.L.payments_billing_title}:</h4>
                            <!-- BEGIN: BILL_ROW -->
                            <div class="row">
                                <div class="span2">
                                    <div style="float: left;margin: 0px 15px;border:none;" class="thumbnail"><img src="<!-- IF {BILL_ROW_ICON} -->{BILL_ROW_ICON}<!-- ELSE -->modules/payments/images/billing_blank.png<!-- ENDIF -->" /></div>
                                </div>
                                <div class="span7">
                                    <h5><a href="{BILL_ROW_URL}">{BILL_ROW_TITLE}</a></h5>
                                </div>
                            </div>
                            <hr/>
                            <!-- END: BILL_ROW -->
                        <!-- END: BILLINGS -->

                        <!-- BEGIN: EMPTYBILLINGS -->
                            <h4>{PHP.L.payments_billing_title}:</h4>
                            <div class="alert alert-error">{PHP.L.payments_emptybillings}</div>
                        <!-- END: EMPTYBILLINGS -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- END: MAIN -->