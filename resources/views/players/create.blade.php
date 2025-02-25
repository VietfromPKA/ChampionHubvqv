@extends('layouts.app')
@section('styles')
<link href="{{ asset('css/player.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container">
    <h1>Thêm cầu thủ vào đội: {{ $team->name }}</h1>

    <form action="{{ route('players.store', $team->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Tên cầu thủ:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="age">Tuổi:</label>
            <input type="number" id="age" name="age" class="form-control">
        </div>
        <div class="form-group">
            <label for="position">Vị trí:</label>
            <input type="text" id="position" name="position" class="form-control">
        </div>
        <div class="form-group">
            <label for="jersey_number">Số áo:</label>
            <input type="number" id="jersey_number" name="jersey_number" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Thêm</button>
    </form>
</div>
@endsection
