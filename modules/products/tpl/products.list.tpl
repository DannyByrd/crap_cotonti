<!-- BEGIN: MAIN -->
<div class="breadcrumb">{LIST_CATPATH}</div>
<!-- IF {PHP.usr.auth_write} -->
<div class="pull-right"><a class="btn btn-primary" href="{LIST_SUBMITNEWPRD_URL}">{PHP.L.prd_submitnewprd}</a></div>
<!-- ENDIF -->
<h1>{LIST_CATTITLE}</h1>

<div class="row">
	<div class="span3">
		{PHP.c|cot_build_structure_products_tree($this,0,0)}
		
        <!-- IF {PHP.cot_plugins_active.smartfilter} -->
            <!-- IF {PHP.out.plg_smartfilter.active} -->
                {PHP.out.plg_smartfilter.html}
            <!-- ENDIF -->
        <!-- ENDIF -->
	     

	
		<!-- IF {LIST_TAG_CLOUD} -->
		<div class="block">
			<h2 class="tags">{PHP.L.Tags}</h2>
			{LIST_TAG_CLOUD}
		</div>
		<!-- ENDIF -->
	</div>
	<div class="span9">
		
		<!-- IF {PHP.cot_plugins_active.payprdvip} -->
		{PHP.c|cot_products_list(10, $this, 'vip', 'prd_vip>0')}
		<!-- ENDIF -->
		
   <!-- IF {LIST_CAT_MAVATAR} -->
        <!-- IF {LIST_CAT_MAVATAR.1} -->
        <img src="{LIST_CAT_MAVATAR.1|cot_mav_thumb($this, 200, 200, width)}" alt="{LIST_CAT_MAVATAR.1.DESC}" />
        <!-- ENDIF -->
    <!-- ENDIF -->

		<!-- BEGIN: LIST_ROW -->
		<div class="media<!-- IF {LIST_ROW_TOP} > 0 --> well prdtop<!-- ENDIF --><!-- IF {LIST_ROW_VIP} > 0 --> prdvip<!-- ENDIF -->">
			<!-- IF {LIST_ROW_COST} > 0 -->
			<div class="pull-right"><span class="label label-success">{LIST_ROW_COST|cot_products_costformat($this)} {PHP.L.valuta}</span></div>
			<div style="clear:both"></div>
				<!-- IF {PHP.cot_plugins_active.simpleorders} -->
			<div class="pull-right">
				<form class="ajax_form" method="POST" action="{PHP|cot_url('plug', 'r=simpleorders')}">
					
					<input type="hidden" name="title" value="{LIST_ROW_SHORTTITLE}">
					<input type="hidden" name="action" value="cartpopup.add">

					<input type="number" name="quantity" value="1" class="input-mini">

					<button class="btn btn-primary" type="submit">В корзину</button>
					
					<div class="simpleorders-form-success"></div>
				</form>
			</div>
				<!-- ENDIF -->
			<!-- ENDIF -->
			<!-- IF {LIST_ROW_VIP} > 0 --><div class="pull-right margintop10" style="clear:both; "><span class="label label-success">VIP</span></div><!-- ENDIF -->
			<!-- IF {LIST_ROW_MAVATAR.1} -->
			<a class="pull-left thumbnail" href="{LIST_ROW_URL}"><img src="{LIST_ROW_MAVATAR.1|cot_mav_thumb($this, 100, 100)}" /></a>	
			<!-- ENDIF -->
			<div class="media-body">
				<h4 class="media-heading"><a href="{LIST_ROW_URL}">{LIST_ROW_SHORTTITLE}</a></h4>
				<!-- IF {LIST_ROW_DESC} --><p class="small marginbottom10">{LIST_ROW_DESC}</p><!-- ENDIF -->
				<p class="small marginbottom10">
					{LIST_ROW_COMMENTS} | {LIST_ROW_UPDATED} | {LIST_ROW_CATPATH} 
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
