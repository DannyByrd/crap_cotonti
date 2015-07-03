<!-- BEGIN: MAIN -->

<div class="breadcrumb">{LIST_CATPATH}</div>
<!-- IF {PHP.usr.auth_write} -->
<div class="pull-right"><a class="btn btn-primary" href="{LIST_SUBMITNEWREZ_URL}">{PHP.L.rez_submitnewrez}</a></div>
<!-- ENDIF -->
<h1>{LIST_CATTITLE}</h1>
<div class="row">
	<div class="span3">
		{PHP.c|cot_build_structure_rezume_tree($this, 0)}

		<!-- IF {LIST_TAG_CLOUD} -->
		<div class="block">
			<h2 class="tags">{PHP.L.Tags}</h2>
			{LIST_TAG_CLOUD}
		</div>
		<!-- ENDIF -->
	</div>
	<div class="span9">

		<!-- IF {PHP.cot_plugins_active.payrezvip} -->
		{PHP.c|cot_rezume_list(10, $this, 'vip', 'rez_vip>0')}
		<!-- ENDIF -->

		<!-- BEGIN: LIST_ROW -->
		<div class="media<!-- IF {LIST_ROW_TOP} > 0 --> well reztop<!-- ENDIF --><!-- IF {LIST_ROW_VIP} > 0 --> rezvip<!-- ENDIF -->">
			<div class="media-body">
				<div class="pull-right">
					{LIST_ROW_SALARY} {PHP.cfg.payments.valuta}
				</div>
				<!-- IF {LIST_ROW_ICON} -->
				
				<a href="{LIST_ROW_ICON.1.FILE}"><div class=""><img src="{LIST_ROW_ICON.1|cot_mav_thumb($this, 200, 200, width)}" /></div></a>
				<!-- ENDIF -->
				<h4 class="media-heading"><a href="{LIST_ROW_URL}">{LIST_ROW_SHORTTITLE}</a></h4>
				<p>{LIST_ROW_AGE} {PHP.L.rez_years}, {PHP.L.rez_sex} {LIST_ROW_SEX}, {PHP.L.rez_edu} {LIST_ROW_EDU}</p>
				<!-- IF {PHP.usr.isadmin} --><p class="small marginbottom10">{LIST_ROW_ADMIN} ({LIST_ROW_COUNT})</p><!-- ENDIF -->
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