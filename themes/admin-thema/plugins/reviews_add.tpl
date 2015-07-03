<!-- BEGIN: MAIN -->

      <div class="page-container">
   
    {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/sidebur.tpl"}
    
    <div class="page-content-wrapper">
		<div class="page-content">
            <div class="portlet light">
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-12">
                           
                            <div class="block" style="text-align:center;">
                                <h2 class="page">Добавить отзыв</h2>
                                {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
                                <form action="{PHP|cot_url('plug', 'e=reviews_add')}" enctype="multipart/form-data" method="post" name="pageaddingform">
                                    <table class="cells reviews-add" style="margin:0px auto;">
                                        <tr>
                                            <td>Тема отзыва:</td>
                                            <td>{REVIEWS_FORM_TITLE}</td>
                                        </tr>
                                        <tr>
                                            <td>Текст сообщения:</td>
                                            <td>{REVIEWS_FORM_DESC}</td>
                                        </tr>

                                        <tr>
                                            <td>Ваше фото:</td>
                                            <td class="mavatar-img">{REVIEWS_FORM_MAVATAR}</td>
                                        </tr>
                                        <tr>
                                           <td></td>
                                            <td colspan="2" class="valid">
                                                <button type="submit" name="rpagestate" value="1" class="margin-top-20 btn blue">Отправить</button>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- IF {DONE_ROW_MSG} -->
    <script>
        setTimeout(function(){
            window.location.href='/{PHP|cot_url('page','c=reviews')}';
        }, 3000);
    </script>
<!-- ENDIF -->

<!-- END: MAIN -->