<!-- BEGIN: MAIN -->
<div class="page-container" style="margin-top:70px;">
    {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/sidebur.tpl"}

<div class="page-content-wrapper">
		<div class="page-content">
			
			<div class="portlet light">
                <div class="page-head">
                    <div class="page-title">
                        <h1>Связаться С Нами</h1>
                    </div>
                </div>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href="index.html">{PHP.L.breadcrumbmaintitle}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Контакты</span>
                    </li>
                </ul>
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="gmaps margin-bottom-40" style="height:400px;">
								
								    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1373.913526200921!2d30.737607093237525!3d46.47193357867792!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40c63183aae72a2d%3A0xc5628b67a6500058!2z0JrQsNGC0LXRgNC40L3QuNC90YHRjNC60LAg0LLRg9C7LiwgODUsINCe0LTQtdGB0LAsINCe0LTQtdGB0YzQutCwINC-0LHQu9Cw0YHRgtGM!5e0!3m2!1sru!2sua!4v1428176379188" width="100%" height="400" frameborder="0" style="border:0"></iframe>
								
								</div>
							</div>
							<div class="row margin-bottom-20" style="margin-top:25px;">
							{FILE "{PHP.cfg.themes_dir}/{PHP.usr.theme}/warnings.tpl"}
                            
								<div class="col-md-6">
									<div class="space20">
									</div>
									<h3 class="form-section">Контакты</h3>
									<p>
										 Lorem ipsum dolor sit amet, Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat consectetuer adipiscing elit.
									</p>
									<div class="well">
										<h4>Address</h4>
										<address>
                                           Улица: {PHP.L.address}<br>
										    <abbr title="Phone">Телефон:</abbr>
										    {PHP.L.telephone}
								        </address>
										<address>
										<strong>E-mail</strong><br>
										<a href="mailto:{PHP.L.email}">
										    {PHP.L.email}
                                        </a>
										</address>
										<ul class="social-icons margin-bottom-10">
											<li>
												<a href="#" data-original-title="facebook" class="facebook">
												</a>
											</li>
											<li>
												<a href="#" data-original-title="github" class="github">
												</a>
											</li>
											<li>
												<a href="#" data-original-title="Goole Plus" class="googleplus">
												</a>
											</li>
											<li>
												<a href="#" data-original-title="linkedin" class="linkedin">
												</a>
											</li>
											<li>
												<a href="#" data-original-title="rss" class="rss">
												</a>
											</li>
											<li>
												<a href="#" data-original-title="skype" class="skype">
												</a>
											</li>
											<li>
												<a href="#" data-original-title="twitter" class="twitter">
												</a>
											</li>
											<li>
												<a href="#" data-original-title="youtube" class="youtube">
												</a>
											</li>
										</ul>
									</div>
								</div>
								<div class="col-md-6">
									<div class="space20">
									</div>
									
									
									<!-- IF {PHP.cfg.plugin.contact.about} -->
                                        <p>{PHP.cfg.plugin.contact.about}</p>
                                        <!-- ENDIF -->
                                        <!-- IF {PHP.cfg.plugin.contact.map} -->
                                        <p>{PHP.cfg.plugin.contact.map}</p>
                                    <!-- ENDIF -->
                                    
									<!-- BEGIN: FORM -->
									<form action="{CONTACT_FORM_SEND}" method="post" name="contact_form" enctype="multipart/form-data">
										<h3 class="form-section">Обратная Связь</h3>
										<p>
											 Lorem ipsum dolor sit amet, Ut wisi enim ad minim veniam, quis nostrud exerci. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat consectetuer
										</p>
										<div class="form-group">
											<div class="input-icon">
												<i class="fa fa-check"></i>
												{CONTACT_FORM_SUBJECT}
											</div>
										</div>
										<div class="form-group">
											<div class="input-icon">
												<i class="fa fa-user"></i>
												{CONTACT_FORM_AUTHOR}
											</div>
										</div>
										<div class="form-group">
											<div class="input-icon">
												<i class="fa fa-envelope"></i>
												{CONTACT_FORM_EMAIL}
											</div>
										</div>
										<div class="form-group">
											{CONTACT_FORM_TEXT}
										</div>
										<button type="submit" class="mi-submit btn green">{PHP.L.Submit}</button>
									</form>
									<!-- END: FORM -->
									
									
									
									
									
									
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- END: MAIN -->






<div class="col">
			<div class="block">
				<h2 class="message"><a href="{PHP|cot_url('plug','e=contact')}">{PHP.L.contact_title}</a></h2>
				<!-- IF {PHP.cfg.plugin.contact.about} -->
				<p>{PHP.cfg.plugin.contact.about}</p>
				<!-- ENDIF -->
				<!-- IF {PHP.cfg.plugin.contact.map} -->
				<p>{PHP.cfg.plugin.contact.map}</p>
				<!-- ENDIF -->
				{FILE "{PHP.cfg.themes_dir}/{PHP.usr.theme}/warnings.tpl"}
				<div class="mi-alert"></div>
<!-- BEGIN: FORM -->
				<form action="{CONTACT_FORM_SEND}" method="post" name="contact_form" enctype="multipart/form-data" class="mi-form mi-no-submit">
					<table class="flat">
						<tr>
							<td class="width25">{PHP.L.Username}:</td>
							<td class="width75">{CONTACT_FORM_AUTHOR}</td>
						</tr>
						<tr>
							<td>{PHP.L.Email}:</td>
							<td>{CONTACT_FORM_EMAIL} </td>
						</tr>
						<tr>
							<td>{PHP.L.Subject}:</td>
							<td>{CONTACT_FORM_SUBJECT}</td>
						</tr>
						<tr>
							<td>{PHP.L.Message}:</td>
							<td>{CONTACT_FORM_TEXT}</td>
						</tr>
<!-- BEGIN: EXTRAFLD -->
						<tr>
							<td>{CONTACT_FORM_EXTRAFLD_TITLE}:</td>
							<td>{CONTACT_FORM_EXTRAFLD}</td>
						</tr>
<!-- END: EXTRAFLD -->
<!-- BEGIN: CAPTCHA -->
						<tr>
							<td>{CONTACT_FORM_VERIFY_IMG}</td>
							<td>{CONTACT_FORM_VERIFY}</td>
						</tr>
<!-- END: CAPTCHA -->
						<tr>
							<td>&nbsp;</td>
							<td><button class="mi-submit" type="submit">{PHP.L.Submit}</button></td>
						</tr>
					</table>
				</form>
<!-- END: FORM -->
			</div>
		</div>