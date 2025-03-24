@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/form_db.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection

@section('content')
    <div class="container">
        <h1 class="page-title">{{ isset($player) ? 'Chỉnh sửa thông tin cầu thủ' : 'Thêm cầu thủ vào đội' }}</h1>
        <h1><i class="fas fa-trophy"></i>{{ $team->name }}<i class="fas fa-futbol"></i></h1>

        <form action="{{ isset($player) ? route('players.update', [$team->id, $player->id]) : route('players.store', $team->id) }}" method="POST">
            @csrf
            @if (isset($player))
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="name">Tên cầu thủ:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ isset($player) ? $player->name : old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="age">Tuổi:</label>
                <input type="number" id="age" name="age" class="form-control" value="{{ isset($player) ? $player->age : old('age') }}">
            </div>
            <div class="form-group">
                <label for="position">Vị trí:</label>
                <input type="text" id="position" name="position" class="form-control" value="{{ isset($player) ? $player->position : old('position') }}">
            </div>
            <div class="form-group">
                <label for="jersey_number">Số áo:</label>
                <input type="number" id="jersey_number" name="jersey_number" class="form-control" value="{{ isset($player) ? $player->jersey_number : old('jersey_number') }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ isset($player) ? $player->email : old('email') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">{{ isset($player) ? 'Cập nhật' : 'Thêm' }}</button>
        </form>
    </div>
@endsection