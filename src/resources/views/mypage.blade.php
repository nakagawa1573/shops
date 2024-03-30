@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <section class="content">
        <h1 class="txt__name">
            {{ $user->name }}さん
        </h1>
        <div class="content__wrapper">
            <section>
                <h2 class="txt__reservation--item">
                    予約状況
                </h2>
                <div class="content__reservation">
                    @php
                        $count = 0;
                    @endphp
                    @foreach ($reservations as $reservation)
                        @foreach ($reservation->reservation as $reservation)
                            <article class="reservation">
                                <div class="reservation__ttl--box">
                                    <div id="box__1">
                                        <img class="reservation__icon" src="{{ asset('storage/watch.png') }}"
                                            alt="">
                                        <p class="reservation__ttl">
                                            @php
                                                $count++;
                                            @endphp
                                            予約{{ $count }}
                                        </p>
                                    </div>
                                    <div id="box__2">
                                        <form action="/reservation/update/{{ $reservation->pivot->id }}" method="get">
                                            @csrf
                                            <button class="reservation__change">
                                                変更
                                            </button>
                                        </form>
                                        <form action="/reservation/delete/{{$reservation->pivot->id}}" method="post">
                                            @csrf
                                            @method('delete')
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
                                @if ($reservation->pivot->product_id)
                                    <div>
                                        @if ($reservation->pivot->pay == 'done')
                                            <p class="reservation__payment--done">
                                                支払い済み
                                            </p>
                                        @else
                                            <form action="/reservation/payment/{{ $reservation->pivot->id }}"
                                                class="reservation__payment">
                                                @csrf
                                                <button class="reservation__payment--btn" type="submit">
                                                    事前決済を行う
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            </article>
                        @endforeach
                    @endforeach
                </div>
            </section>
            <section>
                <h2 class="txt__favorite--item">
                    お気に入り店舗
                </h2>
                <div class="content__shop">
                    @foreach ($favorites as $favorite)
                        @foreach ($favorite->favorite as $favorite)
                            <article class="shop">
                                <div class="shop__img--box">
                                    <img class="shop__img" src="{{ asset('storage/shop') }}/{{ $favorite->img }}"
                                        alt="shop">
                                </div>
                                <div class="shop__txt">
                                    <h2 class="shop__name">
                                        {{ $favorite->shop }}
                                    </h2>
                                    <div class="shop__evaluation">
                                        @if ($favorite->evaluation->count() !== 0)
                                            @php
                                                $countDate = $favorite->evaluation->count();
                                                $count = 0;
                                                foreach ($favorite->evaluation as $evaluation) {
                                                    $count += $evaluation->pivot->evaluation;
                                                }
                                                $average = number_format($count / $countDate, 1);
                                                $stars = number_format($average * 2) * 10;
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
                                        <div class="total__star--check" style="width: {{ $stars ?? 0 }}px">
                                            ★★★★★
                                        </div>
                                    </div>
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
                                        <form class="shop__form--detail" action="/detail/{{ $favorite->id }}"
                                            method="get">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $favorite->id }}">
                                            <button type="submit">
                                                詳しくみる
                                            </button>
                                        </form>
                                        <form class="shop__form--favorite" action="/favorite/{{$favorite->id}}/delete" method="post">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="shop_id" value="{{ $favorite->id }}">
                                            <button type="submit">
                                                <div class="heart_favorite"></div>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    @endforeach
                </div>
            </section>
        </div>
    </section>
@endsection
