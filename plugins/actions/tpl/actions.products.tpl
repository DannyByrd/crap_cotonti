<!-- BEGIN: MAIN -->
	   	<div class="action-block">
		   	<div id="countdown-{ACTION_ID}"></div>
			<script type="text/javascript">
				var date = new Date({ACTION_EXPIRY_DATE}*1000); 
				$('#countdown-{ACTION_ID}').countdown({until: date, timezone: {PHP.plg_gmt} });
		   	</script>
		</div>
<!-- END: MAIN -->