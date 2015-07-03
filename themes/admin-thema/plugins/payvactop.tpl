<!-- BEGIN: MAIN -->
<div class="page-container">
    <div class="row">
        <div class="col-md-6 col-sm-12 col-md-offset-3">
            <div class="portlet red-sunglo box" style="margin-bottom: -2px !important;">
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-cogs"></i>{PHP.L.payvactop_buy_title}</div>
                </div>
            </div>
		{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
			<form action="{PAY_FORM_ACTION}" method="post" style="padding: 25px 10px; background: #B5B4B4;">
                <div class="portlet-body">
                    <div class="row static-info">
                        <div class="col-md-5 name">{PHP.L.payvactop_costofday}:</div>
                        <div class="col-md-7 value">{PAY_FORM_COST} {PHP.cfg.plugin.payvactop.cost} {PHP.cfg.payments.valuta}</div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-5 name">{PHP.L.payvactop_error_days}:</div>
                        <div class="col-md-7 value">{PAY_FORM_PERIOD} {PHP.L.payvactop_day}</div>
                        <div class="row static-info">
                            <div class="col-md-5 name"></div>
                            <div class="col-md-7 value"><button class="btn btn-success">{PHP.L.payvactop_buy}</button></div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
<!-- END: MAIN -->