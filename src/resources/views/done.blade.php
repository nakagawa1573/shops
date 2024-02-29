@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
    <section class="content">
        <p class="content__txt">
            ご予約ありがとうございます
        </p>

        <div class="content__item">
            <a class="content__item--link">
                <button class="content__item--btn" type="submit">
                    戻る
                </button>
            </a>
        </div>
    </section>
@endsection