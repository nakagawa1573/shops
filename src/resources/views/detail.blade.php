@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
    <section class="content">
        <article class="detail">
            <div class="detail__box">
                <a href="" class="detail__back">
                    <button>
                        < </button>
                </a>
                <h2 class="detail__ttl">
                    仙人
                </h2>
            </div>
            <img class="detail__img" src="{{ asset('storage/shop/sushi.jpg') }}" alt="sushi">
            <ul class="detail__category">
                {{-- foreachを使ってカテゴリーをつける --}}
                <li class="detail__category--item">
                    #東京都
                </li>
                <li class="detail__category--item">
                    #寿司
                </li>
            </ul>
            <p class="detail__txt">
                料理長厳選の食材から作る寿司を用いたコースをぜひお楽しみください。食材・味・価格、お客様の満足度を徹底的に追求したお店です。特別な日のお食事、ビジネス接待まで
                気軽に使用することができます。
            </p>
        </article>
        <div class="wrapper">
            <article class="reservation">
                <h2 class="reservation__ttl">
                    予約
                </h2>
                <form class="reservation__form" action="" method="post">
                    @csrf
                    <input class="reservation__form--date" type="date">
                    <input class="reservation__form--time" type="time">
                    <select class="reservation__form--people" name="number_of_people">
                        <option value="1">
                            1人
                        </option>
                        <option value="2">
                            2人
                        </option>
                        <option value="3">
                            3人
                        </option>
                        <option value="4">
                            4人
                        </option>
                        <option value="5">
                            5人
                        </option>
                        <option value="6">
                            6人
                        </option>
                        <option value="7">
                            7人
                        </option>
                    </select>
                    <div class="form__result">
                        <table class="form__result--table">
                            <tr class="form__result--row">
                                <td class="form__result--item">
                                    Shop
                                </td>
                                <td class="form__result--item">
                                    仙人
                                </td>
                            </tr>
                            <tr>
                                <td class="form__result--item">
                                    Date
                                </td>
                                <td class="form__result--item">
                                    2021-04-01
                                </td>
                            </tr>
                            <tr>
                                <td class="form__result--item">
                                    Time
                                </td>
                                <td class="form__result--item">
                                    17:00
                                </td>
                            </tr>
                            <tr>
                                <td class="form__result--item">
                                    Number
                                </td>
                                <td class="form__result--item">
                                    1人
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
@endsection
