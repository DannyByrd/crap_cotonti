<!-- BEGIN: MAIN -->
<div class="page-container">
   
   {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/sidebur.tpl"}
   
    <div class="page-content-wrapper">
		<div class="page-content">
           <div class="row">
               <div class="col-lg-9">
                    <div class="timeline">
                        <!-- BEGIN: LIST_ROW -->
                        <div class="timeline-item">
                            <div class="timeline-badge">
                                 <!-- IF {LIST_ROW_MAVATAR.1} -->
                                     <a href="{LIST_ROW_URL}"><img style="height: 75px;" class="timeline-badge-userpic" src="{LIST_ROW_MAVATAR.1.FILE}" /></a>	
                                 <!-- ENDIF -->
                            </div>
                            <div class="timeline-body">
                                <div class="timeline-body-arrow">
                                </div>
                                <div class="timeline-body-head">
                                    <div class="timeline-body-head-caption">
                                        <a href="{LIST_ROW_URL}" class="timeline-body-title font-blue-madison">{LIST_ROW_SHORTTITLE}</a>
                                    </div>
                                    <div class="timeline-body-head-actions">

                                        <p  style="float:right;display:block;cursor: auto;" class="btn btn-circle btn-xs green">
                                            {LIST_ROW_DATE_STAMP|cot_date('Y-m-d',$this)}
                                        </p>

                                    </div>
                                </div>
                                <div class="timeline-body-content">
                                    <span class="font-grey-cascade">
                                        {LIST_ROW_TEXT_CUT|cot_cutstring($this, 300)}
                                    </span>
                                    <!-- IF {LIST_ROW_COST} > 0 -->
                                        <span style="cursor: auto;" class="btn btn-circle btn-sm blue">{LIST_ROW_COST} {PHP.cfg.payments.valuta}</span>
                                    <!-- ENDIF -->
                                </div>
                            </div>
                        </div>
                        <!-- END: LIST_ROW -->
                    </div>
                    <!-- IF (!{PHP._GET.d}) -->
                        {LIST_ROW_CATDESC}
                    <!-- ENDIF -->
                </div>
                <div class="col-lg-3">
                   <h3 style="text-align:center;">Категории</h3>
                    <div class="block btn blue" style="width: 100%;">
                        <ul class="nav nav-pills nav-stacked">
                            {PHP.c|cot_build_structure_board_tree($this, 0)}
                        </ul>
                    </div>
                    <!-- IF {PHP.usr.auth_write} -->
                        <div style="margin-top:20px;text-align: right;"><a style="width: 100%;" class="btn btn-primary" href="{LIST_SUBMITNEWADV_URL}">{PHP.L.adv_submitnewadv}</a></div>
                    <!-- ELSE -->    
                        <div style="margin-top:20px;text-align: right;"><a style="width: 100%;" class="btn btn-primary" href="{PHP|cot_url('login')}">{PHP.L.adv_submitnewadv}</a></div>
                    <!-- ENDIF -->
                </div>
            </div>
        </div>
<!-- END: MAIN -->