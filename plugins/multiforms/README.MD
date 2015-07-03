# Для отображения формы:
    <!-- IF {PHP.cot_plugins_active.multiforms} -->
        {PHP|cot_multiforms_show_form('test-form')}
    <!-- ENDIF -->


# Как называть файлы
Сдесь 'test-form' - это id формы. Он используется в оприделении tpl файла, в котором содержится html формы. Соотвественно tpl файл надо назвать multiforms.form.test-form.tpl. Если бы у нас if формы был бы 'cool_form', то и tpl файл бы назывался multiforms.form.cool_form.tpl.

Обработчики формы. inc/multiforms.handler.default.php - обработчик по умолчанию. От отсылает все заполненные поля по email. Так же можно подключть и свой обработчик. Для этого надо его назвать multiforms.handler.your-form-id.php


# Ланги
Используются в дефольтном обработчике при названии лейблов для отправляемых данных. Например:
        $L['multiforms_email_filed_my_name'] = 'Имя: ';
        $L['multiforms_email_filed_text'] = 'Текст: ';
Это ланги для полей 'my_name' и 'text'.


# Форма-пример:
        Тестовая форма
        <form id="multiforms-{MULTIFORMS_FORM_ID}" method="post" action="{MULTIFORMS_FORM_ACTION}" class="ajax">
            <div id="ajaxBlock"></div>
            <input type="text" name="multiforms[my_name]" value="">
            <textarea name="multiforms[text]"></textarea>
            {MULTIFORMS_FORM_ID_HIDDEN}
            <button type="submit">Отправить</button>
        </form>


# Форма-пример c файлами для атача на емайл:
    <div class="block">
        Тестовая форма
        <form id="multiforms-{MULTIFORMS_FORM_ID}" method="post" action="{MULTIFORMS_FORM_ACTION}" enctype="multipart/form-data">
        <div id="ajaxBlock">
            <! - Здесь идет обычное содержимое на странице ->
        </div>
            <input type="text" name="multiforms[my_name]" value="">
            <textarea name="multiforms[text]"></textarea>
            <input type="file" name="multiforms_files[]">
            {MULTIFORMS_FORM_ID_HIDDEN}
            <button type="submit">Отправить</button>
        </form>
    </div>
    
    Тут тег <input type="file" name="multiforms_files[]"> можно дублироват столько, сколько файлов вы хотите получать по е-mail.


# Для ajax-овой отправки 
Для того, чтобы форма работала ajax-ово на сайте должен присутствовать 
ВНИМАНЕЕ!!! Файл атачить к емайлу можно только не через ajax!!!!
<script type="text/javascript" src="js/base.js"></script>
А так же в форме должен быть класс "ajax"


#Алерты об успешной отправки сообщения
Для тображения сообщения об успешной отправки надо создать файл 
plugin.multiforms.tpl в вашей папке с темой c содержимым:
   
    <!-- BEGIN: MAIN -->
        {FILE "themes/{PHP.cfg.defaulttheme}/warnings.tpl"}
    <!-- END: MAIN -->

Так же в вашем шаблоне должен находиться файл warnings.tpl
Если его нет, скопировать в качестве примера с другого шаблона или папки system/admin/tpl
