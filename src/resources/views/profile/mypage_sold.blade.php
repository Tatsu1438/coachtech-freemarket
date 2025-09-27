@extends('layouts.profile_layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="user-name-area">
        <div class="user-name-box">
            <div class="icon">
                @if(auth()->user()->icon)
                    <img class="user-icon" src="{{ Storage::url(auth()->user()->icon) }}" alt="{{ auth()->user()->name }}">
                @endif
            </div>
            <div class="user-name">
                {{ auth()->user()->name }}
            </div>
            <div class="user-edit">
                <button class="user-edit-btn" onclick="location.href='{{ route('profile.edit') }}'">プロフィールを編集する</button>
            </div>
        </div>
    </div>


    <div class="change-box">
        <div class="change-sold">
            <button style=" color: red;" class="sold-btn">出品した商品</button>
        </div>
        <div class="change-bought">
            <button class="bought-btn" onclick="location.href='{{ route('profile.bought') }}'">購入した商品</button>
        </div>
    </div>
    <div class="change-box-line"></div>

    <div class="item-box">
        <div class="item-box-1">
            <div class="card-box">
                @foreach ($products->slice(0, 4) as $product)
                    <a href="{{ route('items.detail', $product->id) }}" class="item-card-link">
                    <div class="item-card">
                        <div class="item-card-img">
                            <img src="{{ asset('storage/'.$product->img_url) }}" alt="{{ $product->product_name }}" class="item-image">
                        </div>
                        <div class="item-card-name">
                            <p class="item-name">{{ $product->product_name }}</p>
                            @if($product->purchases->isNotEmpty())
                                <span class="sold">SOLD</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="item-box-margin"></div>
    <div class="item-box">
        <div class="item-box-2">
            <div class="card-box">
                @foreach ($products->slice(4, 4) as $product)
                    <a href="{{ route('items.detail', $product->id) }}" class="item-card-link">
                    <div class="item-card">
                        <div class="item-card-img">
                            <img src="{{ asset('storage/'.$product->img_url) }}" alt="{{ $product->product_name }}" class="item-image">
                        </div>
                        <div class="item-card-name">
                            <p class="item-name">{{ $product->product_name }}
                            </p>
                            @if($product->purchases->isNotEmpty())
                                <span class="sold">SOLD</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="pagination">
        {{ $products->links() }}
    </div>
@endsection