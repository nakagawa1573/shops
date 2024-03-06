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
                {{ $user->name }}さん
            </h1>
            <h2 class="txt__favorite--item">
                お気に入り店舗
            </h2>
        </div>
    </section>
    <section class="content">
        <section class="content__reservation">
            @php
                $count = 0;
            @endphp
            @foreach ($reservations as $reservation)
                @foreach ($reservation->reservation as $reservation)
                    <article class="reservation">
                        <div class="reservation__ttl--box">
                            <div id="box__1">
                                <img class="reservation__icon" src="{{ asset('storage/watch.png') }}" alt="">
                                <p class="reservation__ttl">
                                    @php
                                        $count ++;
                                    @endphp
                                    予約{{ $count }}
                                </p>
                            </div>
                            <div>
                                <form action="/reservation/delete" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="id" value="{{ $reservation->pivot->id }}">
                                    <button class="reservation__cancel--btn" type="submit">
                                        <img class="reservation__cancel--img" src="{{ asset('storage/cross.svg') }}"
                                            alt="">
                                    </button>
                                </form>
                            </div>
                        </div>
                        <table class="reservation__table">
                            <tr class="reservation__row">
                                <td class="reservation__item">
                                    Shop
                                </td>
                                <td class="reservation__item">
                                    {{ $reservation->shop }}
                                </td>
                            </tr>
                            <tr>
                                <td class="reservation__item">
                                    Date
                                </td>
                                <td class="reservation__item">
                                    {{ $reservation->pivot->date }}
                                </td>
                            </tr>
                            <tr>
                                <td class="reservation__item">
                                    Time
                                </td>
                                <td class="reservation__item">
                                    {{ Carbon\Carbon::parse($reservation->pivot->time)->format('H:i') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="reservation__item">
                                    Number
                                </td>
                                <td class="reservation__item">
                                    @if ($reservation->pivot->number == 'over_10')
                                        10人以上
                                    @else
                                    {{ $reservation->pivot->number }}人
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </article>
                @endforeach
            @endforeach
        </section>
        <section class="content__shop">
            @foreach ($favorites as $favorite)
                @foreach ($favorite->favorite as $favorite)
                    <article class="shop">
                        <div class="shop__img--box">
                            <img class="shop__img" src="{{ asset('storage/shop') }}/{{ $favorite->img }}" alt="shop">
                        </div>
                        <div class="shop__txt">
                            <h2 class="shop__name">
                                {{ $favorite->shop }}
                            </h2>
                            <ul class="shop__category">
                                <li class="shop__category--item">
                                    #{{ $favorite->area->area }}
                                </li>
                                @foreach ($favorite->genre as $genre)
                                    <li class="shop__category--item">
                                        #{{ $genre->genre }}
                                    </li>
                                @endforeach
                            </ul>
                            <div class="shop__form">
                                <form class="shop__form--detail" action="/detail/{{ $favorite->id }}" method="get">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $favorite->id }}">
                                    <button type="submit">
                                        詳しくみる
                                    </button>
                                </form>
                                <form class="shop__form--favorite" action="/favorite/delete" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="shop_id" value="{{ $favorite->id }}">
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <button type="submit">
                                        <div class="heart_favorite"></div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            @endforeach
        </section>
    </section>
@endsection
