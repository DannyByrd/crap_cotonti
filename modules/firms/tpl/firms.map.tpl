<!-- BEGIN: MAIN -->

<div class="breadcrumb">{LIST_CATPATH}</div>
<!-- IF {PHP.usr.auth_write} -->
<div class="pull-right"><a class="btn btn-primary" href="{LIST_SUBMITNEWFIRM_URL}">{PHP.L.firm_submitnewfirm}</a></div>
<!-- ENDIF -->
<h1>{LIST_CATTITLE}</h1>
<div class="row">
	<div class="span3">
		{PHP.c|cot_build_structure_firms_tree($this, 0)}

		<!-- IF {LIST_TAG_CLOUD} -->
		<div class="block">
			<h2 class="tags">{PHP.L.Tags}</h2>
			{LIST_TAG_CLOUD}
		</div>
		<!-- ENDIF -->
	</div>
	<div class="span9">		
		
	</div>
</div>

<!-- END: MAIN -->