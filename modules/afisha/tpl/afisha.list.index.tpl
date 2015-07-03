<!-- BEGIN: MAIN -->
	<!-- BEGIN: EVT_ROW -->
	<div class="media">
		<!-- IF {EVT_ROW_COST} > 0 -->
		<div class="pull-right"><span class="label label-success">{EVT_ROW_COST|cot_costformat($this)} {PHP.cfg.payments.valuta}</span></div>
		<!-- ENDIF -->
		<!-- IF {EVT_ROW_MAVATAR.1} -->
		<a class="pull-left thumbnail" href="{EVT_ROW_URL}"><img src="{EVT_ROW_MAVATAR.1|cot_mav_thumb($this, 100, 100, width)}" /></a>	
		<!-- ENDIF -->
		<div class="media-body">
			<h4 class="media-heading"><a href="{EVT_ROW_URL}">{EVT_ROW_SHORTTITLE}</a></h4>
			<!-- IF {EVT_ROW_DESC} --><p class="small marginbottom10">{EVT_ROW_DESC}</p><!-- ENDIF -->
			<div>
				{EVT_ROW_TEXT_CUT}
				<!-- IF {EVT_ROW_TEXT_IS_CUT} -->{EVT_ROW_MORE}<!-- ENDIF -->
			</div>
		</div>	
	</div>		
	<br/>		
	<!-- END: EVT_ROW -->
<!-- END: MAIN -->