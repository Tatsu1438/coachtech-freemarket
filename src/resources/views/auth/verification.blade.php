@extends('layouts.login_layout')

@section('css')
    <link rel="stylesheet" href="{{ asset( 'css/verification.css' )}}">
@endsection

@section('content')
    <div class="verification-box">
        <div>
            <div class="word">
            <p>登録していただいたメールアドレスに認証メールを送付しました</p>
            <p>メール認証を完了してください</p>
            </div>

            <div class="verification-btn-box">
                <a class="verification-btn" href="http://localhost:8026">
                    認証はこちらから
                </a>
            </div>

            <div class="verification-resend">
                <a class="verification-resend-btn" href="{{ route('verification.send') }}"
                onclick="event.preventDefault(); document.getElementById('resend-form').submit();">
                認証メールを再送する
                </a>

                <form id="resend-form" method="POST" action="{{ route('verification.send') }}" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
@endsection