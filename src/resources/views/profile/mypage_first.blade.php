@extends('layouts.profile_layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage-firstlogin.css') }}">
@endsection

@section('content')
    <div class="fillout-box">
        <div class="title-box">
            <h2>プロフィール設定</h2>
        </div>
        <form action="" method="POST">
            @csrf
            <div class="logo-box">
                <div class="icon">

                </div>
                <label for="img" class="file-label">画像を選択する</label>
                <input type="file" id="img" name="img" accept="image/*" hidden>
            </div>
            <div class="user-box">
                <div class="user-box-name">
                    <label for="">ユーザー名</label>
                </div>
                <div class="user-box-input">

                </div>
            </div>
            <div class="postal-box">
                <div class="postal-box-name">
                    <label for="">郵便番号</label>
                </div>
                <div class="postal-box-input">

                </div>
            </div>
            <div class="address-box">
                <div class="address-box-name">
                    <label for="">住所</label>
                </div>
                <div class="address-box-input">

                </div>
            </div>
            <div class="building-box">
                <div class="building-box-name">
                    <label for="">建物名</label>
                </div>
                <div class="building-box-input">

                </div>
            </div>
            <button class="update-btn">更新する</button>
        </form>
    </div>
@endsection

