import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import CheckboxGroup from 'react-checkbox-group';

import Select from '../Select';

class AddPatientPage extends Component {
  constructor(props) {
    super(props);

    this.state = {
      image_1: '',
      image_2: '',
      image_3: '',
      image_4: '',
      image_5: '',
      image_6: '',
      image_7: '',
      image_8: '',
      files: [],
      
      name: '',
      surname: '',
      middle_name: '',
      birthday: '',
      gender: '',
      
      diagnosis: '',
      pay_method: '',
      pay_option: '',

      treatment: '0',
      add_services: '1',

      dental_arches: '',
      upper_dentition: '',
      alignment: '',
      lower_dentition: '',

      right_fang: '',
      left_fang: '',
      what_fang: '',

      right_elastic_traction: '',
      left_elastic_traction: '',

      cutter: '0',

      upper_incisors: '',
      lower_incisors: '',

      middle_line: '',

      sagittal_fissure: '0',

      tooth: [],
      tooth_locks: [],
      tooth_del: [],

      comments: '',
    };

    this.handleInputChange = this.handleInputChange.bind(this);
    this.handlePhotoChange = this.handlePhotoChange.bind(this);
    this.handleSubmitClick = this.handleSubmitClick.bind(this);
    this.handleCheckboxChange = this.handleCheckboxChange.bind(this);
    
  }

  handleInputChange(event) {
    this.setState({
      [event.target.name]: event.target.value
    });
  }

  handleCheckboxChange(event) {
    this.setState({
      [event.target.name]: event.target.checked ? event.target.value : ''
    });
  }

  handlePhotoChange(event) {
    this.setState({
      [event.target.name]: Array.from(event.target.files)[0],
    });
  }


  handleSubmitClick() {
   
    if (this.state.name.length === 0 || this.state.surname.length === 0 || this.state.middle_name.length === 0) {
      alert('Ошибка!\nФИО обязательно для заполнения!');
      return;
    }

    if (this.state.birthday.length !== 10) {
      alert('Ошибка!\nДата рождения обязательна для заполнения! Также проверьте правильность формата даты: 00.00.0000');
      return;
    }

    //Инпут не заполняется из-за того, что не происходит onChange
    // if (this.state.gender.length === 0) {
    //   alert('Ошибка!Пол обязателен для заполнения!');
    //   return;
    // }

    if (this.state.image_1.length === 0) {
      alert('Ошибка!\nФото обязательно!');
      return;
    }
 
      
    let postData = {
      
      image_1: this.state.image_1,
      image_2: this.state.image_1,
      image_3: this.state.image_1,
      image_4: this.state.image_1,
      image_5: this.state.image_1,
      image_6: this.state.image_1,
      image_7: this.state.image_1,
      image_8: this.state.image_1,

      files: this.state.files,

      name: this.state.name,
      surname: this.state.surname,
      middle_name: this.state.middle_name,
      birthday: this.state.birthday,
      gender: this.state.gender,

      diagnosis: this.state.diagnosis,
      pay_method: this.state.pay_method,
      pay_option: this.state.pay_option,

      treatment: this.state.treatment,
      add_services: this.state.add_services,

      
      dental_arches: this.state.dental_arches,
      upper_dentition: this.state.upper_dentition,
      alignment: this.state.alignment,
      lower_dentition: this.state.lower_dentition,

      right_fang: this.state.right_fang,
      left_fang: this.state.left_fang,
      what_fang: this.state.what_fang,

      right_elastic_traction: this.state.right_elastic_traction,
      left_elastic_traction: this.state.left_elastic_traction,

      cutter: this.state.cutter,

      upper_incisors: this.state.upper_incisors,
      lower_incisors: this.state.lower_incisors,

      middle_line: this.state.middle_line,
      sagittal_fissure: this.state.sagittal_fissure,

      tooth: this.state.tooth,
      tooth_locks: this.state.tooth_locks,
      tooth_del: this.state.tooth_del,

      comments: this.state.comments,

      //Это нужно для валидации реквеста ?
      email: 'email@email.dg',
      phone: '89456993453',
      legal_name: 'legal_name',
      address: 'address',
      legal_address: 'legal_address',
      requisites: 'requisites',


      _token: document.querySelector('meta[name="csrf-token"]').content,
    };


    window.axios.post('/api/order', postData, { headers: { 'Content-Type': 'application/json' } }).then(response => {
      alert('Успех!\nПациент успешно добавлен в систему!');
      console.log(response);
    }).catch(event => {
      alert('Ошибка!\nПроверьте правильность введённых данных!');
      console.error(event);
    });

  }

  render() {
    return (
      <>
        <Select
          options={[ 'one', 'two' ]} onChange={this.handleSelectOnChange} /> />
        <div className="content-header">
          <div className="content-header__title">
            <img src="/image/icon/doc.svg" alt="icon" />
            <h1>Добавление пациента</h1>
          </div>
          <div className="content-header__back">
            <a href="#" title="Вернуться назад">
              <img src="/image/icon/arrow_back.svg" alt="icon" />
              Вернуться назад
            </a>
          </div>
        </div>
        <div className="content-patient-form">
          <form className="form-patient" name="form_patient" method="POST" action="" encType="multipart/form-data" acceptCharset="utf-8" autoComplete="off">
            <div className="form-group">
              <h3>Основная информация</h3>
              <div className="form-line">
                <div className="form-line__input"><input value={this.state.surname} onChange={this.handleInputChange} type="text" name="surname" placeholder="Фамилия" title="Фамилия" /><span className="icon user"></span></div>
                <div className="form-line__input"><input value={this.state.name} onChange={this.handleInputChange} type="text" name="name" placeholder="Имя" title="Имя" /><span className="icon user"></span></div>
                <div className="form-line__input"><input value={this.state.middle_name} onChange={this.handleInputChange} type="text" name="middle_name" placeholder="Отчество" title="Отчество" /><span className="icon user"></span></div>
              </div>
              <div className="form-line">
                <div className="form-line__input"><input value={this.state.birthday} onChange={this.handleInputChange} type="text" name="birthday" placeholder="Дата рождения" title="Дата рождения" /><span className="icon date"></span></div>
                <div className="form-select form-line__select">
                  <div className="select">
                    <input id="gender-id" type="hidden" name="gender_id" value="" />
                    <input className="select_box" value={this.state.gender} onChange={this.handleInputChange} id="gender" type="text" name="gender" placeholder="Пол пациента" title="Пол пациента" />
                    <span className="select-arrow"></span>
                    <div className="select_options"
                      data-for="gender">
                      <div className="option option-image" data-id="0">Мужской<span className="icon male"></span></div>
                      <div className="option option-image" data-id="1">Женский<span className="icon female"></span></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div className="form-group">
              <div className="form-group__title">Диагноз / Клиническое состояние</div>
              <div className="form-line">
                <textarea value={this.state.diagnosis} onChange={this.handleInputChange} name="diagnosis" placeholder="Основаня жалоба / Диагноз"></textarea>
              </div>
            </div>

            <div className="form-group form-group_end">
              <h3>Оплата</h3>
              <div className="form-line">
                <div className="form-select form-line__select">
                  <div className="form-line__title">Способ оплаты</div>
                  <div className="select">
                    <input value={this.state.pay_method} onChange={this.handleInputChange} id="pay-method-id" type="hidden" name="pay_method_id" value="" />
                    <input className="select_box" id="pay-method" type="text" value="" name="pay_method" title="Способ оплаты" />
                    <span className="select-arrow"></span>
                    <div className="select_options" data-for="pay-method">
                      <div className="option" data-id="0">Безналичный расчёт</div>
                    </div>
                  </div>
                </div>
                <div className="form-select form-line__select">
                  <div className="form-line__title">Тип оплаты</div>
                  <div className="select">
                    <input id="pay-option-id" type="hidden" name="pay_option_id" value="" />
                    <input value={this.state.pay_option} onChange={this.handleInputChange} className="select_box" id="pay-option" type="text" name="pay_option" placeholder="" title="Тип оплаты" />
                    <span className="select-arrow"></span>
                    <div className="select_options"
                      data-for="pay-option">
                      <div className="option" data-id="0">100% предоплата</div>
                      <div className="option" data-id="1">Рассрочка в два этапа</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div className="form-group form-group_end">
              <h3>Загрузка фотографий</h3>
              <div className="form-image">
                <div className="form-image__item">
                  <div className="form-line__title">Фото в профиль</div>
                  <div className="form-image__box"></div>
                  <div className="button button_upload form-image__button">
                    <input onChange={this.handlePhotoChange} id="image-1" type="file" name="image_1" accept="image/jpeg,image/png" />
                    <label htmlFor="image-1"><img src="/image/icon/camera.svg" alt="icon" /><span>Загрузить фото</span></label></div>
                </div>
                <div className="form-image__item">
                  <div className="form-line__title">Фото в анфас с улыбкой</div>
                  <div className="form-image__box"></div>
                  <div className="button button_upload form-image__button">
                    <input onChange={this.handlePhotoChange} id="image-2" type="file" name="image_2" accept="image/jpeg,image/png" />
                    <label htmlFor="image-2"><img src="/image/icon/camera.svg" alt="icon" /><span>Загрузить фото</span></label></div>
                </div>
                <div className="form-image__item">
                  <div className="form-line__title">Фото в анфас без улыбки</div>
                  <div className="form-image__box"></div>
                  <div className="button button_upload form-image__button">
                    <input onChange={this.handlePhotoChange} id="image-3" type="file" name="image_3" accept="image/jpeg,image/png" />
                    <label htmlFor="image-3"><img src="/image/icon/camera.svg" alt="icon" /><span>Загрузить фото</span></label></div>
                </div>
                <div className="form-image__item">
                  <div className="form-line__title">Латеральный вид слева</div>
                  <div className="form-image__box"></div>
                  <div className="button button_upload form-image__button">
                    <input onChange={this.handlePhotoChange} id="image-4" type="file" name="image_4" accept="image/jpeg,image/png" />
                    <label htmlFor="image-4"><img src="/image/icon/camera.svg" alt="icon" /><span>Загрузить фото</span></label></div>
                </div>
                <div className="form-image__item">
                  <div className="form-line__title">Фронтальный вид</div>
                  <div className="form-image__box"></div>
                  <div className="button button_upload form-image__button">
                    <input onChange={this.handlePhotoChange} id="image-5" type="file" name="image_5" accept="image/jpeg,image/png" />
                    <label htmlFor="image-5"><img src="/image/icon/camera.svg" alt="icon" /><span>Загрузить фото</span></label></div>
                </div>
                <div className="form-image__item">
                  <div className="form-line__title">Латеральный вид справа</div>
                  <div className="form-image__box"></div>
                  <div className="button button_upload form-image__button">
                    <input onChange={this.handlePhotoChange} id="image-6" type="file" name="image_6" accept="image/jpeg,image/png" />
                    <label htmlFor="image-6"><img src="/image/icon/camera.svg" alt="icon" /><span>Загрузить фото</span></label></div>
                </div>
                <div className="form-image__item">
                  <div className="form-line__title">Окклюзивный вид верхнего зубного ряда</div>
                  <div className="form-image__box"></div>
                  <div className="button button_upload form-image__button">
                    <input onChange={this.handlePhotoChange} id="image-7" type="file" name="image_7" accept="image/jpeg,image/png" />
                    <label htmlFor="image-7"><img src="/image/icon/camera.svg" alt="icon" /><span>Загрузить фото</span></label></div>
                </div>
                <div className="form-image__item">
                  <div className="form-line__title">Окклюзивный вид нижнего зубного ряда</div>
                  <div className="form-image__box"></div>
                  <div className="button button_upload form-image__button">
                    <input onChange={this.handlePhotoChange} id="image-8" type="file" name="image_8" accept="image/jpeg,image/png" />
                    <label htmlFor="image-8"><img src="/image/icon/camera.svg" alt="icon" /><span>Загрузить фото</span></label></div>
                </div>
              </div>
            </div>

            <div className="form-group form-group_end">
              <h3>Загрузка фото, ОПТГ и других файлов</h3>
              <div className="form-group">
                <div className="form-line">
                  <div className="form-line__input">
                    <div className="button button_upload">
                      <input id="files" type="file" name="files[]" multiple="multiple" accept="image/jpeg,image/png" />
                      <label htmlFor="files"><img src="/image/icon/clip_note.svg" alt="icon" /><span>Загрузить файлы</span></label></div>
                  </div>
                </div>
              </div>
            </div>

            <div className="form-group form-group-text form-group_end">
              <h3>Рецепт</h3>
              <div className="form-line__title">Курс лечения</div>
              <div className="form-line">
                <div className="radio">
                  <input checked={this.state.treatment === '0'} onChange={this.handleInputChange} id="treatment-1" type="radio" name="treatment" value="0" />
                  <label htmlFor="treatment-1">Курс с моделированием движения корней (глубокий анализ КТ, 3D план движения корней и коронок,<br />3 коррекции, неограниченное количество этапов)</label>
                </div>
              </div>
              <div className="form-line">
                <div className="radio">
                  <input checked={this.state.treatment === '1'} onChange={this.handleInputChange} id="treatment-2" type="radio" name="treatment" value="1" />
                  <label htmlFor="treatment-2">Полный (3D план движения коронок, 3 коррекции, неограниченное количество этапов)</label></div>
              </div>
              <div className="form-line">
                <div className="radio">
                  <input checked={this.state.treatment === '2'} onChange={this.handleInputChange} id="treatment-3" type="radio" name="treatment" value="2" />
                  <label htmlFor="treatment-3">Короткий (3D план движения коронок, до 14 этапов на 2 челюсти)</label>
                </div>
              </div>
              <div className="form-line">
                <div className="radio">
                  <input checked={this.state.treatment === '3'} onChange={this.handleInputChange} id="treatment-4" type="radio" name="treatment" value="3" />
                  <label htmlFor="treatment-4">Лечение одной челюсти(3D план движения коронок, 2 коррекции, неограниченное количество этапов на 1 челюсть)</label></div>
              </div>
              <div className="form-line">
                <div className="radio">
                  <input checked={this.state.treatment === '4'} onChange={this.handleInputChange} id="treatment-5" type="radio" name="treatment" value="4" />
                  <label htmlFor="treatment-5">Короткий Супер-короткий (3D план движения коронок, до 8 кап на 1 челюсть)</label></div>
              </div>
              <div className="form-line">
                <div className="radio">
                  <input checked={this.state.treatment === '5'} onChange={this.handleInputChange} id="treatment-6" type="radio" name="treatment" value="5" />
                  <label htmlFor="treatment-6">Только 3D план</label>
                </div>
              </div>
              <div className="form-line">
                <div className="radio">
                  <input checked={this.state.treatment === '6'} onChange={this.handleInputChange} id="treatment-7" type="radio" name="treatment" value="6" />
                  <label htmlFor="treatment-7">Дети</label></div>
              </div>
              <div className="form-line__title">Дополнительные услуги</div>
              <div className="form-line">
                <div className="checkbox">
                  <input checked={this.state.add_services === '1'} onChange={this.handleCheckboxChange} id="add-services" type="checkbox" name="add_services" value="1" />
                  <label htmlFor="add-services">Антропометрический анализ 3D-моделей (протокол антропометрической диагностики МГМСУ) - 5 000 руб</label></div>
              </div>
            </div>

            <div className="form-group form-group_end">
              <h3>Зубные дуги</h3>
              <div className="form-line">
                <div className="form-select form-line__select">
                  <div className="form-line__title">Необходимо лечить зубные дуги</div>
                  <div className="select">
                    <input id="dental-arches-id" type="hidden" name="dental_arches_id" value="" />
                    <input className="select_box" id="dental-arches" type="text" name="dental_arches" placeholder="" value="" title="Необходимо лечить зубные дуги" />
                    <span className="select-arrow"></span>
                    <div
                      className="select_options" data-for="dental-arches">
                      <div className="option" data-id="0">Обе</div>
                    </div>
                  </div>
                </div>
                <div className="form-select form-line__select">
                  <div className="form-line__title">Форма дуги верхнего зубного ряда</div>
                  <div className="select">
                    <input id="upper-dentition-id" type="hidden" name="upper_dentition_id" value="" />
                    <input className="select_box" id="upper-dentition" type="text" name="upper_dentition" placeholder="" value="" title="Форма дуги верхнего зубного ряда" />
                    <span className="select-arrow"></span>
                    <div
                      className="select_options" data-for="upper-dentition">
                      <div className="option" data-id="0">Не менять</div>
                    </div>
                  </div>
                </div>
              </div>
              <div className="form-line">
                <div className="form-select form-line__select">
                  <div className="form-line__title">Выравнивание зубов</div>
                  <div className="select">
                    <input id="alignment-id" type="hidden" name="alignment_id" value="" />
                    <input value={this.state.alignment} onChange={this.handleInputChange} className="select_box" id="alignment" type="text" name="alignment" title="Выравнивание зубов" />
                    <span className="select-arrow"></span>
                    <div className="select_options"
                      data-for="alignment">
                      <div className="option" data-id="0">По десневому краю</div>
                    </div>
                  </div>
                </div>
                <div className="form-select form-line__select">
                  <div className="form-line__title">Форма дуги нижнего зубного ряда</div>
                  <div className="select">
                    <input id="lower-dentition-id" type="hidden" name="lower_dentition_id" value="" />
                    <input className="select_box" id="lower-dentition" type="text" name="lower_dentition" placeholder="" value="" title="Форма дуги нижнего зубного ряда" />
                    <span className="select-arrow"></span>
                    <div className="select_options" data-for="lower-dentition">
                      <div className="option" data-id="0">Не менять</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div className="form-group">
              <h3>Соотношение клыков</h3>
              <div className="form-line">
                <div className="form-select form-line__select">
                  <div className="form-line__title">Справа</div>
                  <div className="select">
                    <input value={this.state.right_fang} onChange={this.handleInputChange} id="right-fang-ratio-id" type="hidden" name="right_fang_ratio_id" />
                    <input className="select_box" id="right-fang-ratio" type="text" name="right_fang_ratio" title="Справа" />
                    <span className="select-arrow"></span>
                    <div
                      className="select_options" data-for="right-fang-ratio">
                      <div className="option" data-id="0">I класс</div>
                    </div>
                  </div>
                </div>
                <div className="form-select form-line__select">
                  <div className="form-line__title">Слева</div>
                  <div className="select">
                    <input id="left-fang-ratio-id" type="hidden" name="left_fang_ratio_id" value="" />
                    <input className="select_box" id="left-fang-ratio" type="text" name="left_fang_ratio" placeholder="" value="" title="Слева" />
                    <span className="select-arrow"></span>
                    <div
                      className="select_options" data-for="left-fang-ratio">
                      <div className="option" data-id="0">I класс</div>
                    </div>
                  </div>
                </div>
                <div className="form-select form-line__select">
                  <div className="form-line__title">За счет чего</div>
                  <div className="select">
                    <input id="what-fang-ratio-id" type="hidden" name="what_fang_ratio_id" value="" />
                    <input className="select_box" id="what-fang-ratio" type="text" name="what_fang_ratio" placeholder="" value="" title="За счет чего" /><span className="select-arrow"></span>
                    <div
                      className="select_options" data-for="what-fang-ratio">
                      <div className="option" data-id="0">Дистализация</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div className="form-group">
              <h3>Использование эластичной тяги</h3>
              <div className="form-line">
                <div className="form-select form-line__select">
                  <div className="form-line__title">Справа</div>
                  <div className="select">
                    <input id="right-elastic-traction-id" type="hidden" name="right_elastic_traction_id" value="" />
                    <input className="select_box" id="right-elastic-traction" type="text" name="right_elastic_traction" placeholder="" value="" title="Справа" />
                    <span
                      className="select-arrow"></span>
                    <div className="select_options" data-for="right-elastic-traction">
                      <div className="option" data-id="0">Не использовать</div>
                    </div>
                  </div>
                </div>
                <div className="form-select form-line__select">
                  <div className="form-line__title">Слева</div>
                  <div className="select">
                    <input id="left-elastic-traction-id" type="hidden" name="left_elastic_traction_id" value="" />
                    <input className="select_box" id="left-elastic-traction" type="text" name="left_elastic_traction" placeholder="" value="" title="Слева" />
                    <span className="select-arrow"></span>
                    <div className="select_options" data-for="left-elastic-traction">
                      <div className="option" data-id="0">Не использовать</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div className="form-group">
              <h3>Соотношение резцов</h3>
              <div className="form-line__title">Соотношение резцов по вертикали</div>
              <div className="form-line">
                <div className="radio">
                  <input checked={this.state.cutter === '0'} onChange={this.handleInputChange} id="cutter-ratio-1" type="radio" name="cutter_ratio" value="0" />
                  <label htmlFor="cutter-ratio-1">Не менять</label></div>
              </div>
              <div className="form-line">
                <div className="radio">
                  <input checked={this.state.cutter === '1'} onChange={this.handleInputChange} id="cutter-ratio-2" type="radio" name="cutter_ratio" value="1" />
                  <label htmlFor="cutter-ratio-2">Уменьшить высоту резцового перекрытия</label>
              </div>
              </div>
              <div className="form-line">
                <div className="radio">
                  <input checked={this.state.cutter === '2'} onChange={this.handleInputChange} id="cutter-ratio-3" type="radio" name="cutter_ratio" value="2" />
                  <label htmlFor="cutter-ratio-3">Увеличить высоту резцового перекрытия</label>
                </div>
              </div>
            </div>

            <div className="form-group">
              <h3>Соотношение резцов по сагиттали</h3>
              <div className="form-line">
                <div className="form-select form-line__select">
                  <div className="form-line__title">Верхние резцы</div>
                  <div className="select"><input id="upper-incisors-id" type="hidden" name="upper_incisors_id" value="" /><input className="select_box" id="upper-incisors" type="text" name="upper_incisors" placeholder="" value="" title="Верхние резцы" /><span className="select-arrow"></span>
                    <div
                      className="select_options" data-for="upper-incisors">
                      <div className="option" data-id="0">Не менять</div>
                    </div>
                  </div>
                </div>
              </div>
              <div className="form-line">
                <div className="form-select form-line__select">
                  <div className="form-line__title">Нижние резцы</div>
                  <div className="select"><input id="lower-incisors-id" type="hidden" name="lower_incisors_id" value="" /><input className="select_box" id="lower-incisors" type="text" name="lower_incisors" placeholder="" value="" title="Нижние резцы" /><span className="select-arrow"></span>
                    <div
                      className="select_options" data-for="lower-incisors">
                      <div className="option" data-id="0">Не менять</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div className="form-group form-group_end">
              <h3>Соотношение по трансверзали (средняя линия)</h3>
              <div className="form-line form-line_long">
                <div className="form-select form-line__select">
                  <div className="select"><input id="middle-line-id" type="hidden" name="middle_line_id" value="" /><input className="select_box" id="middle-line" type="text" name="middle_line" placeholder="" value="" title="Соотношение по трансверзали (средняя линия)" /><span className="select-arrow"></span>
                    <div
                      className="select_options" data-for="middle-line">
                      <div className="option" data-id="0">Не менять</div>
                    </div>
                  </div>
                </div>
              </div>
              <div className="form-line__title">Сагиттальная щель</div>
              <div className="form-line">
                <div className="radio">
                  <input checked={this.state.sagittal_fissure === '0'} onChange={this.handleInputChange} id="sagittal-fissure-1" type="radio" name="sagittal_fissure" value="0" />
                  <label htmlFor="sagittal-fissure-1">Не менять</label>
                </div>
              </div>
              <div className="form-line">
                <div className="radio">
                  <input checked={this.state.sagittal_fissure === '1'} onChange={this.handleInputChange} id="sagittal-fissure-2" type="radio" name="sagittal_fissure" value="1" />
                  <label htmlFor="sagittal-fissure-2">Установить резцы в контакт</label></div>
              </div>
              <div className="form-line">
                <div className="radio">
                  <input checked={this.state.sagittal_fissure === '2'} onChange={this.handleInputChange} id="sagittal-fissure-3" type="radio" name="sagittal_fissure" value="2" />
                  <label htmlFor="sagittal-fissure-3">Сохранить, если необходимо для поддержания класса</label></div>
              </div>
            </div>

            <div className="form-group">
              <h3>Выборка зубов</h3>
              <div className="form-line__title">Не перемещать следующие зубы (мосты, имплантаты, анкилозированные зубы, другое)</div>
              <div className="form-line">
                <div className="checkbox"><input id="tooth-18" type="checkbox" name="tooth_18" value="1" checked="checked" /><label htmlFor="tooth-18">18</label></div>
                <div className="checkbox"><input id="tooth-17" type="checkbox" name="tooth_17" value="0" /><label htmlFor="tooth-17">17</label></div>
                <div className="checkbox"><input id="tooth-16" type="checkbox" name="tooth_16" value="0" /><label htmlFor="tooth-16">16</label></div>
                <div className="checkbox"><input id="tooth-15" type="checkbox" name="tooth_15" value="0" /><label htmlFor="tooth-15">15</label></div>
                <div className="checkbox"><input id="tooth-14" type="checkbox" name="tooth_14" value="0" /><label htmlFor="tooth-14">14</label></div>
                <div className="checkbox"><input id="tooth-13" type="checkbox" name="tooth_13" value="0" /><label htmlFor="tooth-13">13</label></div>
                <div className="checkbox"><input id="tooth-12" type="checkbox" name="tooth_12" value="1" checked="checked" /><label htmlFor="tooth-12">12</label></div>
                <div className="checkbox"><input id="tooth-11" type="checkbox" name="tooth_11" value="0" /><label htmlFor="tooth-11">11</label></div>
              </div>
              <div className="form-line">
                <div className="checkbox"><input id="tooth-21" type="checkbox" name="tooth_21" value="0" /><label htmlFor="tooth-21">21</label></div>
                <div className="checkbox"><input id="tooth-22" type="checkbox" name="tooth_22" value="1" checked="checked" /><label htmlFor="tooth-22">22</label></div>
                <div className="checkbox"><input id="tooth-23" type="checkbox" name="tooth_23" value="0" /><label htmlFor="tooth-23">23</label></div>
                <div className="checkbox"><input id="tooth-24" type="checkbox" name="tooth_24" value="0" /><label htmlFor="tooth-24">24</label></div>
                <div className="checkbox"><input id="tooth-25" type="checkbox" name="tooth_25" value="1" checked="checked" /><label htmlFor="tooth-25">25</label></div>
                <div className="checkbox"><input id="tooth-26" type="checkbox" name="tooth_26" value="0" /><label htmlFor="tooth-26">26</label></div>
                <div className="checkbox"><input id="tooth-27" type="checkbox" name="tooth_27" value="0" /><label htmlFor="tooth-27">27</label></div>
                <div className="checkbox"><input id="tooth-28" type="checkbox" name="tooth_28" value="0" /><label htmlFor="tooth-28">28</label></div>
              </div>
              <div className="form-line">
                <div className="checkbox"><input id="tooth-48" type="checkbox" name="tooth_48" value="0" /><label htmlFor="tooth-48">48</label></div>
                <div className="checkbox"><input id="tooth-47" type="checkbox" name="tooth_47" value="0" /><label htmlFor="tooth-47">47</label></div>
                <div className="checkbox"><input id="tooth-46" type="checkbox" name="tooth_46" value="0" /><label htmlFor="tooth-46">46</label></div>
                <div className="checkbox"><input id="tooth-45" type="checkbox" name="tooth_45" value="0" /><label htmlFor="tooth-45">45</label></div>
                <div className="checkbox"><input id="tooth-44" type="checkbox" name="tooth_44" value="0" /><label htmlFor="tooth-44">44</label></div>
                <div className="checkbox"><input id="tooth-43" type="checkbox" name="tooth_43" value="0" /><label htmlFor="tooth-43">43</label></div>
                <div className="checkbox"><input id="tooth-42" type="checkbox" name="tooth_42" value="0" /><label htmlFor="tooth-42">42</label></div>
                <div className="checkbox"><input id="tooth-41" type="checkbox" name="tooth_41" value="0" /><label htmlFor="tooth-41">41</label></div>
              </div>
              <div className="form-line">
                <div className="checkbox"><input id="tooth-31" type="checkbox" name="tooth_31" value="0" /><label htmlFor="tooth-31">31</label></div>
                <div className="checkbox"><input id="tooth-32" type="checkbox" name="tooth_32" value="0" /><label htmlFor="tooth-32">32</label></div>
                <div className="checkbox"><input id="tooth-33" type="checkbox" name="tooth_33" value="0" /><label htmlFor="tooth-33">33</label></div>
                <div className="checkbox"><input id="tooth-34" type="checkbox" name="tooth_34" value="0" /><label htmlFor="tooth-34">34</label></div>
                <div className="checkbox"><input id="tooth-35" type="checkbox" name="tooth_35" value="0" /><label htmlFor="tooth-35">35</label></div>
                <div className="checkbox"><input id="tooth-36" type="checkbox" name="tooth_36" value="0" /><label htmlFor="tooth-36">36</label></div>
                <div className="checkbox"><input id="tooth-37" type="checkbox" name="tooth_37" value="0" /><label htmlFor="tooth-37">37</label></div>
                <div className="checkbox"><input id="tooth-38" type="checkbox" name="tooth_38" value="0" /><label htmlFor="tooth-38">38</label></div>
              </div>
            </div>

            <div className="form-group">
              <div className="form-line__title">Избегать замки на следующих зубах (коронки, другое)</div>
              <div className="form-line">
                <div className="checkbox"><input id="tooth-locks-18" type="checkbox" name="tooth_locks_18" value="1" checked="checked" /><label htmlFor="tooth-locks-18">18</label></div>
                <div className="checkbox"><input id="tooth-locks-17" type="checkbox" name="tooth_locks_17" value="0" /><label htmlFor="tooth-locks-17">17</label></div>
                <div className="checkbox"><input id="tooth-locks-16" type="checkbox" name="tooth_locks_16" value="0" /><label htmlFor="tooth-locks-16">16</label></div>
                <div className="checkbox"><input id="tooth-locks-15" type="checkbox" name="tooth_locks_15" value="0" /><label htmlFor="tooth-locks-15">15</label></div>
                <div className="checkbox"><input id="tooth-locks-14" type="checkbox" name="tooth_locks_14" value="0" /><label htmlFor="tooth-locks-14">14</label></div>
                <div className="checkbox"><input id="tooth-locks-13" type="checkbox" name="tooth_locks_13" value="0" /><label htmlFor="tooth-locks-13">13</label></div>
                <div className="checkbox"><input id="tooth-locks-12" type="checkbox" name="tooth_locks_12" value="1" checked="checked" /><label htmlFor="tooth-locks-12">12</label></div>
                <div className="checkbox"><input id="tooth-locks-11" type="checkbox" name="tooth_locks_11" value="0" /><label htmlFor="tooth-locks-11">11</label></div>
              </div>
              <div className="form-line">
                <div className="checkbox"><input id="tooth-locks-21" type="checkbox" name="tooth_locks_21" value="0" /><label htmlFor="tooth-locks-21">21</label></div>
                <div className="checkbox"><input id="tooth-locks-22" type="checkbox" name="tooth_locks_22" value="1" checked="checked" /><label htmlFor="tooth-locks-22">22</label></div>
                <div className="checkbox"><input id="tooth-locks-23" type="checkbox" name="tooth_locks_23" value="0" /><label htmlFor="tooth-locks-23">23</label></div>
                <div className="checkbox"><input id="tooth-locks-24" type="checkbox" name="tooth_locks_24" value="0" /><label htmlFor="tooth-locks-24">24</label></div>
                <div className="checkbox"><input id="tooth-locks-25" type="checkbox" name="tooth_locks_25" value="1" checked="checked" /><label htmlFor="tooth-locks-25">25</label></div>
                <div className="checkbox"><input id="tooth-locks-26" type="checkbox" name="tooth_locks_26" value="0" /><label htmlFor="tooth-locks-26">26</label></div>
                <div className="checkbox"><input id="tooth-locks-27" type="checkbox" name="tooth_locks_27" value="0" /><label htmlFor="tooth-locks-27">27</label></div>
                <div className="checkbox"><input id="tooth-locks-28" type="checkbox" name="tooth_locks_28" value="0" /><label htmlFor="tooth-locks-28">28</label></div>
              </div>
              <div className="form-line">
                <div className="checkbox"><input id="tooth-locks-48" type="checkbox" name="tooth_locks_48" value="0" /><label htmlFor="tooth-locks-48">48</label></div>
                <div className="checkbox"><input id="tooth-locks-47" type="checkbox" name="tooth_locks_47" value="0" /><label htmlFor="tooth-locks-47">47</label></div>
                <div className="checkbox"><input id="tooth-locks-46" type="checkbox" name="tooth_locks_46" value="0" /><label htmlFor="tooth-locks-46">46</label></div>
                <div className="checkbox"><input id="tooth-locks-45" type="checkbox" name="tooth_locks_45" value="0" /><label htmlFor="tooth-locks-45">45</label></div>
                <div className="checkbox"><input id="tooth-locks-44" type="checkbox" name="tooth_locks_44" value="0" /><label htmlFor="tooth-locks-44">44</label></div>
                <div className="checkbox"><input id="tooth-locks-43" type="checkbox" name="tooth_locks_43" value="0" /><label htmlFor="tooth-locks-43">43</label></div>
                <div className="checkbox"><input id="tooth-locks-42" type="checkbox" name="tooth_locks_42" value="0" /><label htmlFor="tooth-locks-42">42</label></div>
                <div className="checkbox"><input id="tooth-locks-41" type="checkbox" name="tooth_locks_41" value="0" /><label htmlFor="tooth-locks-41">41</label></div>
              </div>
              <div className="form-line">
                <div className="checkbox"><input id="tooth-locks-31" type="checkbox" name="tooth_locks_31" value="0" /><label htmlFor="tooth-locks-31">31</label></div>
                <div className="checkbox"><input id="tooth-locks-32" type="checkbox" name="tooth_locks_32" value="0" /><label htmlFor="tooth-locks-32">32</label></div>
                <div className="checkbox"><input id="tooth-locks-33" type="checkbox" name="tooth_locks_33" value="0" /><label htmlFor="tooth-locks-33">33</label></div>
                <div className="checkbox"><input id="tooth-locks-34" type="checkbox" name="tooth_locks_34" value="0" /><label htmlFor="tooth-locks-34">34</label></div>
                <div className="checkbox"><input id="tooth-locks-35" type="checkbox" name="tooth_locks_35" value="0" /><label htmlFor="tooth-locks-35">35</label></div>
                <div className="checkbox"><input id="tooth-locks-36" type="checkbox" name="tooth_locks_36" value="0" /><label htmlFor="tooth-locks-36">36</label></div>
                <div className="checkbox"><input id="tooth-locks-37" type="checkbox" name="tooth_locks_37" value="0" /><label htmlFor="tooth-locks-37">37</label></div>
                <div className="checkbox"><input id="tooth-locks-38" type="checkbox" name="tooth_locks_38" value="0" /><label htmlFor="tooth-locks-38">38</label></div>
              </div>
            </div>

            <div className="form-group form-group_end">
              <div className="form-line__title">Я собираюсь удалить следующие зубы</div>
              <div className="form-line">
                <div className="checkbox"><input id="tooth-del-18" type="checkbox" name="tooth_del_18" value="1" checked="checked" /><label htmlFor="tooth-del-18">18</label></div>
                <div className="checkbox"><input id="tooth-del-17" type="checkbox" name="tooth_del_17" value="0" /><label htmlFor="tooth-del-17">17</label></div>
                <div className="checkbox"><input id="tooth-del-16" type="checkbox" name="tooth_del_16" value="0" /><label htmlFor="tooth-del-16">16</label></div>
                <div className="checkbox"><input id="tooth-del-15" type="checkbox" name="tooth_del_15" value="0" /><label htmlFor="tooth-del-15">15</label></div>
                <div className="checkbox"><input id="tooth-del-14" type="checkbox" name="tooth_del_14" value="0" /><label htmlFor="tooth-del-14">14</label></div>
                <div className="checkbox"><input id="tooth-del-13" type="checkbox" name="tooth_del_13" value="0" /><label htmlFor="tooth-del-13">13</label></div>
                <div className="checkbox"><input id="tooth-del-12" type="checkbox" name="tooth_del_12" value="1" checked="checked" /><label htmlFor="tooth-del-12">12</label></div>
                <div className="checkbox"><input id="tooth-del-11" type="checkbox" name="tooth_del_11" value="0" /><label htmlFor="tooth-del-11">11</label></div>
              </div>
              <div className="form-line">
                <div className="checkbox"><input id="tooth-del-21" type="checkbox" name="tooth_del_21" value="0" /><label htmlFor="tooth-del-21">21</label></div>
                <div className="checkbox"><input id="tooth-del-22" type="checkbox" name="tooth_del_22" value="1" checked="checked" /><label htmlFor="tooth-del-22">22</label></div>
                <div className="checkbox"><input id="tooth-del-23" type="checkbox" name="tooth_del_23" value="0" /><label htmlFor="tooth-del-23">23</label></div>
                <div className="checkbox"><input id="tooth-del-24" type="checkbox" name="tooth_del_24" value="0" /><label htmlFor="tooth-del-24">24</label></div>
                <div className="checkbox"><input id="tooth-del-25" type="checkbox" name="tooth_del_25" value="1" checked="checked" /><label htmlFor="tooth-del-25">25</label></div>
                <div className="checkbox"><input id="tooth-del-26" type="checkbox" name="tooth_del_26" value="0" /><label htmlFor="tooth-del-26">26</label></div>
                <div className="checkbox"><input id="tooth-del-27" type="checkbox" name="tooth_del_27" value="0" /><label htmlFor="tooth-del-27">27</label></div>
                <div className="checkbox"><input id="tooth-del-28" type="checkbox" name="tooth_del_28" value="0" /><label htmlFor="tooth-del-28">28</label></div>
              </div>
              <div className="form-line">
                <div className="checkbox"><input id="tooth-del-48" type="checkbox" name="tooth_del_48" value="0" /><label htmlFor="tooth-del-48">48</label></div>
                <div className="checkbox"><input id="tooth-del-47" type="checkbox" name="tooth_del_47" value="0" /><label htmlFor="tooth-del-47">47</label></div>
                <div className="checkbox"><input id="tooth-del-46" type="checkbox" name="tooth_del_46" value="0" /><label htmlFor="tooth-del-46">46</label></div>
                <div className="checkbox"><input id="tooth-del-45" type="checkbox" name="tooth_del_45" value="0" /><label htmlFor="tooth-del-45">45</label></div>
                <div className="checkbox"><input id="tooth-del-44" type="checkbox" name="tooth_del_44" value="0" /><label htmlFor="tooth-del-44">44</label></div>
                <div className="checkbox"><input id="tooth-del-43" type="checkbox" name="tooth_del_43" value="0" /><label htmlFor="tooth-del-43">43</label></div>
                <div className="checkbox"><input id="tooth-del-42" type="checkbox" name="tooth_del_42" value="0" /><label htmlFor="tooth-del-42">42</label></div>
                <div className="checkbox"><input id="tooth-del-41" type="checkbox" name="tooth_del_41" value="0" /><label htmlFor="tooth-del-41">41</label></div>
              </div>
              <div className="form-line">
                <div className="checkbox"><input id="tooth-del-31" type="checkbox" name="tooth_del_31" value="0" /><label htmlFor="tooth-del-31">31</label></div>
                <div className="checkbox"><input id="tooth-del-32" type="checkbox" name="tooth_del_32" value="0" /><label htmlFor="tooth-del-32">32</label></div>
                <div className="checkbox"><input id="tooth-del-33" type="checkbox" name="tooth_del_33" value="0" /><label htmlFor="tooth-del-33">33</label></div>
                <div className="checkbox"><input id="tooth-del-34" type="checkbox" name="tooth_del_34" value="0" /><label htmlFor="tooth-del-34">34</label></div>
                <div className="checkbox"><input id="tooth-del-35" type="checkbox" name="tooth_del_35" value="0" /><label htmlFor="tooth-del-35">35</label></div>
                <div className="checkbox"><input id="tooth-del-36" type="checkbox" name="tooth_del_36" value="0" /><label htmlFor="tooth-del-36">36</label></div>
                <div className="checkbox"><input id="tooth-del-37" type="checkbox" name="tooth_del_37" value="0" /><label htmlFor="tooth-del-37">37</label></div>
                <div className="checkbox"><input id="tooth-del-38" type="checkbox" name="tooth_del_38" value="0" /><label htmlFor="tooth-del-38">38</label></div>
              </div>
            </div>

            <div className="form-group">
              <div className="form-line__title">Комментарии (какой результат вы хотите получить), прочие инструкции</div>
              <div className="form-line">
                <textarea value={this.state.comments} onChange={this.handleInputChange} name="comments" placeholder="Какой результат Вы хотите получить? / Прочие инструкции..."></textarea>
              </div>
            </div>
            <div className="form-group">
              <div className="button form-button">
                <a onClick={this.handleSubmitClick} style={{ cursor: 'pointer' }} title="Сохранить данные о пациенте">Сохранить данные о пациенте</a>
                </div>
            </div>

          </form>
        </div>


      </>
    );
  }
}

if (document.getElementById('react-db-add-patient-page')) {
  ReactDOM.render(<AddPatientPage />, document.getElementById('react-db-add-patient-page'));
}