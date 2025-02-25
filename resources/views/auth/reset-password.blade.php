@extends('layouts.app')
@section('styles')
    <link href="{{ asset('css/password.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="wrapper">
        <h2>Đặt Lại Mật Khẩu</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="post">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="input-field">
                <input type="email" name="email" required>
                <label>Email của bạn</label>
            </div>
            <div class="input-field">
                <input type="password" name="password" required>
                <label>Mật khẩu mới</label>
            </div>
            <div class="input-field">
                <input type="password" name="password_confirmation" required>
                <label>Xác nhận mật khẩu</label>
            </div>
            <button type="submit">Đặt Lại Mật Khẩu</button>
        </form>
    </div>
@endsection