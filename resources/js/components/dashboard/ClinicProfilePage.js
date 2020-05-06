import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Paginator from "../Paginator";

class ClinicProfilePage extends Component {
  constructor(props) {
    super(props);

    this.state = {
      clinic: null,
      clinicNotFound: false,
      loadingError: false
    };
  }

  componentDidMount() {
    window.axios.get('/api/clinic/' + this.props.clinicId).then(response => {
      this.setState({
        clinic: response.data.data
      });
    }).catch(error => {
      if (error.response.status === 404) {
        this.setState({
          clinicNotFound: true
        });
      } else {
        this.setState({
          loadingError: true
        });
      }
    });
  }

  render() {
    let body;

    if (this.state.clinicNotFound) {
      body = (
        <h2>Профиль не найден</h2>
      );
    } else if (this.state.loadingError) {
      body = (
        <h2>Ошибка загрузки профиля</h2>
      );
    } else {
      body = (
        <>
          <div className="content-clinic">
            <div className="content-clinic-image">
              <img src={this.state.clinic?.clinic_info.photo !== null ? this.state.clinic?.clinic_info.photo : '/image/icon/user_empty.svg'} alt="clinic logo"/>
            </div>
            <div className="content-clinic-info">
              <div className="content-clinic-info__name">Клиника &laquo;ДЕЛЬТА&raquo;</div>
              <ul className="content-clinic-info__group">
                <li className="content-clinic-info__specialty">
                  <img src="/image/icon/info.svg" alt="icon"/>
                  {this.state.clinic?.clinic_info.legal_name}
                </li>
                <li className="content-clinic-info__phone">
                  <img src="/image/icon/phone.svg" alt="icon"/>
                  {this.state.clinic?.phone}
                </li>
                <li className="content-clinic-info__date">
                  <img src="/image/icon/user.svg" alt="icon"/>
                  {this.state.clinic?.name}
                </li>
              </ul>
              <ul className="content-clinic-info__requisites">
                <li>
                  <div className="content-clinic-info__requisites-title">Юр. адрес:</div>
                  <div className="content-clinic-info__requisites-text">{this.state.clinic?.clinic_info.legal_address}</div>
                </li>
                <li>
                  <div className="content-clinic-info__requisites-title">Физ. адрес:</div>
                  <div className="content-clinic-info__requisites-text">{this.state.clinic?.clinic_info.address}</div>
                </li>
                <li>
                  <div className="content-clinic-info__requisites-title">Реквизиты компании:</div>
                  <div className="content-clinic-info__requisites-cut-text">{this.state.clinic?.clinic_info.requisites}</div>
                </li>
              </ul>
              <div className="content-clinic-info__search-panel">
                <div className="button button_square content-clinic-info__search-panel-button">
                  <a href="/view/admin/clinic_profile_edit.html" title="Редактировать информацию">
                    <img src="/image/icon/edit.svg" alt="icon"/>
                  </a>
                </div>
                <div className="button button_square content-clinic-info__search-panel-button">
                  <a href="#" title="Удалить">
                    <img src="/image/icon/trash.svg" alt="icon"/>
                  </a>
                </div>
                <div className="form content-clinic-info__search-panel-search">
                  <input type="search" name="search" autoComplete="off" placeholder="Поиск по пациентам" value=""
                         title="Поиск по пациентам"/>
                  <span className="icon"></span>
                </div>
                <div className="button button_empty content-clinic-info__search-panel-button">
                  <a href="#react-db-doctor-list-modal" className="open-modal" title="Управляющие врачи">
                    <img src="/image/icon/specialty.svg" alt="icon"/>
                    Управляющие врачи
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div className="content-table">
            <ul className="content-table__header">
              <li className="content-table__header-id">
                ID
                <div className="content-table__header-sort">
                  <a href="#" title="">
                    <img src="/image/icon/arrow_down.svg" alt="icon"/>
                  </a>
                </div>
              </li>
              <li className="content-table__header-pay-status">
                Статус
                <div className="content-table__header-sort">
                  <a href="#" title="">
                    <img src="/image/icon/arrow_up.svg" alt="icon"/>
                  </a>
                  <a href="#" title="">
                    <img src="/image/icon/arrow_down.svg" alt="icon"/>
                  </a>
                </div>
              </li>
              <li className="content-table__header-name">
                ФИО пациента
                <div className="content-table__header-sort">
                  <a href="#" title="">
                    <img src="/image/icon/arrow_up.svg" alt="icon"/>
                  </a>
                  <a href="#" title="">
                    <img src="/image/icon/arrow_down.svg" alt="icon"/>
                  </a>
                </div>
              </li>
              <li className="content-table__header-stages">
                Этапов доставки
                <div className="content-table__header-sort">
                  <a href="#" title="">
                    <img src="/image/icon/arrow_up.svg" alt="icon"/>
                  </a>
                  <a href="#" title="">
                    <img src="/image/icon/arrow_down.svg" alt="icon"/>
                  </a>
                </div>
              </li>
              <li className="content-table__header-sum">
                Оплаченная сумма
                <div className="content-table__header-sort">
                  <a href="#" title="">
                    <img src="/image/icon/arrow_up.svg" alt="icon"/>
                  </a>
                  <a href="#" title="">
                    <img src="/image/icon/arrow_down.svg" alt="icon"/>
                  </a>
                </div>
              </li>
              <li className="content-table__header-total-sum">
                Полная сумма оплаты
                <div className="content-table__header-sort">
                  <a href="#" title="">
                    <img src="/image/icon/arrow_up.svg" alt="icon"/>
                  </a>
                  <a href="#" title="">
                    <img src="/image/icon/arrow_down.svg" alt="icon"/>
                  </a>
                </div>
              </li>
            </ul>
            <ul className="content-table__main">
              <li className="content-table__main-id">8475</li>
              <li className="content-table__main-pay-status content-table__main-mark content-table__main-mark_orange">Нет
                цены
              </li>
              <li className="content-table__main-name">
                <a href="/view/admin/patient_card.html" title="">Зубов Александр Андреевич</a>
              </li>
              <li className="content-table__main-stages">3 из 5</li>
              <li className="content-table__main-sum">Не указана</li>
              <li className="content-table__main-total-sum">Не указана</li>
            </ul>
          </div>
          <Paginator />
        </>
      );
    }

    return (
      <>
        <div className="content-header">
          <div className="content-header__title">
            <img src="/image/icon/clinic.svg" alt="icon"/>
            <h1>Информация о клинике</h1>
          </div>
          <div className="content-header__back">
            <a href="#" title="Вернуться назад">
              <img src="/image/icon/arrow_back.svg" alt="icon"/>
              Вернуться назад
            </a>
          </div>
        </div>
        {body}
      </>
    );
  }
}

let container = document.getElementById('react-db-clinic-profile-page');

if (container) {
  ReactDOM.render(<ClinicProfilePage clinicId={container.getAttribute('data-clinic-id')} />, container);
}