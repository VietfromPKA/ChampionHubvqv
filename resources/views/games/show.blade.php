<!-- resources/views/games/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Chi tiết Trận đấu</h1>
        <table class="table">
            <tr>
                <th>Giải đấu</th>
                <td>{{ $game->tournament->name }}</td>
            </tr>
            <tr>
                <th>Đội 1</th>
                <td>{{ $game->team1->name }}</td>
            </tr>
            <tr>
                <th>Đội 2</th>
                <td>{{ $game->team2->name }}</td>
            </tr>
            <tr>
                <th>Ngày giờ</th>
                <td>{{ $game->match_date }}</td>
            </tr>
            <tr>
                <th>Địa điểm</th>
                <td>{{ $game->location }}</td>
            </tr>
        </table>
        <a href="{{ route('games.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>
@endsection
