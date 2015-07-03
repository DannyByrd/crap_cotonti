<!-- BEGIN: MAIN -->

	<div class="breadcrumb">{ADV_TITLE}</div>
	<div class="row">

	 <!-- IF {PHP.cot_plugins_active.latestnews} -->
     	{PHP|cot_show_latestnews(3,products)}
     <!-- ENDIF -->

			<div class="span9">
			<!-- IF {ADV_COST} > 0 --><div class="pull-right"><br/><span class="label label-success large">{ADV_COST|cot_costformat($this)} {PHP.cfg.payments.valuta}</span></div><!-- ENDIF -->
			<h1>{ADV_SHORTTITLE}</h1>
			<p class="small"><i class="icon-time"></i> {ADV_DATE} <!-- IF {ADV_STATUS} == 'expired' --><i class="label">{ADV_LOCALSTATUS}</i><!-- ENDIF --></p>
			<!-- IF {ADV_DESC} --><p class="small">{ADV_DESC}</p><!-- ENDIF -->
			
			<!-- IF {ADV_MAVATAR} -->
			<div class="pull-left marginright10">
				<!-- IF {ADV_MAVATAR.1} -->
				<a href="{ADV_MAVATAR.1.FILE}"><div class="thumbnail"><img src="{ADV_MAVATAR.1|cot_mav_thumb($this, 200, 200, width)}" /></div></a>
				<!-- ENDIF -->

				<!-- IF {ADV_MAVATARCOUNT} -->
				<p>&nbsp;</p>
				<div class="row">
					<!-- FOR {KEY}, {VALUE} IN {ADV_MAVATAR} -->
					<!-- IF {KEY} != 1 -->
					<a href="{VALUE.FILE}" class="span1 pull-left"><img src="{VALUE|cot_mav_thumb($this, 100, 100)}" /></a>
					<!-- ENDIF -->
					<!-- ENDFOR -->
				</div>
				<!-- ENDIF -->
			</div>	
			<!-- ENDIF -->

			{ADV_TEXT}
			<div class="clear"></div>
			<h4>Контактная информация</h4>
			<dl class="dl-horizontal">
				<!-- IF {ADV_PLACEMARKS} -->
				<dt>{PHP.L.placemarks_placeonmap}:</dt>
				<dd>{ADV_PLACEMARKS}</dd>
				<!-- ENDIF -->
				<!-- IF {ADV_ADDR} -->
				<dt>{PHP.L.adv_addr}:</dt>
				<dd>{ADV_ADDR}</dd>
				<!-- ENDIF -->
				<!-- IF {ADV_PHONE} -->
				<dt>{PHP.L.adv_phone}:</dt>
				<dd>{ADV_PHONE}</dd>
				<!-- ENDIF -->
				<!-- IF {ADV_SITE} -->
				<dt>{PHP.L.adv_site}:</dt>
				<dd>{ADV_SITE|cot_build_url($this)}</dd>
				<!-- ENDIF -->
				<!-- IF {ADV_SKYPE} -->
				<dt>{PHP.L.adv_skype}:</dt>
				<dd>{ADV_SKYPE}</dd>
				<!-- ENDIF -->
				<!-- IF {ADV_EMAIL} AND {ADV_HIDEMAIL} -->
				<dt>{PHP.L.adv_email}:</dt>
				<dd>{ADV_EMAIL}</dd>
				<!-- ENDIF -->
			</dl>
			
			<!-- BEGIN: CONTACTFORM -->
			<div id="contactform">
				<h4>{PHP.L.adv_sendmsg}</h4>
				{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
				<div class="customform">
					<form action="{ADV_CONTACT_FORM_ACTION}" method="post" name="msgform">
						<table class="table-bordered table">
							<tr>
								<td>{PHP.L.adv_contact_name}:</td>
								<td>{ADV_CONTACT_FORM_NAME}</td>
							</tr>
							<tr>
								<td>{PHP.L.adv_contact_email}:</td>
								<td>{ADV_CONTACT_FORM_EMAIL}</td>
							</tr>
							<tr>
								<td>{PHP.L.adv_contact_phone}:</td>
								<td>{ADV_CONTACT_FORM_PHONE}</td>
							</tr>
							<tr>
								<td>{PHP.L.adv_contact_msg}:</td>
								<td>{ADV_CONTACT_FORM_TEXT}</td>
							</tr>
							<tr>
								<td>{ADV_CONTACT_FORM_VERIFYIMG}</td>
								<td>{ADV_CONTACT_FORM_VERIFYINPUT} *</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<button type="submit" class="btn btn-success" name="submitmsg" value="1">{PHP.L.Submit}</button>
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
			<!-- END: CONTACTFORM -->
			
			{ADV_COMMENTS_DISPLAY}

		</div>
		<div class="span3">
<!-- BEGIN: ADV_ADMIN -->
			<div class="well well-small">
				<h4>{PHP.L.Adminpanel}</h4>
				<ul class="bullets">
					<!-- IF {PHP.usr.isadmin} -->
					<li><a href="{PHP|cot_url('admin')}">{PHP.L.Adminpanel}</a></li>
					<!-- ENDIF -->
					<li><a href="{ADV_CAT|cot_url('board','m=add&c=$this')}">{PHP.L.adv_addtitle}</a></li>
					<li>{ADV_ADMIN_UNVALIDATE}</li>
					<li>{ADV_ADMIN_EDIT}</li>
					<li>{ADV_ADMIN_CLONE}</li>
					<li>{ADV_ADMIN_DELETE}</li>
				</ul>
			</div>
<!-- END: ADV_ADMIN -->
		</div>
	</div>

<!-- END: MAIN -->