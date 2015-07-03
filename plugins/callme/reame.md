
Шаблон плагина:
    /plugins/callme/tpl/callme.tpl

В шаблона плагина есть html-код кнопки:
    <a data-toggle="modal" href="{PHP|cot_url('callme')}" data-target="#callmeModal" class="bn-fixed">Call me</a>

Если класс кнопки bn-fixed, кропка будет фиксирована слева сайта. 
Так же можно задавать цвета кнопки:

    - Зеленый:
        <a data-toggle="modal" href="{PHP|cot_url('callme')}" data-target="#callmeModal" class="bn-fixed">Call me</a>

    - Черный:
        <a data-toggle="modal" href="{PHP|cot_url('callme')}" data-target="#callmeModal" class="bn-fixed black">Call me</a>

    - Синий:
        <a data-toggle="modal" href="{PHP|cot_url('callme')}" data-target="#callmeModal" class="bn-fixed blue">Call me</a>

    - Розовый:
        <a data-toggle="modal" href="{PHP|cot_url('callme')}" data-target="#callmeModal" class="bn-fixed pink">Call me</a>

    - Белый:
        <a data-toggle="modal" href="{PHP|cot_url('callme')}" data-target="#callmeModal" class="bn-fixed white">Call me</a>        

Для не фиксированой кнопочки. Т.е. если мы хотим вывести ее в одном месте, в блоке, добавляем в нужном месте код:

                <!-- IF {PHP.cot_plugins_active.callme} -->
                    {PHP.out.callme}
                <!-- ENDIF -->
                
                
Затем в шаблоне изменим код кнопки на:

    <a data-toggle="modal" href="{PHP|cot_url('callme')}" data-target="#callmeModal" class="btn btn-primary">Call me</a>

Классы кнопки можно заменить на любой какой нравится.
А так же в админке приостановить хук footer.main

Перед закрывающим тегом body добавить это:
            <!-- IF {PHP.cot_plugins_active.callme} -->
                {PHP.out.callmeWindow}
            <!-- ENDIF -->

В корфигурации есть возможность выбора версии bootstrap 2.x и 3.х            

P.S. Если вы решили обратно поставить фиксированную кнопку не забудьте включить в админке хук footer.main
