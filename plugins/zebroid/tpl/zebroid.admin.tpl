<!-- BEGIN: MAIN -->

        <h2>Заголовок 1</h2>
        {FILE "system/admin/tpl/warnings.tpl"}
            <h3>Настройки импорта:</h3>
            <form name="setsettings" id="setsettings" method="post" action="{ZI_FORM_ACTION_SETTINGS}" class="ajax">
                <table class="cells info">
                    <tr>
                        <td class="width20">Структyра:</td>
                        <td class="width80">{ZI_FORM_STRUCTRE_SELECT}</td>
                    </tr>
                    <tr>
                        <td class="width20">Категория структyры:</td>
                        <td class="width80">{ZI_FORM_STRUCTRE_CAT_SELECT}</td>
                    </tr>
                    <tr>
                        <td class="valid" colspan="2">
                            <button type="submit">Сохранить настройки</button>                            
                        </td>
                    </tr>
                    
                </table>
            </form>
            <br />
            <h3>Импорт:</h3>
            <div class="block">           
                <!--Import form-->
                <form  name="startimport" id="startimport" method="post" action="{ZI_FORM_ACTION_IMPORT}" enctype="multipart/form-data">
                    <table class="cells info">
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