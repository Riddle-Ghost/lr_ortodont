@extends('layouts.office')

@section('content')
    <section id="patient-card">
        <div class="container">
            @include('office.nav')
            <div class="content">
                <div class="content-header">
                    <div class="content-header__title">
                        <img src="/image/icon/doc.svg" alt="icon" />
                        <h1>Карточка пациента</h1>
                    </div>
                    <div class="content-header__back">
                        <a href="{{ route('office.clinic', $clinicId) }}" title="Вернуться назад">
                            <img src="/image/icon/arrow_back.svg" alt="icon"/>
                            Вернуться назад
                        </a>
                    </div>
                </div>
                <div class="content-main">
                    <div class="content-main__title">Информация о пациенте (ID: #33355)</div>
                    <div class="content-main__info">
                        <div class="content-main__name">
                            <div class="content-main__info-title">ФИО</div>
                            <div class="content-main__info-text">Иванов Иван Иванович</div>
                        </div>
                        <div class="content-main__birthday">
                            <div class="content-main__info-title">Дата рождения</div>
                            <div class="content-main__info-text">23.03.1993</div>
                        </div>
                        <div class="content-main__gender">
                            <div class="content-main__info-title">Пол</div>
                            <div class="content-main__info-text"><img src="/image/icon/male.svg" alt="icon" />Мужской</div>
                        </div>
                    </div>
                    <div class="content-main__diagnosis">
                        <div class="content-main__diagnosis-title">Диагноз</div>
                        <div class="content-main__diagnosis-text">Глубокий дистальный прикус, стираемость нижних резцов, ретрузия верхних резцов, скученность зубов на верхней челюсти</div>
                    </div>
                    <div class="content-main__precept">
                        <div class="content-main__precept-title"><img src="/image/icon/info_note.svg" alt="icon" />Рецепт</div>
                        <div class="content-main__precept-text">Курс с моделированием движения корней (глубокий анализ КТ, 3D план движения корней и коронок, 3 коррекции, неограниченное количество этапов)</div>
                    </div>
                </div>
                <div class="content-select-clinic">
                    <div class="content-select-clinic__title">Клиника и оплата</div>
                    <div class="content-select-clinic__info">
                        <div class="content-select-clinic__image"><img src="/image/clinic_logo.jpg" alt="clinic logo" /></div>
                        <div class="content-select-clinic__group">
                            <div class="content-select-clinic__name">Клиника «Дельта»</div>
                            <div class="content-select-clinic__company">ООО «Глобал Дент»</div>
                        </div>
                    </div>
                </div>
                <div class="content-pay-panel">
                    <div class="content-pay-panel__pay-method">
                        <div class="content-pay-panel__pay-method-title">Способ оплаты</div>
                        <div class="content-pay-panel__pay-method-text">Безналичный расчёт</div>
                    </div>
                    <div class="content-pay-panel__pay-option">
                        <div class="content-pay-panel__pay-option-title">Вариант оплаты</div>
                        <div class="content-pay-panel__pay-option-text">Рассрочка в два этапа</div>
                    </div>
                    <div class="button button_square content-pay-panel__button"><a class="open-modal" href="#pay" title="Редактировать"><img src="/image/icon/edit.svg" alt="icon"/></a></div>
                    <div class="content-pay-panel__already-pay">
                        <div class="content-pay-panel__already-pay-title">Оплачено:</div>
                        <div class="content-pay-panel__already-pay-text">Стоимость не указана</div>
                    </div>
                    <div class="button button_disabled content-pay-panel__button"><a href="#" title="Оплатить">Оплатить</a></div>
                </div>
            </div>
            <div class="plan">
                <div class="plan-header">
                    <div class="plan-header__title"><img src="/image/icon/3d.svg" alt="icon" />
                        <h3>3D план</h3>
                    </div>
                </div>
                <div class="plan-main">
                    <div class="button button_blue plan-main__button"><a href="#" title="Смотреть 3D план"><img src="/image/icon/3d_invert.svg" alt="icon"/>Смотреть 3D план</a></div>
                    <div class="button button_empty plan-main__button"><a href="#" title="Ссылка для пациента"><img src="/image/icon/link.svg" alt="icon"/>Ссылка для пациента</a></div>
                </div>
            </div>
            <div class="comments">
                <div class="comments-header">
                    <div class="comments-header__title"><img src="/image/icon/comments.svg" alt="icon" />
                        <h3>Комментарии</h3>
                    </div>
                </div>
                <div class="comments-main">
                    <form class="form-comments" name="form_comments" method="POST" action="" enctype="multipart/form-data" accept-charset="utf-8" autocomplete="off">
                        <div class="form-line form-line_column"><label for="comment">Ваш комментарий</label><textarea id="comment" name="comment" placeholder="Напишите ваш комментарий" value=""></textarea></div>
                        <div class="button button_blue form-button"><a href="#" title="Отправить комментарий"><img src="/image/icon/send_invert.svg" alt="icon"/>Отправить комментарий</a></div>
                    </form>
                </div>
                <ul class="comments-list">
                    <li class="comments-list__item">
                        <div class="comments-list__item-image"><a href="/view/doc/doc_profile.html" title=""><img src="/image/user_photo.jpg" alt="user photo"/></a></div>
                        <div class="comments-list__item-group">
                            <div class="comments-list__item-name"><a href="/view/doc/doc_profile.html" title="">Грачёв Александр Николаевич</a></div>
                            <div class="comments-list__item-comment">Разнообразный и богатый опыт дальнейшее развитие различных форм деятельности играет важную роль в формировании систем массового участия. Значимость этих проблем настолько очевидна, что начало повседневной работы.</div>
                        </div>
                        <div class="comments-list__item-date">21.05.2019</div>
                        <div class="comments-list__item-time">11:45</div>
                    </li>
                    <li class="comments-list__item">
                        <div class="comments-list__item-image"><a href="/view/doc/doc_profile.html" title=""><img src="/image/user_photo.jpg" alt="user photo"/></a></div>
                        <div class="comments-list__item-group">
                            <div class="comments-list__item-name"><a href="/view/doc/doc_profile.html" title="">Грачёв Александр Николаевич</a></div>
                            <div class="comments-list__item-comment">Разнообразный и богатый опыт дальнейшее развитие различных форм деятельности играет важную роль в формировании систем массового участия. Значимость этих проблем настолько очевидна, что начало повседневной работы.</div>
                        </div>
                        <div class="comments-list__item-date">21.05.2019</div>
                        <div class="comments-list__item-time">11:45</div>
                    </li>
                    <li class="comments-list__item">
                        <div class="comments-list__item-image"><a href="/view/doc/doc_profile.html" title=""><img src="/image/user_photo.jpg" alt="user photo"/></a></div>
                        <div class="comments-list__item-group">
                            <div class="comments-list__item-name"><a href="/view/doc/doc_profile.html" title="">Грачёв Александр Николаевич</a></div>
                            <div class="comments-list__item-comment">Разнообразный и богатый опыт дальнейшее развитие различных форм деятельности играет важную роль в формировании систем массового участия. Значимость этих проблем настолько очевидна, что начало повседневной работы.</div>
                        </div>
                        <div class="comments-list__item-date">21.05.2019</div>
                        <div class="comments-list__item-time">11:45</div>
                    </li>
                </ul>
                <div class="pagination">
                    <div class="pagination__docs">Всего комментариев:<span>7</span></div>
                    <div class="pagination__pager">
                        <div class="pagination__pager-prev"><a href="#" title="Листать назад"><img src="/image/icon/arrow_left.svg" alt="icon"/></a></div>
                        <ul>
                            <li>1</li>
                            <li><a class="pagination__pager-link" href="#" title="">2</a></li>
                            <li><a class="pagination__pager-link" href="#" title="">3</a></li>
                        </ul>
                        <div class="pagination__pager-next"><a href="#" title="Листать вперёд"><img src="/image/icon/arrow_right.svg" alt="icon"/></a></div>
                    </div>
                    <div class="pagination__all_pages">Всего страниц:<span>3</span></div>
                </div>
            </div>
            <div class="teeth">
                <div class="teeth-photos">
                    <div class="teeth-photos__title">Фотографии до лечения</div>
                    <ul class="teeth-photos__gallery">
                        <li class="teeth-photos__gallery-item">
                            <div class="teeth-photos__gallery-item-title">Фото в профиль</div>
                            <div class="teeth-photos__gallery-item-image"><img src="/image/patient/patient_photo_1.jpg" alt="patient photo" />
                                <div class="button button_square teeth-photos__gallery-item-button"><a class="open-modal" href="#photo_preview" title="Увеличить фото"><img src="/image/icon/enlarge_photo.svg" alt="icon"/></a></div>
                            </div>
                        </li>
                        <li class="teeth-photos__gallery-item">
                            <div class="teeth-photos__gallery-item-title">Фото в анфас с улыбкой</div>
                            <div class="teeth-photos__gallery-item-image"><img src="/image/patient/patient_photo_2.jpg" alt="patient photo" />
                                <div class="button button_square teeth-photos__gallery-item-button"><a class="open-modal" href="#photo_preview" title="Увеличить фото"><img src="/image/icon/enlarge_photo.svg" alt="icon"/></a></div>
                            </div>
                        </li>
                        <li class="teeth-photos__gallery-item">
                            <div class="teeth-photos__gallery-item-title">Фото в анфас без улыбки</div>
                            <div class="teeth-photos__gallery-item-image"><img src="/image/patient/patient_photo_3.jpg" alt="patient photo" />
                                <div class="button button_square teeth-photos__gallery-item-button"><a class="open-modal" href="#photo_preview" title="Увеличить фото"><img src="/image/icon/enlarge_photo.svg" alt="icon"/></a></div>
                            </div>
                        </li>
                        <li class="teeth-photos__gallery-item">
                            <div class="teeth-photos__gallery-item-title">Латеральный вид слева</div>
                            <div class="teeth-photos__gallery-item-image"><img src="/image/patient/patient_photo_4.jpg" alt="patient photo" />
                                <div class="button button_square teeth-photos__gallery-item-button"><a class="open-modal" href="#photo_preview" title="Увеличить фото"><img src="/image/icon/enlarge_photo.svg" alt="icon"/></a></div>
                            </div>
                        </li>
                        <li class="teeth-photos__gallery-item">
                            <div class="teeth-photos__gallery-item-title">Фронтальный вид</div>
                            <div class="teeth-photos__gallery-item-image"><img src="/image/patient/patient_photo_5.jpg" alt="patient photo" />
                                <div class="button button_square teeth-photos__gallery-item-button"><a class="open-modal" href="#photo_preview" title="Увеличить фото"><img src="/image/icon/enlarge_photo.svg" alt="icon"/></a></div>
                            </div>
                        </li>
                        <li class="teeth-photos__gallery-item">
                            <div class="teeth-photos__gallery-item-title">Латеральный вид справа</div>
                            <div class="teeth-photos__gallery-item-image"><img src="/image/patient/patient_photo_6.jpg" alt="patient photo" />
                                <div class="button button_square teeth-photos__gallery-item-button"><a class="open-modal" href="#photo_preview" title="Увеличить фото"><img src="/image/icon/enlarge_photo.svg" alt="icon"/></a></div>
                            </div>
                        </li>
                        <li class="teeth-photos__gallery-item">
                            <div class="teeth-photos__gallery-item-title">Окклюзивный вид верхнего зубного ряда</div>
                            <div class="teeth-photos__gallery-item-image"><img src="/image/patient/patient_photo_7.jpg" alt="patient photo" />
                                <div class="button button_square teeth-photos__gallery-item-button"><a class="open-modal" href="#photo_preview" title="Увеличить фото"><img src="/image/icon/enlarge_photo.svg" alt="icon"/></a></div>
                            </div>
                        </li>
                        <li class="teeth-photos__gallery-item">
                            <div class="teeth-photos__gallery-item-title">Окклюзивный вид нижнего зубного ряда</div>
                            <div class="teeth-photos__gallery-item-image"><img src="/image/patient/patient_photo_8.jpg" alt="patient photo" />
                                <div class="button button_square teeth-photos__gallery-item-button"><a class="open-modal" href="#photo_preview" title="Увеличить фото"><img src="/image/icon/enlarge_photo.svg" alt="icon"/></a></div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="teeth-files">
                    <div class="teeth-files__title">Загруженые фото, ОПТГ и другие файлы</div>
                    <ul class="teeth-files__gallery">
                        <li class="teeth-files__gallery-item">
                            <div class="teeth-files__gallery-item-image"><img src="/image/patient/patient_file_1.jpg" alt="patient file" /></div>
                            <div class="teeth-files__gallery-item-group">
                                <div class="teeth-files__gallery-item-group">
                                    <div class="teeth-files__gallery-item-title">Рентген снимок.jpg</div>
                                    <div class="teeth-files__gallery-item-info">832 Kb</div>
                                </div>
                                <div class="button button_square teeth-files__gallery-item-button"><a href="/image/patient/patient_file_1.jpg" download="download" title="Скачать"><img src="/image/icon/download.svg" alt="icon"/></a></div>
                            </div>
                        </li>
                        <li class="teeth-files__gallery-item">
                            <div class="teeth-files__gallery-item-image"><img src="/image/patient/patient_file_2.jpg" alt="patient file" /></div>
                            <div class="teeth-files__gallery-item-group">
                                <div class="teeth-files__gallery-item-group">
                                    <div class="teeth-files__gallery-item-title">Крупный план снимок.jpg</div>
                                    <div class="teeth-files__gallery-item-info">1.2 Mb</div>
                                </div>
                                <div class="button button_square teeth-files__gallery-item-button"><a href="/image/patient/patient_file_2.jpg" download="download" title="Скачать"><img src="/image/icon/download.svg" alt="icon"/></a></div>
                            </div>
                        </li>
                        <li class="teeth-files__gallery-item">
                            <div class="teeth-files__gallery-item-image"><img src="/image/patient/patient_file_3.jpg" alt="patient file" /></div>
                            <div class="teeth-files__gallery-item-group">
                                <div class="teeth-files__gallery-item-group">
                                    <div class="teeth-files__gallery-item-title">План установки.jpg</div>
                                    <div class="teeth-files__gallery-item-info">612 Kb</div>
                                </div>
                                <div class="button button_square teeth-files__gallery-item-button"><a href="/image/patient/patient_file_3.jpg" download="download" title="Скачать"><img src="/image/icon/download.svg" alt="icon"/></a></div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="teeth-other">
                    <div class="teeth-other__title">Зубные дуги</div>
                    <div class="teeth-other__info-column">
                        <div class="teeth-other__info-title">Необходимо лечить зубные дуги</div>
                        <div class="teeth-other__info-text">Обе</div>
                    </div>
                    <div class="teeth-other__info-column">
                        <div class="teeth-other__info-title">Форма дуги верхнего зубного ряда</div>
                        <div class="teeth-other__info-text">Не менять</div>
                    </div>
                    <div class="teeth-other__info-column">
                        <div class="teeth-other__info-title">Форма дуги нижнего зубного ряда</div>
                        <div class="teeth-other__info-text">Расширить</div>
                    </div>
                    <div class="teeth-other__info-column">
                        <div class="teeth-other__info-title">Выравнивание зубов</div>
                        <div class="teeth-other__info-text">По десновому краю</div>
                    </div>
                </div>
                <div class="teeth-other">
                    <div class="teeth-other__title">Соотношение клыков</div>
                    <div class="teeth-other__info">
                        <div class="teeth-other__info-column">
                            <div class="teeth-other__info-title">Справа</div>
                            <div class="teeth-other__info-text">I класс</div>
                        </div>
                        <div class="teeth-other__info-column">
                            <div class="teeth-other__info-title">Слева</div>
                            <div class="teeth-other__info-text">I класс</div>
                        </div>
                        <div class="teeth-other__info-column">
                            <div class="teeth-other__info-title">За счет чего</div>
                            <div class="teeth-other__info-text">Дистализация</div>
                        </div>
                    </div>
                    <div class="teeth-other__title">Использование эластичной тяги</div>
                    <div class="teeth-other__info">
                        <div class="teeth-other__info-column">
                            <div class="teeth-other__info-title">Справа</div>
                            <div class="teeth-other__info-text">Не использовать</div>
                        </div>
                        <div class="teeth-other__info-column">
                            <div class="teeth-other__info-title">Слева</div>
                            <div class="teeth-other__info-text">Не использовать</div>
                        </div>
                    </div>
                </div>
                <div class="teeth-other">
                    <div class="teeth-other__title">Соотношение резцов</div>
                    <div class="teeth-other__info-column">
                        <div class="teeth-other__info-title">Соотношение резцов по вертикали</div>
                        <div class="teeth-other__info-text">Уменьшить высоту резцового перекрытия</div>
                    </div>
                    <div class="teeth-other__info-column">
                        <div class="teeth-other__info-title">Соотношение резцов по транзверстали</div>
                        <div class="teeth-other__info-text">Улучшить</div>
                    </div>
                    <div class="teeth-other__title">Соотношение резцов по сагиттали</div>
                    <div class="teeth-other__info-column">
                        <div class="teeth-other__info-title">Верхние резцы</div>
                        <div class="teeth-other__info-text">Устранить ретрузию</div>
                    </div>
                    <div class="teeth-other__info-column">
                        <div class="teeth-other__info-title">Нижние резцы</div>
                        <div class="teeth-other__info-text">Не менять</div>
                    </div>
                    <div class="teeth-other__info-column">
                        <div class="teeth-other__info-title">Сагиттальная щель</div>
                        <div class="teeth-other__info-text">Установить резцы в контакт</div>
                    </div>
                </div>
                <div class="teeth-other">
                    <div class="teeth-other__title">Не перемещать следующие зубы (мосты, имплантаты, анкилозированные зубы, другое)</div>
                    <div class="teeth-other__teeth">
                        <div class="teeth-other__tooth">18</div>
                        <div class="teeth-other__tooth">12</div>
                        <div class="teeth-other__tooth">22</div>
                        <div class="teeth-other__tooth">25</div>
                    </div>
                    <div class="teeth-other__title">Избегать замки на следующих зубах (коронки, другое)</div>
                    <div class="teeth-other__teeth">
                        <div class="teeth-other__tooth">18</div>
                        <div class="teeth-other__tooth">12</div>
                        <div class="teeth-other__tooth">22</div>
                    </div>
                    <div class="teeth-other__title">Я собираюсь удалить следующие зубы</div>
                    <div class="teeth-other__teeth">
                        <div class="teeth-other__tooth">18</div>
                        <div class="teeth-other__tooth">12</div>
                    </div>
                </div>
                <div class="teeth-footer">
                    <div class="button button_empty teeth-footer__button"><a href="#" title="Редактировать карточку пациента"><img src="/image/icon/edit.svg" alt="icon"/>Редактировать карточку пациента</a></div>
                    <div class="button button_square teeth-footer__button"><a href="#" title="Удалить"><img src="/image/icon/trash.svg" alt="icon"/></a></div>
                </div>
            </div>
        </div>
    </section>
@endsection