@extends('layouts.profile_layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="user-name-area">
        <div class="user-name-box">
            <div class="user-icon"></div>
            <div class="user-name"></div>
            <div class="user-edit">
                <button onclick="location.href='{{ route('profile.edit') }}'">プロフィールを編集する</button>
            </div>
        </div>
    </div>


    <div class="change-box">
        <div class="change-sold">
            <button class="sold-btn" onclick="location.href='{{ route('profile.sold') }}'">出品した商品</button>
        </div>
        <div class="change-bought">
            <button style=" color: red;" class="bought-btn">購入した商品</button>
        </div>
    </div>
    <div class="change-box-line"></div>

    <div class="item-box">
        <div class="item-box-1">
            @php
                $items1 = [
                    'Armani+Mens+Clock.jpg',
                    'HDD+Hard+Disk.jpg',
                    'Leather+Shoes+Product+Photo.jpg',
                    'Living+Room+Laptop.jpg'
                ];
            @endphp
            @foreach ($items1 as $index => $item)
                <div class="item-card">
                    <div class="item-card-img">
                        <img src="{{ asset('storage/images/'.$item) }}" alt="アイテム{{ $index + 1 }}" class="item-image">
                    </div>
                    <div class="item-card-name">
                        <p class="item-name">Item {{ $index + 1 }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="item-box-margin"></div>
    <div class="item-box">
        <div class="item-box-2">
            @php
                $items2 = [
                    'Music+Mic+4632231.jpg',
                    'Purse+fashion+pocket.jpg',
                    'Tumbler+souvenir.jpg',
                    'Waitress+with+Coffee+Grinder.jpg'
                ];
            @endphp
            @foreach ($items2 as $index => $item)
                <div class="item-card">
                    <div class="item-card-img">
                        <img src="{{ asset('storage/images/'.$item) }}" alt="アイテム{{ $index + 5 }}" class="item-image">
                    </div>
                    <div class="item-card-name">
                        <p class="item-name">Item {{ $index + 5 }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection