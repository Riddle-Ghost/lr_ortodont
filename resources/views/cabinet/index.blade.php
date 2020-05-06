@extends('layouts.cabinet')

@section('content')
    <section id="clinic-profile">
        <div class="container">
            @include('cabinet.nav')
            <div class="content">
                <div class="content-header">
                    <div class="content-header__title">
                        <img src="/image/icon/clinic.svg" alt="icon" />
                        <h1>Моя клиника</h1>
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
                        <div class="button button_empty content-clinic-info__button">
                            <a class="open-modal" href="#changes" title="Внести изменения">
                                <img src="/image/icon/edit.svg" alt="icon"/>
                                Внести изменения
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection