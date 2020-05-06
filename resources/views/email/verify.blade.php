@if ($password !== null)
    Ваш пароль: <b>{{ $password }}</b><br />
    Обязательно смените пароль при входе в систему!<br />
@endif

Ссылка подтверждения почты: <a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a>