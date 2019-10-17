<?php var_dump($inc_cats) ?>
<!-- Sidebar navigation -->
<div id="slide-out" class="side-nav fixed">
    <ul class="custom-scrollbar">
        <!-- Logo -->
        <li class="logo-sn waves-effect">
            <div class="text-center">
                <a href="#" class="pl-0"><span style="font-style: italic; color: #000;">my</span>CA$H</a>
            </div>
        </li>
        <!--/. Logo -->

        <!-- Side navigation links -->
        <li>
            <ul class="collapsible collapsible-accordion">
                <li><a href="/home" class="collapsible-header waves-effect"><i class=" fas fa-home"></i>
                        Главная</a></li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-plus-circle"></i>
                        Доходы<i class="fas fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="/category/incomings" class="waves-effect">Все записи</a>
                            </li>
                            @foreach ($inc_cats as $cat)
                                <li><a href="/category/incomings/{{ $cat['id'] }}" class="waves-effect">{{ $cat['name'] }}</a>
                                </li>
                            @endforeach
                            <li><a href="/category/add/incomings" class="waves-effect">Добавить категорию</a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-minus-circle"></i> Расходы<i class="fas fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="/category/spendings" class="waves-effect">Все записи</a>
                            </li>
                            @foreach ($spend_cats as $cat)
                                <li><a href="/category/spendings/{{ $cat['id'] }}" class="waves-effect">{{ $cat['name'] }}</a>
                                </li>
                            @endforeach
                            <li><a href="/category/add/spendings" class="waves-effect">Добавить категорию</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-file-invoice-dollar"></i> Коммуналка<i class="fas fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="/commun/bills" class="waves-effect">Все счета</a>
                            </li>
                            <li><a href="/commun/bills/add" class="waves-effect">Новый счет</a>
                            </li>
                            <li><a href="/commun/fields" class="waves-effect">Настройки</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-th-list"></i> Списки покупок<i class="fas fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="/commun/bills" class="waves-effect">Все списки</a>
                            </li>
                            <li><a href="/buylists/createlist" class="waves-effect">Новый список</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-archive"></i> Архив<i class="fas fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="/archive/ballances" class="waves-effect">Балансы</a>
                            </li>
                            <li><a href="/archive/transfers" class="waves-effect">Переводы средств</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-users"></i> Контакты<i class="fas fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="/contacts" class="waves-effect">Контакты</a>
                            </li>
                            <li><a href="/requests" class="waves-effect">Запросы</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cogs"></i> Настройки<i class="fas fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="/settings/ballancetypes/" class="waves-effect">Виды средств</a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </li>
        <!--/. Side navigation links -->
    </ul>
    <div class="sidenav-bg mask-strong"></div>
</div>
<!--/. Sidebar navigation -->