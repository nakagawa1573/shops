@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/import.css') }}">
@endsection

@section('content')
    <section class="content">
        <form action="/admin/import" method="post" enctype="multipart/form-data">
            @csrf
            <label for="csvFile">
                <div class="content__csv">
                    CSVを選択
                </div>
            </label>
            <input type="file" name="csvFile" id="csvFile" onchange="submit(this.form)">
        </form>
        <p>
            @if (session('message'))
                {{ session('message') }}
            @endif
        </p>
    </section>
    <nav class="conditions">
        <h3>
            以下の要件を満たしているか、必ず確認をしてください
        </h3>
        <ul>
            <li>店舗名：50文字以内</li>
            <li>地域：「東京都」「大阪府」「福岡県」のいずれか</li>
            <li>ジャンル：「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれか</li>
            <li>店舗概要：400文字以内</li>
            <li>画像URL：jpeg、pngのみ使用可能</li>
        </ul>
    </nav>
@endsection
