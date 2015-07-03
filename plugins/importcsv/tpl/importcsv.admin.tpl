<!-- BEGIN: MAIN -->
        <h2>Импорт CSV файла</h2>
        {FILE "system/admin/tpl/warnings.tpl"}
           
            <div class="block">           
            <form name="setsettings" id="setsettings" method="post" action="{ICSV_FORM_ACTION_SETTINGS}" class="ajax">
                <table class="cells info">
                	<tr>
                        <td class="coltop" colspan="2">Настройки импорта:</td>
                    </tr>
                    <tr>
                        <td class="width20">Модуль:</td>
                        <td class="width80">{ICSV_FORM_STRUCTRE_SELECT}</td>
                    </tr>
                    <tr>
                        <td class="width20">Категория:</td>
                        <td class="width80">{ICSV_FORM_STRUCTRE_CAT_SELECT}</td>
                    </tr>
                    <tr>
                        <td class="valid" colspan="2">
                            <button type="submit">Сохранить настройки</button>                            
                        </td>
                    </tr>
                    
                </table>
            </form>
            </div>
            <br />
            <div class="block">           
                <!--Import form-->
                <form  name="startimport" id="startimport" method="post" action="{ICSV_FORM_ACTION_IMPORT}" enctype="multipart/form-data">
                    <table class="cells info">
                	<tr>
                        <td class="coltop" colspan="2">Импорт:</td>
                    </tr>
                        <tr>
                            <td class="width20">Файл на комьютере:</td>
                            <td class="width80"><input name="uploadedfile" type="file" size="50" /></td>
                        </tr>
                        <tr>
                            <td class="valid" colspan="2">
                                <button type="submit">Начать импорт</button>                            
                            </td>
                        </tr>
                    </table>
                </form>
                <hr />
            </div>
<!-- END: MAIN -->