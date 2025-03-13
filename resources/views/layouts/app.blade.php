<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Giải Đấu - CHAMPIONHUB</title>
    <link rel="stylesheet" href="{{ asset('./css/app.css') }}">
    <script src="https://kit.fontawesome.com/c991f90e06.js" crossorigin="anonymous"></script>
    @yield('styles')
</head>

<body class="body">
    <header class="header">
        <nav class="navbar">
            <a href="/" class="navbar-logo">
                <img src="{{ asset('images/logoWA.svg') }}" alt="Logo" id="logo">
            </a>
            <ul class="navbar-menu">
                <li class="navbar-item">
                    <a href="/" class="navbar-link">Trang chủ</a>
                </li>
                <li class="navbar-item">
                    <a href="{{ route('public.teams.index')}}" class="navbar-link">Danh sách đội bóng</a>
                </li>
                <li class="navbar-item">
                    <a href="{{ route('stadiums.index') }}" class="navbar-link">Sân bóng</a>
                </li>
                <li class="navbar-item">
                    <a href="" class="navbar-link">Tin tức</a>
                </li>

                @if(auth()->check())
                    <li class="navbar-item">
                        <a href="{{ route('tournament.index') }}" class="navbar-link">Giải đấu</a>
                    </li>
                    <li class="navbar-item">
                        <a href="{{ route('team.index') }}" class="navbar-link">Đội bóng</a>
                    </li>
                    <li class="navbar-item">
                        <a href="{{ route('user.index') }}" class="navbar-link">{{ auth()->user()->name }}</a>
                    </li>
                    <li class="navbar-item">
                        <a href="#" class="navbar-link"><i class="fa-solid fa-bell"></i></a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <!-- Hiển thị Đăng nhập và Đăng ký nếu chưa đăng nhập -->
                    <li class="navbar-item">
                        <a href="{{ route('login') }}" class="navbar-link">Đăng nhập</a>
                    </li>
                @endif
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