<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PROFILE_CATPATH}</div>
<h1>{PROFILE_TITLE}</h1>
<div class="row">
	<div class="span3">
		<!-- BEGIN: MENU -->
		<div class="well" style="padding: 8px 0;">
			<ul class="nav nav-list">
				<!-- BEGIN: MENU_ROW -->
				<li <!-- IF  == {MENU_ROW_ID} --> class="active"<!-- ENDIF -->><a href="{MENU_ROW_URL}">{MENU_ROW_TITLE}</a></li>
				<!-- END: MENU_ROW -->
			</ul>	
		</div>	
		<!-- END: MENU -->
	</div>
	<div class="span9">
		{PROFILE_CONTENT}
		
		<!-- IF  {PHP.m} == whatpay -->
			<!-- IF {PHP.cot_plugins_active.whatpay} -->
	   	    	{PHP|cot_show_payments()}
		
     		<!-- ENDIF -->
      <!-- ENDIF -->

      <!-- IF  {PHP.m} == cmanager -->

			<!-- IF {PHP.cot_plugins_active.cmanager} -->  
	   	    	{PHP|cot_show_cmanager()}
		
     		<!-- ENDIF -->
      <!-- ENDIF -->

      <!-- IF  {PHP.m} == simpleorders AND {ADMIN_USER}  -->

			<!-- IF {PHP.cot_plugins_active.simpleorders} -->  
	   	    	{PHP|cot_show_simpleorders()}
		
     		<!-- ENDIF -->
      <!-- ENDIF -->


	</div>
</div>

<!-- END: MAIN -->