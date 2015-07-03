<!-- BEGIN: MAIN -->

<div class="breadcrumb">{LIST_CATPATH}</div>
<h1>{LIST_CATTITLE}</h1>
<div class="row">
	<div class="span3">
		{PHP.c|cot_build_structure_map_tree($this, 0)}

		<!-- IF {LIST_TAG_CLOUD} -->
		<div class="block">
			<h2 class="tags">{PHP.L.Tags}</h2>
			{LIST_TAG_CLOUD}
		</div>
		<!-- ENDIF -->
	</div>
	<div class="span9">
			<!-- IF {LIST_FIRMMARKS} -->
			{LIST_FIRMMARKS}
			<!-- ENDIF -->
		<!-- BEGIN: LIST_ROW -->
		<div class="media">
			<h4 class="media-heading"><a href="{LIST_ROW_URL}">{LIST_ROW_SHORTTITLE}</a></h4>
			<!-- IF {LIST_ROW_LOGO} != '' -->
			<a class="pull-left" href="{LIST_ROW_URL}"><img src="{LIST_ROW_LOGO}" alt="{LIST_ROW_SHORTTITLE}" /></a>	
			<!-- ENDIF -->
			<div class="media-body">
				<!-- IF {LIST_ROW_DESC} --><p class="small marginbottom10">{LIST_ROW_DESC}</p><!-- ENDIF -->
				<p class="small marginbottom10">
				{LIST_ROW_UPDATED} | {LIST_ROW_CATPATH}
					<!-- IF {PHP.usr.isadmin} -->| {LIST_ROW_ADMIN} ({LIST_ROW_COUNT})<!-- ENDIF -->
				</p>
				{LIST_ROW_TEXT_CUT}
				<!-- IF {LIST_ROW_TEXT_IS_CUT} -->{LIST_ROW_MORE}<!-- ENDIF -->
			</div>
		</div>		
		<br/>
		<!-- END: LIST_ROW -->
		<!-- IF {LIST_TOP_PAGINATION} -->
		<p class="paging clear"><span>{PHP.L.Pages} {LIST_TOP_CURRENTPAGE} {PHP.L.Of} {LIST_TOP_TOTALPAGES}</span>{LIST_TOP_PAGEPREV}{LIST_TOP_PAGINATION}{LIST_TOP_PAGENEXT}</p>
		<!-- ENDIF -->
	</div>
</div>

<!-- END: MAIN -->