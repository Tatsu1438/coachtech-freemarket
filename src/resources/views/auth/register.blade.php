@extends('layouts.login_layout')

@section('css')
    <link rel="stylesheet" href="{{ asset( 'css/register.css' )}}">
@endsection

@section('content')
    <div class="register">
        <div class="register-box">
            <h2>会員登録</h2>
            <form method="POST" action="/register">
                @csrf
                <div class="name-form">
                    <div class="name-form-name">
                        <label for="name">ユーザー名</label>
                    </div>
                    <div class="name-form-input">
                        <input type="text" id="name" name="name">
                    </div>
                    @error('name')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
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
                <div class="confirm-form">
                    <div class="confirm-form-name">
                        <label for="password_confirmation">確認用パスワード</label>
                    </div>
                    <div class="confirm-form-input">
                        <input type="password" id="password_confirmation" name="password_confirmation">
                    </div>
                    @if ($errors->has('password'))
                        <p class="error">{{ $errors->first('password') }}</p>
                    @endif
                </div>
                <div class="register-submit">
                    <button type="submit" id="btn">登録する</button>
                </div>
                <div class="login-btn-box">
                    <a href="/login" class="login-btn">ログインはこちら</a>
                </div>
            </form>
        </div>
    </div>
@endsection