<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Giải Đấu - CHAMPIONHUB</title>
    <!-- Đảm bảo đường dẫn đúng tới file CSS -->
    <link rel="stylesheet" href="{{ asset('./css/app.css') }}">
</head>

<body>
    <header>
        <nav>
            <a href="/">
                <img src="{{ asset('images/logoWA.svg') }}" alt="Logo" id="logo">
            </a>
            <ul>
                <li><a href="">Trang chủ</a></li>
                <li><a href="">Giải đang diễn ra</a></li>
                <li><a href="">Giải đang theo dõi</a></li>
                <li><a href="">Quản lý Giải đấu</a></li>
                <li><a href="">Đội bóng</a></li>
                <li><a href="">Tin tức</a></li>
                <li><a href="{{ route('login')}}">Đăng nhập</a></li>
                <li><a href="{{ route('signin')}}">Đăng ký</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Đây là nơi nội dung của các view khác sẽ được chèn vào -->
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2024 CHAMPIONHUB</p>
    </footer>
</body>

</html>