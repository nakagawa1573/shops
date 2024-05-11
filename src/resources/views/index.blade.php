@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('search')
    <section class="search">
        <form class="search__form" action="/" method="get" novalidate>
            @csrf
            <select class="search__sort" name="sort" onchange="submit(this.form)">
                <option value="" disabled selected style="display:none;">
                    並び替え：評価高/低
                </option>
                <option value="random" {{ $sort == 'random' ? 'selected' : '' }}>
                    ランダム
                </option>
                <option value="high" {{ $sort == 'high' ? 'selected' : '' }}>
                    評価が高い順
                </option>
                <option value="low" {{ $sort == 'low' ? 'selected' : '' }}>
                    評価が低い順
                </option>
            </select>
            <div class="search__group">
                <div class="search__area--box">
                    <select class="search__area" name="area_id" onchange="submit(this.form)" required>
                        <option value="" selected>
                            All area
                        </option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}" {{ $area->id == $area_id ? 'selected' : '' }}>
                                {{ $area->area }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="search__genre--box">
                    <select class="search__genre" name="genre_id" onchange="submit(this.form)" required>
                        <option value="" selected>
                            All genre
                        </option>
                        @foreach ($genres as $genre)
                            <option value="{{ $genre->id }}" {{ $genre->id == $genre_id ? 'selected' : '' }}>
                                {{ $genre->genre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="search__form--box">
                    <button class="search__btn" type="submit">
                        <img src="{{ asset('storage/search.svg') }}" alt="search">
                    </button>
                    <input class="search__word" type="text" name="keyword" value="{{ $keyword ?? '' }}"
                        placeholder="Search ...">
                </div>
            </div>
        </form>
    </section>
@endsection

@section('content')
    <section class="content">
        @foreach ($shops as $shop)
            <article class="content__item">
                <div class="shop__img--box">
                    <img class="shop__img" src="{{ asset('storage/shop') }}/{{ $shop->img }}" alt="shop">
                </div>
                <div class="shop__txt">
                    <h2 class="shop__name">
                        {{ $shop->shop }}
                    </h2>
                    <div class="shop__evaluation">
                        @if ($shop->evaluation->count() !== 0)
                            @php
                                $countDate = $shop->evaluation->count();
                                $width = $shop->average * 10;
                                $stars = ($width - $width % 5) * 2;
                            @endphp
                        @else
                            @php
                                $stars = 0;
                                $countDate = 0;
                            @endphp
                        @endif
                        <div class="total__star">
                            ★★★★★ <span id="count">({{ $countDate }})</span>
                        </div>
                        <div class="total__star--check" id="star" style="width: {{ $stars ?? 0 }}px">
                            ★★★★★
                        </div>
                    </div>
                    <ul class="shop__category">
                        <li class="shop__category--item">
                            #{{ $shop->area->area }}
                        </li>
                        @php
                            $count = 0;
                        @endphp
                        @foreach ($shop->genre as $genre)
                            <li class="shop__category--item">
                                #{{ $genre->genre }}
                            </li>
                            @php
                                $count++;
                            @endphp
                            @if ($count == 2)
                                <li class="shop__category--item">
                                    ...
                                </li>
                                @break
                            @endif
                        @endforeach
                    </ul>
                <div class="shop__form">
                    <form class="shop__form--detail" action="/detail/{{ $shop->id }}" method="get">
                        @csrf
                        <button type="submit">
                            詳しくみる
                        </button>
                    </form>
                    @csrf
                    @if (Auth::check())
                        @php
                            $flag = false;
                            foreach ($favorites as $favorite) {
                                if ($favorite->shop_id == $shop->id) {
                                    $flag = true;
                                    break;
                                }
                            }
                        @endphp
                        @if ($flag)
                            <form class="shop__form--favorite" action="/favorite/{{ $shop->id }}/delete"
                                method="post">
                                @csrf
                                @method('delete')
                                <button type="submit">
                                    <div class="heart_favorite"></div>
                                </button>
                            </form>
                        @else
                            <form class="shop__form--favorite" action="/favorite/{{ $shop->id }}" method="post">
                                @csrf
                                <button type="submit">
                                    <div class="heart"></div>
                                </button>
                            </form>
                        @endif
                    @else
                        <form class="shop__form--favorite" action="/login" method="get">
                            @csrf
                            <button type="submit">
                                <div class="heart"></div>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </article>
    @endforeach
</section>
@endsection
