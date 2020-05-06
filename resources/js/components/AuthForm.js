import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class AuthForm extends Component {
  constructor(props) {
    super(props);

    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    this.state = {
      'email': '',
      'password': ''
    };

    this.onSubmit = this.onSubmit.bind(this);
    this.onEmailChange = this.onEmailChange.bind(this);
    this.onPasswordChange = this.onPasswordChange.bind(this);
  }

  onEmailChange(event) {
    this.setState({
      'email': event.target.value
    });
  }

  onPasswordChange(event) {
    this.setState({
      'password': event.target.value
    });
  }

  onSubmit() {
    if (this.state.email.length === 0) {
      alert('error');
      return;
    }

    if (this.state.password.length === 0) {
      alert('error');
      return;
    }

    document.getElementById('form_auth').submit()
  }

  render() {
    return (
      <>
        <div className="auth-header">
          <div className="auth-header__logo">
            <div className="auth-header__logo-title">
              ЭЛАЙНЕРЫ
            </div>
            <div className="auth-header__logo-desc">
              VISION SMILE
            </div>
          </div>
        </div>
        <div className="auth-main">
          <h1>
            Авторизация<br />
            в личный кабинет
          </h1>
          <form id="form_auth" name="form_auth" method="POST" action={"/login"} className="form-auth"
                encType="multipart/form-data" autoComplete="off">
            <input type="hidden" name="csrf-token" value={this.csrfToken} />
            <div className="form-line">
              <input value={this.state.email} type="email" name="email" placeholder="Введите логин"
                     title="Введите логин" required={true} onChange={this.onEmailChange} />
              <span className="icon login"></span>
            </div>
            <div className="form-line">
              <input value={this.state.password} type="password" name="password" placeholder="Введите пароль"
                     title="Введите пароль" required={true} onChange={this.onPasswordChange} />
              <span className="icon password"></span>
            </div>
            <div className="button button_gradient send disabled form-auth__button">
              <a href="#" onClick={this.onSubmit} title="Войти в личный кабинет">Войти в личный кабинет</a>
            </div>
            <div className="form-auth__link">
              <a href="#access_recovery" className="open-modal" title="Восстановить пароль">Восстановить пароль</a>
            </div>
          </form>
        </div>
      </>
    );
  }
}

if (document.getElementById('react-auth-form')) {
  ReactDOM.render(<AuthForm />, document.getElementById('react-auth-form'));
}
