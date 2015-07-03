<!-- BEGIN: MAIN -->
<div class="col">
	<div class="block">
		<h1>Weather</h1>
	</div>
</div>


<!-- BEGIN: WEATHER_ROW -->
	<h4>{WEATHER_CITY}</h4>
	<div style="float: left; margin-right:20px">
		<p>Сегодня</p> 
		<p><img src="{WEATHER_NOW_IMG_SRC}">{WEATHER_NOW_TYPE}: {WEATHER_NOW_TEMP} | Ночь: {WEATHER_NOW_NIGHT}</p>
	</div>

	<div > 
		<p>Завтра</p> 
		<p><img src="{WEATHER_TOMR_IMG_SRC}">{WEATHER_TOMR_TYPE}: {WEATHER_TOMR_TEMP} | Ночь: {WEATHER_TOMR_NIGHT}</p>
	</div>
	<div style="clear: both;"></div>

<!-- END: WEATHER_ROW -->


<!-- END: MAIN -->