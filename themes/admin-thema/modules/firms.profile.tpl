<!-- BEGIN: MAIN -->
	<!-- IF {PHP.usr.auth_write} -->
	<div class="pull-right"><a class="btn btn-primary" href="{LIST_SUBMITNEWFIRM_URL}">{PHP.L.firm_submitnewfirm}</a></div>
	<!-- ENDIF -->
	<div class="clear"></div>
	<hr/>

    <!-- BEGIN: LIST_ROW -->
        <div class="portlet blue-hoki box">
            <div class="portlet-title">
                <div class="caption">
                    <a class="ahref" href="{LIST_ROW_URL}">{LIST_ROW_SHORTTITLE}</a>
                </div>
                <div class="actions">
                    <span class="label opublik
                        <!-- IF {LIST_ROW_STATUS} == 'published' -->label-success<!-- ENDIF -->
                        <!-- IF {LIST_ROW_STATUS} == 'pending' -->label-warning<!-- ENDIF -->">{LIST_ROW_LOCALSTATUS}
                    </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row static-info">
                    <div class="col-md-8 name">
                        <!-- IF {LIST_ROW_LOGO} != '' -->
                            <a class="pull-left" href="{LIST_ROW_URL}">
                                <img src="{LIST_ROW_LOGO}" alt="{LIST_ROW_SHORTTITLE}" />
                            </a>
                        <!-- ENDIF -->


                        <!-- IF {LIST_ROW_MAVATAR.1} -->
                            <a class="pull-left thumbnail" style="margin: 15px 10px 0px 0px;" href="{LIST_ROW_URL}"><img src="{LIST_ROW_MAVATAR.1|cot_mav_thumb($this, 100, 100)}" /></a>
                        <!-- ENDIF -->
                        <!-- IF {LIST_ROW_TEXT} -->
                            <p class="small marginbottom10">{LIST_ROW_TEXT_CUT|cot_cutstring($this, 350)}</p>
                        <!-- ENDIF -->
                    </div>
                    <div class="col-md-4 value">
                        <p class="vipvakan">{LIST_ROW_PAYVIP}</p>
                        <p class="vipvakan">{LIST_ROW_PAYTOP}</p>
                        <p class="vipvakan">{LIST_ROW_PAYBOLD}</p>
                        <!-- IF {PHP.usr.isadmin} -->
                            <p style="font-size: 84%;" class="small marginbottom10">{LIST_ROW_ADMIN} ({LIST_ROW_COUNT})</p>
                        <!-- ENDIF -->
                    </div>
                </div>
            </div>
        </div>
    <!-- END: LIST_ROW -->



	
	<!-- IF {LIST_TOP_PAGINATION} -->
	<p class="paging clear"><span>{PHP.L.Firm} {LIST_TOP_CURRENTFIRM} {PHP.L.Of} {LIST_TOP_TOTALFIRMS}</span>{LIST_TOP_PAGEPREV}{LIST_TOP_PAGINATION}{LIST_TOP_PAGENEXT}</p>
	<!-- ENDIF -->

<!-- END: MAIN -->