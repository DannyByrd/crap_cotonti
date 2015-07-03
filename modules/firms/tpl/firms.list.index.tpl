<!-- BEGIN: MAIN -->
<div class="row">
	<ul class="media-list">	
		<!-- BEGIN: FIRM_ROW -->
		<li class="pull-left span3">
			<div class="block">
				<h4 class="media-heading"><a href="{FIRM_ROW_URL}">{FIRM_ROW_SHORTTITLE}</a></h4>
				<!-- IF {FIRM_ROW_LOGO} != '' -->
				<a class="pull-left" href="{FIRM_ROW_URL}"><img src="{FIRM_ROW_LOGO}" alt="{FIRM_ROW_SHORTTITLE}" /></a>	
				<!-- ENDIF -->
				<div class="media-body">
					<!-- IF {FIRM_ROW_DESC} --><p class="small marginbottom10">{FIRM_ROW_DESC}</p><!-- ENDIF -->
					{FIRM_ROW_TEXT_CUT}
					<!-- IF {FIRM_ROW_TEXT_IS_CUT} -->{FIRM_ROW_MORE}<!-- ENDIF -->
				</div>
			</div>
			<br/>
		</li>
		<!-- END: FIRM_ROW -->
	</ul>
</div>	
<div class="clear"></div>
<!-- END: MAIN -->