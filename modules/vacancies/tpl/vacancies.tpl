<!-- BEGIN: MAIN -->

	<div class="breadcrumb">{VAC_TITLE}</div>
	<div class="row">
		<div class="span9">
			<h1>{VAC_SHORTTITLE}</h1>
			<!-- IF {VAC_DESC} --><p class="small">{VAC_DESC}</p><!-- ENDIF -->
			
			<h4>Информация о вакансии</h4>

			<!-- IF {VAC_ICON} -->
				
				<a href="{VAC_ICON.1.FILE}"><div class=""><img src="{VAC_ICON.1|cot_mav_thumb($this, 200, 200, width)}" /></div></a>
				<!-- ENDIF -->
			<dl class="dl-horizontal">
				<dt>{PHP.L.vac_salary}:</dt>
				<dd>{VAC_SALARY} {PHP.cfg.payments.valuta}</dd>
				<dt>{PHP.L.vac_duty}:</dt>
				<dd>{VAC_DUTY}</dd>
				<dt>{PHP.L.vac_term}:</dt>
				<dd>{VAC_TERM}</dd>
				<dt>{PHP.L.vac_qua}:</dt>
				<dd>{VAC_QUA}</dd>
				<dt>{PHP.L.vac_edu}:</dt>
				<dd>{VAC_EDU}</dd>
				<dt>{PHP.L.vac_age}:</dt>
				<dd>{VAC_AGE} {PHP.L.vac_years}</dd>
				<dt>{PHP.L.vac_exp}:</dt>
				<dd>{VAC_EXP} {PHP.L.vac_years}</dd>
				<dt>{PHP.L.vac_sex}:</dt>
				<dd>{VAC_SEX}</dd>
			</dl>
			
			<div class="clear"></div>
			<h4>Контактная информация</h4>
			<dl class="dl-horizontal">
				<!-- IF {VAC_ADDR} -->
				<dt>{PHP.L.vac_addr}:</dt>
				<dd>{VAC_ADDR}</dd>
				<!-- ENDIF -->
				<!-- IF {VAC_PHONE} -->
				<dt>{PHP.L.vac_phone}:</dt>
				<dd>{VAC_PHONE}</dd>
				<!-- ENDIF -->
				<!-- IF {VAC_SITE} -->
				<dt>{PHP.L.vac_site}:</dt>
				<dd>{VAC_SITE|cot_build_url($this)}</dd>
				<!-- ENDIF -->
				<!-- IF {VAC_SKYPE} -->
				<dt>{PHP.L.vac_skype}:</dt>
				<dd>{VAC_SKYPE}</dd>
				<!-- ENDIF -->
				<!-- IF {VAC_EMAIL} AND {VAC_HIDEMAIL} -->
				<dt>{PHP.L.adv_email}:</dt>
				<dd>{VAC_EMAIL}</dd>
				<!-- ENDIF -->
			</dl>
			
			<!-- BEGIN: CONTACTFORM -->
			<div id="contactform">
				<h4>{PHP.L.adv_sendmsg}</h4>
				{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
				<div class="customform">
					<form action="{VAC_CONTACT_FORM_ACTION}" method="post" name="msgform">
						<table class="table-bordered table">
							<tr>
								<td>{PHP.L.vac_contact_name}:</td>
								<td>{VAC_CONTACT_FORM_NAME}</td>
							</tr>
							<tr>
								<td>{PHP.L.vac_contact_email}:</td>
								<td>{VAC_CONTACT_FORM_EMAIL}</td>
							</tr>
							<tr>
								<td>{PHP.L.vac_contact_phone}:</td>
								<td>{VAC_CONTACT_FORM_PHONE}</td>
							</tr>
							<tr>
								<td>{PHP.L.vac_contact_msg}:</td>
								<td>{VAC_CONTACT_FORM_TEXT}</td>
							</tr>
							<tr>
								<td>{VAC_CONTACT_FORM_VERIFYIMG}</td>
								<td>{VAC_CONTACT_FORM_VERIFYINPUT} *</td>
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
			
			{VAC_COMMENTS_DISPLAY}

		</div>
		<div class="span3">
<!-- BEGIN: VAC_ADMIN -->
			<div class="well well-small">
				<h4>{PHP.L.Adminpanel}</h4>
				<ul class="bullets">
					<!-- IF {PHP.usr.isadmin} -->
					<li><a href="{PHP|cot_url('admin')}">{PHP.L.Adminpanel}</a></li>
					<!-- ENDIF -->
					<li><a href="{VAC_CAT|cot_url('vacancies','m=add&c=$this')}">{PHP.L.vac_addtitle}</a></li>
					<li>{VAC_ADMIN_UNVALIDATE}</li>
					<li>{VAC_ADMIN_EDIT}</li>
					<li>{VAC_ADMIN_CLONE}</li>
					<li>{VAC_ADMIN_DELETE}</li>
				</ul>
			</div>
<!-- END: VAC_ADMIN -->
		</div>
	</div>

<!-- END: MAIN -->