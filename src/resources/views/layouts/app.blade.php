<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
    <title>Rese</title>
</head>

<body>
    <header class="header">
        <section class="header__box">
            <a href="#modal">
                <button class="header__btn">
                    <div class="line__1"></div>
                    <div class="line__2"></div>
                    <div class="line__3"></div>
                </button>
            </a>
            <h1 class="header__ttl">
                Rese
            </h1>
        </section>
        @yield('search')
    </header>
    <main>
        @yield('content')
    </main>
    <section class="modal" id="modal">
        <article class="modal__content">
            <div class="modal__box--btn">
                <a class="modal__close" href="#">
                    <button class="modal__close--btn">
                        <span class="cross"></span>
                    </button>
                </a>
            </div>
            @if (Auth::guard('web')->check())
                <div class="modal__box--link">
                    <p>
                        <a class="modal__link" href="/">
                            Home
                        </a>
                    </p>
                    <form class="modal__logout" action="/logout" method="post">
                        @csrf
                        <button type="submit">
                            Logout
                        </button>
                    </form>
                    <p>
                        <a class="modal__link" href="/mypage">
                            Mypage
                        </a>
                    </p>
                </div>
            @elseif(Auth::guard('owners')->check())
                <div class="modal__box--link">
                    <p>
                        <a class="modal__link" href="/">
                            Home
                        </a>
                    </p>
                    <form class="modal__logout" action="/owner/logout" method="post">
                        @csrf
                        <button type="submit">
                            Logout
                        </button>
                    </form>
                    <p>
                        <a class="modal__link" href="/owner">
                            Management
                        </a>
                    </p>
                </div>
            @elseif(Auth::guard('admins')->check())
                <div class="modal__box--link">
                    <p>
                        <a class="modal__link" href="/">
                            Home
                        </a>
                    </p>
                    <form class="modal__logout" action="/admin/logout" method="post">
                        @csrf
                        <button type="submit">
                            Logout
                        </button>
                    </form>
                    <p>
                        <a class="modal__link" href="/admin">
                            Registration for owner
                        </a>
                    </p>
                    <p>
                        <a class="modal__link" href="/admin/mail">
                            Mail
                        </a>
                    </p>
                </div>
            @else
                <div class="modal__box--link">
                    <p>
                        <a class="modal__link" href="/">
                            Home
                        </a>
                    </p>
                    <p>
                        <a class="modal__link" href="/register">
                            Registration
                        </a>
                    </p>
                    <p>
                        <a class="modal__link" href="/login">
                            Login
                        </a>
                    </p>
                </div>
            @endif
        </article>
    </section>
</body>

</html>
