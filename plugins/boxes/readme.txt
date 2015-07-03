Copyright (c) 2015, PRoHtml | http://prohtml.net/webmaster/cotonti/boxes

Для того чтобы добавлять свои описания к слотам, добавьте в PHP файл вашего шаблона код:
- если шаблон называется "set" , то соответственно добавить в файл set.php в самый низ:

To add your own description to slots, add to PHP file of your template or code of the same name:
- If the pattern is called "set", then add a file, respectively set.php to the bottom:





    $L['style_my'] = ' style="color:blue"';
    /** ================================================
    СВОИ МЕТКИ ДЛЯ БЛОКОВ ВЫВОДИМЫХ ЧЕРЕЗ ПЛАГИН BOXES |
    More tags BLOCKS hatchability via plugins BOXES    | 
    ================================================== */
    //  Вывод блоков в верхней части сайта (шапка)
    /** {PHP.box_shapka1}  */$L['box_shapka1_my'] = '';
    /** {PHP.box_shapka2}  */$L['box_shapka2_my'] = '';  
        
    //  Вывод блоков в центральной части сайта (индекс)
    /** {PHP.box_index1}  */$L['box_index1_my'] = '';
    /** {PHP.box_index2}  */$L['box_index2_my'] = '';    
    /** {PHP.box_index3}  */$L['box_index3_my'] = '';
    /** {PHP.box_index4}  */$L['box_index4_my'] = '';    
        
    //  Вывод блоков в боковой части сайта (сайдбар)
    /** {PHP.box_sidebar1}  */$L['box_sidebar1_my'] = '';
    /** {PHP.box_sidebar2}  */$L['box_sidebar2_my'] = '';
    
    //  Вывод блоков в нижней части сайта (футер)
    /** {PHP.box_footer1}  */$L['box_footer1_my'] = '';
    /** {PHP.box_footer2}  */$L['box_footer2_my'] = '';
        
    //  Дополнительные блоки для любой части
    /** {PHP.box1}  */$L['box1_my'] = '';
    /** {PHP.box2}  */$L['box2_my'] = '';
    /** {PHP.box3}  */$L['box3_my'] = '';
    /** {PHP.box4}  */$L['box4_my'] = '';
    /** {PHP.box5}  */$L['box5_my'] = '';


