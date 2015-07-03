<!-- BEGIN: MAIN -->

	<!-- IF {PHP.usr.auth_write} -->
	<div class="pull-right"><a class="btn btn-primary" href="{LIST_SUBMITNEWrez_URL}">{PHP.L.rez_submitnewrez}</a></div>
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
		<div class="media-body">
			<h4 class="media-heading"><a href="{LIST_ROW_URL}">{LIST_ROW_SHORTTITLE}</a></h4>
			<!-- IF {LIST_ROW_DESC} --><p class="small marginbottom10">{LIST_ROW_DESC}</p><!-- ENDIF -->
			<!-- IF {PHP.usr.isadmin} --><p class="small marginbottom10">{LIST_ROW_ADMIN} ({LIST_ROW_COUNT})</p><!-- ENDIF -->
			<div>
				{LIST_ROW_TEXT_CUT}
				<!-- IF {LIST_ROW_TEXT_IS_CUT} -->{LIST_ROW_MORE}<!-- ENDIF -->
			</div>
		</div>
	</div>		
	<br/>		
	<!-- END: LIST_ROW -->
	<!-- IF {LIST_TOP_PAGINATION} -->
	<p class="paging clear"><span>{PHP.L.Pages} {LIST_TOP_CURRENTPAGE} {PHP.L.Of} {LIST_TOP_TOTALPAGES}</span>{LIST_TOP_PAGEPREV}{LIST_TOP_PAGINATION}{LIST_TOP_PAGENEXT}</p>
	<!-- ENDIF -->

<!-- END: MAIN -->