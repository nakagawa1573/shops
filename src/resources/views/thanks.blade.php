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
            <form class="content__item--form" action="/login" method="post">
                @csrf
                <input type="hidden" name="email" value="{{session('email')}}">
                <input type="hidden" name="password" value="{{session('password')}}">
                <button class="content__item--btn" type="submit">
                    ログインする
                </button>
            </form>
        </div>
    </section>
@endsection