<!-- BEGIN: MAIN -->
	<!-- IF {PHP.usr.auth_write} -->
	<div class="pull-right"><a class="btn btn-primary" href="{LIST_SUBMITNEWPOST_URL}">{PHP.L.post_submitnewpost}</a></div>
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
                <div class="col-md-12 name">
                    <!-- IF {LIST_ROW_TEXT_CUT|cot_cutstring($this, 350)} -->
                        <p class="small marginbottom10">{LIST_ROW_TEXT_CUT|cot_cutstring($this, 350)}</p>
                    <!-- ENDIF -->
                </div>
                <div class="col-md-12">
                    <!-- IF {PHP.usr.isadmin} --><p class="small marginbottom10">{LIST_ROW_ADMIN} ({LIST_ROW_COUNT})</p><!-- ENDIF -->
                </div>
            </div>
        </div>
    </div>
<!-- END: LIST_ROW -->


	<!-- IF {LIST_TOP_PAGINATION} -->
	<p class="paging clear"><span>{PHP.L.Pages} {LIST_TOP_CURRENTPAGE} {PHP.L.Of} {LIST_TOP_TOTALPAGES}</span>{LIST_TOP_PAGEPREV}{LIST_TOP_PAGINATION}{LIST_TOP_PAGENEXT}</p>
	<!-- ENDIF -->
<!-- END: MAIN -->
<div>
    {LIST_ROW_TEXT_CUT}
    <!-- IF {LIST_ROW_TEXT_IS_CUT} -->{LIST_ROW_MORE}<!-- ENDIF -->
</div>