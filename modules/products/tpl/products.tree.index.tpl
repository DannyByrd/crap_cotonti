<!-- BEGIN: MAIN -->
<div class="row">
	

	
	<ul class="pull-left span3">
		<!-- BEGIN: LIST_ROWCAT -->
		<!-- IF {LIST_ROWCAT_COUNT_VIEW} AND {LIST_ROWCAT_NUM} <= {LIST_ROWCAT_COUNT_VIEW} -->
		<li><a href="{LIST_ROWCAT_URL}" title="{LIST_ROWCAT_TITLE}">{LIST_ROWCAT_TITLE}</a> ({LIST_ROWCAT_COUNT})</li> 
		<h4>{LIST_ROWCAT_DESC|cot_cutstring($this, 20)}</h4>
		<!-- IF {PHP.cot_plugins_active.mavatars} -->
			<!-- IF {LIST_ROWCAT_CATEGORY_AVATAR} == {LIST_ROWCAT_CATEGORY} -->
				<img src="{LIST_ROWCAT_MAVATAR.1|cot_mav_thumb($this, 100, 150)}"/>
			<!-- ENDIF -->
		<!-- ENDIF -->
	<!-- IF {LIST_ROWCAT_COL} -->
		<!-- ENDIF -->
	</ul>
	<ul class="pull-right span3">
	<!-- ENDIF -->
		<!-- END: LIST_ROWCAT -->
	</ul>
</div>	
<div class="clear"></div>

<!-- END: MAIN -->