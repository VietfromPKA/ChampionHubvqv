<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Giải Đấu - CHAMPIONHUB</title>
    <link rel="icon" href="/images/logo.svg" type="image/svg">
    <link rel="stylesheet" href="{{ asset('./css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('./css/app.css') }}">
    <script src="https://kit.fontawesome.com/c991f90e06.js" crossorigin="anonymous"></script>
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
                <li><a href="">Đăng ký</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="wrapper">
            <h2>Đăng Nhập</h2>
            <form action="" method="post">
                <div class="input-field">
                    <input type="email" name="email" required>
                    <label>Email của bạn</label>
                </div>
                <div class="input-field">
                    <input type="password" name="password" required>
                    <label>Mật khẩu</label>
                </div>
                <div class="forget">
                    <label for="remember">
                        </label>
                    <a href="">Quên mật khẩu?</a>
                </div>
                <button type="submit">Đăng nhập</button>
                <div class="register">
                    <p>Bạn chưa có tài khoản? <a href="" style="color: red;">Đăng ký</a></p>
                </div>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 CHAMPIONHUB</p>
    </footer>
</body>

</html>