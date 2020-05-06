import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class AddClinicPage extends Component {
  constructor(props) {
    super(props);

    this.state = {
      photo: '',
      photoPreview: null,

      name: '',
      email: '',
      phone: '',
      legal_name: '',
      address: '',
      legal_address: '',
      requisites: '',
    };

    this.handleInputChange = this.handleInputChange.bind(this);
    this.handlePhotoChange = this.handlePhotoChange.bind(this);
    this.handleSubmitClick = this.handleSubmitClick.bind(this);
  }

  handleInputChange(event) {
    this.setState({
      [event.target.name]: event.target.value
    });
  }

  handlePhotoChange(event) {
    this.setState({
      photo: Array.from(event.target.files)[0],
      photoPreview: URL.createObjectURL(Array.from(event.target.files)[0])
    });
  }

  handleSubmitClick() {
    if (this.state.name.length === 0) {
      alert('Ошибка!\nФИО обязательно для заполнения!');
      return;
    }

    if (this.state.phone.length === 0) {
      alert('Ошибка!\nНомер телефона обязателен для заполнения!');
      return;
    }

    if (this.state.email.length < 4 || this.state.email.indexOf('@') === -1) {
      alert('Ошибка!\nЭлектронная почта обязательна для заполнения!');
      return;
    }

    if (this.state.legal_name === 0){
      alert('Ошибка!\nЮр. название обязательно для заполнения!');
      return;
    }

    if (this.state.address === 0) {
      alert('Ошибка!\nАдрес обязателен для заполнения!');
      return;
    }

    if (this.state.legal_address === 0) {
      alert('Ошибка!\nЮридический адрес обязателен для заполнения!');
      return;
    }

    if (this.state.requisites === 0) {
      alert('Ошибка!\nРеквизиты обязательны для заполнения!');
      return;
    }

    let postData = new FormData();

    postData.append('name', this.state.name);
    postData.append('email', this.state.email);
    postData.append('phone', this.state.phone);
    postData.append('legal_name', this.state.legal_name);
    postData.append('legal_address', this.state.legal_address);
    postData.append('address', this.state.address);
    postData.append('requisites', this.state.requisites);
    postData.append('photo', this.state.photo);

    window.axios.post('/api/clinic', postData, { headers: { 'Content-Type': 'multipart/form-data' } }).then(() => {
      alert('Успех!\nКлиника успешно добавлена в систему!');
    }).catch(event => {
      alert('Ошибка!\nПроверьте правильность введённых данных!');
      console.error(event);
    });
  }

  render() {
    return (
      <>
        <div className="content-header">
          <div className="content-header__title">
            <img src="/image/icon/clinic.svg" alt="icon"/>
            <h1>Добавление клиники</h1>
          </div>
          <div className="content-header__back">
            <a href="#" title="Вернуться назад">
              <img src="/image/icon/arrow_back.svg" alt="icon"/>
              Вернуться назад
            </a>
          </div>
        </div>
        <div className="content-form">
          <form className="form-clinic" name="form_clinic" encType="multipart/form-data" autoComplete="off">
            <div className="form-group">
              <div className="form-image">
                <div className="form-image__box">
                  {this.state.photoPreview !== null && <img src={this.state.photoPreview} style={{ width: '100%', height: '100%' }} />}
                </div>
                <div className="button button_upload form-image__button">
                  <input onChange={this.handlePhotoChange} id="clinic-image" type="file" name="image" accept="image/jpeg,image/png"/>
                  <label htmlFor="clinic-image">
                    <img src="/image/icon/camera.svg" alt="icon"/>
                    <span>Загрузить логотип</span>
                  </label>
                </div>
              </div>
              <div className="form-data">
                <div className="form-data__title">Заполнение данных</div>
                <div className="form-line">
                  <div className="form-line__input">
                    <input onChange={this.handleInputChange} type="text" name="name" placeholder="Фактическое название клиники"
                           title="Фактическое название клиники"/>
                    <span className="icon info"></span>
                  </div>
                  <div className="form-line__input">
                    <input onChange={this.handleInputChange} type="text" name="phone" placeholder="Телефон клиники" title="Телефон клиники"/>
                    <span className="icon phone"></span>
                  </div>
                </div>
                <div className="form-line">
                  <div className="form-line__input">
                    <input onChange={this.handleInputChange} type="text" name="legal_name" placeholder="Юр. название клиники"
                           title="Юр. название клиники"/>
                    <span className="icon info"></span>
                  </div>
                  <div className="form-line__input">
                    <input onChange={this.handleInputChange} type="text" name="email" placeholder="Электронная почта" title="Электронная почта"/>
                    <span className="icon email"></span>
                  </div>
                </div>
                <div className="form-line form-line_column">
                  <label htmlFor="clinic-legal-address">Юридический адрес клиники</label>
                  <input onChange={this.handleInputChange} id="clinic-legal-address" type="text" name="legal_address"
                         placeholder="Введите юридический адрес" title="Введите юридический адрес"/>
                </div>
                <div className="form-line form-line_column">
                  <label htmlFor="clinic-address">Физический адрес клиники</label>
                  <input onChange={this.handleInputChange} id="clinic-address" type="text" name="address" placeholder="Введите фактический адрес"
                         title="Введите фактический адрес"/>
                </div>
                <div className="form-line form-line_column">
                  <label htmlFor="clinic-requisites">Реквизиты компании</label>
                  <input onChange={this.handleInputChange} id="clinic-requisites" type="text" name="requisites" placeholder="Введите реквизиты компании"
                         title="Введите реквизиты компании"/>
                </div>
              </div>
            </div>
            <div className="form-group">
              <div className="button form-button">
                <a onClick={this.handleSubmitClick} style={{ cursor: 'pointer' }} title="Подтвердить добавление клиники">Подтвердить добавление клиники</a>
              </div>
            </div>
          </form>
        </div>
      </>
    );
  }
}

if (document.getElementById('react-db-add-clinic-page')) {
  ReactDOM.render(<AddClinicPage />, document.getElementById('react-db-add-clinic-page'));
}