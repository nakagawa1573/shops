@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <section class="txt__box">
        <div class="txt__reservation">
            <h2 class="txt__reservation--item">
                予約状況
            </h2>
        </div>
        <div class="txt__favorite">
            {{-- ユーザー名を表示させる --}}
            <h1 class="txt__favorite--item">
                testさん
            </h1>
            <h2 class="txt__favorite--item">
                お気に入り店舗
            </h2>
        </div>
    </section>
    <section class="content">
        <section class="content__reservation">
            <article class="reservation">
                <div class="reservation__ttl--box">
                    <div id="box__1">
                        <img class="reservation__icon" src="{{ asset('storage/watch.png') }}" alt="">
                        <p class="reservation__ttl">
                            予約1
                        </p>
                    </div>
                    <div>
                        <form action="" method="post">
                            @csrf
                            @method('delete')
                            <button class="reservation__cancel--btn" type="submit">
                                <img class="reservation__cancel--img" src="{{ asset('storage/cross.svg') }}" alt="">
                            </button>
                        </form>
                    </div>
                </div>
                {{-- 予約状況を取得して表示&foreachで複製 --}}
                <table class="reservation__table">
                    <tr class="reservation__row">
                        <td class="reservation__item">
                            Shop
                        </td>
                        <td class="reservation__item">
                            仙人
                        </td>
                    </tr>
                    <tr>
                        <td class="reservation__item">
                            Date
                        </td>
                        <td class="reservation__item">
                            2021-04-01
                        </td>
                    </tr>
                    <tr>
                        <td class="reservation__item">
                            Time
                        </td>
                        <td class="reservation__item">
                            17:00
                        </td>
                    </tr>
                    <tr>
                        <td class="reservation__item">
                            Number
                        </td>
                        <td class="reservation__item">
                            1人
                        </td>
                    </tr>
                </table>
            </article>
            <article class="reservation">
                <div class="reservation__ttl--box">
                    <div id="box__1">
                        <img class="reservation__icon" src="{{ asset('storage/watch.png') }}" alt="">
                        <p class="reservation__ttl">
                            予約1
                        </p>
                    </div>
                    <div>
                        <form action="" method="post">
                            @csrf
                            @method('delete')
                            <button class="reservation__cancel--btn" type="submit">
                                <img class="reservation__cancel--img" src="{{ asset('storage/cross.svg') }}" alt="">
                            </button>
                        </form>
                    </div>
                </div>
                {{-- 予約状況を取得して表示&foreachで複製 --}}
                <table class="reservation__table">
                    <tr class="reservation__row">
                        <td class="reservation__item">
                            Shop
                        </td>
                        <td class="reservation__item">
                            仙人
                        </td>
                    </tr>
                    <tr>
                        <td class="reservation__item">
                            Date
                        </td>
                        <td class="reservation__item">
                            2021-04-01
                        </td>
                    </tr>
                    <tr>
                        <td class="reservation__item">
                            Time
                        </td>
                        <td class="reservation__item">
                            17:00
                        </td>
                    </tr>
                    <tr>
                        <td class="reservation__item">
                            Number
                        </td>
                        <td class="reservation__item">
                            1人
                        </td>
                    </tr>
                </table>
            </article>
        </section>
        <section class="content__shop">
            <article class="shop">
                <div class="shop__img--box">
                    <img class="shop__img" src="{{ asset('storage/shop/sushi.jpg') }}" alt="sushi">
                </div>
                <div class="shop__txt">
                    <h2 class="shop__name">
                        仙人
                    </h2>
                    <ul class="shop__category">
                        {{-- foreachを使ってカテゴリーをつける --}}
                        <li class="shop__category--item">
                            #東京都
                        </li>
                        <li class="shop__category--item">
                            #寿司
                        </li>
                    </ul>
                    <div class="shop__form">
                        <form class="shop__form--detail" action="" method="get">
                            @csrf
                            <button type="submit">
                                詳しくみる
                            </button>
                        </form>
                        <form class="shop__form--favorite" action="" method="post">
                            @csrf
                            <input type="hidden" name="" value="">
                            <button type="submit">
                                {{-- ifを使ってもしお気に入りにされていたら違う色のハートになるようにする --}}
                                <div class="heart"></div>
                            </button>
                        </form>
                    </div>
                </div>
            </article>
            <article class="shop">
                <div class="shop__img--box">
                    <img class="shop__img" src="{{ asset('storage/shop/sushi.jpg') }}" alt="sushi">
                </div>
                <div class="shop__txt">
                    <h2 class="shop__name">
                        仙人
                    </h2>
                    <ul class="shop__category">
                        {{-- foreachを使ってカテゴリーをつける --}}
                        <li class="shop__category--item">
                            #東京都
                        </li>
                        <li class="shop__category--item">
                            #寿司
                        </li>
                    </ul>
                    <div class="shop__form">
                        <form class="shop__form--detail" action="" method="get">
                            @csrf
                            <button type="submit">
                                詳しくみる
                            </button>
                        </form>
                        <form class="shop__form--favorite" action="" method="post">
                            @csrf
                            <input type="hidden" name="" value="">
                            <button type="submit">
                                {{-- ifを使ってもしお気に入りにされていたら違う色のハートになるようにする --}}
                                <div class="heart"></div>
                            </button>
                        </form>
                    </div>
                </div>
            </article>
            <article class="shop">
                <div class="shop__img--box">
                    <img class="shop__img" src="{{ asset('storage/shop/sushi.jpg') }}" alt="sushi">
                </div>
                <div class="shop__txt">
                    <h2 class="shop__name">
                        仙人
                    </h2>
                    <ul class="shop__category">
                        {{-- foreachを使ってカテゴリーをつける --}}
                        <li class="shop__category--item">
                            #東京都
                        </li>
                        <li class="shop__category--item">
                            #寿司
                        </li>
                    </ul>
                    <div class="shop__form">
                        <form class="shop__form--detail" action="" method="get">
                            @csrf
                            <button type="submit">
                                詳しくみる
                            </button>
                        </form>
                        <form class="shop__form--favorite" action="" method="post">
                            @csrf
                            <input type="hidden" name="" value="">
                            <button type="submit">
                                {{-- ifを使ってもしお気に入りにされていたら違う色のハートになるようにする --}}
                                <div class="heart"></div>
                            </button>
                        </form>
                    </div>
                </div>
            </article>
        </section>
    </section>
@endsection
