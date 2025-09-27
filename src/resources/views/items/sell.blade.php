@extends('layouts.items_layout')

@section('css')
    <link rel="stylesheet" href="{{ asset( 'css/sell.css' )}}">
@endsection

@section('content')
    <div class="sell">
        <div class="sell-box">
            <h2>商品の出品</h2>
            <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="item-img">
                    <div class="item-img-name">
                        <label for="img">商品画像</label>
                    </div>
                    <div class="item-img-input">
                        <input type="file" id="img" name="img_url" style="display: none;" >
                        <label for="img" class="file-label">画像を選択する</label>

                        <img id="preview-img" src="" alt="プレビュー" style="display:none;">

                        <script>
                            document.getElementById('img').addEventListener('change', function() {
                                const file = this.files[0];

                                if (file && file.type.startsWith('image/')) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        const previewImg = document.getElementById('preview-img');
                                        previewImg.src = e.target.result;
                                        previewImg.style.display = "block";
                                    };
                                    reader.readAsDataURL(file);
                                } else {
                                    document.getElementById('preview-img').style.display = "none";
                                }
                            });
                        </script>
                    </div>
                </div>
                <div class="image-error">
                    @error('img_url')
                        <p  style="color: red;" class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="category-condition">
                    <div class="category-condition-title">
                        <h3>商品の詳細</h3>
                    </div>
                    <div class="category-line"></div>
                    <div class="category-name">
                        <label for="category">カテゴリー</label>
                    </div>

                    <div class="category-input">
                        <input type="checkbox" id="cat-fashion" name="category[]" value="ファッション">
                        <label for="cat-fashion"  class="radio-label">ファッション</label>

                        <input type="checkbox" id="cat-appliances" name="category[]" value="家電">
                        <label for="cat-appliances" class="radio-label">家電</label>

                        <input type="checkbox" id="cat-interior" name="category[]" value="インテリア">
                        <label for="cat-interior" class="radio-label">インテリア</label>

                        <input type="checkbox" id="cat-female" name="category[]" value="レデイース">
                        <label for="cat-female" class="radio-label">レディース</label>

                        <input type="checkbox" id="cat-mens" name="category[]" value="メンズ">
                        <label for="cat-mens" class="radio-label">メンズ</label>

                        <input type="checkbox" id="cat-cosmetic" name="category[]" value="コスメ">
                        <label for="cat-cosmetic" class="radio-label">コスメ</label>

                        <input type="checkbox" id="cat-books" name="category[]" value="本">
                        <label for="cat-books" class="radio-label">本</label>

                        <input type="checkbox" id="cat-game" name="category[]" value="ゲーム">
                        <label for="cat-game" class="radio-label">ゲーム</label>

                        <input type="checkbox" id="cat-sports" name="category[]" value="スポーツ">
                        <label for="cat-sports" class="radio-label">スポーツ</label>

                        <input type="checkbox" id="cat-kitchen" name="category[]" value="キッチン">
                        <label for="cat-kitchen" class="radio-label">キッチン</label>

                        <input type="checkbox" id="cat-handmade" name="category[]" value="ハンドメイド">
                        <label for="cat-handmade" class="radio-label">ハンドメイド</label>

                        <input type="checkbox" id="cat-accessory" name="category[]" value="アクセサリー">
                        <label for="cat-accessory" class="radio-label">アクセサリー</label>

                        <input type="checkbox" id="cat-toys" name="category[]" value="おもちゃ">
                        <label for="cat-toys" class="radio-label">おもちゃ</label>

                        <input type="checkbox" id="cat-baby-kids" name="category[]" value="ベビー・キッズ">
                        <label for="cat-baby-kids" class="radio-label">ベビー・キッズ</label>

                    </div>
                    <div class="category-error">
                        @error('category')
                            <p  style="color: red;" class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="condition-name">
                        <label for="condition">商品の状態</label>
                    </div>
                    <div class="condition-input">
                        <select name="condition" id="condition">
                            <option value="">選択してください</option>
                            <option value="new">新品・未使用</option>
                            <option value="like_new">未使用に近い</option>
                            <option value="good">目立った傷や汚れなし</option>
                            <option value="fair">やや傷や汚れあり</option>
                            <option value="poor">全体的に状態が悪い</option>
                        </select>
                        <div class="condition-error">
                            @error('condition')
                                <p  style="color: red;" class="error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="item-detail">
                    <div class="item-detail-title">
                        <h3>商品名と説明</h3>
                    </div>
                    <div class="item-detail-line"></div>
                    <div></div>
                    <div class="item-detail-name">
                        <label for="item-name">商品名</label>
                    </div>
                    <div class="item-detail-input">
                        <input type="text" id="item-name" name="product_name">
                        <div class="product-error">
                            @error('product_name')
                                <p  style="color: red;" class="error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="item-brand-name">
                        <label for="brand">ブランド名</label>
                    </div>
                    <div class="item-brand-input">
                        <input type="text" id="brand" name="brand">
                        <div>
                            @error('brand')
                                <p  style="color: red;" class="error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="item-text-name">
                        <label for="detail">商品の説明</label>
                    </div>
                    <div class="item-text-input">
                        <textarea id="detail" name="description" rows="4" cols="40"></textarea>
                        <div class="description-error">
                            @error('description')
                                <p  style="color: red;" class="error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="item-price-name">
                        <label for="price">販売価格</label>
                    </div>
                    <div class="item-price-input">
                        <input type="number" id="price" name="price" min="0" placeholder="¥">
                        <div class="price-error">
                            @error('price')
                                <p  style="color: red;" class="error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="sell-submit">
                    <button type="submit" id="btn">出品する</button>
                </div>
            </form>
        </div>
    </div>
@endsection
