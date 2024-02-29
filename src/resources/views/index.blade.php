@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('search')
    <section class="search">
        <form class="search__form" action="" method="post" novalidate>
            @csrf
            <div class="search__area--box">
                <select class="search__area" name="area" id="" required>
                    <option value=""selected>
                        All area
                    </option>
                    <option value="">
                        東京
                    </option>
                </select>
            </div>
            <div class="search__genre--box">
                <select class="search__genre" name="genre" id="" required>
                    <option value="" selected>
                        All genre
                    </option>
                    <option value="">
                        寿司
                    </option>
                </select>
            </div>
            <div class="search__form--box">
                <button class="search__btn" type="submit">
                    <img src="{{ asset('storage/search.svg') }}" alt="search">
                </button>
                <input class="search__word" type="text" name="keyword" value="" placeholder="Search ...">
            </div>
        </form>
    </section>
@endsection

@section('content')
    <section class="content">
        {{-- foreachを使って数を増やしていく --}}
        <article class="content__item">
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
        <article class="content__item">
            <div class="shop__img--box">
                <img class="shop__img" src="{{ asset('storage/shop/sushi.jpg') }}" alt="sushi">
            </div>
            <div class="shop__txt">
                <p class="shop__name">
                    仙人
                </p>
                <ul class="shop__category">
                    {{-- foreachを使ってカテゴリーをつける --}}
                    <li class="shop__category--item">
                        東京都
                    </li>
                    <li class="shop__category--item">
                        寿司
                    </li>
                </ul>
                <div class="shop__form">
                    <form class="shop__form--detail" action="" method="get">
                        @csrf
                        <button type="submit">
                            詳しく見る
                        </button>
                    </form>
                    <form class="shop__form--favorite" action="" method="post">
                        @csrf
                        <input type="hidden" name="" value="">
                        <button type="submit">
                            H
                        </button>
                    </form>
                </div>
            </div>
        </article>
        <article class="content__item">
            <div class="shop__img--box">
                <img class="shop__img" src="{{ asset('storage/shop/sushi.jpg') }}" alt="sushi">
            </div>
            <div class="shop__txt">
                <p class="shop__name">
                    仙人
                </p>
                <ul class="shop__category">
                    {{-- foreachを使ってカテゴリーをつける --}}
                    <li class="shop__category--item">
                        東京都
                    </li>
                    <li class="shop__category--item">
                        イタリアン
                    </li>
                </ul>
                <div class="shop__form">
                    <form class="shop__form--detail" action="" method="get">
                        @csrf
                        <button type="submit">
                            詳しく見る
                        </button>
                    </form>
                    <form class="shop__form--favorite" action="" method="post">
                        @csrf
                        <input type="hidden" name="" value="">
                        <button type="submit">
                            H
                        </button>
                    </form>
                </div>
            </div>
        </article>
        <article class="content__item">
            <div class="shop__img--box">
                <img class="shop__img" src="{{ asset('storage/shop/sushi.jpg') }}" alt="sushi">
            </div>
            <div class="shop__txt">
                <p class="shop__name">
                    仙人
                </p>
                <ul class="shop__category">
                    {{-- foreachを使ってカテゴリーをつける --}}
                    <li class="shop__category--item">
                        東京都
                    </li>
                    <li class="shop__category--item">
                        イタリアン
                    </li>
                </ul>
                <div class="shop__form">
                    <form class="shop__form--detail" action="" method="get">
                        @csrf
                        <button type="submit">
                            詳しく見る
                        </button>
                    </form>
                    <form class="shop__form--favorite" action="" method="post">
                        @csrf
                        <input type="hidden" name="" value="">
                        <button type="submit">
                            H
                        </button>
                    </form>
                </div>
            </div>
        </article>
        <article class="content__item">
            <div class="shop__img--box">
                <img class="shop__img" src="{{ asset('storage/shop/sushi.jpg') }}" alt="sushi">
            </div>
            <div class="shop__txt">
                <p class="shop__name">
                    仙人
                </p>
                <ul class="shop__category">
                    {{-- foreachを使ってカテゴリーをつける --}}
                    <li class="shop__category--item">
                        東京都
                    </li>
                    <li class="shop__category--item">
                        イタリアン
                    </li>
                </ul>
                <div class="shop__form">
                    <form class="shop__form--detail" action="" method="get">
                        @csrf
                        <button type="submit">
                            詳しく見る
                        </button>
                    </form>
                    <form class="shop__form--favorite" action="" method="post">
                        @csrf
                        <input type="hidden" name="" value="">
                        <button type="submit">
                            H
                        </button>
                    </form>
                </div>
            </div>
        </article>
        <article class="content__item">
            <div class="shop__img--box">
                <img class="shop__img" src="{{ asset('storage/shop/sushi.jpg') }}" alt="sushi">
            </div>
            <div class="shop__txt">
                <p class="shop__name">
                    仙人
                </p>
                <ul class="shop__category">
                    {{-- foreachを使ってカテゴリーをつける --}}
                    <li class="shop__category--item">
                        東京都
                    </li>
                    <li class="shop__category--item">
                        イタリアン
                    </li>
                </ul>
                <div class="shop__form">
                    <form class="shop__form--detail" action="" method="get">
                        @csrf
                        <button type="submit">
                            詳しく見る
                        </button>
                    </form>
                    <form class="shop__form--favorite" action="" method="post">
                        @csrf
                        <input type="hidden" name="" value="">
                        <button type="submit">
                            H
                        </button>
                    </form>
                </div>
            </div>
        </article>
    </section>
@endsection
