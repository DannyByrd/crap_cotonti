<!-- BEGIN: MAIN -->
	<!-- BEGIN: ADV_ROW -->
	<div class="media">
		<!-- IF {ADV_ROW_COST} > 0 -->
		<div class="pull-right"><span class="label label-success">{ADV_ROW_COST|cot_costformat($this)} {PHP.cfg.payments.valuta}</span></div>
		<!-- ENDIF -->
		<!-- IF {ADV_ROW_MAVATAR.1} -->
		<a class="pull-left thumbnail" href="{ADV_ROW_URL}"><img src="{ADV_ROW_MAVATAR.1|cot_mav_thumb($this, 100, 100, width)}" /></a>	
		<!-- ENDIF -->
		<div class="media-body">
			<h4 class="media-heading"><a href="{ADV_ROW_URL}">{ADV_ROW_SHORTTITLE}</a></h4>
			<!-- IF {ADV_ROW_DESC} --><p class="small marginbottom10">{ADV_ROW_DESC}</p><!-- ENDIF -->
			<div>
				{ADV_ROW_TEXT_CUT}
				<!-- IF {ADV_ROW_TEXT_IS_CUT} -->{ADV_ROW_MORE}<!-- ENDIF -->
			</div>
		</div>	
	</div>		
	<br/>		
	<!-- END: ADV_ROW -->
<!-- END: MAIN -->