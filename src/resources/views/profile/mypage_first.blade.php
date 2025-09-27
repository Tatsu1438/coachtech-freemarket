@extends('layouts.profile_layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage-firstlogin.css') }}">
@endsection

@section('content')
    <div class="fillout-box">
        <div class="title-box">
            <h2>プロフィール設定</h2>
        </div>
        <form action="{{ route('profile.first') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="logo-box">
                <div class="icon">

                </div>
                <label for="icon" class="file-label">画像を選択する</label>
                <input type="file" id="icon" name="icon" accept="image/*" hidden>
            </div>
            @error('icon')
                <p  style="color: red;" class="error">{{ $message }}</p>
            @enderror
            <div class="user-box">
                <div class="user-box-name">
                    <label for="name">ユーザー名</label>
                </div>
                <div class="user-box-input">
                    <input class="user-box-input" type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}">
                </div>
                @error('name')
                    <p  style="color: red;" class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="postal-box">
                <div class="postal-box-name">
                    <label for="">郵便番号</label>
                </div>
                <div class="postal-box-input">
                    <input class="postal-box-input" type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', auth()->user()->postal_code) }}">
                </div>
                @error('postal_code')
                    <p  style="color: red;" class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="address-box">
                <div class="address-box-name">
                    <label for="address">住所</label>
                </div>
                <div class="address-box-input">
                    <input class="address-box-input" type="text" id="address" name="address" value="{{ old('address', auth()->user()->address) }}">
                </div>
                @error('address')
                    <p  style="color: red;" class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="building-box">
                <div class="building-box-name">
                    <label for="">建物名</label>
                </div>
                <div class="building-box-input">
                    <input class="building-box-input" type="text" id="building" name="building" value="{{ old('building', auth()->user()->building) }}">
                </div>
            </div>
            <button class="update-btn">更新する</button>
        </form>
    </div>
@endsection

