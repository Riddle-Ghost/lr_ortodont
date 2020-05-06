<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,500;0,600;0,700;1,500;1,600;1,700&display=swap">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="auth-page">
<header>
    <div class="container">
        <a href="/" class="logo">
            <div class="logo-title">ЭЛАЙНЕРЫ</div>
            <div class="logo-desc">VISION SMILE</div>
        </a>
        <div class="header-user">
            <div class="header-user__alarm">
                <a href="#alarm" class="open-modal">
                    <img src="/image/icon/alarm.svg" alt="icon">
                    <span class="alarm">7</span>
                </a>
            </div>
            <div class="header-user__name">
                <a href="#" title=""></a>
            </div>
            <div class="header-user__photo">
                <a href="#" title="">
                    <img src="/image/icon/user_empty.svg" alt="user photo">
                </a>
            </div>
            <div class="header-user__exit">
                <a href="{{ route('logout') }}" title="Выйти" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                    <img src="/image/icon/exit.svg" alt="icon">
                </a>
                <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
</header>
<main>
    @yield('content')
</main>
<footer>
    <div class="container">
        <div class="footer-info">
            ООО "Клиника Доктора Зотовой"<br>
            ИНН 7813561862, ОГРН 1137847176620
        </div>
    </div>
</footer>
<div class="popup">
    <div class="overlay">
        <div class="overlay-close close-modal"></div>
        @stack('modals')
        @include('modals.doctor-notification')
    </div>
</div>
</body>
</html>