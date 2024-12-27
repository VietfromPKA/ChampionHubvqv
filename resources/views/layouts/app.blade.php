<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Giải Đấu - CHAMPIONHUB</title>
    <link rel="stylesheet" href="{{ asset('./css/app.css') }}">
    @yield('styles')
</head>

<body class="body">
    <header class="header">
        <nav class="navbar">
            <a href="/" class="navbar-logo">
                <img src="{{ asset('images/logoWA.svg') }}" alt="Logo" id="logo">
            </a>
            <ul class="navbar-menu">
                <li class="navbar-item"><a href="/" class="navbar-link">Trang chủ</a></li>
                <li class="navbar-item"><a href="" class="navbar-link">Giải đang diễn ra</a></li>
                <li class="navbar-item"><a href="" class="navbar-link">Giải đang theo dõi</a></li>
                <li class="navbar-item"><a href="{{ route('tournament.index') }}" class="navbar-link">Quản lý Giải đấu</a></li>
                <li class="navbar-item"><a href="{{ route('team.index') }}" class="navbar-link">Quản lý Đội bóng</a></li>
                <li class="navbar-item"><a href="" class="navbar-link">Tin tức</a></li>
                <li class="navbar-item"><a href="{{ route('login') }}" class="navbar-link">Đăng nhập</a></li>
                <li class="navbar-item"><a href="{{ route('signin') }}" class="navbar-link">Đăng ký</a></li>
            </ul>
        </nav>
    </header>

    <main class="main">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2024 CHAMPIONHUB</p>
    </footer>
</body>

</html>
