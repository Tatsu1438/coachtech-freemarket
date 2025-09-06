<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtech-freemarket</title>
    <link rel="stylesheet" href="{{ asset('css/login_layout.css') }}">
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
            <div></div>
            <div></div>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>