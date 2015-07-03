<!-- BEGIN: MAIN -->
    <!-- BEGIN: PRD_ROW -->
            <div class="note note-info">
                <h4 class="block" style="display: initial;"><a href="{PRD_ROW_URL}" title="{PRD_ROW_SHORTTITLE}">{PRD_ROW_SHORTTITLE}</a></h4>
                   <span class="badge badge-success" style="float:right;">
                       <!-- IF {PRD_ROW_COST} > 0 -->
                            {PRD_ROW_COST|cot_products_costformat($this)} {PHP.L.valuta}
                        <!-- ENDIF -->
                   </span>
                    <p>
                        <!-- IF {PRD_ROW_MAVATAR.1} -->
                            <a style="margin: 10px 10px 0px 0px;" class="pull-left thumbnail" href="{PRD_ROW_URL}"><img src="{PRD_ROW_MAVATAR.1|cot_mav_thumb($this, 70, 70)}" /></a>	
                        <!-- ENDIF -->
                    </p>
                    <p>
                        {PRD_ROW_TEXT_CUT|cot_cutstring($this, 300)}
                    </p>
                    <p style="text-align: right;"><a href="{PRD_ROW_URL}" class="btn blue" style="padding:2px 10px;text-align: right; background:#6BB4C3;"> Далее <i class="fa  fa-angle-right"></i></a></p>
            </div>
    <!-- END: PRD_ROW -->
<!-- END: MAIN -->