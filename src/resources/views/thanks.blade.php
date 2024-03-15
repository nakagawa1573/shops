@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
    <section class="content">
        <p class="content__txt">
            会員登録ありがとうございます
        </p>
        <div class="content__item">
            <a href="/login">
                <button class="content__item--btn" type="submit">
                    ログインする
                </button>
            </a>
        </div>
    </section>
@endsection
