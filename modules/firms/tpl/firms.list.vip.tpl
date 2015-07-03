<!-- BEGIN: MAIN -->
<!-- IF {TOTALITEMS} > 0 -->
<div class="well firmvip">
	<div class="row">
		<!-- BEGIN: FIRM_ROW -->
		<div class="span3">
			<div class="media">
				<!-- IF {FIRM_ROW_MAVATAR.1} -->
				<a class="pull-left thumbnail" href="{FIRM_ROW_URL}"><img src="{FIRM_ROW_MAVATAR.1|cot_mav_thumb($this, 100, 100, width)}" /></a>	
				<!-- ENDIF -->
				<div class="media-body">
					<h4 class="media-heading"><a href="{FIRM_ROW_URL}">{FIRM_ROW_SHORTTITLE}</a></h4>
					{FIRM_ROW_TEXT_CUT}
				<!-- IF {FIRM_LIST_ROW_TEXT_IS_CUT} -->{FIRM_ROW_MORE}<!-- ENDIF -->
				</div>	
			</div>		
		</div>		
		<!-- END: FIRM_ROW -->
	</div>	
</div>	
<!-- ENDIF -->
<!-- END: MAIN -->