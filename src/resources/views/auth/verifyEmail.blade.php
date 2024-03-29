@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <section class="content">
        <p class="content__ttl">
            Registration
        </p>
        <div class="content__auth">
            <form class="auth__form" action="/register/verify/send" method="post">
                @csrf
                <p>
                    登録メールアドレスに確認用メールを送信しました
                </p>
                <p>
                    メールを再送する場合は下のボタンをクリックしてください
                </p>
                <p>
                    {{session('message')}}
                </p>
                <div class="auth__form--item">
                    <button class="auth__form--item__btn" type="submit">
                        再送
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection