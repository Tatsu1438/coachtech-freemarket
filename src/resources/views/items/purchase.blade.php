@extends('layouts.items_layout')

@section('css')
    <link rel="stylesheet" href="{{ asset( 'css/purchase.css')}}">
@endsection

@section('content')
    <div class="purchase-confirm">
        <form class="form" action="{{ route('purchase.store', ['item' => $item->id]) }}" method="post">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <input type="hidden" name="price" value="{{ $item->price }}">
            <input type="hidden" name="postal_code" value="{{ $user->postal_code }}">
            <input type="hidden" name="address" value="{{ $user->address }}">
            <input type="hidden" name="building" value="{{ $user->building }}">
            <div class="purchase-confirm-group1">
                <div class="item-info-box">
                    <div class="item-info-img">
                        <img src="{{ asset('storage/images/'. basename($item->img_url)) }}" alt="{{ $item->name }}" class="item-image">
                    </div>
                    <div class="item-info-name-price">
                        <p class="item-name">{{ $item->product_name }}</p>
                        <p class="item-price"> ¥{{ number_format($item->price ?? 0) }}</p>
                    </div>
                </div>
                <div class="line1"></div>
                <div class="pay-method">
                    <div class="pay-method-box">
                        <p class="pay-method-label">支払い方法</p>
                        <div class="pay-method-input-box">
                            <select  id="paymentSelect" class="pay-method-input" name="payment_method" required>
                                <option value="" selected disabled>選択してください</option>
                                <option value="コンビニ払い">コンビニ払い</option>
                                <option value="クレジットカード払い">クレジットカード払い</option>
                            </select>
                        </div>
                        @error('payment_method')
                            <p  style="color: red;" class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="pay-method-margin">
                    </div>
                </div>
                <div class="line1"></div>
                <div class="address-area">
                    <div class="address-title">
                        <div class="address-title-label">
                            <p>配送先</p>
                        </div>
                        <div class="address-change">
                            <a href="{{ route('address.edit', ['item_id' => $item->id]) }}">変更する</a>
                        </div>
                    </div>
                    <div class="user-address-box">
                        <div class="user-address-postal">
                            <p>〒{{ $user->postal_code ?? '' }}</p>
                        </div>
                        @error('postal_code')
                            <p  style="color: red;" class="error">{{ $message }}</p>
                        @enderror
                        <div class="user-address">
                            <p>{{ $user->address ?? '' }}</p>
                        </div>
                        <div class="user-address-building">
                            <p>{{ $user->building ?? '' }}</p>
                        </div>
                        @error('address')
                            <p  style="color: red;" class="error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="line2"></div>
            </div>
            <div class="purchase-confirm-group2">
                <div class="purchase-confirm1">
                    <div class="purchase-confirm-brock1">
                        <div class="item-price2">
                            <p>商品代金</p>
                        </div>
                        <div class="item-price-box">
                            <p class="item-price">¥{{ number_format($item->price ?? 0) }}</p>
                        </div>
                    </div>
                    <div class="confirm-line"></div>
                    <div class="purchase-confirm2">
                        <div class="purchase-confirm-brock2">
                            <p>支払い方法</p>
                        </div>
                        <div>
                            <p id="selectedPayment"></p>
                        </div>
                    </div>
                </div>
                <div class="purchase-submit">
                    <button type="submit" class="purchase-submit-btn">購入する</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    document.getElementById('paymentSelect').addEventListener('change', function() {
        const selected = this.value;
        document.getElementById('selectedPayment').textContent = selected;
    });
</script>
@endsection