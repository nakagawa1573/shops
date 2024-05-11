@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <section class="content">
        <p class="content__ttl">
            Registration for owner
        </p>
        <div class="content__auth">
            <form class="auth__form" action="/admin" method="post">
                @csrf
                <p class="error">
                    @error('name')
                        {{ $message }}
                    @enderror
                </p>
                <p class="success">
                    @if (session('message'))
                        {{ session('message') }}
                    @endif
                </p>
                <div class="auth__form--item">
                    <img src="{{ asset('storage/person.svg') }}" alt="person" width="25px">
                    <input class="auth__form--item__input" type="text" name="name" placeholder="Username">
                </div>
                <p class="error">
                    @error('email')
                        {{ $message }}
                    @enderror
                </p>
                <div class="auth__form--item">
                    <img src="{{ asset('storage/mail.svg') }}" alt="mail" width="25px">
                    <input class="auth__form--item__input" type="text" name="email" placeholder="Email">
                </div>
                <p class="error">
                    @error('password')
                        {{ $message }}
                    @enderror
                </p>
                <div class="auth__form--item">
                    <img src="{{ asset('storage/key.svg') }}" alt="key" width="25px">
                    <input class="auth__form--item__input" type="password" name="password" placeholder="Password">
                </div>
                <div class="auth__form--item">
                    <button class="auth__form--item__btn" type="submit">
                        登録
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
