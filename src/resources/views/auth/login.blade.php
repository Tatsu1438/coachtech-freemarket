@extends('layouts.login_layout')

@section('css')
    <link rel="stylesheet" href="{{ asset( 'css/login.css' )}}">
@endsection

@section('content')
    <div class="login">
        <div class="login-box">
            <h2>ログイン</h2>
            <form method="POST" action="/login">
                @csrf
                <div class="mail-form">
                    <div class="mail-form-name">
                        <label for="email">メールアドレス</label>
                    </div>
                    <div class="mail-form-input">
                        <input type="email" id="email" name="email">
                    </div>
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="pass-form">
                    <div class="pass-form-name">
                        <label for="password">パスワード</label>
                    </div>
                    <div class="pass-form-input">
                        <input type="password" id="password" name="password">
                    </div>
                    @error('password')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="login-submit">
                    <button type="submit" id="btn">ログインする</button>
                </div>
                <div class="register-btn-box">
                    <a href="/register" class="register-btn">会員登録はこちら</a>
                </div>
            </form>
        </div>
    </div>
@endsection