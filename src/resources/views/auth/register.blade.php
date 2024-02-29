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
            <form class="auth__form" action="" method="post">
                @csrf
                <div class="auth__form--item">
                    <img src="{{asset('storage/person.svg')}}" alt="person" width="25px">
                    <input class="auth__form--item__input" type="text" placeholder="Username">
                </div>
                <div class="auth__form--item">
                    <img src="{{asset('storage/mail.svg')}}" alt="mail" width="25px">
                    <input class="auth__form--item__input" type="text" placeholder="Email">
                </div>
                <div class="auth__form--item">
                    <img src="{{asset('storage/key.svg')}}" alt="key" width="25px">
                    <input class="auth__form--item__input" type="password" placeholder="Password">
                </div>
                <div class="auth__form--item">
                    <button  class="auth__form--item__btn" type="submit">
                        登録
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
