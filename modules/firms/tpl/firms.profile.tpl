<!-- BEGIN: MAIN -->

	<!-- IF {PHP.usr.auth_write} -->
	<div class="pull-right"><a class="btn btn-primary" href="{LIST_SUBMITNEWFIRM_URL}">{PHP.L.firm_submitnewfirm}</a></div>
	<!-- ENDIF -->
	<div class="clear"></div>
	<hr/>
	<!-- BEGIN: LIST_ROW -->
	<div class="media">			
		<div class="pull-right">
			<span class="label 
				  <!-- IF {LIST_ROW_STATUS} == 'published' -->label-success<!-- ENDIF -->
				  <!-- IF {LIST_ROW_STATUS} == 'pending' -->label-warning<!-- ENDIF -->">{LIST_ROW_LOCALSTATUS}</span>
			<br/>
			<br/>
			<p>{LIST_ROW_PAYVIP}</p>	  
			<p>{LIST_ROW_PAYTOP}</p>	  
			<p>{LIST_ROW_PAYBOLD}</p>
		</div>
		<!-- IF {LIST_ROW_LOGO} != '' -->
		<a class="pull-left" href="{LIST_ROW_URL}"><img src="{LIST_ROW_LOGO}" alt="{LIST_ROW_SHORTTITLE}" /></a>	
		<!-- ENDIF -->
		<div class="media-body">
			<h4 class="media-heading"><a href="{LIST_ROW_URL}">{LIST_ROW_SHORTTITLE}</a></h4>
			<!-- IF {LIST_ROW_DESC} --><p class="small marginbottom10">{LIST_ROW_DESC}</p><!-- ENDIF -->
			<!-- IF {PHP.usr.isadmin} --><p class="small marginbottom10">{LIST_ROW_ADMIN} ({LIST_ROW_COUNT})</p><!-- ENDIF -->
			{LIST_ROW_TEXT_CUT}
			<!-- IF {LIST_ROW_TEXT_IS_CUT} -->{LIST_ROW_MORE}<!-- ENDIF -->
		</div>
	</div>	
	<br/>
	<!-- END: LIST_ROW -->
	
	<!-- IF {LIST_TOP_PAGINATION} -->
	<p class="paging clear"><span>{PHP.L.Firm} {LIST_TOP_CURRENTFIRM} {PHP.L.Of} {LIST_TOP_TOTALFIRMS}</span>{LIST_TOP_PAGEPREV}{LIST_TOP_PAGINATION}{LIST_TOP_PAGENEXT}</p>
	<!-- ENDIF -->

<!-- END: MAIN -->