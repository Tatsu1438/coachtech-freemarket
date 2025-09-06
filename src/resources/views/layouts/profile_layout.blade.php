<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtech-freemarket</title>
    <link rel="stylesheet" href="{{ asset('css/items_layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    @yield('css')
</head>
<body>
    <header>
        <div class="header_box">
            <div class="header-logobox">
                <div>
                    <img src="{{ asset('storage/images/logo.svg') }}" alt="ロゴ">
                </div>
            </div>
            <div class="search-box">
                <div class="search-input-box">
                    <input class="search-input" type="text" placeholder="なにをお探しですか？" >
                </div>
            </div>
            <div class="btn-box">
                <div class="logout-box">
                    @auth
                    <form method="POST" action="{{ route('logout') }}" >
                        @csrf
                        <button class="logout-btn">ログアウト</button>
                    </form>
                    @endauth

                    @guest
                    <button class="logout-btn">ログイン</button>
                    @endguest
                </div>
                <div class="mypage-btn-box">
                    <button class="mypage-btn" onclick="location.href='{{ route('profile.sold') }}'">マイページ</button>
                </div>
                <div class="sell-btn-box">
                    <button class="sell-btn" onclick="location.href='{{ route('items.sell') }}'">出品</button>
                </div>
            </div>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>