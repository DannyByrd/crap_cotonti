<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PHP.L.payfirmbold_buy_title}</div>

<div class="row">
	<div class="span9">
		{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
		<div class="customform">
			<form action="{PAY_FORM_ACTION}" method="post">
				<table class="table">
					<tr>
						<td width="220">{PHP.L.payfirmbold_costofday}:</td>
						<td>{PAY_FORM_COST} {PHP.cfg.plugin.payfirmbold.cost} {PHP.cfg.payments.valuta}</td>
					</tr>
					<tr>
						<td>{PHP.L.payfirmbold_error_days}:</td>
						<td>{PAY_FORM_PERIOD} {PHP.L.payfirmbold_day}</td>
					</tr>
					<tr>
						<td></td>
						<td><button class="btn btn-success">{PHP.L.payfirmbold_buy}</button></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>

<!-- END: MAIN -->