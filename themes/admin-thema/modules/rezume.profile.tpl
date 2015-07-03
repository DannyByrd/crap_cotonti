<!-- BEGIN: MAIN -->

	<!-- IF {PHP.usr.auth_write} -->
	<div class="pull-right"><a class="btn btn-primary" href="{LIST_SUBMITNEWrez_URL}">{PHP.L.rez_submitnewrez}</a></div>
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
                        <p style="font-weight: 600;">{LIST_ROW_AGE} {PHP.L.rez_years}, {PHP.L.rez_sex} - {LIST_ROW_SEX}, {PHP.L.rez_edu}: {LIST_ROW_EDU}</p>
                        <p>{LIST_ROW_WORKS}</p>
                    </div>
                    <div class="col-md-4 value">
                       <p class="vipvakan">{LIST_ROW_PAYVIP}</p>
                        <p class="vipvakan">{LIST_ROW_PAYTOP}</p>
<!--                        <p class="vipvakan">{LIST_ROW_PAYBOLD}</p>-->
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