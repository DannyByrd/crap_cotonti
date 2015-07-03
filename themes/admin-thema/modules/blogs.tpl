<!-- BEGIN: MAIN -->
<div class="page-container">
   
   {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/sidebur.tpl"}
   
    <div class="page-content-wrapper">
		<div class="page-content">
            <div class="portlet light">
				<div class="portlet-body">
					<div class="row">
					    <div class="col-md-12 blog-page">
							<div class="row">
							    <div class="<!-- IF {PHP.usr.auth_write} -->col-md-9<!-- ELSE -->col-md-12<!-- ENDIF --> article-block">

                                        <div class="breadcrumb">{POST_TITLE}</div>
                                        <div class="row">
                                            <div class="span9">
                                                <h1>{POST_SHORTTITLE}</h1>

                                                <a style="margin: 0px 15px 10px 0px;" class="pull-left thumbnail" href="{POST_OWNER_DETAILSLINK}">
                                                    <img style="width:100px; height:100px;" src="<!-- IF {POST_OWNER_AVATAR_SRC} -->{POST_OWNER_AVATAR_SRC}<!-- ELSE -->datas/defaultav/blank.png<!-- ENDIF -->" class="avatar" alt="" />
                                                </a>
                                                <div class="media-body">
                                                    <p>{POST_OWNER_NAME}</p>
                                                    <p class="small date">{POST_DATE}</p>
                                                </div>

                                                {POST_TEXT}

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