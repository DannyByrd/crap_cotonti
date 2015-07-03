<!-- BEGIN: MAIN -->
<!-- IF {TOTALITEMS} > 0 -->
<div class="well advip">
	<div class="row">
		<!-- BEGIN: ADV_ROW -->
		<div class="span3">
			<div class="media">
				<!-- IF {ADV_ROW_MAVATAR.1} -->
				<a class="pull-left thumbnail" href="{ADV_ROW_URL}"><img src="{ADV_ROW_MAVATAR.1|cot_mav_thumb($this, 100, 100, width)}" /></a>	
				<!-- ENDIF -->
				<div class="media-body">
					<h4 class="media-heading"><a href="{ADV_ROW_URL}">{ADV_ROW_SHORTTITLE}</a></h4>
					<!-- IF {ADV_ROW_COST} > 0 -->
					<div class="label label-success">{ADV_ROW_COST|cot_costformat($this)} {PHP.cfg.payments.valuta}</div>
					<!-- ENDIF -->
				</div>	
			</div>		
		</div>		
		<!-- END: ADV_ROW -->
	</div>	
</div>	
<!-- ENDIF -->
<!-- END: MAIN -->