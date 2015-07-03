<!-- BEGIN: MAIN -->

        <div class="block">
            <h2 class="page">Добавить отзыв</h2>
            {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
            <form action="{PHP|cot_url('plug', 'e=reviews_add')}" enctype="multipart/form-data" method="post" name="pageaddingform">
                <table class="cells">
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
                        <td>{REVIEWS_FORM_MAVATAR}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="valid">
                            <button type="submit" name="rpagestate" value="1" class="submit">Отправить</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

<!-- END: MAIN -->