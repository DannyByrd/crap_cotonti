<!-- BEGIN: MAIN -->

	<!-- IF {PHP.usr.auth_write} -->
	<div class="pull-right"><a class="btn btn-primary" href="{LIST_SUBMITNEWADV_URL}">{PHP.L.adv_submitnewadv}</a></div>
	<!-- ENDIF -->
	<div class="clear"></div>
	<hr/>



    <!-- BEGIN: LIST_ROW -->
        <div class="portlet blue-hoki box <!-- IF {LIST_ROW_BOLD} > 0 --> adbold<!-- ENDIF --><!-- IF {LIST_ROW_VIP} > 0 --> advip<!-- ENDIF -->">
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
                        <!-- IF {LIST_ROW_MAVATAR.1} -->
                            <a class="pull-left thumbnail" style="margin-right: 10px;" href="{LIST_ROW_URL}"><img src="{LIST_ROW_MAVATAR.1|cot_mav_thumb($this, 100, 100)}" /></a>
                        <!-- ENDIF -->
                        <!-- IF {LIST_ROW_TEXT} -->
                            {LIST_ROW_TEXT_CUT|cot_cutstring($this, 300)}
                        <!-- ENDIF -->
                        <!-- IF {LIST_ROW_COST} -->
                            <div class="pull-right"><br/>
                                <span class="label label-success large">{LIST_ROW_COST|cot_products_costformat($this)} {PHP.L.valuta}</span>
                            </div>
                        <!-- ENDIF -->
                        <p style="margin: 35px 0px 0px 14px;"><i class="icon-time"></i> {LIST_ROW_DATE_STAMP|cot_date('Y-m-d',$this)}</p>
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
	<p class="paging clear"><span>{PHP.L.Pages} {LIST_TOP_CURRENTPAGE} {PHP.L.Of} {LIST_TOP_TOTALPAGES}</span>{LIST_TOP_PAGEPREV}{LIST_TOP_PAGINATION}{LIST_TOP_PAGENEXT}</p>
	<!-- ENDIF -->

<!-- END: MAIN -->