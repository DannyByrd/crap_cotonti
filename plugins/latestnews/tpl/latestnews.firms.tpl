<!-- BEGIN: MAIN -->


<div class="col">
	<div class="block">
		<h1>Latest News FIRMS TPL!</h1>
	</div>
</div>
	<!-- BEGIN: LATESTNEWS_ROW -->
	<h3>{LATESTNEWS_PAGE_TITLE}</h3>
	<!-- IF {PHP.cot_plugins_active.mavatars} -->
		<img src="{LATESTNEWS_PAGE_MAVATAR.1|cot_mav_thumb($this, 100, 100)}"/>
	<!-- ENDIF -->
	{LATESTNEWS_PAGE_TEXT|cot_cutstring($this, 100)};


	<!-- END: LATESTNEWS_ROW -->

<!-- END: MAIN -->