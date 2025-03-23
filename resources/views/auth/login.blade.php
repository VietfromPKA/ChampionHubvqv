@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrapper">
    <h2>Đăng Nhập</h2>
    
    <!-- Hiển thị thông báo lỗi -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('login') }}" method="post">
        @csrf
        <div class="input-field">
            <input type="email" name="email" required>
            <label>Email của bạn</label>
        </div>
        <div class="input-field">
            <input type="password" name="password" required>
            <label>Mật khẩu</label>
        </div>
        <button type="submit">Đăng nhập</button>
        <!-- Liên kết "Quên mật khẩu" -->
        <div class="forgot-password">
            <a href="{{ route('password.forgot') }}">Quên mật khẩu?</a>
        </div>
        <!-- Liên kết "Đăng ký" -->
        <div class="register">
            <p>Bạn chưa có tài khoản? <a href="{{ route('signin') }}" style="color: red;">Đăng ký</a></p>
        </div>
    </form>
</div>
@endsection