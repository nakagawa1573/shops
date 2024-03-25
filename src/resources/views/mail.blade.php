@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/mail.css') }}">
@endsection

@section('content')
    <section class="content">
        <h2 class="content__ttl">
            メール送信
        </h2>
        <article class="content__mail">
            <p class="message">
                {{ session('message') }}
            </p>
            <form action="" method="post">
                @csrf
                <div class="content__mail--item" id="subject">
                    <h3 id="ttl">
                        主題
                    </h3>
                    <input id="item__1" type="text" name="subject">
                </div>
                <div class="content__mail--item" id="content">
                    <h3 id="ttl">
                        本文
                    </h3>
                    <textarea name="content" id="item__2" cols="30" rows="10"></textarea>
                </div>
                <button id="btn">
                    送信
                </button>
            </form>
        </article>
    </section>
@endsection
