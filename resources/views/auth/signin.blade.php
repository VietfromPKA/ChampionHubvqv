@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrapper">
    <h2>Đăng Ký</h2>
    <form action="{{ route('signin') }}" method="post">
        @csrf
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
        <button type="submit">Đăng ký</button>
    </form>
</div>
@endsection