@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/evaluation.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="content__wrapper">
            <div class="content__item--wrapper">
                <div class="content__item--box">
                    <h1 class="content__item--ttl">
                        今回のご利用はいかがでしたか？
                    </h1>
                    <article class="content__item--shop">
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
                                        $stars = ($width - ($width % 5)) * 2;
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
                            @if ($favorite !== null)
                                <form class="shop__form--favorite" action="/favorite/{{ $shop->id }}/delete"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit">
                                        <div class="heart_favorite"></div>
                                    </button>
                                </form>
                            @else
                                <form class="shop__form--favorite" action="/favorite/{{ $shop->id }}"
                                    method="post">
                                    @csrf
                                    <button type="submit">
                                        <div class="heart"></div>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </article>
            </div>
        </div>
        <article class="content__item--wrapper">
            <div class="content__item">
                <h2 class="content__item--text">
                    体験を評価してください
                </h2>
                @error('evaluation')
                    <p class="error">
                        {{ $message }}
                    </p>
                @enderror
                <div class="content__item--star">
                    <button class="evaluation__star" id="star1">
                        ★
                    </button>
                    <button class="evaluation__star" id="star2">
                        ★
                    </button>
                    <button class="evaluation__star" id="star3">
                        ★
                    </button>
                    <button class="evaluation__star" id="star4">
                        ★
                    </button>
                    <button class="evaluation__star" id="star5">
                        ★
                    </button>
                </div>
            </div>
            <form name="form"
                action="/detail/evaluation/{{ $shop->id }}{{ isset($evaluation) ? '/' . $evaluation->id : null }}"
                enctype="multipart/form-data" method="post">
                @csrf
                @if (isset($evaluation))
                    @method('patch')
                @endif
                <input type="hidden" id="evaluation" name="evaluation" value="{{old('evaluation') ?? $evaluation->evaluation ?? null}}">
                <div class="content__item">
                    <h2 class="content__item--text">
                        口コミを投稿
                    </h2>
                    @error('comment')
                        <p class="error">
                            {{ $message }}
                        </p>
                    @enderror
                    @php
                        $comment = old('comment') ?? $evaluation->comment ?? null
                    @endphp
                    <textarea class="content__item--comment" id="comment" name="comment" placeholder="カジュアルな夜のお出かけにおすすめのスポット">{{$comment}}</textarea>
                    <p class="content__item--counter">
                        <span id="counter">
                            {{ mb_strlen($comment) }}
                        </span>
                        /400 (最高文字数)
                    </p>
                </div>
                <div class="content__item">
                    <h2 class="content__item--text">
                        画像の追加
                    </h2>
                    @error('img')
                        <p class="error">
                            {{ $message }}
                        </p>
                    @enderror
                    <input class="content__item--img" id="img" name="img" type="file">
                    <label for="img">
                        <p class="content__item--img__txt" id="drop__area">
                            クリックして写真を追加<br>
                            またはドラッグアンドドロップ
                        </p>
                    </label>
                </div>
            </form>
        </article>
    </div>
    <p class="message">
        {{ session('message') }}
    </p>
    <div class="btn__wrapper">
        @if (isset($evaluation))
            <button type="button" class="btn" id="btn">
                口コミを更新
            </button>
        @else
            <button type="button" class="btn" id="btn">
                口コミを投稿
            </button>
        @endif
    </div>
</section>
<script src="{{ asset('js/evaluation.js') }}"></script>
@endsection
