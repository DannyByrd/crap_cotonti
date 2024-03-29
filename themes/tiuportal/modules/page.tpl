<!-- BEGIN: MAIN -->

		<div class="col3-2 first">
			<div class="block">
				<h2 class="page">{PAGE_TITLE}</h2>
				<div class="combox">{PAGE_COMMENTS_COUNT}</div>
				<h3>{PAGE_SHORTTITLE}</h3>
				{PAGE_RATINGS_DISPLAY}
				<!-- IF {PAGE_DESC} --><p class="small">{PAGE_DESC}</p><!-- ENDIF -->
				<div class="clear desc">
					<p class="column">
						<strong>{PHP.L.Tags}:</strong>
<!-- BEGIN: PAGE_TAGS_ROW -->
						<!-- IF {PHP.tag_i} > 0 -->, <!-- ENDIF --><a href="{PAGE_TAGS_ROW_URL}" title="{PAGE_TAGS_ROW_TAG}" rel="nofollow">{PAGE_TAGS_ROW_TAG}</a>
<!-- END: PAGE_TAGS_ROW -->
<!-- BEGIN: PAGE_NO_TAGS -->
						{PAGE_NO_TAGS}
<!-- END: PAGE_NO_TAGS -->
					</p>
					<p class="column floatright">
						<strong>{PHP.L.Filedunder}:</strong>{PAGE_CATPATH}
					</p>
				</div>
		        <!-- IF {PAGE_MAVATAR} -->
				<div class="clear imagesbox">
				    <!-- IF {PAGE_MAVATAR.1} -->
				   	<img src="{PAGE_MAVATAR.1|cot_mav_thumb($this, 200, 200, width)}" alt="{PAGE_MAVATAR.1.DESC1}" title="{PAGE_MAVATAR.1.DESC2}"  />
					<!-- ENDIF -->
				</div>
			    <!-- ENDIF -->

					

		<!-- IF {PHP.cot_plugins_active.simpleorders} -->
					<div class="pull-right">
						<form class="ajax_form" method="POST" action="{PHP|cot_url('plug', 'r=simpleorders')}">
							
							<input type="hidden" name="title" value="{PAGE_SHORTTITLE}">
							<input type="hidden" name="action" value="cartpopup.add">

							<input type="number" name="quantity" value="1" class="input-mini">

							<button class="btn btn-primary" type="submit">В корзину</button>
							
							<div class="simpleorders-form-success"></div>
						</form>
					</div>
						<!-- ENDIF -->

				<div class="clear textbox">{PAGE_TEXT}
				<!-- IF {PAGE_NEED_TARIFF} -->
					<br>
						<a href="{PHP|cot_url('tariffs', 'a=info')}">Выберите необходимый вам тариф</a>
				  <!-- ENDIF -->
				</div>
<!-- BEGIN: PAGE_FILE -->
				<div class="download">
<!-- BEGIN: MEMBERSONLY -->
					<p>{PAGE_SHORTTITLE}</p>
<!-- END: MEMBERSONLY -->
<!-- BEGIN: DOWNLOAD -->
					<p>{PHP.L.Download}: <a class="strong" href="{PAGE_FILE_URL}">{PAGE_SHORTTITLE}</a></p>
<!-- END: DOWNLOAD -->
					<p>{PHP.L.Filesize}, kB: {PAGE_FILE_SIZE}{PHP.L.kb}</p>
					<p>{PHP.L.Downloaded}: {PAGE_FILE_COUNT}</p>
				</div>
<!-- END: PAGE_FILE -->
			</div>
			{PAGE_COMMENTS_DISPLAY}
		</div>

		<div class="col3-1">
<!-- BEGIN: PAGE_ADMIN -->
			<div class="block">
				<h2 class="admin">{PHP.L.Adminpanel}</h2>
				<ul class="bullets">
					<!-- IF {PHP.usr.isadmin} -->
					<li><a href="{PHP|cot_url('admin')}">{PHP.L.Adminpanel}</a></li>
					<!-- ENDIF -->
					<li><a href="{PAGE_CAT|cot_url('page','m=add&c=$this')}">{PHP.L.page_addtitle}</a></li>
					<li>{PAGE_ADMIN_UNVALIDATE}</li>
					<li>{PAGE_ADMIN_EDIT}</li>
					<li>{PAGE_ADMIN_CLONE}</li>
					<li>{PAGE_ADMIN_DELETE}</li>
				</ul>
			</div>
<!-- END: PAGE_ADMIN -->
			{FILE "{PHP.cfg.themes_dir}/{PHP.theme}/inc/contact.tpl"}
<!-- BEGIN: PAGE_MULTI -->
			<div class="block">
				<h2 class="info">{PHP.L.Summary}:</h2>
				{PAGE_MULTI_TABTITLES}
				<p class="paging">{PAGE_MULTI_TABNAV}</p>
			</div>
<!-- END: PAGE_MULTI -->
		</div>

<!-- END: MAIN -->