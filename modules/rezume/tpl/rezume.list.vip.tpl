	<!-- BEGIN: MAIN -->
<!-- IF {TOTALITEMS} > 0 -->
<div class="well rezvip">
	<div class="row">
		<!-- BEGIN: LIST_ROW -->
		<div class="span3">
			<div class="media">
				<!-- IF {LIST_ROW_MAVATAR.1} -->
				<a class="pull-left thumbnail" href="{LIST_ROW_URL}"><img src="{LIST_ROW_MAVATAR.1|cot_mav_thumb($this, 100, 100, width)}" /></a>	
				<!-- ENDIF -->
				<div class="media-body">
					<h4 class="media-heading"><a href="{LIST_ROW_URL}">{LIST_ROW_SHORTTITLE}</a></h4>
				</div>	
			</div>		
		</div>		
		<!-- END: LIST_ROW -->
	</div>	
</div>	
<!-- ENDIF -->
<!-- END: MAIN -->