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
            <button class="sold-btn" onclick="location.href='{{ route('profile.sold') }}'">出品した商品</button>
        </div>
        <div class="change-bought">
            <button style=" color: red;" class="bought-btn">購入した商品</button>
        </div>
    </div>
    <div class="change-box-line"></div>

    <div class="item-box">
        <div class="item-box-1">
            <div class="card-box">
                @foreach ($purchases->slice(0, 4) as $index => $purchase)
                    <div class="item-card">
                        <div class="item-card-img">
                            <img src="{{ asset($purchase->product && $purchase->product->img_url ? str_replace('storage/app/public/', 'storage/', $purchase->product->img_url) : 'images/default.jpg') }}" alt="アイテム{{ $index + 1 }}" class="item-image">
                        </div>
                        <div class="item-card-name">
                            <p class="item-name">{{ $purchase->product ? $purchase->product->product_name : '商品名なし' }}</p>
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
                @foreach ($purchases->slice(4, 4) as $index => $purchase)
                    <div class="item-card">
                        <div class="item-card-img">
                            <img src="{{ asset($purchase->product && $purchase->product->img_url ? str_replace('storage/app/public/', 'storage/', $purchase->product->img_url) : 'images/default.jpg') }}" 
                                alt="アイテム{{ $index + 5 }}" 
                                class="item-image">
                        </div>
                        <div class="item-card-name">
                            <p class="item-name">{{ $purchase->product ? $purchase->product->product_name : '商品名なし' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="pagination">
        {{ $purchases->links() }}
    </div>

@endsection