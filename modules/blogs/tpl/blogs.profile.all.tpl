<!-- BEGIN: MAIN -->

	<!-- BEGIN: LIST_ROW -->
	<div class="media">
		<div class="pull-right">
			<span class="label 
				  <!-- IF {LIST_ROW_STATUS} == 'published' -->label-success<!-- ENDIF -->
				  <!-- IF {LIST_ROW_STATUS} == 'pending' -->label-warning<!-- ENDIF -->">{LIST_ROW_LOCALSTATUS}</span>
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

<!-- END: MAIN -->