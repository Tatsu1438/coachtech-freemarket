@extends('layouts.items_layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/top-items.css') }}">
@endsection

@section('content')
    <div class="change-box">
        <div class="change-recommend">
            <a href="{{ route('items.top') }}">
                <button class="recommend-btn">おすすめ</button>
            </a>
        </div>
        <div class="change-mylist">
            <button  style=" color: red;" class="mylist-btn">マイリスト</button>
        </div>
    </div>
    <div class="change-box-line"></div>

    <div class="item-box">
        <div class="item-box-1">
            @foreach ($products as $index => $item)
            <a href="{{ route('items.detail', $item->id) }}" class="item-card-link">
                <div class="item-card">
                    <div class="item-card-img">
                        <img src="{{ asset('storage/images/'. basename($item->img_url)) }}" alt="{{ $item->name }}" class="item-image">
                    </div>
                    <div class="item-card-name">
                        <p class="item-name">{{ $item->name }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    <div class="item-box-margin"></div>
    <div class="item-box">
        <div class="item-box-2">
            @foreach ($products as $index => $item)
            <a href="{{ route('items.detail', $item->id) }}" class="item-card-link">
                <div class="item-card">
                    <div class="item-card-img">
                        <img src="{{ asset('storage/images/'. basename($item->img_url)) }}" alt="{{ $item->name }}" class="item-image">
                    </div>
                    <div class="item-card-name">
                        <p class="item-name">{{ $item->name }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>


@endsection


