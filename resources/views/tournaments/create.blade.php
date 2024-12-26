@extends('layouts.app')
@section('styles')
<link href="{{ asset('css/qlygiaidau.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container create-tournament">
    <h1 class="page-title">Tạo mới giải đấu</h1>

    <form action="{{ route('tournament.store') }}" method="POST" class="tournament-form">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Tên giải đấu:</label>
            <input type="text" name="name" id="name" class="form-input" required>
        </div>

        <div class="form-group">
            <label for="start_date" class="form-label">Ngày bắt đầu:</label>
            <input type="date" name="start_date" id="start_date" class="form-input" required>
        </div>

        <div class="form-group">
            <label for="end_date" class="form-label">Ngày kết thúc:</label>
            <input type="date" name="end_date" id="end_date" class="form-input" required>
        </div>

        <button type="submit" class="btn-submit">Lưu</button>
    </form>

</div>
@endsection