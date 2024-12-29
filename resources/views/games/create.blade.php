@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/games.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-games-form">
    <h1 class="games-form-title">Tạo Trận đấu Mới</h1>
    <form action="{{ route('games.store') }}" method="POST">
        @csrf
        <div class="form-group-games">
            <label for="tournament_id" class="games-form-label">Giải đấu</label>
            <select name="tournament_id" id="tournament_id" class="form-control-games">
                @foreach($tournaments as $tournament)
                    <option value="{{ $tournament->id }}">{{ $tournament->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group-games">
            <label for="team1_id" class="games-form-label">Đội 1</label>
            <select name="team1_id" id="team1_id" class="form-control-games">
                @foreach($teams as $team)
                    <option value="{{ $team->id }}" data-tournament="{{ $team->tournament_id }}">{{ $team->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group-games">
            <label for="team2_id" class="games-form-label">Đội 2</label>
            <select name="team2_id" id="team2_id" class="form-control-games">
                @foreach($teams as $team)
                    <option value="{{ $team->id }}" data-tournament="{{ $team->tournament_id }}">{{ $team->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group-games">
            <label for="match_date" class="games-form-label">Ngày giờ</label>
            <input type="datetime-local" name="match_date" id="match_date" class="form-control-games">
        </div>

        <div class="form-group-games">
            <label for="location" class="games-form-label">Địa điểm</label>
            <input type="text" name="location" id="location" class="form-control-games" required>
        </div>

        <button type="submit" class="btn-submit">Tạo trận đấu</button>
    </form>
</div>
@endsection
