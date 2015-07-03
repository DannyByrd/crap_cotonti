<!-- BEGIN: MAIN -->
	<div class="plug-actions">
	   	<!-- BEGIN: ACTIONS_ROW -->
	   	<div style="text-align: center;" class="action-row span3 col-centered">
		   	<h3 class="plug-actions-title"><a href="{ACTION_URL}">{ACTION_TITLE}</a></h3>
		   	<!-- IF {ACTION_MAVATAR.1} -->
		   	<img style="height: 120px;" src="{ACTION_MAVATAR.1|cot_mav_thumb($this, 100, 100, width)}" alt="{ACTION_TITLE}">
		   	<!-- ENDIF -->
		   	<div style="text-align: left; min-height: 160px;" class="plug-actions-text">
			   	{ACTION_TEXT}
		   	</div>

            <div id="countdown-{ACTION_ID}"></div>
			<script type="text/javascript">
				var date = new Date({ACTION_EXPIRY_DATE}*1000); 
				console.log(date.getTimezoneOffset());
				$('#countdown-{ACTION_ID}').countdown({until: date, timezone: {PHP.plg_gmt} });
		   	</script>
		</div>
		<!-- END: ACTIONS_ROW -->	    		
	</div>
<!-- END: MAIN -->
