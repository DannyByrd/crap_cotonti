<!-- BEGIN: MAIN -->
<div class="page-container">

    {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/sidebur.tpl"}

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-basket font-green-sharp"></i>
                                <span class="caption-subject font-green-sharp bold uppercase">
                                    <!-- IF {PHP.cfg.payments.balance_enabled} -->
                                        {BALANCE_SUMM|number_format($this, '2', '.', ' ')} {PHP.cfg.payments.valuta}
                                    <!-- ENDIF -->
                                </span>
                            </div>
                        </div>

                        <div class="portlet-body">
                            <div class="tabbable">
    <!--Навигация-->
                                        <ul class="nav nav-tabs nav-tabs-lg">
                                            <li<!-- IF {PHP.n} == 'history' --> class="active"<!-- ENDIF -->><a href="{BALANCE_HISTORY_URL}">{PHP.L.payments_history}</a></li>
                                            <!-- IF {PHP.cfg.payments.balance_enabled} -->
                                            <li<!-- IF {PHP.n} == 'billing' --> class="active"<!-- ENDIF -->><a href="{BALANCE_BILLING_URL}">{PHP.L.payments_paytobalance}</a></li>
                                            <!-- IF {PHP.cfg.payments.payouts_enabled} -->
                                            <li<!-- IF {PHP.n} == 'payouts' --> class="active"<!-- ENDIF -->><a href="{BALANCE_PAYOUT_URL}">{PHP.L.payments_payouts}</a></li>
                                            <!-- ENDIF -->
                                            <!-- IF {PHP.cfg.payments.transfers_enabled} -->
                                            <li<!-- IF {PHP.n} == 'transfer' --> class="active"<!-- ENDIF -->><a href="{BALANCE_TRANSFER_URL}">{PHP.L.payments_transfer}</a></li>
                                            <!-- ENDIF -->
                                            <!-- ENDIF -->
                                        </ul>



                                <div class="tab-content">
     <!--Пополнить счет-->
                                        <!-- BEGIN: BILLINGFORM -->
                                                <div class="tab-content no-space">
                                                    <div class="tab-pane active" id="tab_general">
                                                        <div class="form-body">
                                                            {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
                                                            <form action="{BALANCE_FORM_ACTION_URL}" method="post">

                                                                <div class="form-group">
                                                                    <label class="col-md-3 control-label">{PHP.L.payments_balance_billing_summ} ({PHP.cfg.payments.valuta}): </label>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" type="text" name="summ" size="5" value="{BALANCE_FORM_SUMM}"/>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-md-3 control-label"></label>
                                                                    <div class="col-md-9" style="padding-top: 10px;">
                                                                        <button class="btn btn-success">{PHP.L.payments_paytobalance}</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                        <!-- END: BILLINGFORM -->

                                        <!-- BEGIN: PAYOUTS -->
                                        <a class="pull-right btn btn-success" href="{PHP|cot_url('payments', 'm=balance&n=payouts&a=add')}">{PHP.L.payments_balance_payouts_button}</a>
                                        <h5>{PHP.L.payments_balance_payout_list}</h5>
                                        <table class="table">
                                            <!-- BEGIN: PAYOUT_ROW -->
                                            <tr>
                                                <td>{PAYOUT_ROW_ID}</td>
                                                <td>{PAYOUT_ROW_CDATE|cot_date('d.m.Y H:i', $this)}</td>
                                                <td style="text-align: right;">{PAYOUT_ROW_SUMM|number_format($this, '2', '.', ' ')} {PHP.cfg.payments.valuta}</td>
                                                <td><!-- IF {PAYOUT_ROW_DATE} > 0 -->{PAYOUT_ROW_DATE|cot_date('d.m.Y H:i', $this)}<!-- ELSE -->{PHP.L.No}<!-- ENDIF --></td>
                                            </tr>
                                            <!-- END: PAYOUT_ROW -->
                                        </table>
                                        <!-- END: PAYOUTS -->



                                        <!-- BEGIN: PAYOUTFORM -->
                                        <h5 class="vuvod">{PHP.L.payments_balance_payout_title}</h5>
                                        {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
                                        <form action="{PAYOUT_FORM_ACTION_URL}" method="post" id="payoutform">
                                            <table class="customform redactor-style zayavka-na">
                                                <tr>
                                                    <td class="width30"><p>{PHP.L.payments_balance_payout_details}:</p></td>
                                                    <td><textarea name="details" rows="5" cols="40">{PAYOUT_FORM_DETAILS}</textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="width30"><p>{PHP.L.payments_balance_payout_summ}:</p></td>
                                                    <td>{PAYOUT_FORM_SUMM} <span style="display: block;padding-top: 5px;">{PHP.cfg.payments.valuta}</span></td>
                                                </tr>
                                                <!-- IF {PHP.cfg.payments.payouttax} > 0 -->
                                                <tr>
                                                    <td class="width30">{PHP.L.payments_balance_payout_tax} ({PHP.cfg.payments.payouttax}%):</td>
                                                    <td><span id="payout_tax">{PAYOUT_FORM_TAX}</span> {PHP.cfg.payments.valuta}</td>
                                                </tr>
                                                <tr>
                                                    <td class="width30">{PHP.L.payments_balance_payout_total}:</td>
                                                    <td><span id="payout_total">{PAYOUT_FORM_TOTAL}</span> {PHP.cfg.payments.valuta}</td>
                                                </tr>
                                                <!-- ENDIF -->
                                                <tr>
                                                    <td class="width30"></td>
                                                    <td><button class="btn btn-success">{PHP.L.Submit}</button></td>
                                                </tr>
                                            </table>
                                        </form>

                                        <!-- IF {PHP.cfg.payments.payouttax} > 0 -->
                                        <script>
                                            $().ready(function() {
                                                $('#payoutform').bind('change click keyup', function (){
                                                    var summ = parseFloat($("input[name='summ']").val());
                                                    var tax = parseFloat({PHP.cfg.payments.payouttax});

                                                    if(isNaN(summ)) summ = 0;

                                                    var taxsumm = summ*tax/100;
                                                    var totalsumm = summ + taxsumm;

                                                    $('#payout_tax').html(taxsumm);
                                                    $('#payout_total').html(totalsumm);
                                                });
                                            });
                                        </script>
                                        <!-- ENDIF -->
                                        <!-- END: PAYOUTFORM -->



               <!--Перевод пользователю-->
                                        <!-- BEGIN: TRANSFERFORM -->
                                            <div class="tab-content no-space">
                                                <div class="tab-pane active" id="tab_general">
                                                    <div class="form-body">
                                                        {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
                                                        <form action="{TRANSFER_FORM_ACTION_URL}" method="post" id="transferform">
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">{PHP.L.payments_balance_transfer_comment}: <span class="required">* </span></label>
                                                                <div class="col-md-9">
                                                                    <textarea class="form-control" name="comment" rows="5" cols="40">{TRANSFER_FORM_COMMENT}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label" style="padding-top: 10px;">{PHP.L.payments_balance_transfer_username}:<span class="required">* </span></label>
                                                                <div class="col-md-9" style="padding-top: 10px;">
                                                                    <input type="text" class="form-control" name="username" value="{TRANSFER_FORM_USERNAME}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label" style="padding-top: 10px;">{PHP.L.payments_balance_transfer_summ}:({PHP.cfg.payments.valuta})<span class="required">* </span></label>
                                                                <div class="col-md-9" style="padding-top: 10px;">
                                                                    {TRANSFER_FORM_SUMM}
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <!-- IF {PHP.cfg.payments.transfertax} > 0 AND !{PHP.cfg.payments.transfertaxfromrecipient} -->
                                                                <tr>
                                                                    <td class="width30">{PHP.L.payments_balance_transfer_tax} ({PHP.cfg.payments.transfertax}%):</td>
                                                                    <td><span id="transfer_tax">{TRANSFER_FORM_TAX}</span> {PHP.cfg.payments.valuta}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="width30">{PHP.L.payments_balance_transfer_total}:</td>
                                                                    <td>
                                                                        <span id="transfer_total">{TRANSFER_FORM_TOTAL}</span> {PHP.cfg.payments.valuta}

                                                                        <script>
                                                                            $().ready(function() {
                                                                                $('#transferform').bind('change click keyup', function (){
                                                                                    var summ = parseFloat($("input[name='summ']").val());
                                                                                    var tax = parseFloat({PHP.cfg.payments.transfertax});

                                                                                    if(isNaN(summ)) summ = 0;

                                                                                    var taxsumm = summ*tax/100;
                                                                                    var totalsumm = summ + taxsumm;

                                                                                    $('#transfer_tax').html(taxsumm);
                                                                                    $('#transfer_total').html(totalsumm);
                                                                                });
                                                                            });
                                                                        </script>

                                                                    </td>
                                                                </tr>
                                                                <!-- ENDIF -->
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label" style="padding-top: 10px;"></label>
                                                                <div class="col-md-9" style="padding-top: 10px;">
                                                                    <button class="btn btn-success">{PHP.L.Submit}</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- END: TRANSFERFORM -->







            <!--Вывод истории-->
                                    <!-- BEGIN: HISTORY -->
                                        <div class="tab-pane active">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="portlet grey-cascade box">
                                                        <div class="portlet-title">
                                                            <div class="caption">
                                                                <i class="fa fa-cogs"></i>{PHP.L.payments_history}
                                                            </div>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover table-bordered table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th></th>
                                                                        <th>Дата</th>
                                                                        <th>Операция</th>
                                                                        <th>Отчет</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <!-- BEGIN: HIST_ROW -->
                                                                        <tr>
                                                                            <td>{HIST_ROW_ID}</td>
                                                                            <td><!-- IF {HIST_ROW_AREA} == 'balance' -->+<!-- ELSE -->-<!-- ENDIF --></td>
                                                                            <td>{HIST_ROW_PDATE|cot_date('d.m.Y H:i', $this)}</td>
                                                                            <td>{HIST_ROW_DESC}</td>
                                                                            <td>{HIST_ROW_SUMM|number_format($this, '2', '.', ' ')} {PHP.cfg.payments.valuta}</td>
                                                                        </tr>
                                                                        <!-- END: HIST_ROW -->
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- END: HISTORY -->

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