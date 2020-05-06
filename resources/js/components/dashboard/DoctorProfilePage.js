import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import _ from 'lodash';

import Paginator from '../Paginator';

class DoctorProfilePage extends Component {
  constructor(props) {
    super(props);

    this.state = {
      currentPage: 1,
      searchText: '',
      clinicsPaginator: [],

      doctor: null,
      doctorNotFound: false,
      loadingError: false
    };

    this.handleSearchChange = this.handleSearchChange.bind(this);
    this.handleSearchChangeThrottled = _.throttle(this.handleSearchChange, 20);

    this.handleNextClick = this.handleNextClick.bind(this);
    this.handlePreviousClick = this.handlePreviousClick.bind(this);
  }

  componentDidMount() {
    window.axios.get('/api/doctor/' + this.props.doctorId).then(response => {
      this.setState({
        doctor: response.data.data
      });

      this.loadClinics();
    }).catch(error => {
      if (error.response.status === 404) {
        this.setState({
          doctorNotFound: true
        });
      } else {
        this.setState({
          loadingError: true
        });
      }
    });
  }

  componentWillUnmount() {
    this.handleSearchChangeThrottled.cancel();
  }

  handleSearchChange(event) {
    this.setState({
      searchText: event.target.value,
      currentPage: 1
    }, this.loadClinics);
  }

  handleNextClick() {
    if (this.state.currentPage !== this.state.clinicsPaginator.last_page) {
      this.setState({
        currentPage: this.state.currentPage + 1
      }, this.loadClinics);
    }
  }

  handlePreviousClick() {
    if (this.state.currentPage !== 1) {
      this.setState({
        currentPage: this.state.currentPage - 1
      }, this.loadClinics);
    }
  }

  loadClinics() {
    let params = '?page=' + this.state.currentPage;

    if (this.state.searchText !== '') {
      params += '&search=' + this.state.searchText;
    }

    window.axios.get('/api/doctor/' + this.props.doctorId + '/clinic/' + params).then(_response => {
      this.setState({
        clinicsPaginator: _response.data.data
      });
    }).catch(error => {
      alert('Не удалось загрузить список клиник!');
      console.error(error);
    });
  }

  formatedBirthday() {
    if (this.state.doctor === null) {
      return '';
    }

    let dateArray = this.state.doctor.doctor_info.birthday.split('-');

    return dateArray[2] + '.' + dateArray[1] + '.' + dateArray[0];
  }

  render() {
    let body;

    if (this.state.doctorNotFound) {
      body = (
        <h2>Профиль не найден</h2>
      );
    } else if (this.state.loadingError) {
      body = (
        <h2>Ошибка загрузки профиля</h2>
      );
    } else {
      const clinics = this.state.clinicsPaginator?.data.map(clinic => {
        return (
          <ul className="content-table__main">
            <li className="content-table__main-name content-table__main-mark content-table__main-mark_orange">
              <a href={'/dashboard/clinics/' + clinic.id}>{clinic.name}</a>
            </li>
            <li className="content-table__main-phone">
              <a href={'tel:' + clinic.phone}>{clinic.phone}</a>
            </li>
            <li className="content-table__main-patients-count">
              {clinic.doctors_all_patients} чел
            </li>
            <li className="content-table__main-status">
              <div className="content-table__main-status_group">
                <div className="content-table__main-mark content-table__main-mark_blue">{clinic.doctors_waiting_patients}</div>
                <div className="content-table__main-mark content-table__main-mark_orange">{clinic.doctors_modeling_patients}</div>
                <div className="content-table__main-mark content-table__main-mark_green">{clinic.doctors_cure_patients}</div>
              </div>
              <div className="content-table__main-mark">{clinic.doctors_done_patients}</div>
            </li>
          </ul>
        );
      });

      body = (
        <>
          <div className="content-doc">
            <div className="content-doc-image">
              <img src={this.state.doctor?.doctor_info.photo === null ? "/image/icon/user_empty.svg" : this.state.doctor?.doctor_info.photo} alt="user photo" />
            </div>
            <div className="content-doc-info">
              <div className="content-doc-info__name">{this.state.doctor?.name}</div>
              <ul className="content-doc-info__group">
                <li className="content-doc-info__specialty">
                  <img src="/image/icon/specialty.svg" alt="icon" />
                  {this.state.doctor?.doctor_info.position}
                </li>
                <li className="content-doc-info__date">
                  <img src="/image/icon/calendar.svg" alt="icon" />
                  {this.formatedBirthday()}
                </li>
                <li className="content-doc-info__phone">
                  <img src="/image/icon/phone.svg" alt="icon" />
                  {this.state.doctor?.phone}
                </li>
              </ul>
              <p className="content-doc-info__desc">{this.state.doctor?.doctor_info.description}</p>
              <div className="content-doc-info__search-panel">
                <div className="button button_square content-doc-info__search-panel-button">
                  <a href={'/dashboard/doctors/edit/' + this.state.doctor?.id} title="Редактировать информацию">
                    <img src="/image/icon/edit.svg" alt="icon" />
                  </a>
                </div>
                <div className="button button_square content-doc-info__search-panel-button">
                  <a href="" title="Удалить">
                    <img src="/image/icon/trash.svg" alt="icon" />
                  </a>
                </div>
                <div className="form content-doc-info__search-panel-search">
                  <input value={this.state.searchText} onChange={this.handleSearchChangeThrottled} type="search" name="search" autoComplete="off" placeholder="Поиск по клиникам"
                         title="Поиск по клиникам" />
                  <span className="icon"></span>
                </div>
              </div>
            </div>
          </div>
          <div className="content-table">
            <ul className="content-table__header">
              <li className="content-table__header-name">
                Название клиники
                <div className="content-table__header-sort">
                  <a href="">
                    <img src="/image/icon/arrow_up.svg" alt="icon" />
                  </a>
                  <a href="">
                    <img src="/image/icon/arrow_down.svg" alt="icon" />
                  </a>
                </div>
              </li>
              <li className="content-table__header-phone">
                Телефон клиники
                <div className="content-table__header-sort">
                  <a href="">
                    <img src="/image/icon/arrow_up.svg" alt="icon" />
                  </a>
                  <a href="">
                    <img src="/image/icon/arrow_down.svg" alt="icon" />
                  </a>
                </div>
              </li>
              <li className="content-table__header-patients-count">
                Пациентов у врача
                <div className="content-table__header-sort">
                  <a href="">
                    <img src="/image/icon/arrow_up.svg" alt="icon" />
                  </a>
                  <a href="">
                    <img src="/image/icon/arrow_down.svg" alt="icon" />
                  </a>
                </div>
              </li>
              <li className="content-table__header-status">
                Пациенты по статусам
                <div className="content-table__header-sort">
                  <a href="">
                    <img src="/image/icon/arrow_up.svg" alt="icon" />
                  </a>
                  <a href="">
                    <img src="/image/icon/arrow_down.svg" alt="icon" />
                  </a>
                </div>
              </li>
            </ul>
            {clinics}
          </div>
          <Paginator
            itemType="клиник"
            currentPage={this.state.currentPage}
            allItemsCount={this.state.clinicsPaginator?.total}
            pagesCount={this.state.clinicsPaginator?.last_page}
            onClickNext={this.handleNextClick}
            onClickPrevious={this.handlePreviousClick} />
        </>
      );
    }

    return (
      <>
        <div className="content-header">
          <div className="content-header__title">
            <img src="/image/icon/doc.svg" alt="icon" />
            <h1>Профиль врача</h1>
          </div>
          <div className="content-header__back">
            <a href="/dashboard/doctors" title="Вернуться назад">
              <img src="/image/icon/arrow_back.svg" alt="icon" />
              Вернуться назад
            </a>
          </div>
        </div>
        {body}
      </>
    );
  }
}

let container = document.getElementById('react-db-doctor-profile-page');

if (container) {
  ReactDOM.render(<DoctorProfilePage doctorId={container.getAttribute('data-doctor-id')} />, container);
}