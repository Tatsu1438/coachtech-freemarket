@extends('layouts.items_layout')

@section('css')
    <link rel="stylesheet" href="{{ asset( 'css/sell.css' )}}">
@endsection

@section('content')
    <div class="sell">
        <div class="sell-box">
            <h2>商品の出品</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="item-img">
                    <div class="item-img-name">
                        <label for="img">商品画像</label>
                    </div>
                    <div class="item-img-input">
                        <input type="file" id="img" name="img" accept="image/*" hidden>
                        <label for="img" class="file-label">画像を選択する</label>

                        <img id="preview-img" src="" alt="プレビュー" style="display:none;">

                        <script>
                            document.getElementById('img').addEventListener('change', function() {
                                const file = this.files[0];

                                // プレビュー表示
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
                <div class="category-condition">
                    <div class="category-condition-title">
                        <h3>商品の詳細</h3>
                    </div>
                    <div class="category-line"></div>
                    <div class="category-name">
                        <label for="category">カテゴリー</label>
                    </div>
                    <div class="category-input">
                        <input type="radio" id="cat-fashion" name="category" value="fashion">
                        <label for="cat-fashion" class="radio-label">ファッション</label>

                        <input type="radio" id="cat-appliances" name="category" value="appliances">
                        <label for="cat-appliances" class="radio-label">家電</label>

                        <input type="radio" id="cat-interior" name="category" value="interior">
                        <label for="cat-interior" class="radio-label">インテリア</label>

                        <input type="radio" id="cat-female" name="category" value="female">
                        <label for="cat-female" class="radio-label">レディース</label>

                        <input type="radio" id="cat-mens" name="category" value="mens">
                        <label for="cat-mens" class="radio-label">メンズ</label>

                        <input type="radio" id="cat-cosmetic" name="category" value="cosmetic">
                        <label for="cat-cosmetic" class="radio-label">コスメ</label>

                        <input type="radio" id="cat-books" name="category" value="books">
                        <label for="cat-books" class="radio-label">本</label>

                        <input type="radio" id="cat-game" name="category" value="game">
                        <label for="cat-game" class="radio-label">ゲーム</label>

                        <input type="radio" id="cat-sports" name="category" value="sports">
                        <label for="cat-sports" class="radio-label">スポーツ</label>

                        <input type="radio" id="cat-kitchen" name="category" value="kitchen">
                        <label for="cat-kitchen" class="radio-label">キッチン</label>

                        <input type="radio" id="cat-handmade" name="category" value="handmade">
                        <label for="cat-handmade" class="radio-label">ハンドメイド</label>

                        <input type="radio" id="cat-accessory" name="category" value="accessory">
                        <label for="cat-accessory" class="radio-label">アクセサリー</label>

                        <input type="radio" id="cat-toys" name="category" value="toys">
                        <label for="cat-toys" class="radio-label">おもちゃ</label>

                        <input type="radio" id="cat-baby-kids" name="category" value="baby-kids">
                        <label for="cat-baby-kids" class="radio-label">ベビー・キッズ</label>
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
                        <input type="text" id="item-name" name="item-name">
                    </div>
                    <div class="item-brand-name">
                        <label for="brand">ブランド名</label>
                    </div>
                    <div class="item-brand-input">
                        <input type="text" id="brand" name="brand">
                    </div>
                    <div class="item-text-name">
                        <label for="detail">商品の説明</label>
                    </div>
                    <div class="item-text-input">
                        <textarea id="detail" name="detail" rows="4" cols="40"></textarea>
                    </div>
                    <div class="item-price-name">
                        <label for="price">販売価格</label>
                    </div>
                    <div class="item-price-input">
                        <input type="number" id="price" name="price" min="0" placeholder="¥">
                </div>


                <div class="sell-submit">
                    <button type="submit" id="btn">出品する</button>
                </div>
            </form>
        </div>
    </div>
@endsection
