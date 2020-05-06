import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class AddDoctorPage extends Component {
  constructor(props) {
    super(props);

    this.state = {
      photo: '',
      photoPreview: null,

      name: '',
      birthday: '',
      position: '',
      phone: '',
      email: '',
      description: '',
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

    if (this.state.position.length === 0) {
      alert('Ошибка!\nДолжность обязательна для заполнения!');
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

    if (this.state.birthday.length !== 10) {
      alert('Ошибка!\nДата рождения обязательна для заполнения! Также проверьте правильность формата даты: 00.00.0000');
      return;
    }

    if (this.state.description.length === 0) {
      alert('Ошибка!\nОписание обязательно для заполнения!');
      return;
    }

    let postData = new FormData();

    postData.append('name', this.state.name);
    postData.append('email', this.state.email);
    postData.append('phone', this.state.phone);
    postData.append('position', this.state.position);
    postData.append('birthday', this.state.birthday);
    postData.append('description', this.state.description);
    postData.append('photo', this.state.photo);

    postData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

    window.axios.post('/api/doctor', postData, { headers: { 'Content-Type': 'multipart/form-data' } }).then(response => {
      alert('Успех!\nДоктор успешно добавлен в систему!');
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
            <img src="/image/icon/doc.svg" alt="icon" />
            <h1>Добавление врача</h1>
          </div>
          <div className="content-header__back">
            <a href="/dashboard/doctors" title="Вернуться назад">
              <img src="/image/icon/arrow_back.svg" alt="icon" />
              Вернуться назад
            </a>
          </div>
        </div>
        <div className="content-form">
          <form className="form-doc" name="form_doc" encType="multipart/form-data" autoComplete="off">
            <div className="form-group">
              <div className="form-image">
                <div className="form-image__box">
                  <div className="button button_upload form-image__button">
                    <input onChange={this.handlePhotoChange} name="image" type="file" id="doc-image" accept="image/jpeg,image/png" />
                    <label htmlFor="doc-image">
                      <img src="/image/icon/camera.svg" alt="icon" />
                      <span>Загрузить фото</span>
                    </label>
                  </div>
                  {this.state.photoPreview !== null && <img src={this.state.photoPreview} style={{ width: '100%', height: '100%' }} />}
                </div>
              </div>
              <div className="form-data">
                <div className="form-data__title">Заполнение данных</div>
                <div className="form-line">
                  <div className="form-line__input">
                    <input value={this.state.name} onChange={this.handleInputChange} type="text" name="name" placeholder="ФИО врача" title="ФИО врача" />
                    <span className="icon user"></span>
                  </div>
                  <div className="form-line__input">
                    <input value={this.state.birthday} onChange={this.handleInputChange} type="text" name="birthday" placeholder="Дата рождения" title="Дата рождения" />
                    <span className="icon date"></span>
                  </div>
                  <div className="form-line__input">
                    <input value={this.state.position} onChange={this.handleInputChange} type="text" name="position" placeholder="Должность" title="Должность" />
                    <span className="icon specialty"></span>
                  </div>
                </div>
                <div className="form-line">
                  <div className="form-line__input">
                    <input value={this.state.phone} onChange={this.handleInputChange} type="text" name="phone" placeholder="Номер телефона" title="Номер телефона" />
                    <span className="icon phone"></span>
                  </div>
                  <div className="form-line__input">
                    <input value={this.state.email} onChange={this.handleInputChange} type="text" name="email" placeholder="Электронная почта" title="Электронная почта" />
                    <span className="icon email"></span>
                  </div>
                </div>
                <div className="form-line">
                  <textarea value={this.state.description} onChange={this.handleInputChange} name="description" placeholder="Описание"></textarea>
                </div>
              </div>
            </div>
            <div className="form-group">
              <div className="button form-button">
                <a onClick={this.handleSubmitClick} style={{ cursor: 'pointer' }} title="Подтвердить добавление врача">Подтвердить добавление врача</a>
              </div>
            </div>
          </form>
        </div>
      </>
    );
  }
}

if (document.getElementById('react-db-add-doctor-page')) {
  ReactDOM.render(<AddDoctorPage />, document.getElementById('react-db-add-doctor-page'));
}