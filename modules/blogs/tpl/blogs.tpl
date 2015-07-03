<!-- BEGIN: MAIN -->

	<div class="breadcrumb">{POST_TITLE}</div>
	<div class="row">
		<div class="span9">
			<h1>{POST_SHORTTITLE}</h1>

			<!-- IF {POST_ICON} -->
				
				<a href="{POST_ICON.1.FILE}"><div class=""><img src="{POST_ICON.1|cot_mav_thumb($this, 200, 200, width)}" /></div></a>
				<!-- ENDIF -->
			
			<div class="media">
				<a class="pull-left thumbnail" href="{POST_OWNER_DETAILSLINK}"><img src="{POST_ROW_OWNER_DETAILSLINK}"><img src="<!-- IF {POST_OWNER_AVATAR_SRC} -->{POST_OWNER_AVATAR_SRC}<!-- ELSE -->datas/defaultav/blank.png<!-- ENDIF -->" class="avatar" alt="" /></a>
				<div class="media-body">
					<p>{POST_OWNER_NAME}</p>
					<p class="small date">{POST_DATE}</p>
				</div>
			</div>	
			<br/>
			
			<!-- IF {POST_DESC} --><p class="small">{POST_DESC}</p><!-- ENDIF -->
			
			<p>{POST_TEXT}</p>
			
			{POST_COMMENTS_DISPLAY}

		</div>
		<div class="span3">
<!-- BEGIN: POST_ADMIN -->
			<div class="well well-small">
				<h4>{PHP.L.Adminpanel}</h4>
				<ul class="bullets">
					<!-- IF {PHP.usr.isadmin} -->
					<li><a href="{PHP|cot_url('admin')}">{PHP.L.Adminpanel}</a></li>
					<!-- ENDIF -->
					<li><a href="{POST_CAT|cot_url('blogs','m=add&c=$this')}">{PHP.L.post_addtitle}</a></li>
					<li>{POST_ADMIN_UNVALIDATE}</li>
					<li>{POST_ADMIN_EDIT}</li>
					<li>{POST_ADMIN_CLONE}</li>
					<li>{POST_ADMIN_DELETE}</li>
				</ul>
			</div>
<!-- END: POST_ADMIN -->
		</div>
	</div>

<!-- END: MAIN -->