@extends('layouts.items_layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/top-items.css') }}">
@endsection

@section('content')
    <div class="change-box">
        <div class="change-recommend">
            <button style=" color: red;" class="recommend-btn">おすすめ</button>
        </div>
        <div class="change-mylist">
            <a href="{{ route('items.top_mylist') }}">
                <button class="mylist-btn">マイリスト</button>
            </a>
        </div>
    </div>
    <div class="change-box-line"></div>

    <div class="item-box">
        <div class="item-box-1">
            @foreach ($items1 as $index => $item)
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
            @foreach ($items2 as $index => $item)
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


