<!-- BEGIN: MAIN -->
    <!-- BEGIN: LATESTNEWS_ROW -->
        <div class="note note-info">
            <h4 class="block" style="display: initial;"><a href="{LATESTNEWS_PAGE_URL}" title="{LATESTNEWS_PAGE_TITLE}">{LATESTNEWS_PAGE_TITLE}</a></h4>
            <p>
                <!-- IF {PHP.cot_plugins_active.mavatars} -->
                    <img style="margin: 10px 10px 0px 0px;" class="pull-left thumbnail" src="{LATESTNEWS_PAGE_MAVATAR.1|cot_mav_thumb($this, 70, 70)}"/>
               <!-- ENDIF -->
            </p>
            <p>
                {LATESTNEWS_PAGE_TEXT_CUT|cot_cutstring($this, 300)}
            </p>
            <p style="text-align: right;"><a href="{LATESTNEWS_PAGE_URL}" class="btn blue" style="padding:2px 10px;text-align: right; background:#6BB4C3;"> Далее <i class="fa  fa-angle-right"></i></a></p>
        </div>
    <!-- END: LATESTNEWS_ROW -->
<!-- END: MAIN -->


