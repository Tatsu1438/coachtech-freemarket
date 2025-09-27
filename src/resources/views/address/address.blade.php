@extends('layouts.items_layout')

@section('css')
    <link rel="stylesheet" href=" {{ asset('css/address.css') }} ">
@endsection

@section('content')
    <div class="address-form">
        <form action="{{ route('address.update', ['item_id' => $item->id]) }}" method="post">
            @csrf
            <div class="address-title">
                <h2>住所の変更</h2>
            </div>
            <div class="form-box">
                <div>
                    <label for="">郵便番号</label>
                </div>
                <div>
                    <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code ?? '') }}">
                </div>
                @error('postal_code')
                    <p  style="color: red;" class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-box">
                <div>
                    <label for="">住所</label>
                </div>
                <div>
                    <input type="text" name="address" value="{{ old('address', $user->address ?? '') }}">
                </div>
                @error('address')
                    <p  style="color: red;" class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-box">
                <div>
                    <label for="">建物名</label>
                </div>
                <div>
                    <input type="text" name="building" value="{{ old('building', $user->building ?? '') }}" >
                </div>
            </div>
            <div class="address-submit">
                <button class="address-submit-btn">更新する</button>
            </div>
        </form>
    </div>
@endsection