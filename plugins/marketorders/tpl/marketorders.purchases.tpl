<!-- BEGIN: MAIN -->
<div class="breadcrumb">{BREADCRUMBS}</div>
<h1>{PHP.L.marketorders_purchases_title}</h1>

<ul class="nav nav-tabs" id="myTab">
	<li<!-- IF !{PHP.status} --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('marketorders', 'm=purchases')}">{PHP.L.All}</a></li>
	<li<!-- IF {PHP.status} == 'paid' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('marketorders', 'm=purchases&status=paid')}">{PHP.L.marketorders_purchases_paidorders}</a></li>
	<li<!-- IF {PHP.status} == 'done' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('marketorders', 'm=purchases&status=done')}">{PHP.L.marketorders_purchases_doneorders}</a></li>
	<li<!-- IF {PHP.status} == 'claim' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('marketorders', 'm=purchases&status=claim')}">{PHP.L.marketorders_purchases_claimorders}</a></li>
	<li<!-- IF {PHP.status} == 'cancel' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('marketorders', 'm=purchases&status=cancel')}">{PHP.L.marketorders_purchases_cancelorders}</a></li>
</ul>

<!-- BEGIN: ORDER_ROW -->	
<div class="media">
	<div class="pull-right">{ORDER_ROW_COST} {PHP.cfg.payments.valuta}</div>
	<div class="span2">
		<div class="media-header"><a href="{ORDER_ROW_URL}">№ {ORDER_ROW_ID} [{ORDER_ROW_PAID|date('d.m.Y H:i', $this)}]</a></div>
	</div>
	<div class="span6">
		[ID {ORDER_ROW_PRD_ID}] <a href="{ORDER_ROW_PRD_URL}">{ORDER_ROW_PRD_SHORTTITLE}</a> ({ORDER_ROW_SELLER_NAME})
	</div>
	<div class="span2">
		{ORDER_ROW_SELLER_NAME}
	</div>
</div>	
<hr/>
<!-- END: ORDER_ROW -->

<!-- IF {PAGENAV_COUNT} > 0 -->	
<div class="pagination"><ul>{PAGENAV_PAGES}</ul></div>
<!-- ELSE -->
<div class="alert">{PHP.L.marketorders_empty}</div>
<!-- ENDIF -->

<!-- END: MAIN -->