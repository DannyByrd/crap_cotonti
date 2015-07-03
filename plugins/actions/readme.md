# Иструкция к установки: #
   
    - установить плагин в админке

    - создать екстраполе prod_actions для Модуля Pages. Тип выбрать datetime.
   
    - создать екстраполе prod_actions для Модуля Products. Тип выбрать datetime.

    - Добавить тэги в tpl-файлах:
        + page.edit.tpl: {  }
        + page.add.tpl: {PAGEADD_FORM_PROD_ACTIONS}
        + products.add.tpl : {PRDADD_FORM_PROD_ACTIONS}
        + products.edit.tpl : {PRDEDIT_FORM_PROD_ACTIONS}
        + page.tpl: {PAGE_ACTION_BLOCK}
        + page.list.tpl: {LIST_ROW_ACTION_BLOCK}
        + products.tpl: {PAGE_ACTION_BLOCK}
        + products.list.tpl: {LIST_ROW_ACTION_BLOCK}



#Инструкция к использованию:#

    Для главной:
    Если на гланой странице - в нужном месте добавить 
            <!-- IF {PHP.cot_plugins_active.actions} -->
                {PHP|cot_show_page_actions()}
            <!-- ENDIF -->
    Так будет выводить 4 записи(из модуля Page).

    Если указать число записей, например 8:
            <!-- IF {PHP.cot_plugins_active.actions} -->
                {PHP|cot_show_page_actions(8)}
            <!-- ENDIF -->

    Так же можно задать для конкретной категории, например 'articles':
        <!-- IF {PHP.cot_plugins_active.actions} -->
            {PHP|cot_show_page_actions(8, 'articles')}
        <!-- ENDIF -->    

    Аналогично для продуктов только функция: cot_show_prd_actions()


    P.S.
    Не забудьте настроить правильно часовой пояс для таймера.
    В файле /plugins/actions/actions.header.main.php есть переменная, в ней указывается часовой пояс по GMT:
            $plg_gmt = '+3';
    
    Этот же часовой пояс должен настроен и в системном файле /system/common.php функцией:
            date_default_timezone_set('Europe/Kiev');
    
    Для работы плагина предполагается наличие плагина jquery.countdown в папке:
            /js/lib/jquery.countdown


