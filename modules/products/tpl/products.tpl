<!-- BEGIN: MAIN -->

	<div class="breadcrumb">{PRD_TITLE}</div>
	<!-- IF {PHP.cot_plugins_active.latestnews} -->
     {PHP|cot_show_latestnews(3,vacancies)}
     <h3>hm... end?</h3>
     <!-- ENDIF -->
	<div class="row">

	
		<div class="span3">
		<h2>LOL WHAT ?</h2>
			{PHP|cot_build_structure_products_tree($this,0, 0)}

		</div>
		<div class="span9">
			<!-- IF {PRD_COST} --><div class="pull-right"><br/><span class="label label-success large">{PRD_COST|cot_products_costformat($this)} {PHP.L.valuta}</span></div><!-- ENDIF -->
			<h1>{PRD_SHORTTITLE}</h1>
			{PRD_QUICKORDER_BUTTON}
			
			<p class="small"><i class="icon-time"></i> {PRD_DATE} <!-- IF {PRD_STATUS} == 'expired' --><i class="label">{PRD_LOCALSTATUS}</i><!-- ENDIF --></p>
			<!-- IF {PRD_DESC} --><p class="small">{PRD_DESC}</p><!-- ENDIF -->
			
			<!-- IF {PRD_MAVATAR} -->
			
			<div class="pull-left marginright10">
				<!-- IF {PRD_MAVATAR.1} -->
				<a href="{PRD_MAVATAR.1.FILE}"><div class="thumbnail"><img src="{PRD_MAVATAR.1|cot_mav_thumb($this, 200, 200, width)}" /></div></a>
				<!-- ENDIF -->

				<!-- IF {PRD_MAVATARCOUNT} -->
				<p>&nbsp;</p>
				<div class="row">
					<!-- FOR {KEY}, {VALUE} IN {PRD_MAVATAR} -->
					<!-- IF {KEY} != 1 -->
					<a href="{VALUE.FILE}" class="span1 pull-left"><img src="{VALUE|cot_mav_thumb($this, 100, 100)}" /></a>
					<!-- ENDIF -->
					<!-- ENDFOR -->
				</div>
				<!-- ENDIF -->
			</div>	
			<!-- ENDIF -->

			{PRD_TEXT}

			<!-- IF {PHP.cot_plugins_active.simpleorders} -->
			<div class="pull-right">
				<form class="ajax_form" method="POST" action="{PHP|cot_url('plug', 'r=simpleorders')}">
					
					<input type="hidden" name="title" value="{PRD_SHORTTITLE}">
					<input type="hidden" name="action" value="cartpopup.add">

					<input type="number" name="quantity" value="1" class="input-mini">

					<button class="btn btn-primary" type="submit">В корзину</button>
					
					<div class="simpleorders-form-success"></div>
				</form>
			</div>
				<!-- ENDIF -->
			
			{PRD_COMMENTS_DISPLAY}

		</div>
		<div class="span3">
			
			<div class="well well-small">
				<h4>{PHP.L.prd_seller}</h4>
				<div class="media">
					<div class="pull-left">{PRD_OWNER_AVATAR}</div>
					<div class="media-body">
						<h4 class="media-heading">{PRD_OWNER_NAME}</h4>
					</div>	
				</div>	
			</div>
				
<!-- BEGIN: PRD_ADMIN -->
			<div class="well well-small">
				<h4>{PHP.L.Adminpanel}</h4>
				<ul class="nav">
					<!-- IF {PHP.usr.isadmin} -->
					<li><a href="{PHP|cot_url('admin')}">{PHP.L.Adminpanel}</a></li>
					<!-- ENDIF -->
					<li><a href="{PRD_CAT|cot_url('products','m=add&c=$this')}">{PHP.L.prd_addtitle}</a></li>
					<li>{PRD_ADMIN_UNVALIDATE}</li>
					<li>{PRD_ADMIN_EDIT}</li>
					<li>{PRD_ADMIN_CLONE}</li>
					<li>{PRD_ADMIN_DELETE}</li>
				</ul>
			</div>
<!-- END: PRD_ADMIN -->
		</div>
	</div>

<!-- END: MAIN -->