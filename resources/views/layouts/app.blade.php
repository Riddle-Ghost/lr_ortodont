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
            <nav class="header-menu">
                <ul>
                    <li>
                        <a href="#" title="О нас">О нас</a>
                    </li>
                    <li>
                        <a href="#" title="Преимущества">Преимущества</a>
                    </li>
                    <li>
                        <a href="#" title="Отзывы">Отзывы</a>
                    </li>
                    <li>
                        <a href="#" title="FAQ">FAQ</a>
                    </li>
                    <li>
                        <a href="#" title="Контакты">Контакты</a>
                    </li>
                </ul>
            </nav>
            <div class="header-info">
                <div class="header-doc">
                    <a href="{{ route('login') }}"
                       @if(Route::currentRouteName() == 'login') class="header-doc__active" @endif
                       title="Для врачей">
                        <img src="/image/icon/doc.svg" alt="icon">
                        Для врачей
                    </a>
                </div>
                <div class="header-phone">
                    <a href="tel:+78126605702" title="Получить консультацию">
                        <div class="header-phone__call">
                            8 (812) 660-57-02
                        </div>
                        <div class="header-phone__text">
                            Получить консультацию
                        </div>
                    </a>
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
        </div>
    </div>
</body>
</html>
