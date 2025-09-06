@extends('layouts.items_layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item_detail.css') }}">
@endsection

@section('content')
    <div class="item-detail-box">
        <div class="item-detail-img">
            <img src="{{ asset('storage/images/'. basename($item->img_url)) }}" alt="{{ $item->name }}" class="item-image">
        </div>
        <div class="item-detail">
            <div class="item-detail-group1">
                <h2 class="item-name">{{ $item->name }}</h2>
                <p class="item-brand">{{ $item->brand}}</p>
                <p class="item-price">価格: ¥{{ number_format($item->price ?? 0) }}(税込)</p>
                <div class="production-action">
                    <div class="product-good">
                        <form action="{{ route('favorites.toggle', $item->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="favorite-btn">
                                <img src="{{ asset('storage/images/' . (auth()->check() && auth()->user()->favorites->contains($item->id) ? 'color-star.png' : 'star.png')) }}" alt="いいね">
                            </button>
                        </form>
                        <p class="count">{{ $item->favorited_by_users_count }}</p>
                    </div>
                    <div class="product-comment">
                        <button class="comment-btn">
                            <img src="{{ asset('storage/images/comment.png') }}" alt="コメント">
                        </button>
                        <p class="count">{{ $item->comments_count ?? 0 }}</p>
                    </div>
                </div>
                <div class="buy-btn-box">
                    <form action="{{ route('items.purchase', $item->id) }}" method="GET">
                        @csrf
                        <button type="submit" class="buy-btn">購入手続きへ</button>
                    </form>
                </div>
                <div>
                    <h3 class="item-description-title">商品説明</h3>
                    <p class="item-description-content">{!! nl2br(e($item->description)) !!}</p>
                </div>
                <div class="item-detail-title">
                    <h3>商品の情報</h3>
                </div>
                <div class="item-info">
                    <div class="item-info-category">
                        <strong>カテゴリー：</strong>
                        <p class="item-category">
                            @foreach($item->categories as $category)
                            <span>{{ $category->name }}</span>
                            @endforeach
                        </p>
                    </div>
                    <div class="item-info-condition">
                        <strong>商品の状態：</strong>
                        <p class="item-condition">{{ $item->condition }}</p>
                    </div>
                </div>
                <div class="comment-area">
                    <div class="comment-title">
                        <span>コメント</span><p class="count">（{{ $item->comments_count ?? 0 }}）</p>
                    </div>
                    <div class="all-comments">
                        <div class="comment-id-icon">

                        </div>
                        <div class="comment-content">
                            
                        </div>
                    </div>
                    <div class="comment-text">
                        <h3 class="comment-text-title">商品へのコメント</h3>
                        <form action="{{ route('comments.store', $item->id) }}" method="POST">
                            @csrf
                            <textarea name="comment" id="comment"></textarea>
                            <div class="comment-submit">
                                <button type="submit" class="comment-submit-btn">コメントを送信する</button>
                            </div>
                        </form>
                    </div>
                    

                </div>
            </div>

        </div>
    </div>
@endsection