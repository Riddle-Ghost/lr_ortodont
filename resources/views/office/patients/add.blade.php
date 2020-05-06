@extends('layouts.office')

@section('content')
    <section id="patient-add">
        <div class="container">
            @include('office.nav')
            <div class="content">
                <div class="content-header">
                    <div class="content-header__title">
                        <img src="/image/icon/doc.svg" alt="icon" />
                        <h1>Добавление пациента</h1>
                    </div>
                    <div class="content-header__back">
                        <a href="{{ route('office.clinic', $clinicId) }}" title="Вернуться назад">
                            <img src="/image/icon/arrow_back.svg" alt="icon"/>
                            Вернуться назад
                        </a>
                    </div>
                </div>
                <div class="content-patient-form">
                    <form class="form-patient" name="form_patient" enctype="multipart/form-data" autocomplete="off">
                        <div class="form-group">
                            <h3>Основная информация</h3>
                            <div class="form-line">
                                <div class="form-line__input">
                                    <input type="text" name="surname" placeholder="Фамилия" value="" title="Фамилия" />
                                    <span class="icon user"></span>
                                </div>
                                <div class="form-line__input">
                                    <input type="text" name="name" placeholder="Имя" value="" title="Имя" />
                                    <span class="icon user"></span>
                                </div>
                                <div class="form-line__input">
                                    <input type="text" name="middle_name" placeholder="Отчество" value="" title="Отчество" />
                                    <span class="icon user"></span>
                                </div>
                            </div>
                            <div class="form-line">
                                <div class="form-line__input">
                                    <input type="text" name="birthday" placeholder="Дата рождения" value="" title="Дата рождения" />
                                    <span class="icon date"></span>
                                </div>
                                <div class="form-select form-line__select">
                                    <div class="select">
                                        <input id="gender-id" type="hidden" name="gender_id" value="" />
                                        <input class="select_box" id="gender" type="text" name="gender" placeholder="Пол пациента" value="" title="Пол пациента" />
                                        <span class="select-arrow"></span>
                                        <div class="select_options" data-for="gender">
                                            <div class="option option-image" data-id="0">
                                                Мужской <span class="icon male"></span>
                                            </div>
                                            <div class="option option-image" data-id="1">
                                                Женский <span class="icon female"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group__title">Диагноз / Клиническое состояние</div>
                            <div class="form-line">
                                <textarea name="diagnosis" placeholder="Основаня жалоба / Диагноз" value=""></textarea>
                            </div>
                        </div>
                        <div class="form-group form-group_end">
                            <h3>Оплата</h3>
                            <div class="form-line">
                                <div class="form-select form-line__select">
                                    <div class="form-line__title">Способ оплаты</div>
                                    <div class="select">
                                        <input id="pay-method-id" type="hidden" name="pay_method_id" value="" />
                                        <input class="select_box" id="pay-method" type="text" name="pay_method" placeholder="" value="" title="Способ оплаты" />
                                        <span class="select-arrow"></span>
                                        <div class="select_options" data-for="pay-method">
                                            <div class="option" data-id="0">Безналичный расчёт</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-select form-line__select">
                                    <div class="form-line__title">Тип оплаты</div>
                                    <div class="select">
                                        <input id="pay-option-id" type="hidden" name="pay_option_id" value="" />
                                        <input class="select_box" id="pay-option" type="text" name="pay_option" placeholder="" value="" title="Тип оплаты" />
                                        <span class="select-arrow"></span>
                                        <div class="select_options" data-for="pay-option">
                                            <div class="option" data-id="0">100% предоплата</div>
                                            <div class="option" data-id="1">Рассрочка в два этапа</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group_end">
                            <h3>Загрузка фотографий</h3>
                            <div class="form-image">
                                <div class="form-image__item">
                                    <div class="form-line__title">Фото в профиль</div>
                                    <div class="form-image__box"></div>
                                    <div class="button button_upload form-image__button">
                                        <input id="image-1" type="file" name="image_1" accept="image/jpeg,image/png" />
                                        <label for="image-1">
                                            <img src="/image/icon/camera.svg" alt="icon"/>
                                            <span>Загрузить фото</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-image__item">
                                    <div class="form-line__title">Фото в анфас с улыбкой</div>
                                    <div class="form-image__box"></div>
                                    <div class="button button_upload form-image__button"><input id="image-2" type="file" name="image_2" accept="image/jpeg,image/png" /><label for="image-2"><img src="/image/icon/camera.svg" alt="icon"/><span>Загрузить фото</span></label></div>
                                </div>
                                <div class="form-image__item">
                                    <div class="form-line__title">Фото в анфас без улыбки</div>
                                    <div class="form-image__box"></div>
                                    <div class="button button_upload form-image__button"><input id="image-3" type="file" name="image_3" accept="image/jpeg,image/png" /><label for="image-3"><img src="/image/icon/camera.svg" alt="icon"/><span>Загрузить фото</span></label></div>
                                </div>
                                <div class="form-image__item">
                                    <div class="form-line__title">Латеральный вид слева</div>
                                    <div class="form-image__box"></div>
                                    <div class="button button_upload form-image__button"><input id="image-4" type="file" name="image_4" accept="image/jpeg,image/png" /><label for="image-4"><img src="/image/icon/camera.svg" alt="icon"/><span>Загрузить фото</span></label></div>
                                </div>
                                <div class="form-image__item">
                                    <div class="form-line__title">Фронтальный вид</div>
                                    <div class="form-image__box"></div>
                                    <div class="button button_upload form-image__button"><input id="image-5" type="file" name="image_5" accept="image/jpeg,image/png" /><label for="image-5"><img src="/image/icon/camera.svg" alt="icon"/><span>Загрузить фото</span></label></div>
                                </div>
                                <div class="form-image__item">
                                    <div class="form-line__title">Латеральный вид справа</div>
                                    <div class="form-image__box"></div>
                                    <div class="button button_upload form-image__button"><input id="image-6" type="file" name="image_6" accept="image/jpeg,image/png" /><label for="image-6"><img src="/image/icon/camera.svg" alt="icon"/><span>Загрузить фото</span></label></div>
                                </div>
                                <div class="form-image__item">
                                    <div class="form-line__title">Окклюзивный вид верхнего зубного ряда</div>
                                    <div class="form-image__box"></div>
                                    <div class="button button_upload form-image__button"><input id="image-7" type="file" name="image_7" accept="image/jpeg,image/png" /><label for="image-7"><img src="/image/icon/camera.svg" alt="icon"/><span>Загрузить фото</span></label></div>
                                </div>
                                <div class="form-image__item">
                                    <div class="form-line__title">Окклюзивный вид нижнего зубного ряда</div>
                                    <div class="form-image__box"></div>
                                    <div class="button button_upload form-image__button"><input id="image-8" type="file" name="image_8" accept="image/jpeg,image/png" /><label for="image-8"><img src="/image/icon/camera.svg" alt="icon"/><span>Загрузить фото</span></label></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group_end">
                            <h3>Загрузка фото, ОПТГ и других файлов</h3>
                            <div class="form-group">
                                <div class="form-line">
                                    <div class="form-line__input">
                                        <div class="button button_upload">
                                            <input id="files" type="file" name="files[]" multiple="multiple" accept="image/jpeg,image/png" />
                                            <label for="files">
                                                <img src="/image/icon/clip_note.svg" alt="icon"/>
                                                <span>Загрузить файлы</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-text form-group_end">
                            <h3>Рецепт</h3>
                            <div class="form-line__title">Курс лечения</div>
                            <div class="form-line">
                                <div class="radio"><input id="treatment-1" type="radio" name="treatment" value="0" checked="checked" /><label for="treatment-1">Курс с моделированием движения корней (глубокий анализ КТ, 3D план движения корней и коронок,<br/>3 коррекции, неограниченное количество этапов)</label></div>
                            </div>
                            <div class="form-line">
                                <div class="radio"><input id="treatment-2" type="radio" name="treatment" value="1" /><label for="treatment-2">Полный (3D план движения коронок, 3 коррекции, неограниченное количество этапов)</label></div>
                            </div>
                            <div class="form-line">
                                <div class="radio"><input id="treatment-3" type="radio" name="treatment" value="2" /><label for="treatment-3">Короткий (3D план движения коронок, до 14 этапов на 2 челюсти)</label></div>
                            </div>
                            <div class="form-line">
                                <div class="radio"><input id="treatment-4" type="radio" name="treatment" value="3" /><label for="treatment-4">Лечение одной челюсти(3D план движения коронок, 2 коррекции, неограниченное количество этапов на 1 челюсть)</label></div>
                            </div>
                            <div class="form-line">
                                <div class="radio"><input id="treatment-5" type="radio" name="treatment" value="4" /><label for="treatment-5">Короткий Супер-короткий (3D план движения коронок, до 8 кап на 1 челюсть)</label></div>
                            </div>
                            <div class="form-line">
                                <div class="radio"><input id="treatment-6" type="radio" name="treatment" value="5" /><label for="treatment-6">Только 3D план</label></div>
                            </div>
                            <div class="form-line">
                                <div class="radio"><input id="treatment-7" type="radio" name="treatment" value="6" /><label for="treatment-7">Дети</label></div>
                            </div>
                            <div class="form-line__title">Дополнительные услуги</div>
                            <div class="form-line">
                                <div class="checkbox"><input id="add-services" type="checkbox" name="add_services" value="1" checked="checked" /><label for="add-services">Антропометрический анализ 3D-моделей (протокол антропометрической диагностики МГМСУ) - 5 000 руб</label></div>
                            </div>
                        </div>
                        <div class="form-group form-group_end">
                            <h3>Зубные дуги</h3>
                            <div class="form-line">
                                <div class="form-select form-line__select">
                                    <div class="form-line__title">Необходимо лечить зубные дуги</div>
                                    <div class="select"><input id="dental-arches-id" type="hidden" name="dental_arches_id" value="" /><input class="select_box" id="dental-arches" type="text" name="dental_arches" placeholder="" value="" title="Необходимо лечить зубные дуги" /><span class="select-arrow"></span>
                                        <div
                                                class="select_options" data-for="dental-arches">
                                            <div class="option" data-id="0">Обе</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-select form-line__select">
                                    <div class="form-line__title">Форма дуги верхнего зубного ряда</div>
                                    <div class="select"><input id="upper-dentition-id" type="hidden" name="upper_dentition_id" value="" /><input class="select_box" id="upper-dentition" type="text" name="upper_dentition" placeholder="" value="" title="Форма дуги верхнего зубного ряда" />
                                        <span class="select-arrow"></span>
                                        <div class="select_options" data-for="upper-dentition">
                                            <div class="option" data-id="0">Не менять</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-line">
                                <div class="form-select form-line__select">
                                    <div class="form-line__title">Выравнивание зубов</div>
                                    <div class="select"><input id="alignment-id" type="hidden" name="alignment_id" value="" /><input class="select_box" id="alignment" type="text" name="alignment" placeholder="" value="" title="Выравнивание зубов" /><span class="select-arrow"></span>
                                        <div class="select_options"
                                             data-for="alignment">
                                            <div class="option" data-id="0">По десневому краю</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-select form-line__select">
                                    <div class="form-line__title">Форма дуги нижнего зубного ряда</div>
                                    <div class="select"><input id="lower-dentition-id" type="hidden" name="lower_dentition_id" value="" /><input class="select_box" id="lower-dentition" type="text" name="lower_dentition" placeholder="" value="" title="Форма дуги нижнего зубного ряда" />
                                        <span class="select-arrow"></span>
                                        <div class="select_options" data-for="lower-dentition">
                                            <div class="option" data-id="0">Не менять</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <h3>Соотношение клыков</h3>
                            <div class="form-line">
                                <div class="form-select form-line__select">
                                    <div class="form-line__title">Справа</div>
                                    <div class="select"><input id="right-fang-ratio-id" type="hidden" name="right_fang_ratio_id" value="" /><input class="select_box" id="right-fang-ratio" type="text" name="right_fang_ratio" placeholder="" value="" title="Справа" /><span class="select-arrow"></span>
                                        <div
                                                class="select_options" data-for="right-fang-ratio">
                                            <div class="option" data-id="0">I класс</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-select form-line__select">
                                    <div class="form-line__title">Слева</div>
                                    <div class="select"><input id="left-fang-ratio-id" type="hidden" name="left_fang_ratio_id" value="" /><input class="select_box" id="left-fang-ratio" type="text" name="left_fang_ratio" placeholder="" value="" title="Слева" /><span class="select-arrow"></span>
                                        <div
                                                class="select_options" data-for="left-fang-ratio">
                                            <div class="option" data-id="0">I класс</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-select form-line__select">
                                    <div class="form-line__title">За счет чего</div>
                                    <div class="select"><input id="what-fang-ratio-id" type="hidden" name="what_fang_ratio_id" value="" /><input class="select_box" id="what-fang-ratio" type="text" name="what_fang_ratio" placeholder="" value="" title="За счет чего" /><span class="select-arrow"></span>
                                        <div
                                                class="select_options" data-for="what-fang-ratio">
                                            <div class="option" data-id="0">Дистализация</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <h3>Использование эластичной тяги</h3>
                            <div class="form-line">
                                <div class="form-select form-line__select">
                                    <div class="form-line__title">Справа</div>
                                    <div class="select"><input id="right-elastic-traction-id" type="hidden" name="right_elastic_traction_id" value="" /><input class="select_box" id="right-elastic-traction" type="text" name="right_elastic_traction" placeholder="" value="" title="Справа" />
                                        <span class="select-arrow"></span>
                                        <div class="select_options" data-for="right-elastic-traction">
                                            <div class="option" data-id="0">Не использовать</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-select form-line__select">
                                    <div class="form-line__title">Слева</div>
                                    <div class="select"><input id="left-elastic-traction-id" type="hidden" name="left_elastic_traction_id" value="" /><input class="select_box" id="left-elastic-traction" type="text" name="left_elastic_traction" placeholder="" value="" title="Слева" /><span class="select-arrow"></span>
                                        <div
                                                class="select_options" data-for="left-elastic-traction">
                                            <div class="option" data-id="0">Не использовать</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <h3>Соотношение резцов</h3>
                            <div class="form-line__title">Соотношение резцов по вертикали</div>
                            <div class="form-line">
                                <div class="radio"><input id="cutter-ratio-1" type="radio" name="cutter_ratio" value="0" checked="checked" /><label for="cutter-ratio-1">Не менять</label></div>
                            </div>
                            <div class="form-line">
                                <div class="radio"><input id="cutter-ratio-2" type="radio" name="cutter_ratio" value="1" /><label for="cutter-ratio-2">Уменьшить высоту резцового перекрытия</label></div>
                            </div>
                            <div class="form-line">
                                <div class="radio"><input id="cutter-ratio-3" type="radio" name="cutter_ratio" value="2" /><label for="cutter-ratio-3">Увеличить высоту резцового перекрытия</label></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <h3>Соотношение резцов по сагиттали</h3>
                            <div class="form-line">
                                <div class="form-select form-line__select">
                                    <div class="form-line__title">Верхние резцы</div>
                                    <div class="select"><input id="upper-incisors-id" type="hidden" name="upper_incisors_id" value="" /><input class="select_box" id="upper-incisors" type="text" name="upper_incisors" placeholder="" value="" title="Верхние резцы" /><span class="select-arrow"></span>
                                        <div
                                                class="select_options" data-for="upper-incisors">
                                            <div class="option" data-id="0">Не менять</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-line">
                                <div class="form-select form-line__select">
                                    <div class="form-line__title">Нижние резцы</div>
                                    <div class="select"><input id="lower-incisors-id" type="hidden" name="lower_incisors_id" value="" /><input class="select_box" id="lower-incisors" type="text" name="lower_incisors" placeholder="" value="" title="Нижние резцы" /><span class="select-arrow"></span>
                                        <div
                                                class="select_options" data-for="lower-incisors">
                                            <div class="option" data-id="0">Не менять</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group_end">
                            <h3>Соотношение по трансверзали (средняя линия)</h3>
                            <div class="form-line form-line_long">
                                <div class="form-select form-line__select">
                                    <div class="select"><input id="middle-line-id" type="hidden" name="middle_line_id" value="" /><input class="select_box" id="middle-line" type="text" name="middle_line" placeholder="" value="" title="Соотношение по трансверзали (средняя линия)" /><span class="select-arrow"></span>
                                        <div
                                                class="select_options" data-for="middle-line">
                                            <div class="option" data-id="0">Не менять</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-line__title">Сагиттальная щель</div>
                            <div class="form-line">
                                <div class="radio"><input id="sagittal-fissure-1" type="radio" name="sagittal_fissure" value="0" checked="checked" /><label for="sagittal-fissure-1">Не менять</label></div>
                            </div>
                            <div class="form-line">
                                <div class="radio"><input id="sagittal-fissure-2" type="radio" name="sagittal_fissure" value="1" /><label for="sagittal-fissure-2">Установить резцы в контакт</label></div>
                            </div>
                            <div class="form-line">
                                <div class="radio"><input id="sagittal-fissure-3" type="radio" name="sagittal_fissure" value="2" /><label for="sagittal-fissure-3">Сохранить, если необходимо для поддержания класса</label></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <h3>Выборка зубов</h3>
                            <div class="form-line__title">Не перемещать следующие зубы (мосты, имплантаты, анкилозированные зубы, другое)</div>
                            <div class="form-line">
                                <div class="checkbox"><input id="tooth-18" type="checkbox" name="tooth_18" value="1" checked="checked" /><label for="tooth-18">18</label></div>
                                <div class="checkbox"><input id="tooth-17" type="checkbox" name="tooth_17" value="0" /><label for="tooth-17">17</label></div>
                                <div class="checkbox"><input id="tooth-16" type="checkbox" name="tooth_16" value="0" /><label for="tooth-16">16</label></div>
                                <div class="checkbox"><input id="tooth-15" type="checkbox" name="tooth_15" value="0" /><label for="tooth-15">15</label></div>
                                <div class="checkbox"><input id="tooth-14" type="checkbox" name="tooth_14" value="0" /><label for="tooth-14">14</label></div>
                                <div class="checkbox"><input id="tooth-13" type="checkbox" name="tooth_13" value="0" /><label for="tooth-13">13</label></div>
                                <div class="checkbox"><input id="tooth-12" type="checkbox" name="tooth_12" value="1" checked="checked" /><label for="tooth-12">12</label></div>
                                <div class="checkbox"><input id="tooth-11" type="checkbox" name="tooth_11" value="0" /><label for="tooth-11">11</label></div>
                            </div>
                            <div class="form-line">
                                <div class="checkbox"><input id="tooth-21" type="checkbox" name="tooth_21" value="0" /><label for="tooth-21">21</label></div>
                                <div class="checkbox"><input id="tooth-22" type="checkbox" name="tooth_22" value="1" checked="checked" /><label for="tooth-22">22</label></div>
                                <div class="checkbox"><input id="tooth-23" type="checkbox" name="tooth_23" value="0" /><label for="tooth-23">23</label></div>
                                <div class="checkbox"><input id="tooth-24" type="checkbox" name="tooth_24" value="0" /><label for="tooth-24">24</label></div>
                                <div class="checkbox"><input id="tooth-25" type="checkbox" name="tooth_25" value="1" checked="checked" /><label for="tooth-25">25</label></div>
                                <div class="checkbox"><input id="tooth-26" type="checkbox" name="tooth_26" value="0" /><label for="tooth-26">26</label></div>
                                <div class="checkbox"><input id="tooth-27" type="checkbox" name="tooth_27" value="0" /><label for="tooth-27">27</label></div>
                                <div class="checkbox"><input id="tooth-28" type="checkbox" name="tooth_28" value="0" /><label for="tooth-28">28</label></div>
                            </div>
                            <div class="form-line">
                                <div class="checkbox"><input id="tooth-48" type="checkbox" name="tooth_48" value="0" /><label for="tooth-48">48</label></div>
                                <div class="checkbox"><input id="tooth-47" type="checkbox" name="tooth_47" value="0" /><label for="tooth-47">47</label></div>
                                <div class="checkbox"><input id="tooth-46" type="checkbox" name="tooth_46" value="0" /><label for="tooth-46">46</label></div>
                                <div class="checkbox"><input id="tooth-45" type="checkbox" name="tooth_45" value="0" /><label for="tooth-45">45</label></div>
                                <div class="checkbox"><input id="tooth-44" type="checkbox" name="tooth_44" value="0" /><label for="tooth-44">44</label></div>
                                <div class="checkbox"><input id="tooth-43" type="checkbox" name="tooth_43" value="0" /><label for="tooth-43">43</label></div>
                                <div class="checkbox"><input id="tooth-42" type="checkbox" name="tooth_42" value="0" /><label for="tooth-42">42</label></div>
                                <div class="checkbox"><input id="tooth-41" type="checkbox" name="tooth_41" value="0" /><label for="tooth-41">41</label></div>
                            </div>
                            <div class="form-line">
                                <div class="checkbox"><input id="tooth-31" type="checkbox" name="tooth_31" value="0" /><label for="tooth-31">31</label></div>
                                <div class="checkbox"><input id="tooth-32" type="checkbox" name="tooth_32" value="0" /><label for="tooth-32">32</label></div>
                                <div class="checkbox"><input id="tooth-33" type="checkbox" name="tooth_33" value="0" /><label for="tooth-33">33</label></div>
                                <div class="checkbox"><input id="tooth-34" type="checkbox" name="tooth_34" value="0" /><label for="tooth-34">34</label></div>
                                <div class="checkbox"><input id="tooth-35" type="checkbox" name="tooth_35" value="0" /><label for="tooth-35">35</label></div>
                                <div class="checkbox"><input id="tooth-36" type="checkbox" name="tooth_36" value="0" /><label for="tooth-36">36</label></div>
                                <div class="checkbox"><input id="tooth-37" type="checkbox" name="tooth_37" value="0" /><label for="tooth-37">37</label></div>
                                <div class="checkbox"><input id="tooth-38" type="checkbox" name="tooth_38" value="0" /><label for="tooth-38">38</label></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line__title">Избегать замки на следующих зубах (коронки, другое)</div>
                            <div class="form-line">
                                <div class="checkbox"><input id="tooth-locks-18" type="checkbox" name="tooth_locks_18" value="1" checked="checked" /><label for="tooth-locks-18">18</label></div>
                                <div class="checkbox"><input id="tooth-locks-17" type="checkbox" name="tooth_locks_17" value="0" /><label for="tooth-locks-17">17</label></div>
                                <div class="checkbox"><input id="tooth-locks-16" type="checkbox" name="tooth_locks_16" value="0" /><label for="tooth-locks-16">16</label></div>
                                <div class="checkbox"><input id="tooth-locks-15" type="checkbox" name="tooth_locks_15" value="0" /><label for="tooth-locks-15">15</label></div>
                                <div class="checkbox"><input id="tooth-locks-14" type="checkbox" name="tooth_locks_14" value="0" /><label for="tooth-locks-14">14</label></div>
                                <div class="checkbox"><input id="tooth-locks-13" type="checkbox" name="tooth_locks_13" value="0" /><label for="tooth-locks-13">13</label></div>
                                <div class="checkbox"><input id="tooth-locks-12" type="checkbox" name="tooth_locks_12" value="1" checked="checked" /><label for="tooth-locks-12">12</label></div>
                                <div class="checkbox"><input id="tooth-locks-11" type="checkbox" name="tooth_locks_11" value="0" /><label for="tooth-locks-11">11</label></div>
                            </div>
                            <div class="form-line">
                                <div class="checkbox"><input id="tooth-locks-21" type="checkbox" name="tooth_locks_21" value="0" /><label for="tooth-locks-21">21</label></div>
                                <div class="checkbox"><input id="tooth-locks-22" type="checkbox" name="tooth_locks_22" value="1" checked="checked" /><label for="tooth-locks-22">22</label></div>
                                <div class="checkbox"><input id="tooth-locks-23" type="checkbox" name="tooth_locks_23" value="0" /><label for="tooth-locks-23">23</label></div>
                                <div class="checkbox"><input id="tooth-locks-24" type="checkbox" name="tooth_locks_24" value="0" /><label for="tooth-locks-24">24</label></div>
                                <div class="checkbox"><input id="tooth-locks-25" type="checkbox" name="tooth_locks_25" value="1" checked="checked" /><label for="tooth-locks-25">25</label></div>
                                <div class="checkbox"><input id="tooth-locks-26" type="checkbox" name="tooth_locks_26" value="0" /><label for="tooth-locks-26">26</label></div>
                                <div class="checkbox"><input id="tooth-locks-27" type="checkbox" name="tooth_locks_27" value="0" /><label for="tooth-locks-27">27</label></div>
                                <div class="checkbox"><input id="tooth-locks-28" type="checkbox" name="tooth_locks_28" value="0" /><label for="tooth-locks-28">28</label></div>
                            </div>
                            <div class="form-line">
                                <div class="checkbox"><input id="tooth-locks-48" type="checkbox" name="tooth_locks_48" value="0" /><label for="tooth-locks-48">48</label></div>
                                <div class="checkbox"><input id="tooth-locks-47" type="checkbox" name="tooth_locks_47" value="0" /><label for="tooth-locks-47">47</label></div>
                                <div class="checkbox"><input id="tooth-locks-46" type="checkbox" name="tooth_locks_46" value="0" /><label for="tooth-locks-46">46</label></div>
                                <div class="checkbox"><input id="tooth-locks-45" type="checkbox" name="tooth_locks_45" value="0" /><label for="tooth-locks-45">45</label></div>
                                <div class="checkbox"><input id="tooth-locks-44" type="checkbox" name="tooth_locks_44" value="0" /><label for="tooth-locks-44">44</label></div>
                                <div class="checkbox"><input id="tooth-locks-43" type="checkbox" name="tooth_locks_43" value="0" /><label for="tooth-locks-43">43</label></div>
                                <div class="checkbox"><input id="tooth-locks-42" type="checkbox" name="tooth_locks_42" value="0" /><label for="tooth-locks-42">42</label></div>
                                <div class="checkbox"><input id="tooth-locks-41" type="checkbox" name="tooth_locks_41" value="0" /><label for="tooth-locks-41">41</label></div>
                            </div>
                            <div class="form-line">
                                <div class="checkbox"><input id="tooth-locks-31" type="checkbox" name="tooth_locks_31" value="0" /><label for="tooth-locks-31">31</label></div>
                                <div class="checkbox"><input id="tooth-locks-32" type="checkbox" name="tooth_locks_32" value="0" /><label for="tooth-locks-32">32</label></div>
                                <div class="checkbox"><input id="tooth-locks-33" type="checkbox" name="tooth_locks_33" value="0" /><label for="tooth-locks-33">33</label></div>
                                <div class="checkbox"><input id="tooth-locks-34" type="checkbox" name="tooth_locks_34" value="0" /><label for="tooth-locks-34">34</label></div>
                                <div class="checkbox"><input id="tooth-locks-35" type="checkbox" name="tooth_locks_35" value="0" /><label for="tooth-locks-35">35</label></div>
                                <div class="checkbox"><input id="tooth-locks-36" type="checkbox" name="tooth_locks_36" value="0" /><label for="tooth-locks-36">36</label></div>
                                <div class="checkbox"><input id="tooth-locks-37" type="checkbox" name="tooth_locks_37" value="0" /><label for="tooth-locks-37">37</label></div>
                                <div class="checkbox"><input id="tooth-locks-38" type="checkbox" name="tooth_locks_38" value="0" /><label for="tooth-locks-38">38</label></div>
                            </div>
                        </div>
                        <div class="form-group form-group_end">
                            <div class="form-line__title">Я собираюсь удалить следующие зубы</div>
                            <div class="form-line">
                                <div class="checkbox"><input id="tooth-del-18" type="checkbox" name="tooth_del_18" value="1" checked="checked" /><label for="tooth-del-18">18</label></div>
                                <div class="checkbox"><input id="tooth-del-17" type="checkbox" name="tooth_del_17" value="0" /><label for="tooth-del-17">17</label></div>
                                <div class="checkbox"><input id="tooth-del-16" type="checkbox" name="tooth_del_16" value="0" /><label for="tooth-del-16">16</label></div>
                                <div class="checkbox"><input id="tooth-del-15" type="checkbox" name="tooth_del_15" value="0" /><label for="tooth-del-15">15</label></div>
                                <div class="checkbox"><input id="tooth-del-14" type="checkbox" name="tooth_del_14" value="0" /><label for="tooth-del-14">14</label></div>
                                <div class="checkbox"><input id="tooth-del-13" type="checkbox" name="tooth_del_13" value="0" /><label for="tooth-del-13">13</label></div>
                                <div class="checkbox"><input id="tooth-del-12" type="checkbox" name="tooth_del_12" value="1" checked="checked" /><label for="tooth-del-12">12</label></div>
                                <div class="checkbox"><input id="tooth-del-11" type="checkbox" name="tooth_del_11" value="0" /><label for="tooth-del-11">11</label></div>
                            </div>
                            <div class="form-line">
                                <div class="checkbox"><input id="tooth-del-21" type="checkbox" name="tooth_del_21" value="0" /><label for="tooth-del-21">21</label></div>
                                <div class="checkbox"><input id="tooth-del-22" type="checkbox" name="tooth_del_22" value="1" checked="checked" /><label for="tooth-del-22">22</label></div>
                                <div class="checkbox"><input id="tooth-del-23" type="checkbox" name="tooth_del_23" value="0" /><label for="tooth-del-23">23</label></div>
                                <div class="checkbox"><input id="tooth-del-24" type="checkbox" name="tooth_del_24" value="0" /><label for="tooth-del-24">24</label></div>
                                <div class="checkbox"><input id="tooth-del-25" type="checkbox" name="tooth_del_25" value="1" checked="checked" /><label for="tooth-del-25">25</label></div>
                                <div class="checkbox"><input id="tooth-del-26" type="checkbox" name="tooth_del_26" value="0" /><label for="tooth-del-26">26</label></div>
                                <div class="checkbox"><input id="tooth-del-27" type="checkbox" name="tooth_del_27" value="0" /><label for="tooth-del-27">27</label></div>
                                <div class="checkbox"><input id="tooth-del-28" type="checkbox" name="tooth_del_28" value="0" /><label for="tooth-del-28">28</label></div>
                            </div>
                            <div class="form-line">
                                <div class="checkbox"><input id="tooth-del-48" type="checkbox" name="tooth_del_48" value="0" /><label for="tooth-del-48">48</label></div>
                                <div class="checkbox"><input id="tooth-del-47" type="checkbox" name="tooth_del_47" value="0" /><label for="tooth-del-47">47</label></div>
                                <div class="checkbox"><input id="tooth-del-46" type="checkbox" name="tooth_del_46" value="0" /><label for="tooth-del-46">46</label></div>
                                <div class="checkbox"><input id="tooth-del-45" type="checkbox" name="tooth_del_45" value="0" /><label for="tooth-del-45">45</label></div>
                                <div class="checkbox"><input id="tooth-del-44" type="checkbox" name="tooth_del_44" value="0" /><label for="tooth-del-44">44</label></div>
                                <div class="checkbox"><input id="tooth-del-43" type="checkbox" name="tooth_del_43" value="0" /><label for="tooth-del-43">43</label></div>
                                <div class="checkbox"><input id="tooth-del-42" type="checkbox" name="tooth_del_42" value="0" /><label for="tooth-del-42">42</label></div>
                                <div class="checkbox"><input id="tooth-del-41" type="checkbox" name="tooth_del_41" value="0" /><label for="tooth-del-41">41</label></div>
                            </div>
                            <div class="form-line">
                                <div class="checkbox"><input id="tooth-del-31" type="checkbox" name="tooth_del_31" value="0" /><label for="tooth-del-31">31</label></div>
                                <div class="checkbox"><input id="tooth-del-32" type="checkbox" name="tooth_del_32" value="0" /><label for="tooth-del-32">32</label></div>
                                <div class="checkbox"><input id="tooth-del-33" type="checkbox" name="tooth_del_33" value="0" /><label for="tooth-del-33">33</label></div>
                                <div class="checkbox"><input id="tooth-del-34" type="checkbox" name="tooth_del_34" value="0" /><label for="tooth-del-34">34</label></div>
                                <div class="checkbox"><input id="tooth-del-35" type="checkbox" name="tooth_del_35" value="0" /><label for="tooth-del-35">35</label></div>
                                <div class="checkbox"><input id="tooth-del-36" type="checkbox" name="tooth_del_36" value="0" /><label for="tooth-del-36">36</label></div>
                                <div class="checkbox"><input id="tooth-del-37" type="checkbox" name="tooth_del_37" value="0" /><label for="tooth-del-37">37</label></div>
                                <div class="checkbox"><input id="tooth-del-38" type="checkbox" name="tooth_del_38" value="0" /><label for="tooth-del-38">38</label></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line__title">Комментарии (какой результат вы хотите получить), прочие инструкции</div>
                            <div class="form-line"><textarea name="comments" placeholder="Какой результат Вы хотите получить? / Прочие инструкции..." value=""></textarea></div>
                        </div>
                        <div class="form-group">
                            <div class="button form-button">
                                <a href="#" title="Сохранить данные о пациенте">Сохранить данные о пациенте</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection