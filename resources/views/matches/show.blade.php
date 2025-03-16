@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Chi tiết lịch thi đấu</h2>
    <table class="table">
        <tr>
            <th>Giải đấu:</th>
            <td>{{ $match->tournament->name ?? 'Trận cá nhân' }}</td>
        </tr>
        <tr>
            <th>Đội 1:</th>
            <td>{{ $match->team1->name }}</td>
        </tr>
        <tr>
            <th>Đội 2:</th>
            <td>{{ $match->team2->name }}</td>
        </tr>
        <tr>
            <th>Sân đấu:</th>
            <td>{{ $match->stadium->name }}</td>
        </tr>
        <tr>
            <th>Số sân:</th>
            <td>{{ $match->field_number }}</td>
        </tr>
        <tr>
            <th>Ngày giờ:</th>
            <td>{{ $match->match_date }}</td>
        </tr>
        <tr>
            <th>Địa điểm:</th>
            <td>{{ $match->location }}</td>
        </tr>
    </table>
    <a href="{{ route('tournaments.show', $tournament->id) }}" class="tournament-link">
                        {{ $tournament->name }}
                    </a>
    <!-- <a href="{{ route('tournament.show') }}" class="btn btn-secondary">Quay lại</a> -->
</div>
@endsection
