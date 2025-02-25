@extends('layouts.app')
@section('styles')
    <link href="{{ asset('css/password.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="wrapper">
        <h2>Quên Mật Khẩu</h2>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="post">
            @csrf
            <div class="input-field">
                <input type="email" name="email" required>
                <label>Email của bạn</label>
            </div>
            <button type="submit">Gửi Liên Kết Đặt Lại Mật Khẩu</button>
        </form>
    </div>
@endsection