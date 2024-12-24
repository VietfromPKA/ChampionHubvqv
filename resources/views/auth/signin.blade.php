<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký - CHAMPIONHUB</title>
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
                <li><a href="{{ route('login') }}">Đăng nhập</a></li>
                <li><a href="">Đăng ký</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="wrapper">
            <h2>Đăng Ký</h2>
            <form action="" method="post">
                <div class="input-field">
                    <input type="text" name="name" required>
                    <label>Tên đầy đủ</label>
                </div>
                <div class="input-field">
                    <input type="email" name="email" required>
                    <label>Email của bạn</label>
                </div>
                <div class="input-field">
                    <input type="password" name="password" required>
                    <label>Mật khẩu</label>
                </div>
                <div class="input-field">
                    <input type="password" name="password_confirmation" required>
                    <label>Nhập lại mật khẩu</label>
                </div>
                <div class="agree">
                    <label for="terms">
                        <input type="checkbox" id="terms" name="terms" required>
                        Tôi đồng ý với <a href="">Điều khoản và Dịch vụ</a>
                    </label>
                </div>
                <button type="submit">Đăng ký</button>
                <div class="login">
                    <p>Đã có tài khoản? <a href="{{ route('login') }}" style="color: red;">Đăng nhập</a></p>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 CHAMPIONHUB</p>
    </footer>
</body>

</html>