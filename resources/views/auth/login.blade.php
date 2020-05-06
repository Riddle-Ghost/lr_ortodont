@extends('layouts.app')

@section('content')
    <section id="auth">
        <div class="container">
            <div class="auth">
                <div class="auth-header">
                    <div class="auth-header__logo">
                        <div class="auth-header__logo-title">
                            ЭЛАЙНЕРЫ
                        </div>
                        <div class="auth-header__logo-desc">
                            VISION SMILE
                        </div>
                    </div>
                </div>
                <div class="auth-main">
                    <h1>
                        Авторизация<br>
                        в личный кабинет
                    </h1>
                    <form id="form_auth" name="form_auth" method="POST" action="{{ route('login') }}" class="form-auth" enctype="multipart/form-data" accept-charset="utf-8" autocomplete="off">
                        @csrf
                        <div class="form-line" @error('email') style="box-shadow: 0 0 2px 2px rgba(227, 42, 1, .8)" @enderror>
                            <input type="email" name="email" placeholder="Введите логин" title="Введите логин" required>
                            <span class="icon login"></span>
                        </div>
                        @error('email')
                            <div style="margin: 1rem" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                        <div class="form-line" @error('password') style="box-shadow: 0 0 2px 2px rgba(227, 42, 1, .8)" @enderror>
                            <input type="password" name="password" placeholder="Введите пароль" title="Введите пароль" required>
                            <span class="icon password"></span>
                        </div>
                        @error('password')
                            <div style="margin: 1rem" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                        <div class="button button_gradient send disabled form-auth__button">
                            <a href="#" title="Войти в личный кабинет" onclick="document.getElementById('form_auth').submit()">Войти в личный кабинет</a>
                        </div>
                        <div class="form-auth__link">
                            <a href="#access_recovery" class="open-modal" title="Восстановить пароль">Восстановить пароль</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('modals')
    @include('modals.recovery-access')
@endpush