<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực Email - ChampionHub</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        .email-header h1 {
            color: #333333;
            font-size: 24px;
            margin: 0;
        }
        .email-body {
            padding: 20px 0;
            color: #555555;
            line-height: 1.6;
        }
        .email-body a {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff !important;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .email-body a:hover {
            background-color: #0056b3;
        }
        .email-footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #777777;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Chào mừng bạn đến với ChampionHub!</h1>
        </div>
        <div class="email-body">
            <p>Xin chào <strong>{{ $user->name }}</strong>,</p>
            <p>Cảm ơn bạn đã đăng ký tài khoản tại ChampionHub! Để hoàn tất quá trình đăng ký, vui lòng xác thực email của bạn bằng cách nhấp vào liên kết dưới đây:</p>
            <p>
                <a href="{{ route('verifyEmail', $user->verification_token) }}">
                    Nhấn vào đây để xác thực email
                </a>
            </p>
            <p>Nếu bạn không thực hiện đăng ký này, vui lòng bỏ qua email này.</p>
        </div>
        <div class="email-footer">
            <p>Trân trọng,</p>
            <p>Đội ngũ ChampionHub</p>
        </div>
    </div>
</body>
</html>