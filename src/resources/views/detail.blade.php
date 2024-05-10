@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
    <section class="content">
        <article class="detail">
            <div class="detail__box">
                <form class="detail__back" action="/back" method="GET">
                    @csrf
                    <button>
                        < </button>
                </form>
                <h1 class="detail__ttl">
                    {{ $shop->shop }}
                </h1>
            </div>
            <img class="detail__img" src="{{ asset('storage/shop') }}/{{ $shop->img }}" alt="shop">
            <ul class="detail__category">
                <li class="detail__category--item">
                    #{{ $shop->area->area }}
                </li>
                @foreach ($shop->genre as $genre)
                    <li class="shop__category--item">
                        #{{ $genre->genre }}
                    </li>
                @endforeach
            </ul>
            <p class="detail__txt">
                {{ $shop->overview }}
            </p>
        </article>
        <div class="wrapper">
            <article class="reservation">
                <h2 class="reservation__ttl">
                    予約
                </h2>
                @if (
                    $errors->has('shop_id') ||
                        $errors->has('date') ||
                        $errors->has('time') ||
                        $errors->has('number') ||
                        session('reservation__message'))
                    <p class="error">
                        {{ $errors->first() ?: session('reservation__message') }}
                    </p>
                @endif
                <form class="reservation__form" action="/reservation/{{ $shop->id }}" method="post">
                    @csrf
                    <input class="reservation__form--date" type="date" name="date" id="date"
                        value="{{ old('date') ?: date('Y-m-d') }}">
                    <div class="wrapper__input">
                        <select class="reservation__form--time" id="time" name="time">
                            <option value="00:00" {{ old('time') == '00:00' ? 'selected' : '' }}>00:00</option>
                            <option value="00:30" {{ old('time') == '00:30' ? 'selected' : '' }}>00:30</option>
                            <option value="01:00" {{ old('time') == '01:00' ? 'selected' : '' }}>01:00</option>
                            <option value="01:30" {{ old('time') == '01:30' ? 'selected' : '' }}>01:30</option>
                            <option value="02:00" {{ old('time') == '02:00' ? 'selected' : '' }}>02:00</option>
                            <option value="02:30" {{ old('time') == '02:30' ? 'selected' : '' }}>02:30</option>
                            <option value="03:00" {{ old('time') == '03:00' ? 'selected' : '' }}>03:00</option>
                            <option value="03:30" {{ old('time') == '03:30' ? 'selected' : '' }}>03:30</option>
                            <option value="04:00" {{ old('time') == '04:00' ? 'selected' : '' }}>04:00</option>
                            <option value="04:30" {{ old('time') == '04:30' ? 'selected' : '' }}>04:30</option>
                            <option value="05:00" {{ old('time') == '05:00' ? 'selected' : '' }}>05:00</option>
                            <option value="05:30" {{ old('time') == '05:30' ? 'selected' : '' }}>05:30</option>
                            <option value="06:00" {{ old('time') == '06:00' ? 'selected' : '' }}>06:00</option>
                            <option value="06:30" {{ old('time') == '06:30' ? 'selected' : '' }}>06:30</option>
                            <option value="07:00" {{ old('time') == '07:00' ? 'selected' : '' }}>07:00</option>
                            <option value="07:30" {{ old('time') == '07:30' ? 'selected' : '' }}>07:30</option>
                            <option value="08:00" {{ old('time') == '08:00' ? 'selected' : '' }}>08:00</option>
                            <option value="08:30" {{ old('time') == '08:30' ? 'selected' : '' }}>08:30</option>
                            <option value="09:00" {{ old('time') == '09:00' ? 'selected' : '' }}>09:00</option>
                            <option value="09:30" {{ old('time') == '09:30' ? 'selected' : '' }}>09:30</option>
                            <option value="10:00" {{ old('time') == '10:00' ? 'selected' : '' }}>10:00</option>
                            <option value="10:30" {{ old('time') == '10:30' ? 'selected' : '' }}>10:30</option>
                            <option value="11:00" {{ old('time') == '11:00' ? 'selected' : '' }}>11:00</option>
                            <option value="11:30" {{ old('time') == '11:30' ? 'selected' : '' }}>11:30</option>
                            <option value="12:00" {{ old('time') == '12:00' ? 'selected' : '' }}>12:00</option>
                            <option value="12:30" {{ old('time') == '12:30' ? 'selected' : '' }}>12:30</option>
                            <option value="13:00" {{ old('time') == '13:00' ? 'selected' : '' }}>13:00</option>
                            <option value="13:30" {{ old('time') == '13:30' ? 'selected' : '' }}>13:30</option>
                            <option value="14:00" {{ old('time') == '14:00' ? 'selected' : '' }}>14:00</option>
                            <option value="14:30" {{ old('time') == '14:30' ? 'selected' : '' }}>14:30</option>
                            <option value="15:00" {{ old('time') == '15:00' ? 'selected' : '' }}>15:00</option>
                            <option value="15:30" {{ old('time') == '15:30' ? 'selected' : '' }}>15:30</option>
                            <option value="16:00" {{ old('time') == '16:00' ? 'selected' : '' }}>16:00</option>
                            <option value="16:30" {{ old('time') == '16:30' ? 'selected' : '' }}>16:30</option>
                            <option value="17:00" {{ old('time') == '17:00' ? 'selected' : '' }}>17:00</option>
                            <option value="17:30" {{ old('time') == '17:30' ? 'selected' : '' }}>17:30</option>
                            <option value="18:00" {{ old('time') == '18:00' ? 'selected' : '' }}>18:00</option>
                            <option value="18:30" {{ old('time') == '18:30' ? 'selected' : '' }}>18:30</option>
                            <option value="19:00" {{ old('time') == '19:00' ? 'selected' : '' }}>19:00</option>
                            <option value="19:30" {{ old('time') == '19:30' ? 'selected' : '' }}>19:30</option>
                            <option value="20:00" {{ old('time') == '20:00' ? 'selected' : '' }}>20:00</option>
                            <option value="20:30" {{ old('time') == '20:30' ? 'selected' : '' }}>20:30</option>
                            <option value="21:00" {{ old('time') == '21:00' ? 'selected' : '' }}>21:00</option>
                            <option value="21:30" {{ old('time') == '21:30' ? 'selected' : '' }}>21:30</option>
                            <option value="22:00" {{ old('time') == '22:00' ? 'selected' : '' }}>22:00</option>
                            <option value="22:30" {{ old('time') == '22:30' ? 'selected' : '' }}>22:30</option>
                            <option value="23:00" {{ old('time') == '23:00' ? 'selected' : '' }}>23:00</option>
                            <option value="23:30" {{ old('time') == '23:30' ? 'selected' : '' }}>23:30</option>
                        </select>
                    </div>
                    <div class="wrapper__input">
                        <select class="reservation__form--people" id="number" name="number">
                            <option value="1" {{ old('number') == 1 ? 'selected' : '' }}>
                                1人
                            </option>
                            <option value="2" {{ old('number') == 2 ? 'selected' : '' }}>
                                2人
                            </option>
                            <option value="3" {{ old('number') == 3 ? 'selected' : '' }}>
                                3人
                            </option>
                            <option value="4" {{ old('number') == 4 ? 'selected' : '' }}>
                                4人
                            </option>
                            <option value="5" {{ old('number') == 5 ? 'selected' : '' }}>
                                5人
                            </option>
                            <option value="6" {{ old('number') == 6 ? 'selected' : '' }}>
                                6人
                            </option>
                            <option value="7" {{ old('number') == 7 ? 'selected' : '' }}>
                                7人
                            </option>
                            <option value="8" {{ old('number') == 8 ? 'selected' : '' }}>
                                8人
                            </option>
                            <option value="9" {{ old('number') == 9 ? 'selected' : '' }}>
                                9人
                            </option>
                            <option value="over_10" {{ old('number') == 'over_10' ? 'selected' : '' }}>
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
                                    {{ $shop->shop }}
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
                    </div>
                    <button class="form__btn" type="submit">
                        予約する
                    </button>
                </form>
            </article>
        </div>
    </section>
    <section class="evaluation">
        @php
            $flag = false;
            foreach ($evaluations as $evaluation) {
                if (Auth::guard('web')->check() && $evaluation->user_id === Auth::user()->id) {
                    $flag = true;
                    break;
                }
            }
        @endphp
        @if (Auth::check() && !$flag)
            <a href="/detail/evaluation/{{ $shop->id }}" class="evaluation__post">
                口コミを投稿する
            </a>
            <br>
        @endif
        {{ session('message') }}
        <p class="evaluation__ttl">
            全ての口コミ情報
        </p>
        <article class="evaluation__item--group">
            @foreach ($evaluations as $evaluation)
                <div class="evaluation__item">
                    <div class="evaluation__link--wrapper">
                        @can('update', $evaluation)
                            <a class="evaluation__link" href="/detail/evaluation/{{ $shop->id }}">
                                口コミを編集
                            </a>
                        @endcan
                        @can('destroy', $evaluation)
                            <form class="evaluation__link--form" action="/detail/evaluation/delete/{{ $evaluation->id }}"
                                method="post">
                                @csrf
                                @method('delete')
                                <button class="evaluation__link" type="submit">
                                    口コミを削除
                                </button>
                            </form>
                        @endcan
                    </div>
                    <div class="star__box">
                        <div class="star">★★★★★</div>
                        <div class="star__check--group">
                            @php
                                $count = $evaluation->evaluation;
                            @endphp
                            @for ($i = 1; $i <= $count; $i++)
                                <div class="star__check">★</div>
                            @endfor
                        </div>
                    </div>
                    <p>
                        {!! nl2br(htmlspecialchars($evaluation->comment)) !!}
                    </p>
                    @if (isset($evaluation->img))
                        <img class="evaluation__img" src="{{ Storage::disk('public')->url('/evaluation/' . $evaluation->img) }}">
                    @endif
                </div>
            @endforeach
        </article>
    </section>
    <script src="{{ asset('js/main.js') }}"></script>
@endsection
