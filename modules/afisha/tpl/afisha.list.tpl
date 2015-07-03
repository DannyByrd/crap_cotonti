<!-- BEGIN: MAIN -->

<div class="breadcrumb">{LIST_CATPATH}</div>
<!-- IF {PHP.usr.auth_write} -->
<div class="pull-right"><a class="btn btn-primary" href="{LIST_SUBMITNEWADV_URL}">{PHP.L.event_submitnewevent}</a></div>
<!-- ENDIF -->
<h1>{LIST_CATTITLE}</h1>

<!-- IF (!{PHP._GET.d}) -->
                                    {LIST_ROW_CATDESC}
                                <!-- ENDIF -->

	
<div class="row">
	<div class="span3">
		{PHP.c|cot_build_structure_afisha_tree('','',$this, 0)}

		<!-- IF {LIST_TAG_CLOUD} -->
		<div class="block">
			<h2 class="tags">{PHP.L.Tags}</h2>
			{LIST_TAG_CLOUD}
		</div>
		<!-- ENDIF -->
	</div>
	<div class="span9">

		<!-- IF {PHP.cot_plugins_active.payafishavip} -->
		{PHP.c|cot_afisha_list(10, $this, 'vip', 'event_vip>0')}
		<!-- ENDIF -->

		<!-- BEGIN: LIST_ROW -->
		<div class="media<!-- IF {LIST_ROW_VIP} > 0 --> eventvip<!-- ENDIF -->">
			<!-- IF {LIST_ROW_COST} > 0 -->
			<div class="pull-right"><span class="label label-success">{LIST_ROW_COST|cot_costformat($this)} {PHP.cfg.payments.valuta}</span></div>
			<!-- ENDIF -->
			<!-- IF {LIST_ROW_MAVATAR.1} -->
			<a class="pull-left thumbnail" href="{LIST_ROW_URL}"><img src="{LIST_ROW_MAVATAR.1|cot_mav_thumb($this, 100, 100, width)}" /></a>	
			<!-- ENDIF -->
			<div class="media-body">
				<h4 class="media-heading"><a href="{LIST_ROW_URL}">{LIST_ROW_SHORTTITLE}</a></h4>
				<!-- IF {LIST_ROW_DESC} --><p class="small marginbottom10">{LIST_ROW_DESC}</p><!-- ENDIF -->
				<p class="small marginbottom10">
				{LIST_ROW_UPDATED} | {LIST_ROW_CATPATH}
				<!-- IF {PHP.usr.isadmin} -->| {LIST_ROW_ADMIN} ({LIST_ROW_COUNT})<!-- ENDIF -->
				</p>
				<p>
					{LIST_ROW_TEXT_CUT}
					<!-- IF {LIST_ROW_TEXT_IS_CUT} -->{LIST_ROW_MORE}<!-- ENDIF -->
				</p>
				<p class="small"><i class="icon-time"></i> {LIST_ROW_DATE}</p>
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