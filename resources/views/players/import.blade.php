@extends('layouts.app')
@section('styles')
    <link href="{{ asset('css/player.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <h1>Thêm cầu thủ từ Excel</h1>

        <a href="https://docs.google.com/spreadsheets/d/1RXwa-seSVfOF6tjDxGRFkY3Oo9TVw4ZtrhK5NesjyEY/edit?usp=sharing" class="btn btn-info" target="_blank">Tải file mẫu</a>


        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('players.import', $team->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Chọn file Excel:</label>
                <input type="file" name="file" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Tải Dữ Liệu</button>
        </form>

        <a href="{{ route('players.index', $team->id) }}" class="btn btn-secondary">Quay lại danh sách</a>
    </div>
@endsection