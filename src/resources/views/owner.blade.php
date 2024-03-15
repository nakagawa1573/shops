@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/owner.css') }}">
@endsection

@section('content')
    <section class="content">
        @if (!isset($shopData))
            <h2 class="content__ttl">
                店舗の作成
            </h2>
            <article class="content__form">
                <form action="/owner" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="content__form--box" id="box__1">
                        <div class="content__form--item">
                            <h3>店名</h3>
                            <input id="name" type="text" name="shop" value="{{ old('shop') }}">
                        </div>
                        @error('shop')
                            <p class="error">{{ $message }}</p>
                        @enderror
                        <div class="content__form--item">
                            <h3>エリア</h3>
                            <div id="area__wrapper" style="height: 30px">
                                <select name="area_id" id="area">
                                    @foreach ($areas as $area)
                                        <option value="{{ $area->id }}"
                                            {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                            {{ $area->area }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @error('area_id')
                            <p class="error">{{ $message }}</p>
                        @enderror
                        <fieldset>
                            <legend>
                                <h3 id="genre__ttl">
                                    ジャンル
                                </h3>
                            </legend>
                            <div class="genre__wrapper">
                                @foreach ($genres as $genre)
                                    <div class="genre__item">
                                        <input class="genre__item--check" type="checkbox" id="genre{{ $genre->id }}"
                                            name="genre_id[]" value="{{ $genre->id }}">
                                        <label for="genre{{ $genre->id }}">{{ $genre->genre }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </fieldset>
                        @error('genre_id')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="content__form--box" id="box__2">
                        <div class="content__form--item">
                            <h3>店舗概要</h3>
                            <textarea name="overview" id="overview" cols="30" rows="10">{{ old('overview') }}</textarea>
                        </div>
                        @error('overview')
                            <p class="error">{{ $message }}</p>
                        @enderror
                        <div class="content__form--item">
                            <h3>トップ画像</h3>
                            <input type="file" id="img" name="img">
                        </div>
                        @error('img')
                            <p class="error">{{ $message }}</p>
                        @enderror
                        <button type="submit" id="btn">
                            送信する
                        </button>
                    </div>
                </form>
            </article>
        @else
            <h2 class="content__ttl">
                店舗情報の更新
            </h2>
            <article class="content__form">
                <form action="/owner/update" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="id" value="{{ $shopData->id }}">
                    <div class="content__form--box" id="box__1">
                        <div class="content__form--item">
                            <h3>店名</h3>
                            <input id="name" type="text" name="shop" value="{{ $shopData->shop }}">
                        </div>
                        @error('shop')
                            <p class="error">{{ $message }}</p>
                        @enderror
                        <div class="content__form--item">
                            <h3>エリア</h3>
                            <div id="area__wrapper" style="height: 30px">
                                <select name="area_id" id="area">
                                    @foreach ($areas as $area)
                                        <option value="{{ $area->id }}"
                                            {{ $shopData->area_id == $area->id ? 'selected' : '' }}>
                                            {{ $area->area }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @error('area_id')
                            <p class="error">{{ $message }}</p>
                        @enderror
                        <fieldset>
                            <legend>
                                <h3 id="genre__ttl">
                                    ジャンル
                                </h3>
                            </legend>
                            <div class="genre__wrapper">
                                @foreach ($genres as $genre)
                                    @php
                                        $checked = '';
                                        foreach ($genreDatas as $genredata) {
                                            if ($genre->id == $genredata->genre_id) {
                                                $checked = 'checked';
                                            }
                                        }
                                    @endphp
                                    <div class="genre__item">
                                        <input class="genre__item--check" type="checkbox" id="genre{{ $genre->id }}"
                                            name="genre_id[]" value="{{ $genre->id }}" {{ $checked }}>
                                        <label for="genre{{ $genre->id }}">{{ $genre->genre }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </fieldset>
                        @error('genre_id')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="content__form--box" id="box__2">
                        <div class="content__form--item">
                            <h3>店舗概要</h3>
                            <textarea name="overview" id="overview" cols="30" rows="10">{{ $shopData->overview }}</textarea>
                        </div>
                        @error('overview')
                            <p class="error">{{ $message }}</p>
                        @enderror
                        <div class="content__form--item">
                            <h3>トップ画像</h3>
                            <input type="file" id="img" name="img">
                        </div>
                        @error('img')
                            <p class="error">{{ $message }}</p>
                        @enderror
                        <button type="submit" id="btn">
                            送信する
                        </button>
                    </div>
                </form>
            </article>
            <article class="content__reservation">
                <h2 class="content__ttl">
                    予約一覧
                </h2>
                @foreach ($reservations as $reservation)
                    <div class="content__reservation--item">
                        <table class="content__reservation--table">
                            <tr class="content__reservation--row">
                                <th class="content__reservation--header">
                                    Name:
                                </th>
                                <td class="content__reservation--data" id="name">
                                    {{ $reservation->user->name }}
                                </td>
                                <th class="content__reservation--header">
                                    Date:
                                </th>
                                <td class="content__reservation--data" id="date">
                                    {{ $reservation->date }}
                                </td>
                                <th class="content__reservation--header">
                                    Time:
                                </th>
                                <td class="content__reservation--data" id="time">
                                    {{ $reservation->time }}
                                </td>
                                <th class="content__reservation--header">
                                    Number:
                                </th>
                                <td class="content__reservation--data" id="number">
                                    @if ($reservation->number == 'over_10')
                                        10人以上
                                    @else
                                        {{ $reservation->number }}人
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                @endforeach
            </article>
        @endif
    </section>
@endsection
