@extends('layouts.app')
@section('styles')
    <link href="{{ asset('css/qlygiaidau.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <h1>Sửa giải đấu</h1>

        <form action="{{ route('tournament.update', $tournament->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="name">Tên giải đấu:</label>
            <input type="text" name="name" id="name" value="{{ $tournament->name }}" required>

            <label for="start_date">Ngày bắt đầu:</label>
            <input type="date" name="start_date" id="start_date" value="{{ $tournament->start_date }}" required>

            <label for="end_date">Ngày kết thúc:</label>
            <input type="date" name="end_date" id="end_date" value="{{ $tournament->end_date }}" required>

            <button type="submit">Cập nhật</button>
        </form>
    </div>
@endsection
