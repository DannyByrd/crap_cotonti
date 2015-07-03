<!-- BEGIN: MAIN -->

	<!-- BEGIN: LIST_ROW -->
	<div class="media<!-- IF {LIST_ROW_BOLD} > 0 --> adbold<!-- ENDIF --><!-- IF {LIST_ROW_VIP} > 0 --> eventip<!-- ENDIF -->">
		<div class="pull-right textright">
			<span class="label 
				<!-- IF {LIST_ROW_STATUS} == 'published' -->label-success<!-- ENDIF -->
				<!-- IF {LIST_ROW_STATUS} == 'pending' -->label-warning<!-- ENDIF -->">{LIST_ROW_LOCALSTATUS}
			</span>	  
		</div>
		<div class="media-body">
			<h4 class="media-heading"><a href="{LIST_ROW_URL}">{LIST_ROW_SHORTTITLE}</a></h4>
			<!-- IF {LIST_ROW_DESC} --><p class="small marginbottom10">{LIST_ROW_DESC}</p><!-- ENDIF -->
			<!-- IF {PHP.usr.isadmin} --><p class="small marginbottom10">{LIST_ROW_ADMIN} ({LIST_ROW_COUNT})</p><!-- ENDIF -->
			<p class="small"><i class="icon-time"></i> {LIST_ROW_DATE}</p>
		</div>
	</div>	
	<br/>			
	<!-- END: LIST_ROW -->

<!-- END: MAIN -->