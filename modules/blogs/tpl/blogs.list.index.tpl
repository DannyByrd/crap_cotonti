<!-- BEGIN: MAIN -->
	<!-- BEGIN: POST_ROW -->
	<div class="media">
		<a class="pull-left thumbnail" href="{POST_ROW_OWNER_DETAILSLINK}"><img src="<!-- IF {POST_ROW_OWNER_AVATAR_SRC} -->{POST_ROW_OWNER_AVATAR_SRC}<!-- ELSE -->datas/defaultav/blank.png<!-- ENDIF -->" class="avatar" alt="" /></a>	
		<div class="media-body">
			<p>{POST_ROW_OWNER_NAME}</p>
			<h4 class="media-heading"><a href="{POST_ROW_URL}">{POST_ROW_SHORTTITLE}</a></h4>
			<!-- IF {POST_ROW_DESC} --><p class="small marginbottom10">{POST_ROW_DESC}</p><!-- ENDIF -->
			<div>
				{POST_ROW_TEXT_CUT}
				<!-- IF {POST_ROW_TEXT_IS_CUT} -->{POST_ROW_MORE}<!-- ENDIF -->
			</div>
		</div>	
	</div>	
	<br/>			
	<!-- END: POST_ROW -->
<!-- END: MAIN -->