@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/updateReservation.css') }}">
@endsection

@section('content')
    <section class="content">
        <article class="reservation">
            <div class="reservation__ttl--box">
                <form action="/back" method="GET">
                    @csrf
                    <button class="reservation__back">
                        < </button>
                </form>
                <h2 class="reservation__ttl">
                    予約
                </h2>
            </div>
            @if ($errors->any() || session('message'))
                <p class="error">
                    {{ $errors->first() ?: session('message') }}
                </p>
            @endif
            <form class="reservation__form" action="/reservation/change" method="post">
                @csrf
                @method('PATCH')
                <input type="hidden" name="shop_id" value="{{ $reservation->shop_id }}">
                <input type="hidden" name="id" value="{{ $reservation->id }}">
                <input class="reservation__form--date" type="date" name="date" id="date"
                    value="{{ $reservation->date }}">
                <div class="wrapper__input">
                    <select class="reservation__form--time" id="time" name="time">
                        <option value="00:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '00:00' ? 'selected' : '' }}>00:00
                        </option>
                        <option value="00:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '00:30' ? 'selected' : '' }}>00:30
                        </option>
                        <option value="01:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '01:00' ? 'selected' : '' }}>01:00
                        </option>
                        <option value="01:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '01:30' ? 'selected' : '' }}>01:30
                        </option>
                        <option value="02:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '02:00' ? 'selected' : '' }}>02:00
                        </option>
                        <option value="02:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '02:30' ? 'selected' : '' }}>
                            02:30
                        </option>
                        <option value="03:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '03:00' ? 'selected' : '' }}>
                            03:00</option>
                        <option value="03:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '03:30' ? 'selected' : '' }}>
                            03:30</option>
                        <option value="04:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '04:00' ? 'selected' : '' }}>
                            04:00</option>
                        <option value="04:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '04:30' ? 'selected' : '' }}>
                            04:30</option>
                        <option value="05:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '05:00' ? 'selected' : '' }}>
                            05:00</option>
                        <option value="05:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '05:30' ? 'selected' : '' }}>
                            05:30</option>
                        <option value="06:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '06:00' ? 'selected' : '' }}>
                            06:00</option>
                        <option value="06:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '06:30' ? 'selected' : '' }}>
                            06:30</option>
                        <option value="07:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '07:00' ? 'selected' : '' }}>
                            07:00</option>
                        <option value="07:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '07:30' ? 'selected' : '' }}>
                            07:30</option>
                        <option value="08:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '08:00' ? 'selected' : '' }}>
                            08:00</option>
                        <option value="08:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '08:30' ? 'selected' : '' }}>
                            08:30</option>
                        <option value="09:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '09:00' ? 'selected' : '' }}>
                            09:00</option>
                        <option value="09:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '09:30' ? 'selected' : '' }}>
                            09:30</option>
                        <option value="10:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '10:00' ? 'selected' : '' }}>
                            10:00</option>
                        <option value="10:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '10:30' ? 'selected' : '' }}>
                            10:30</option>
                        <option value="11:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '11:00' ? 'selected' : '' }}>
                            11:00</option>
                        <option value="11:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '11:30' ? 'selected' : '' }}>
                            11:30</option>
                        <option value="12:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '12:00' ? 'selected' : '' }}>
                            12:00</option>
                        <option value="12:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '12:30' ? 'selected' : '' }}>
                            12:30</option>
                        <option value="13:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '13:00' ? 'selected' : '' }}>
                            13:00</option>
                        <option value="13:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '13:30' ? 'selected' : '' }}>
                            13:30</option>
                        <option value="14:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '14:00' ? 'selected' : '' }}>
                            14:00</option>
                        <option value="14:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '14:30' ? 'selected' : '' }}>
                            14:30</option>
                        <option value="15:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '15:00' ? 'selected' : '' }}>
                            15:00</option>
                        <option value="15:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '15:30' ? 'selected' : '' }}>
                            15:30</option>
                        <option value="16:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '16:00' ? 'selected' : '' }}>
                            16:00</option>
                        <option value="16:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '16:30' ? 'selected' : '' }}>
                            16:30</option>
                        <option value="17:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '17:00' ? 'selected' : '' }}>
                            17:00</option>
                        <option value="17:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '17:30' ? 'selected' : '' }}>
                            17:30</option>
                        <option value="18:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '18:00' ? 'selected' : '' }}>
                            18:00</option>
                        <option value="18:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '18:30' ? 'selected' : '' }}>
                            18:30</option>
                        <option value="19:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '19:00' ? 'selected' : '' }}>
                            19:00</option>
                        <option value="19:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '19:30' ? 'selected' : '' }}>
                            19:30</option>
                        <option value="20:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '20:00' ? 'selected' : '' }}>
                            20:00</option>
                        <option value="20:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '20:30' ? 'selected' : '' }}>
                            20:30</option>
                        <option value="21:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '21:00' ? 'selected' : '' }}>
                            21:00</option>
                        <option value="21:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '21:30' ? 'selected' : '' }}>
                            21:30</option>
                        <option value="22:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '22:00' ? 'selected' : '' }}>
                            22:00</option>
                        <option value="22:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '22:30' ? 'selected' : '' }}>
                            22:30</option>
                        <option value="23:00"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '23:00' ? 'selected' : '' }}>
                            23:00</option>
                        <option value="23:30"
                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') == '23:30' ? 'selected' : '' }}>
                            23:30</option>
                    </select>
                </div>
                <div class="wrapper__input">
                    <select class="reservation__form--people" id="number" name="number">
                        <option value="1" {{ $reservation->number == 1 ? 'selected' : '' }}>
                            1人
                        </option>
                        <option value="2" {{ $reservation->number == 2 ? 'selected' : '' }}>
                            2人
                        </option>
                        <option value="3" {{ $reservation->number == 3 ? 'selected' : '' }}>
                            3人
                        </option>
                        <option value="4" {{ $reservation->number == 4 ? 'selected' : '' }}>
                            4人
                        </option>
                        <option value="5" {{ $reservation->number == 5 ? 'selected' : '' }}>
                            5人
                        </option>
                        <option value="6" {{ $reservation->number == 6 ? 'selected' : '' }}>
                            6人
                        </option>
                        <option value="7" {{ $reservation->number == 7 ? 'selected' : '' }}>
                            7人
                        </option>
                        <option value="8" {{ $reservation->number == 8 ? 'selected' : '' }}>
                            8人
                        </option>
                        <option value="9" {{ $reservation->number == 9 ? 'selected' : '' }}>
                            9人
                        </option>
                        <option value="over_10" {{ $reservation->number == 'over_10' ? 'selected' : '' }}>
                            10人以上
                        </option>
                    </select>
                </div>
                <div class="form__result">
                    <table class="form__result--table">
                        <tr class="form__result--row">
                            <td class="form__result--item">
                                Shop
                            </td>
                            <td class="form__result--item">
                                {{ $reservation->shop->shop }}
                            </td>
                        </tr>
                        <tr>
                            <td class="form__result--item">
                                Date
                            </td>
                            <td class="form__result--item" id="result__date">
                            </td>
                        </tr>
                        <tr>
                            <td class="form__result--item">
                                Time
                            </td>
                            <td class="form__result--item" id="result__time">
                            </td>
                        </tr>
                        <tr>
                            <td class="form__result--item">
                                Number
                            </td>
                            <td class="form__result--item" id="result__number">
                            </td>
                        </tr>
                    </table>
                    <script src="{{ asset('js/main.js') }}"></script>
                </div>
                <button class="form__btn" type="submit">
                    変更する
                </button>
            </form>
        </article>
    </section>
@endsection
