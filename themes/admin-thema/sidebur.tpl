<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li<!-- IF {PHP.env.ext} == 'index' --> class="active"<!-- ENDIF -->><a href="{PHP.cgf.mainurl}">{PHP.L.Home}</a></li>
            <!-- IF {PHP.cot_modules.products} -->
            <li<!-- IF {PHP.env.ext} == 'products' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('products')}">{PHP.L.Products}</a></li>
            <!-- ENDIF -->
            <li<!-- IF {PHP.env.ext} == 'users' AND ({PHP.group} == 'sellers' AND {PHP.m} == 'main' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('users', 'group=sellers')}">{PHP.L.sellers}</a></li>
            <li<!-- IF {PHP.env.ext} == 'page' AND {PHP.c} == 'news' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('page','c=news')}">{PHP.L.News}</a></li>
            <!-- IF {PHP.cot_modules.forums} -->
            <li<!-- IF {PHP.env.ext} == 'forums' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('forums')}">{PHP.L.Forums}</a></li>
            <!-- ENDIF -->
            <!-- IF {PHP.cot_modules.afisha} -->
            <li<!-- IF {PHP.env.ext} == 'afisha' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('afisha')}">Афиша</a></li>
            <!-- ENDIF -->
            <!-- IF {PHP.cot_modules.blogs} -->
            <li<!-- IF {PHP.env.ext} == 'blogs' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('blogs')}">Блоги</a></li>
            <!-- ENDIF -->
            <!-- IF {PHP.cot_modules.board} -->
            <li<!-- IF {PHP.env.ext} == 'board' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('board')}">Объявления</a></li>
            <!-- ENDIF -->
            <!-- IF {PHP.cot_modules.firms} -->
            <li<!-- IF {PHP.env.ext} == 'firms' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('firms')}">Организации</a></li>
            <!-- ENDIF -->
            <!-- IF {PHP.cot_modules.vacancies} -->
            <li<!-- IF {PHP.env.ext} == 'vacancies' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('vacancies')}">Вакансии</a></li>
            <!-- ENDIF -->
            <!-- IF {PHP.cot_modules.places} -->
            <li<!-- IF {PHP.env.ext} == 'places' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('places')}">Места</a></li>
            <!-- ENDIF -->
            <!-- IF {PHP.cot_modules.rezume} -->
            <li<!-- IF {PHP.env.ext} == 'rezume' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('rezume')}">Резюме</a></li>
            <!-- ENDIF -->
                        <li<!-- IF {PHP.env.ext} == 'reviews' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('page', 'c=reviews')}">Отзывы</a></li>
            <!-- IF {PHP.cot_plugins_active.search} -->
            <li<!-- IF {PHP.env.ext} == 'search' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('plug','e=search')}">{PHP.L.Search}</a></li>
            <!-- ENDIF -->
            <!-- IF {PHP.cot_plugins_active.contact} -->
            <li<!-- IF {PHP.env.ext} == 'contact' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('plug','e=contact')}">Контакты</a></li>
            <!-- ENDIF -->
        </ul>
    </div>
</div>