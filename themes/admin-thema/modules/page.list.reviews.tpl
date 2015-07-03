<!-- BEGIN: MAIN -->
<div class="page-container">
   
    {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/sidebur.tpl"}
    
    <div class="page-content-wrapper">
		<div class="page-content">
            <div class="portlet light">
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-12">
                           <ul class="timeline">
                                <!-- BEGIN: LIST_ROW -->
                                    <li class="timeline-blue">
                                        <div class="timeline-time">
                                            <span class="date">
                                            {LIST_ROW_DATE_STAMP|cot_date('Y-m-d',$this)}</span>
                                            <span class="time">
                                            {LIST_ROW_DATE_STAMP|cot_date('H:i',$this)}</span>
                                        </div>
                                        <div class="timeline-icon" style="padding-top: 10px;">
                                            <i class="fa fa-comments"></i>
                                        </div>
                                        <div class="timeline-body">
                                            <h2>{LIST_ROW_SHORTTITLE}</h2>
                                            <div class="timeline-content">
                                                <!-- IF {LIST_ROW_MAVATAR.1} -->
                                                    <a href="{LIST_ROW_URL}"><img class="timeline-img pull-right" src="{LIST_ROW_MAVATAR.1.FILE}" /></a>	
                                                <!-- ENDIF -->
                                                
                                                {LIST_ROW_TEXT_CUT|cot_cutstring($this, 300)} <br>
                                            </div>
                                            <div class="timeline-footer">
                                                <a href="{LIST_ROW_URL}" class="btn green">
                                                    Читать далее <i class="m-icon-swapright m-icon-white"></i>
                                                </a>
										    </div>
                                        </div>
                                    </li>
                                <!-- END: LIST_ROW -->
                            </ul>
                       
                            <div class="timeline-footer">
								<a href="/index.php?e=reviews_add" class="btn blue">
									Добавить отзыв <i class="m-icon-swapright m-icon-white"></i>
								</a>
							</div>
                       
                       
                        <div class="pagination-style">
                            <ul class="pagination pull-right">
								{LIST_TOP_PAGEPREV}{LIST_TOP_PAGINATION}{LIST_TOP_PAGENEXT}
							</ul>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- END: MAIN -->











