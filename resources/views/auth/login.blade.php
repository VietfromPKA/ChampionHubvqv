@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrapper">
    <h2>Đăng Nhập</h2>
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
        <div class="register">
            <p>Bạn chưa có tài khoản? <a href="{{ route('signin') }}" style="color: red;">Đăng ký</a></p>
        </div>
    </form>
</div>
@endsection