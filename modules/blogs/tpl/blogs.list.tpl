<!-- BEGIN: MAIN -->

<div class="breadcrumb">{LIST_CATPATH}</div>
<!-- IF {PHP.usr.auth_write} -->
<div class="pull-right"><a class="btn btn-primary" href="{LIST_SUBMITNEWPOST_URL}">{PHP.L.post_submitnewpost}</a></div>
<!-- ENDIF -->
<h1>{LIST_CATTITLE}</h1>
<div class="row">
	<div class="span3">
		{PHP.c|cot_build_structure_blogs_tree($this, 0)}

		<!-- IF {LIST_TAG_CLOUD} -->
		<div class="block">
			<h2 class="tags">{PHP.L.Tags}</h2>
			{LIST_TAG_CLOUD}
		</div>
		<!-- ENDIF -->
	</div>
	<div class="span9">
		<!-- BEGIN: LIST_ROW -->
		<div class="media">
			<a class="pull-left thumbnail" href="{LIST_ROW_OWNER_DETAILSLINK}"><img src="{POST_ROW_OWNER_DETAILSLINK}"><img src="<!-- IF {LIST_ROW_OWNER_AVATAR_SRC} -->{LIST_ROW_OWNER_AVATAR_SRC}<!-- ELSE -->datas/defaultav/blank.png<!-- ENDIF -->" class="avatar" alt="" /></a>	
			<div class="media-body">
				<p>{LIST_ROW_OWNER_NAME}</p>
				<h4 class="media-heading"><a href="{LIST_ROW_URL}">{LIST_ROW_SHORTTITLE}</a></h4>
				<!-- IF {LIST_ROW_DESC} --><p class="small marginbottom10">{LIST_ROW_DESC}</p><!-- ENDIF -->
				<!-- IF {PHP.usr.isadmin} --><p class="small marginbottom10">{LIST_ROW_ADMIN} ({LIST_ROW_COUNT})</p><!-- ENDIF -->
				<p>
					{LIST_ROW_TEXT_CUT}
					<!-- IF {LIST_ROW_TEXT_IS_CUT} -->{LIST_ROW_MORE}<!-- ENDIF -->
				</p>
				<!-- IF {LIST_ROW_ICON} -->
				
				<a href="{LIST_ROW_ICON.1.FILE}"><div class=""><img src="{LIST_ROW_ICON.1|cot_mav_thumb($this, 200, 200, width)}" /></div></a>
				
				<!-- ENDIF -->
			</div>
			<!-- IF {PHP.cot_plugins_active.comments} -->
			<p class="small pull-right">{LIST_ROW_COMMENTS}</p>
			<!-- ENDIF -->
			<hr/>
		</div>			
		<!-- END: LIST_ROW -->
		<!-- IF {LIST_TOP_PAGINATION} -->
		<p class="paging clear"><span>{PHP.L.Pages} {LIST_TOP_CURRENTPAGE} {PHP.L.Of} {LIST_TOP_TOTALPAGES}</span>{LIST_TOP_PAGEPREV}{LIST_TOP_PAGINATION}{LIST_TOP_PAGENEXT}</p>
		<!-- ENDIF -->
	</div>
</div>

<!-- END: MAIN -->