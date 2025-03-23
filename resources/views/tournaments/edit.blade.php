@extends('layouts.app')
@section('styles')
    <link href="{{ asset('css/create.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container edit-tournament">
        <h1 class="page-title">Sửa giải đấu</h1>

        <form action="{{ route('tournaments.update', $tournament->id) }}" method="POST" class="tournament-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name" class="form-label">Tên giải đấu:</label>
                <input type="text" name="name" id="name" class="form-input" value="{{ $tournament->name }}" required>
            </div>

            <div class="form-group">
                <label for="start_date" class="form-label">Ngày bắt đầu:</label>
                <input type="date" name="start_date" id="start_date" class="form-input"
                    value="{{ $tournament->start_date }}" required>
            </div>

            <div class="form-group">
                <label for="end_date" class="form-label">Ngày kết thúc:</label>
                <input type="date" name="end_date" id="end_date" class="form-input" value="{{ $tournament->end_date }}"
                    required>
            </div>

            <div class="btn">
                <a href="{{ route('tournaments.index') }}" class="back-link">Quay lại</a>
                <button type="submit" class="btn-submit">Cập nhật</button>
            </div>
        </form>

    </div>
@endsection