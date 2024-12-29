@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/games.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-games-form">
    <h1 class="games-form-title">Chỉnh sửa Trận đấu</h1>
    <form action="{{ route('games.update', $game->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group-games">
            <label for="tournament_id" class="games-form-label">Giải đấu</label>
            <select name="tournament_id" id="tournament_id" class="form-control-games">
                @foreach($tournaments as $tournament)
                    <option value="{{ $tournament->id }}" {{ $tournament->id == $game->tournament_id ? 'selected' : '' }}>
                        {{ $tournament->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group-games">
            <label for="team1_id" class="games-form-label">Đội 1</label>
            <select name="team1_id" id="team1_id" class="form-control-games">
                @foreach($teams as $team)
                    <option value="{{ $team->id }}" {{ $team->id == $game->team1_id ? 'selected' : '' }}>{{ $team->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group-games">
            <label for="team2_id" class="games-form-label">Đội 2</label>
            <select name="team2_id" id="team2_id" class="form-control-games">
                @foreach($teams as $team)
                    <option value="{{ $team->id }}" {{ $team->id == $game->team2_id ? 'selected' : '' }}>{{ $team->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group-games">
            <label for="match_date" class="games-form-label">Ngày giờ</label>
            <input type="datetime-local" name="match_date" id="match_date" class="form-control-games"
                value="{{ \Carbon\Carbon::parse($game->match_date)->format('Y-m-d\TH:i') }}">
        </div>
        <div class="form-group-games">
            <label for="location" class="games-form-label">Địa điểm</label>
            <input type="text" name="location" id="location" class="form-control-games" value="{{ $game->location }}">
        </div>
        <button type="submit" class="btn-submit">Cập nhật trận đấu</button>
    </form>
</div>
@endsection
