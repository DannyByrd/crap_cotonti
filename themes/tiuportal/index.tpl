<!-- BEGIN: MAIN -->
		

  
	

	<!-- IF {PHP.cot_plugins_active.callme} -->
		{PHP.out.callme}
	<!-- ENDIF -->

	<div class="well well-large">
		{PHP.L.index_text}
	</div>

	<!-- IF {PHP.cot_plugins_active.callme} -->
{PHP.out.callmeWindow}
<!-- ENDIF -->


	<!-- IF {PHP.cot_plugins_active.callme} -->
           <a data-toggle="modal" href="{PHP|cot_url('callme')}" data-target="#callmeModal" class="btn btn-primary">Записаться на прием</a>
      <!-- ENDIF -->
	
	
<!-- IF {PHP.cot_plugins_active.tariffs} -->

		{PHP|cot_show_tariffs()}
 <!-- ENDIF -->
	
	<!-- IF {PHP.cot_plugins_active.weather} -->
			

	   	{PHP|cot_show_weather()} 
	   	{PHP|cot_show_weather('Мариуполь')} 
		
		
     <!-- ENDIF -->

     
	
	<!-- IF {PHP.cot_modules.afisha} -->
	{PHP|cot_afisha_list(2,'','vip')}
	<!-- ENDIF -->
	
	<!-- IF {INDEX_NEWS} -->
	<br/>
	<div class="block">
		{INDEX_NEWS}
	</div>

	<!-- ENDIF -->

	<hr/>

	<!-- IF {PHP.cot_plugins_active.multiforms} -->
	{PHP|cot_multiforms_show_form('test-form')}
	<hr/>
	<!-- ENDIF -->
	
	

	<h2>HERE ?</h2>

	<a href="{BALANCE_FORM_ACTION_URL}"> Link </a>
		{PHP|cot_build_structure_page_tree('about', 'true',0, 'index')}
		<hr>
		{PHP|cot_build_structure_products_tree('','', 0, 'index')}
		<br><hr>
		{PHP|cot_build_structure_rezume_tree('', 'marketing-pr', 0, 'index',3)}
		<br>
		<div class="span5"> 
				<!-- BEGIN: LIST_ROWCAT --> 
				<h2> {BALANCE_FORM_ACTION_URL} AAAA </h2>

				<!-- IF {LIST_ROWCAT_NUM} < 5 -->
						<h3	><a href="{LIST_ROWCAT_URL}" title="{LIST_ROWCAT_TITLE}">{LIST_ROWCAT_TITLE}</a> ({LIST_ROWCAT_COUNT})</h3>
						<!-- IF {LIST_ROWCAT_DESC} -->
						<p class="small">{LIST_ROWCAT_DESC}</p>
						<!-- ENDIF -->
						<!-- ENDIF -->
				<!-- END: LIST_ROWCAT -->
		</div>
		 <h3>WHAT ??</h3> 
     <!-- IF {PHP.cot_plugins_active.latestnews} -->
    {PHP|cot_show_latestnews(3)}
	<hr/>
     <!-- ENDIF -->
	

	<div class="row">
		<div class="col-md-4">
			<!-- IF {INDEX_TAG_CLOUD} -->
			<div class="block">
				<div class="mboxHD tags">{PHP.L.Tags}</div>
				{INDEX_TAG_CLOUD}
			</div>
			<!-- ENDIF -->
		</div>

		<div class="col-md-4">
			<!-- IF {INDEX_POLLS} -->
			<div class="block">
				<div class="mboxHD polls">{PHP.L.Polls}</div>
				{INDEX_POLLS}
			</div>
			<!-- ENDIF -->
		</div>
		
		<div class="col-md-4">
			<!-- IF {PHP.out.whosonline} -->
			<div class="block">
				<div class="mboxHD online">{PHP.L.Online}</div>
				<a href="{PHP|cot_url('plug','e=whosonline')}">{PHP.out.whosonline}</a>
				<!-- IF {PHP.out.whosonline_reg_list} -->:<br />{PHP.out.whosonline_reg_list}<!-- ENDIF -->
			</div>
			<!-- ENDIF -->
		</div>
	</div>
	
<!-- END: MAIN -->