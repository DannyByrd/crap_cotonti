Для работы mailchmp достаточно установить следующие классы для html-тегов формы:

<form class="mi-form">
<input type="text" class="mi-email">
<input type="submit" class="mi-submit">

Это обязательные классы тегов для работы плагина mailchmp. В аккаунт mailchmp будет отправляться только email. Так же можно добавлять еще:

    - имя : <input type="text" class="mi-fname">
    - номер телефона: <input type="text" class="mi-phone">

Так же для mi-form желательно указать name. Это вам поможет легче искть оштбки при включенном test_mode.

Дополнительные классы для формы:
    - mi-auto-clear : очищает форму после отправки данных.
        Пример : <form class="mi-form mi-auto-clear">

    - mi-no-submit : не перезагружает страницу после отправки данных. 
        Пример : <form class="mi-form mi-no-submit">

    - mi-alert : тег для отображения ошибок валидации и успешного заполнения. Вместе с mi-alert желательно использовать mi-no-sbmit. Иначе ошибок не успеете увидить.


Для настройки плагина нужен API keys с вашего аккаунта на mailchimp.com.
Или можете добавить этот: 7648325be29a18ab67ad0c268203174c-us8