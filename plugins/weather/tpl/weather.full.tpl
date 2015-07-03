<!-- BEGIN: MAIN -->
<div class="col">
	<div class="block">
		<h1>Full Weather</h1>
	</div>
</div>
<div class="container">
	
<h4>{FULL_WEATHER_CITY}</h4>
<div class="row">
		<div class="span2"></div>
		<div class="span7">
			<div class="row">
				<div class="span2"></div>
				<div class="span1"></div>
				<div class="span1"></div>
				<div class="span1">Давление, мм рт. ст.</div>
				<div class="span1">Влажность</div>
				<div class="span1">Ветер, м/с</div>
			</div>
		</div>
	</div>
<!-- BEGIN: FULL_WEATHER_ROW -->

	<div class="row">
		<div class="span2">
		<!-- IF {FULL_WEATHER_DAYPART_NEWDAY} == true -->
			    {FULL_WEATHER_DATA}

		<!--ENDIF -->
		</div>
		<div class="span7">
			<div class="row">
				<div class="span2">{FULL_WEATHER_DAYPART_KIND}
				{FULL_WEATHER_DAYPART_TEMPFROM}...{FULL_WEATHER_DAYPART_TEMPTO}</div>
				<div class="span1"><img src="{FULL_WEATHER_DAYPART_IMAGE}"></div>
				<div class="span1">{FULL_WEATHER_DAYPART_TYPE}</div>
				<div class="span1">{FULL_WEATHER_DAYPART_PRESSURE}</div>
				<div class="span1">{FULL_WEATHER_DAYPART_HUMIDITY} %</div>
				<div class="span1">{FULL_WEATHER_DAYPART_WINDDIR} {FULL_WEATHER_DAYPART_WINDSPEED}</div>
			</div>
		</div>
	</div><!-- IF {FULL_WEATHER_DAYPART_NEWDAY} == end --> <hr><!--ENDIF -->
			   

		
<!-- END:  FULL_WEATHER_ROW -->

</div>
<!-- END: MAIN -->