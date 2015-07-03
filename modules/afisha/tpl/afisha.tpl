<!-- BEGIN: MAIN -->

	<div class="breadcrumb">{EVT_TITLE}</div>
	<div class="row">

		
		<div class="span9">
		

			<h1>{EVT_SHORTTITLE}</h1>
			<p class="small"><i class="icon-time"></i> {EVT_DATE} <!-- IF {EVT_STATUS} == 'expired' --><i class="label">{EVT_LOCALSTATUS}</i><!-- ENDIF --></p>
			<!-- IF {EVT_DESC} --><p class="small">{EVT_DESC}</p><!-- ENDIF -->
			
			<!-- IF {EVT_MAVATAR} -->
			<div class="pull-left marginright10">
				<!-- IF {EVT_MAVATAR.1} -->
				<a href="{EVT_MAVATAR.1.FILE}"><div class="thumbnail"><img src="{EVT_MAVATAR.1|cot_mav_thumb($this, 200, 200, width)}" /></div></a>
				<!-- ENDIF -->

				<!-- IF {EVT_MAVATARCOUNT} -->
				<p>&nbsp;</p>
				<div class="row">
					<!-- FOR {KEY}, {VALUE} IN {EVT_MAVATAR} -->
					<!-- IF {KEY} != 1 -->
					<a href="{VALUE.FILE}" class="span1 pull-left"><img src="{VALUE|cot_mav_thumb($this, 100, 100)}" /></a>
					<!-- ENDIF -->
					<!-- ENDFOR -->
				</div>
				<!-- ENDIF -->
			</div>	
			<!-- ENDIF -->



			{EVT_TEXT}
			<div class="clear"></div>
			{EVT_COMMENTS_DISPLAY}
		</div>
		<div class="span3">
<!-- BEGIN: EVT_ADMIN -->
			<div class="well well-small">
				<h4>{PHP.L.Adminpanel}</h4>
				<ul class="bullets">
					<!-- IF {PHP.usr.isadmin} -->
					<li><a href="{PHP|cot_url('admin')}">{PHP.L.Adminpanel}</a></li>
					<!-- ENDIF -->
					<li><a href="{EVT_CAT|cot_url('afisha','m=add&c=$this')}">{PHP.L.event_addtitle}</a></li>
					<li>{EVT_ADMIN_UNVALIDATE}</li>
					<li>{EVT_ADMIN_EDIT}</li>
					<li>{EVT_ADMIN_CLONE}</li>
					<li>{EVT_ADMIN_DELETE}</li>
				</ul>
			</div>
<!-- END: EVT_ADMIN -->
		</div>
	</div>

<!-- END: MAIN -->