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
                               <div class="col-lg-6">
                                    <div class="block">
                                        <h2 class="users">Пользователи</h2>
                                        <table class="cells">
                                            <tr>
                                                <td class="coltop" class="width5">{USERS_TOP_PM}</td>
                                                <td class="coltop" class="width20">{USERS_TOP_NAME}</td>
                                                <td class="coltop" class="width20">{USERS_TOP_GRPTITLE}</td>
                                                <td class="coltop" class="width15">{USERS_TOP_GRPLEVEL}</td>
                                                <td class="coltop" class="width15">{USERS_TOP_COUNTRY}</td>
                                                <td class="coltop" class="width25">{USERS_TOP_REGDATE}</td>
                                            </tr>
                                        <!-- BEGIN: USERS_ROW -->
                                            <tr>
                                                <td class="centerall">{USERS_ROW_PM}</td>
                                                <td>{USERS_ROW_NAME}&nbsp;{USERS_ROW_TAG}</td>
                                                <td>{USERS_ROW_MAINGRP}</td>
                                                <td class="centerall">{USERS_ROW_MAINGRPSTARS}</td>
                                                <td class="centerall">{USERS_ROW_COUNTRYFLAG} {USERS_ROW_COUNTRY}</td>
                                                <td class="centerall">{USERS_ROW_REGDATE}</td>
                                            </tr>
                                        <!-- END: USERS_ROW -->
                                        </table>
                                    </div>
                                </div>
                            
                                <div class="col-lg-6">
                                    <div class="block">
                                        <h2 class="prefs">{PHP.L.Filters}</h2>
                                        <form action="{USERS_TOP_FILTER_ACTION}" method="post">
                                            {USERS_TOP_FILTERS_COUNTRY}
                                            {USERS_TOP_FILTERS_MAINGROUP}
                                            {USERS_TOP_FILTERS_GROUP}
                                            {USERS_TOP_FILTERS_SEARCH}<br />
                                            <button type="submit" class="submit">{PHP.L.Submit}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="paging"><span>{PHP.L.users_usersperpage}: {USERS_TOP_MAXPERPAGE}</span><span>{PHP.L.users_usersinthissection}: {USERS_TOP_TOTALUSERS}</span>{USERS_TOP_PAGEPREV}{USERS_TOP_PAGNAV}{USERS_TOP_PAGENEXT}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: MAIN -->