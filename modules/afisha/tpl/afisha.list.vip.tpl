<!-- BEGIN: MAIN -->
<!-- IF {TOTALITEMS} > 0 -->
<div class="well eventvip">
	<div class="row">
		<!-- BEGIN: EVT_ROW -->
		<div class="span3">
			<div class="media">
				<div class="media-body">
				<h1>YOUUUU!</h1>
					<h4 class="media-heading"><a href="{EVT_ROW_URL}">{EVT_ROW_SHORTTITLE}</a></h4>
					<!-- IF {EVT_ROW_COST} > 0 -->
					<div class="label label-success">{EVT_ROW_COST|cot_costformat($this)} {PHP.cfg.payments.valuta}</div>
					<!-- ENDIF -->
				</div>	
			</div>		
		</div>		
		<!-- END: EVT_ROW -->
	</div>	
</div>	
<!-- ENDIF -->
<!-- END: MAIN -->