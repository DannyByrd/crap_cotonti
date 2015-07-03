<!-- BEGIN: MAIN -->
	<!-- IF {FILTER_COUNT} -->
	<div class="block">
		<div class="mboxHD admin">Smart Filter</div>
		<ul class="nav nav-tabs nav-stacked">
			<li><a href="{FILTER_URL_RESET}">Сбросить фильтр</a></li>
			<!-- BEGIN: FILTER_ROW -->
			<li>
				<h5>{FILTER_ROW_DESCRIPTION}</h5>
				<ul class="nav nav-tabs nav-stacked">
				<!-- BEGIN: FILTER_ITEM -->
					<li class="<!-- IF {FILTER_ITEM_DISABLED} -->filter-disabled<!-- ENDIF -->">
						<!-- IF {FILTER_ITEM_DISABLED}-->
						<a style="color: rgb(51, 51, 51);">{FILTER_ITEM_TITLE}({FILTER_ITEM_COUNT})</a>
						<!-- ELSE -->
						<a href="{FILTER_ITEM_URL}">{FILTER_ITEM_TITLE}({FILTER_ITEM_COUNT})</a>
						<!-- ENDIF -->
					</li>
				<!-- END: FILTER_ITEM -->
				</ul>
			</li>
			<!-- END: FILTER_ROW -->
			<li><a href="{FILTER_URL_RESET}">Сбросить фильтр</a></li>
		</ul>
	</div>
	<!-- ENDIF -->
<!-- END: MAIN -->