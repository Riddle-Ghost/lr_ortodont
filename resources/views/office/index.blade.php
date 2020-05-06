@extends('layouts.office')

@section('content')
    <section id="doc-profile">
        <div class="container">
            @include('office.nav')
            <div class="content">
                <div class="content-header">
                    <div class="content-header__title">
                        <img src="/image/icon/doc.svg" alt="icon" />
                        <h1>Мой профиль</h1>
                    </div>
                </div>
                <div class="content-doc">
                    <div class="content-doc-image">
                        <img src="/image/user_photo.jpg" alt="user photo" />
                    </div>
                    <div class="content-doc-info">
                        <div class="content-doc-info__name">Грачёв Александр Николаевич</div>
                        <ul class="content-doc-info__group">
                            <li class="content-doc-info__specialty">
                                <img src="/image/icon/specialty.svg" alt="icon" />
                                Врач-ортодонт
                            </li>
                            <li class="content-doc-info__date">
                                <img src="/image/icon/calendar.svg" alt="icon" />
                                23.08.1993
                            </li>
                            <li class="content-doc-info__phone">
                                <img src="/image/icon/phone.svg" alt="icon" />
                                +7 800 555 35 35
                            </li>
                        </ul>
                        <p class="content-doc-info__desc">Задача организации, в особенности же укрепление и развитие структуры в значительной степени обуславливает создание системы обучения кадров, соответствует насущным потребностям. Идейные соображения высшего порядка, а также укрепление и развитие структуры требуют определения.</p>
                        <div class="content-doc-info__search-panel">
                            <div class="form content-doc-info__search-panel-search">
                                <input type="search" name="search" autocomplete="off" placeholder="Поиск по клиникам" value="" title="Поиск по клиникам" />
                                <span class="icon"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-table">
                    <ul class="content-table__header">
                        <li class="content-table__header-name">
                            Название клиники
                            <div class="content-table__header-sort">
                                <a href="#" title="">
                                    <img src="/image/icon/arrow_up.svg" alt="icon"/>
                                </a>
                                <a href="#" title="">
                                    <img src="/image/icon/arrow_down.svg" alt="icon"/>
                                </a>
                            </div>
                        </li>
                        <li class="content-table__header-phone">
                            Телефон клиники
                            <div class="content-table__header-sort">
                                <a href="#" title="">
                                    <img src="/image/icon/arrow_up.svg" alt="icon"/>
                                </a>
                                <a href="#" title="">
                                    <img src="/image/icon/arrow_down.svg" alt="icon"/>
                                </a>
                            </div>
                        </li>
                        <li class="content-table__header-patients-count">
                            Пациентов у врача
                            <div class="content-table__header-sort">
                                <a href="#" title="">
                                    <img src="/image/icon/arrow_up.svg" alt="icon"/>
                                </a>
                                <a href="#" title="">
                                    <img src="/image/icon/arrow_down.svg" alt="icon"/>
                                </a>
                            </div>
                        </li>
                        <li class="content-table__header-status">
                            Пациенты по статусам
                            <div class="content-table__header-sort">
                                <a href="#" title="">
                                    <img src="/image/icon/arrow_up.svg" alt="icon"/>
                                </a>
                                <a href="#" title="">
                                    <img src="/image/icon/arrow_down.svg" alt="icon"/>
                                </a>
                            </div>
                        </li>
                    </ul>
                    <ul class="content-table__main">
                        <li class="content-table__main-name content-table__main-mark content-table__main-mark_orange">
                            <a href="/view/doc/clinic_profile.html" title="">Стоматология «Улыбка»</a>
                        </li>
                        <li class="content-table__main-phone">
                            <a href="#" title="">+7 800 555 35 35</a>
                        </li>
                        <li class="content-table__main-patients-count">150 чел</li>
                        <li class="content-table__main-status">
                            <div class="content-table__main-status_group">
                                <div class="content-table__main-mark content-table__main-mark_blue">50</div>
                                <div class="content-table__main-mark content-table__main-mark_orange">23</div>
                                <div class="content-table__main-mark content-table__main-mark_green">36</div>
                            </div>
                            <div class="content-table__main-mark">41</div>
                        </li>
                    </ul>
                </div>
                <div class="pagination">
                    <div class="pagination__docs">
                        Всего клиник: <span>14</span>
                    </div>
                    <div class="pagination__pager">
                        <div class="pagination__pager-prev">
                            <a href="#" title="Листать назад">
                                <img src="/image/icon/arrow_left.svg" alt="icon"/>
                            </a>
                        </div>
                        <ul>
                            <li>1</li>
                            <li>
                                <a class="pagination__pager-link" href="#" title="">2</a>
                            </li>
                            <li>
                                <a class="pagination__pager-link" href="#" title="">3</a>
                            </li>
                            <li>
                                <a class="pagination__pager-link" href="#" title="">4</a>
                            </li>
                        </ul>
                        <div class="pagination__pager-next">
                            <a href="#" title="Листать вперёд">
                                <img src="/image/icon/arrow_right.svg" alt="icon"/>
                            </a>
                        </div>
                    </div>
                    <div class="pagination__all_pages">
                        Всего страниц: <span>4</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection