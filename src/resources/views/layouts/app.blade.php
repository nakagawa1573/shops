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
            {{-- ifでログイン状態、否ログイン状態で変わるようにする --}}
            <div class="modal__box--link">
                <p>
                    <a class="modal__link" href="/">
                        Home
                    </a>
                </p>
                <p>
                    <a class="modal__link" href="">
                        Registration
                    </a>
                </p>
                <p>
                    <a class="modal__link" href="">
                        Login
                    </a>
                </p>
            </div>
        </article>
    </section>
</body>

</html>
