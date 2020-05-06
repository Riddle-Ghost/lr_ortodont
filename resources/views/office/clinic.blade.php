@extends('layouts.office')

@section('content')
    <section id="clinic-profile">
        <div class="container">
            @include('office.nav')
            <div class="content">
                <div class="content-header">
                    <div class="content-header__title">
                        <img src="/image/icon/clinic.svg" alt="icon" />
                        <h1>Информация о клинике</h1>
                    </div>
                    <div class="content-header__back">
                        <a href="{{ route('office.index') }}" title="Вернуться назад">
                            <img src="/image/icon/arrow_back.svg" alt="icon"/>
                            Вернуться назад
                        </a>
                    </div>
                </div>
                <div class="content-clinic">
                    <div class="content-clinic-image">
                        <img src="/image/clinic_logo.jpg" alt="clinic logo" />
                    </div>
                    <div class="content-clinic-info">
                        <div class="content-clinic-info__name">Клиника «ДЕЛЬТА»</div>
                        <ul class="content-clinic-info__group">
                            <li class="content-clinic-info__specialty">
                                <img src="/image/icon/info.svg" alt="icon" />
                                ООО «Глобал Дент»
                            </li>
                            <li class="content-clinic-info__phone">
                                <img src="/image/icon/phone.svg" alt="icon" />
                                +7 800 555 35 35
                            </li>
                            <li class="content-clinic-info__date">
                                <img src="/image/icon/user.svg" alt="icon" />
                                Иванов Иван Иванович
                            </li>
                        </ul>
                        <ul class="content-clinic-info__requisites">
                            <li>
                                <div class="content-clinic-info__requisites-title">Юр. адрес:</div>
                                <div class="content-clinic-info__requisites-text">111555, г. Мурманск, пр. Связи, 12</div>
                            </li>
                            <li>
                                <div class="content-clinic-info__requisites-title">Физ. адрес:</div>
                                <div class="content-clinic-info__requisites-text">111555, г. Мурманск, пр. Связи, 12</div>
                            </li>
                            <li>
                                <div class="content-clinic-info__requisites-title">Реквизиты компании:</div>
                                <div class="content-clinic-info__requisites-cut-text">40702810123450101230 в Московский банк</div>
                                <div class="content-clinic-info__requisites-link">
                                    <a class="open-modal" href="#requisites" title="Посмотреть реквизиты">Смотреть полностью</a>
                                </div>
                            </li>
                        </ul>
                        <div class="content-clinic-info__search-panel">
                            <div class="form content-clinic-info__search-panel-search">
                                <input type="search" name="search" autocomplete="off" placeholder="Поиск по пациентам" value="" title="Поиск по пациентам" />
                                <span class="icon"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-table">
                    <ul class="content-table__header">
                        <li class="content-table__header-id">
                            ID
                            <div class="content-table__header-sort">
                                <a href="#" title="">
                                    <img src="/image/icon/arrow_down.svg" alt="icon"/>
                                </a>
                            </div>
                        </li>
                        <li class="content-table__header-pay-status">
                            Статус
                            <div class="content-table__header-sort">
                                <a href="#" title="">
                                    <img src="/image/icon/arrow_up.svg" alt="icon"/>
                                </a>
                                <a href="#" title="">
                                    <img src="/image/icon/arrow_down.svg" alt="icon"/>
                                </a>
                            </div>
                        </li>
                        <li class="content-table__header-name">
                            ФИО пациента
                            <div class="content-table__header-sort">
                                <a href="#" title="">
                                    <img src="/image/icon/arrow_up.svg" alt="icon"/>
                                </a>
                                <a href="#" title="">
                                    <img src="/image/icon/arrow_down.svg" alt="icon"/>
                                </a>
                            </div>
                        </li>
                        <li class="content-table__header-stages">
                            Этапов доставки
                            <div class="content-table__header-sort">
                                <a href="#" title="">
                                    <img src="/image/icon/arrow_up.svg" alt="icon"/>
                                </a>
                                <a href="#" title="">
                                    <img src="/image/icon/arrow_down.svg" alt="icon"/>
                                </a>
                            </div>
                        </li>
                        <li class="content-table__header-sum">
                            Оплаченная сумма
                            <div class="content-table__header-sort">
                                <a href="#" title="">
                                    <img src="/image/icon/arrow_up.svg" alt="icon"/>
                                </a>
                                <a href="#" title="">
                                    <img src="/image/icon/arrow_down.svg" alt="icon"/>
                                </a>
                            </div>
                        </li>
                        <li class="content-table__header-total-sum">
                            Полная сумма оплаты
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
                        <li class="content-table__main-id">8475</li>
                        <li class="content-table__main-pay-status content-table__main-mark content-table__main-mark_orange">Нет цены</li>
                        <li class="content-table__main-name">
                            <a href="/view/doc/patient_card.html" title="">Зубов Александр Андреевич</a>
                        </li>
                        <li class="content-table__main-stages">3 из 5</li>
                        <li class="content-table__main-sum">Не указана</li>
                        <li class="content-table__main-total-sum">Не указана</li>
                    </ul>
                </div>
                <div class="pagination">
                    <div class="pagination__docs">
                        Всего пациентов: <span>42</span>
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
                        Всего страниц: <span>11</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection