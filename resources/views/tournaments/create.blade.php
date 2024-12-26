@extends('layouts.app')
@section('styles')
    <link href="{{ asset('css/qlygiaidau.css') }}" rel="stylesheet">
@endsection

@section('content')
    <h1>Tạo mới giải đấu</h1>

    <form action="{{ route('tournament.store') }}" method="POST">
        @csrf
        <label for="name">Tên giải đấu:</label>
        <input type="text" name="name" id="name" required>

        <label for="start_date">Ngày bắt đầu:</label>
        <input type="date" name="start_date" id="start_date" required>

        <label for="end_date">Ngày kết thúc:</label>
        <input type="date" name="end_date" id="end_date" required>

        <button type="submit">Lưu</button>
    </form>
@endsection
