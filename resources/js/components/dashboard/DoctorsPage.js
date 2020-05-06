import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import _ from 'lodash';

import Paginator from '../Paginator';

class DoctorsPage extends Component {
  constructor(props) {
    super(props);

    this.state = {
      currentPage: 1,
      searchText: '',

      paginator: null
    };

    this.handleSearchChange = this.handleSearchChange.bind(this);
    this.handleSearchChangeThrottled = _.throttle(this.handleSearchChange, 20);

    this.handleNextClick = this.handleNextClick.bind(this);
    this.handlePreviousClick = this.handlePreviousClick.bind(this);
  }

  componentDidMount() {
    this.loadDoctors();
  }

  componentWillUnmount() {
    this.handleSearchChangeThrottled.cancel();
  }

  handleSearchChange(event) {
    this.setState({
      searchText: event.target.value,
      currentPage: 1
    }, this.loadDoctors);
  }

  handleNextClick() {
    if (this.state.currentPage !== this.state.paginator.last_page) {
      this.setState({
        currentPage: this.state.currentPage + 1
      }, this.loadDoctors);
    }
  }

  handlePreviousClick() {
    if (this.state.currentPage !== 1) {
      this.setState({
        currentPage: this.state.currentPage - 1
      }, this.loadDoctors);
    }
  }

  loadDoctors() {
    let params = '?page=' + this.state.currentPage;

    if (this.state.searchText !== '') {
      params += '&search=' + this.state.searchText;
    }

    window.axios.get('/api/doctor/' + params).then(response => {
      this.setState({
        paginator: response.data.data
      });
    });
  }

  render() {
    let doctorsList = this.state.paginator?.data.map(doctor => {
      return (
        <ul className="content-table__main">
          <li className="content-table__main-id">{doctor.id}</li>
          <li className="content-table__main-name">
            <a href={'/dashboard/doctors/profile/' + doctor.id}>{doctor.name}</a>
          </li>
          <li className="content-table__main-position">{doctor.doctor_info.position}</li>
          <li className="content-table__main-phone">
            <a href={'tel:' + doctor.phone}>{doctor.phone}</a>
          </li>
          <li className="content-table__main-patients-count">{doctor.orders_all_count} чел</li>
          <li className="content-table__main-status">
            <div className="content-table__main-status_group">
              <div className="content-table__main-mark content-table__main-mark_blue">{doctor.orders_waiting_count}</div>
              <div className="content-table__main-mark content-table__main-mark_orange">{doctor.orders_modeling_count}</div>
              <div className="content-table__main-mark content-table__main-mark_green">{doctor.orders_cure_count}</div>
            </div>
            <div className="content-table__main-mark">{doctor.orders_done_count}</div>
          </li>
        </ul>
      );
    });

    return (
      <>
        <div className="content-header">
          <div className="content-header__title">
            <img src="/image/icon/doc.svg" alt="icon" />
            <h1>Список врачей</h1>
          </div>
        </div>
        <div className="content-search-panel">
          <div className="button content-search-panel__button">
            <a href="/dashboard/doctors/add" title="Добавить врача">Добавить врача</a>
          </div>
          <div className="form content-search-panel__search">
            <input value={this.state.searchText} onChange={this.handleSearchChangeThrottled} type="search" name="search" autoComplete="off" placeholder="Поиск по врачам"
                   title="Поиск по врачам"/>
            <span className="icon search"></span>
          </div>
        </div>
        <div className="content-table">
          <ul className="content-table__header">
            <li className="content-table__header-id">
              ID
              <div className="content-table__header-sort">
                <a href="#">
                  <img src="/image/icon/arrow_down.svg" alt="icon" />
                </a>
              </div>
            </li>
            <li className="content-table__header-name">
              ФИО врача
              <div className="content-table__header-sort">
                <a href="#">
                  <img src="/image/icon/arrow_up.svg" alt="icon" />
                </a>
                <a href="#">
                  <img src="/image/icon/arrow_down.svg" alt="icon" />
                </a>
              </div>
            </li>
            <li className="content-table__header-position">
              Должность
              <div className="content-table__header-sort">
                <a href="#">
                  <img src="/image/icon/arrow_up.svg" alt="icon" />
                </a>
                <a href="#">
                  <img src="/image/icon/arrow_down.svg" alt="icon" />
                </a>
              </div>
            </li>
            <li className="content-table__header-phone">
              Телефон
              <div className="content-table__header-sort">
                <a href="#">
                  <img src="/image/icon/arrow_up.svg" alt="icon" />
                </a>
                <a href="#">
                  <img src="/image/icon/arrow_down.svg" alt="icon" />
                </a>
              </div>
            </li>
            <li className="content-table__header-patients-count">
              Пациентов
              <div className="content-table__header-sort">
                <a href="#">
                  <img src="/image/icon/arrow_up.svg" alt="icon" />
                </a>
                <a href="#">
                  <img src="/image/icon/arrow_down.svg" alt="icon" />
                </a>
              </div>
            </li>
            <li className="content-table__header-status">
              Пациенты по статусам
              <div className="content-table__header-sort">
                <a href="#">
                  <img src="/image/icon/arrow_up.svg" alt="icon" />
                </a>
                <a href="#">
                  <img src="/image/icon/arrow_down.svg" alt="icon" />
                </a>
              </div>
            </li>
          </ul>
          {doctorsList}
        </div>
        <Paginator
          itemType="врачей"
          currentPage={this.state.currentPage}
          allItemsCount={this.state.paginator?.total}
          pagesCount={this.state.paginator?.last_page}
          onClickNext={this.handleNextClick}
          onClickPrevious={this.handlePreviousClick}
        />
      </>
    );
  }
}

if (document.getElementById('react-db-doctors-page')) {
  ReactDOM.render(<DoctorsPage />, document.getElementById('react-db-doctors-page'));
}