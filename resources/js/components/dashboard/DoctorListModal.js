import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class DoctorListModal extends Component {
  constructor(props) {
    super(props);

    this.state = {
      doctors: [],
      clinicNotFound: false,
      loadingError: false
    };
  }

  componentDidMount() {
    const url = this.props.modeEdit === '1' ? '/api/doctor/?all=1' : '/api/clinic/' + this.props.clinicId + '/doctors';

    window.axios.get(url).then(response => {
      if (this.props.modeEdit === '1') {
        let doctors = response.data.data;

        window.axios.get('/api/clinic/' + this.props.clinicId + '/doctors').then(_response => {
          doctors = doctors.map(item => {
            item.isAttached = false;

            _response.data.data.forEach(_item => {
              if (item.id === _item.id) {
                item.isAttached = true;
              }
            });

            return item;
          });

          this.setState({
            doctors: doctors
          });
        });
      } else {
        this.setState({
          doctors: response.data.data
        });
      }
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

  handleServiceChange(doctor) {
    let index = -1;
    const doctors = [...this.state.doctors];

    for (let i = 0; i < doctors.length; i++) {
      if (doctors[i].id === doctor.id) {
        index = i;
        doctors[i].isAttached = !doctors[i].isAttached;

        break;
      }
    }

    if (doctors[index].isAttached) {
      window.axios.post('/api/doctor/' + doctor.id + '/clinic', {
        clinic_id: this.props.clinicId
      }).then(() => {
        this.setState({
          doctors: doctors
        });
      }).catch(error => {
        alert(error.response.data.message);
      });
    } else {
      window.axios.delete('/api/doctor/' + doctor.id + '/clinic/' + this.props.clinicId).then(() => {
        this.setState({
          doctors: doctors
        });
      }).catch(error => {
        alert(error.response.data.message);
      });
    }
  }

  render() {
    let body;

    if (this.state.clinicNotFound) {
      body = (
        <h2>Клиника не найдена</h2>
      );
    } else if (this.state.loadingError) {
      body = (
        <h2>Ошибка загрузки списка</h2>
      );
    } else {
      let doctors = this.state.doctors.map(doctor => {
        return (
          <li className="docs-main__list-item">
            <div className="docs-main__list-item-image">
              <img src={doctor.doctor_info.photo !== null ? doctor.doctor_info.photo : '/image/icon/user_empty.svg'} alt="user photo"/>
            </div>
            <div className="docs-main__list-item-info">
              <div className="docs-main__list-item-specialty">
                <img src="/image/icon/specialty.svg" alt="icon"/>
                {doctor.doctor_info.position}
              </div>
              <div className="docs-main__list-item-name">{doctor.name}</div>
              {
                this.props.modeEdit === '1' &&
                <div className="button docs-main__list-item-button">
                  <a onClick={() => this.handleServiceChange(doctor)} style={{ cursor: 'pointer' }}>{doctor.isAttached ? 'Снять с обслуживания' : 'Назначить на обслуживание'}</a>
                </div>
              }
            </div>
          </li>
        );
      });

      body = (
        <>
          <ul className="docs-main__list">
            {doctors}
          </ul>
        </>
      );
    }

    return (
      <div className="docs">
        <div className="docs-header">
          <div className="docs-header__title">
            <img src="/image/icon/doc.svg" alt="icon"/>
            <h3>Список врачей</h3>
          </div>
          <div className="docs-header__close">
            <a className="close-modal" href="#" title="Закрыть">Закрыть</a>
          </div>
        </div>
        <div className="docs-main">
          {body}
        </div>
      </div>
    );
  }
}

let container = document.getElementById('react-db-doctor-list-modal');

if (container) {
  ReactDOM.render(
    <DoctorListModal
      clinicId={container.getAttribute('data-clinic-id')}
      modeEdit={container.getAttribute('data-mode-edit')} />,
    container
  );
}