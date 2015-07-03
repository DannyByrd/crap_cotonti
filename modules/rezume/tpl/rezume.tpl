<!-- BEGIN: MAIN -->

	<div class="breadcrumb">{REZ_TITLE}</div>
	<div class="row">
		<div class="span9">
			<h1>{REZ_SHORTTITLE}</h1>
			<!-- IF {REZ_DESC} --><p class="small">{REZ_DESC}</p><!-- ENDIF -->

			

				<!-- IF {REZ_ICON} -->
				
				<a href="{REZ_ICON.1.FILE}"><div class=""><img src="{REZ_ICON.1|cot_mav_thumb($this, 200, 200, width)}" /></div></a>
				<!-- ENDIF -->
			
				
			<dl class="dl-horizontal">
				<dt>{PHP.L.rez_salary}:</dt>
				<dd>{REZ_SALARY} {PHP.cfg.payments.valuta}</dd>
				<dt>{PHP.L.rez_age}:</dt>
				<dd>{REZ_AGE} {PHP.L.rez_years}</dd>
				<dt>{PHP.L.rez_sex}:</dt>
				<dd>{REZ_SEX}</dd>
				<dt>{PHP.L.rez_exp}:</dt>
				<dd>{REZ_EXP} {PHP.L.rez_years}</dd>
				<dt>{PHP.L.rez_works}:</dt>
				<dd>{REZ_WORKS}</dd>
				<dt>{PHP.L.rez_edu}:</dt>
				<dd>{REZ_EDU}</dd>
				<dt>{PHP.L.rez_study}:</dt>
				<dd>{REZ_STUDY}</dd>
				<dt>{PHP.L.rez_qua}:</dt>
				<dd>{REZ_QUA}</dd>

			</dl>
			
			<div class="clear"></div>
			<h4>{PHP.L.rez_contacts}</h4>
			<dl class="dl-horizontal">
				<!-- IF {REZ_FIO} -->
				<dt>{PHP.L.rez_fio}:</dt>
				<dd>{REZ_FIO}</dd>
				<!-- ENDIF -->
				<!-- IF {REZ_ADDR} -->
				<dt>{PHP.L.rez_addr}:</dt>
				<dd>{REZ_ADDR}</dd>
				<!-- ENDIF -->
				<!-- IF {REZ_PHONE} -->
				<dt>{PHP.L.rez_phone}:</dt>
				<dd>{REZ_PHONE}</dd>
				<!-- ENDIF -->
				<!-- IF {REZ_SITE} -->
				<dt>{PHP.L.rez_site}:</dt>
				<dd>{REZ_SITE|cot_build_url($this)}</dd>
				<!-- ENDIF -->
				<!-- IF {REZ_SKYPE} -->
				<dt>{PHP.L.rez_skype}:</dt>
				<dd>{REZ_SKYPE}</dd>
				<!-- ENDIF -->
				<!-- IF {REZ_EMAIL} AND {REZ_HIDEMAIL} -->
				<dt>{PHP.L.rez_email}:</dt>
				<dd>{REZ_EMAIL}</dd>
				<!-- ENDIF -->
			</dl>
			
			<!-- BEGIN: CONTACTFORM -->
			<div id="contactform">
				<h4>{PHP.L.rez_sendmsg}</h4>
				{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
				<div class="customform">
					<form action="{REZ_CONTACT_FORM_ACTION}" method="post" name="msgform">
						<table class="table-bordered table">
							<tr>
								<td>{PHP.L.rez_contact_name}:</td>
								<td>{REZ_CONTACT_FORM_NAME}</td>
							</tr>
							<tr>
								<td>{PHP.L.rez_contact_email}:</td>
								<td>{REZ_CONTACT_FORM_EMAIL}</td>
							</tr>
							<tr>
								<td>{PHP.L.rez_contact_phone}:</td>
								<td>{REZ_CONTACT_FORM_PHONE}</td>
							</tr>
							<tr>
								<td>{PHP.L.rez_contact_msg}:</td>
								<td>{REZ_CONTACT_FORM_TEXT}</td>
							</tr>
							<tr>
								<td>{REZ_CONTACT_FORM_VERIFYIMG}</td>
								<td>{REZ_CONTACT_FORM_VERIFYINPUT} *</td>
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
			
			{REZ_COMMENTS_DISPLAY}

		</div>
		<div class="span3">
<!-- BEGIN: REZ_ADMIN -->
			<div class="well well-small">
				<h4>{PHP.L.Adminpanel}</h4>
				<ul class="bullets">
					<!-- IF {PHP.usr.isadmin} -->
					<li><a href="{PHP|cot_url('admin')}">{PHP.L.Adminpanel}</a></li>
					<!-- ENDIF -->
					<li><a href="{REZ_CAT|cot_url('rezume','m=add&c=$this')}">{PHP.L.rez_addtitle}</a></li>
					<li>{REZ_ADMIN_UNVALIDATE}</li>
					<li>{REZ_ADMIN_EDIT}</li>
					<li>{REZ_ADMIN_CLONE}</li>
					<li>{REZ_ADMIN_DELETE}</li>
				</ul>
			</div>
<!-- END: REZ_ADMIN -->
		</div>
	</div>

<!-- END: MAIN -->