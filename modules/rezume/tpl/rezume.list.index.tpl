<!-- BEGIN: MAIN -->
	<!-- BEGIN: LIST_ROW -->
	<div class="media">
		<div class="media-body">
			<div class="pull-right">
				{LIST_ROW_SALARY} {PHP.cfg.payments.valuta}
			</div>
			<h4 class="media-heading"><a href="{LIST_ROW_URL}">{LIST_ROW_SHORTTITLE}</a></h4>
			<p>{LIST_ROW_AGE} {PHP.L.rez_years}, {PHP.L.rez_sex} {LIST_ROW_SEX}, {PHP.L.rez_edu} {LIST_ROW_EDU}</p>
			<!-- IF {PHP.usr.isadmin} --><p class="small marginbottom10">{LIST_ROW_ADMIN} ({LIST_ROW_COUNT})</p><!-- ENDIF -->
		</div>	
	</div>		
	<br/>			
	<!-- END: LIST_ROW -->
<!-- END: MAIN -->