<!-- BEGIN: MAIN -->
<div class="page-container">

   
    {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/sidebur.tpl"}

  
  <div class="page-content-wrapper">
  <div class="page-content">
   <div class="page-head">
       <div class="row">
          
<!--Вывод новостей-->
           <div class="col-md-6">
                <div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-bullhorn font-red-sunglo"></i>
								<span class="caption-subject font-red-sunglo bold uppercase"><a href="{PHP|cot_url('page', 'c=news')}">{PHP.L.pages}</a></span>
							</div>
						</div>
						<div class="portlet-body">
                           <!-- IF {INDEX_NEWS} -->
                                 {INDEX_NEWS}
                           <!-- ENDIF -->
						</div>
						
						
					</div>
           </div>
           
           
           
<!--Вывод продуктов-->      
           <div class="col-md-6">
                <div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-legal font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase"><a style="color: #4DB3A2 !important;" href="{PHP|cot_url('products')}">{PHP.L.products}</a></span>
							</div>
						</div>
						<div class="portlet-body">
                           <!-- IF {PHP.cot_modules.products} -->
                               {PHP|cot_products_list(3)}
                           <!-- ENDIF -->
						</div>
					</div>
           </div>
           
<!--Вывод Вакансий-->  
              <div class="col-md-6">
                   <div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cubes"></i><a style="color: #fff !important;" href="{PHP|cot_url('products')}">{PHP.L.vacancies}</a>
							</div>
						</div>
						<div class="portlet-body">
							<!-- IF {PHP.cot_modules.vacancies} -->
                                {PHP|cot_vacancies_list(3)}
                            <!-- ENDIF -->
						</div>
                  </div>
              </div>
              
<!--Вывод Новостей в sidebar-->   
              <div class="col-md-6" style="margin-top: -275px;">
                   <div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cubes"></i><a style="color: #fff !important;" href="{PHP|cot_url('page')}">{PHP.L.sidebar} - Новости</a>
							</div>
						</div>
						<div class="portlet-body">
							<!-- IF {PHP.cot_plugins_active.latestnews} <-->
							    <h1>ffffffffffffffff</h1>
							</-->
                            {PHP|cot_show_latestnews(3)}
                            <!-- ENDIF -->
						</div>
                  </div>
              </div>
              
<!--Вывод Объявлений в sidebar-->   
              <div class="col-md-6">
                   <div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cubes"></i><a style="color: #fff !important;" href="{PHP|cot_url('page')}">{PHP.L.sidebar} - Объявления</a>
							</div>
						</div>
						<div class="portlet-body">
							<!-- IF {PHP.cot_plugins_active.latestnews} -->
                                {PHP|cot_show_latestnews(3,board)}
                            <!-- ENDIF -->
						</div>
                  </div>
              </div>
<!--Вывод Продуктов в sidebar-->   
              <div class="col-md-6" style="margin-top: -275px;">
                   <div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cubes"></i><a style="color: #fff !important;" href="{PHP|cot_url('page')}">{PHP.L.sidebar} - Продукты</a>
							</div>
						</div>
						<div class="portlet-body">
							<!-- IF {PHP.cot_plugins_active.latestnews} -->
                                {PHP|cot_show_latestnews(3,products)}
                            <!-- ENDIF -->
						</div>
                  </div>
              </div>
<!--Вывод Фирм в sidebar-->   
              <div class="col-md-6">
                   <div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cubes"></i><a style="color: #fff !important;" href="{PHP|cot_url('page')}">{PHP.L.sidebar} - Фирмы</a>
							</div>
						</div>
						<div class="portlet-body">
							<!-- IF {PHP.cot_plugins_active.latestnews} -->
                                {PHP|cot_show_latestnews(3,firms)}
                            <!-- ENDIF -->
						</div>
                  </div>
              </div>
<!--Вывод Афиш в sidebar-->   
              <div class="col-md-6" style="margin-top: -75px;">
                   <div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cubes"></i><a style="color: #fff !important;" href="{PHP|cot_url('page')}">{PHP.L.sidebar} - Афиши</a>
							</div>
						</div>
						<div class="portlet-body">
							<!-- IF {PHP.cot_plugins_active.latestnews} -->
                                {PHP|cot_show_latestnews(3,afisha)}
                            <!-- ENDIF -->
						</div>
                  </div>
              </div>
<!--Вывод Резюме в sidebar-->   
              <div class="col-md-6">
                   <div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cubes"></i><a style="color: #fff !important;" href="{PHP|cot_url('page')}">{PHP.L.sidebar} - Резюме</a>
							</div>
						</div>
						<div class="portlet-body">
							<!-- IF {PHP.cot_plugins_active.latestnews} -->
                                {PHP|cot_show_latestnews(3,rezume)}
                            <!-- ENDIF -->
						</div>
                  </div>
              </div>
      
      
      
       </div>
      </div>
      </div>
      </div>
</div>
	
<!-- END: MAIN -->

{PHP|cot_build_structure_page_tree('', 0, 'index',3)}
