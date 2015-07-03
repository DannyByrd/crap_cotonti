<!-- BEGIN: MAIN -->

	<div class="breadcrumb">{FIRM_TITLE}</div>
	<div class="row">
		<div class="span9">

		<!-- IF {PHP.cot_plugins_active.latestnews} -->
     			{PHP|cot_show_latestnews(3)}
     		<!-- ENDIF -->
			<h1>{FIRM_SHORTTITLE}</h1>
			
			<!-- IF {FIRM_DESC} --><p class="small">{FIRM_DESC}</p><!-- ENDIF -->
			<div class="row">
				<!-- IF {FIRM_MAVATAR} -->
				<div class="span2 thumbnail">
				<div class="pull-left marginright10">
					<!-- IF {FIRM_MAVATAR.1} -->
					<a href="{FIRM_MAVATAR.1.FILE}"><div class="thumbnail"><img src="{FIRM_MAVATAR.1|cot_mav_thumb($this, 200, 200, width)}" /></div></a>
					<!-- ENDIF -->

					<!-- IF {FIRM_MAVATARCOUNT} -->
					<p>&nbsp;</p>
					<div class="row">
						<!-- FOR {KEY}, {VALUE} IN {FIRM_MAVATAR} -->
						<!-- IF {KEY} != 1 -->
						<a href="{VALUE.FILE}" class="span1 pull-left"><img src="{VALUE|cot_mav_thumb($this, 100, 100)}" /></a>
						<!-- ENDIF -->
						<!-- ENDFOR -->
					</div>
					<!-- ENDIF -->
				</div>	
				</div>
				<!-- ENDIF -->
				<div class="span6">
					{FIRM_TEXT}
					
					<h4>Контактная информация</h4>
					<dl class="dl-horizontal">
						<!-- IF {FIRM_PLACEMARKS} -->
						<dt>{PHP.L.placemarks_placeonmap}:</dt>
						<dd>{FIRM_PLACEMARKS}</dd>
						<!-- ENDIF -->
						<!-- IF {FIRM_ADDR} -->
						<dt>{PHP.L.firm_addr}:</dt>
						<dd>{FIRM_ADDR}</dd>
						<!-- ENDIF -->
						<!-- IF {FIRM_PHONE} -->
						<dt>{PHP.L.firm_phone}:</dt>
						<dd>{FIRM_PHONE}</dd>
						<!-- ENDIF -->
						<!-- IF {FIRM_SITE} -->
						<dt>{PHP.L.firm_site}:</dt>
						<dd>{FIRM_SITE|cot_build_url($this)}</dd>
						<!-- ENDIF -->
						<!-- IF {FIRM_SKYPE} -->
						<dt>{PHP.L.firm_skype}:</dt>
						<dd>{FIRM_SKYPE}</dd>
						<!-- ENDIF -->
						<!-- IF {FIRM_EMAIL} -->
						<dt>{PHP.L.firm_email}:</dt>
						<dd>{FIRM_EMAIL}</dd>
						<!-- ENDIF -->
					</dl>
					
					{FIRM_COMMENTS_DISPLAY}
				</div>
			</div>
		</div>
		<div class="span3">
<!-- BEGIN: FIRM_ADMIN -->
			<div class="well well-small">
				<h4>{PHP.L.Adminpanel}</h4>
				<ul class="bullets">
					<!-- IF {PHP.usr.isadmin} -->
					<li><a href="{PHP|cot_url('admin')}">{PHP.L.Adminpanel}</a></li>
					<!-- ENDIF -->
					<li><a href="{FIRM_CAT|cot_url('firms','m=add&c=$this')}">{PHP.L.firm_addtitle}</a></li>
					<li>{FIRM_ADMIN_UNVALIDATE}</li>
					<li>{FIRM_ADMIN_EDIT}</li>
					<li>{FIRM_ADMIN_CLONE}</li>
					<li>{FIRM_ADMIN_DELETE}</li>
				</ul>
			</div>
<!-- END: FIRM_ADMIN -->
		</div>
	</div>

<!-- END: MAIN -->