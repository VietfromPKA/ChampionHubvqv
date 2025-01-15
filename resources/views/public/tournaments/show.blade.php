@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/qlygiaidau.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="tournament-details">
    <h1 class="tournament-title">{{ $tournament->name }}</h1>
    <p class="tournament-date"><strong>Thời gian:</strong>Từ {{ $tournament->start_date }} đến
        {{ $tournament->end_date }}
    </p>

    <h2 class="team-list-title">Danh sách đội bóng</h2>
    <button class="toggle-teams-btn">Hiển thị danh sách đội bóng</button>
    @if ($tournament->teams->isEmpty())
        <p class="no-teams">Không có đội bóng nào tham gia giải đấu này.</p>
    @else
        <div class="team-list">
            @foreach ($tournament->teams->chunk(3) as $teamChunk)
                <div class="team-row">
                    @foreach ($teamChunk as $team)
                        <div class="team-item">
                            <strong class="team-name">Tên đội:</strong> {{ $team->name }}
                            <br>
                            <strong class="coach-name">Huấn luyện viên:</strong> {{ $team->coach_name ?? 'Không có thông tin' }}
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif

    <h2 class="game-schedule-title">Lịch thi đấu</h2>
    @if ($tournament->games->isEmpty())
        <p class="no-games">Chưa có lịch thi đấu cho giải đấu này.</p>
    @else
        <table class="game-schedule-table">
            <thead>
                <tr>
                    <th>Đội 1</th>
                    <th>Đội 2</th>
                    <th>Ngày giờ</th>
                    <th>Địa điểm</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tournament->games as $game)
                    <tr>
                        <td>{{ $game->team1->name }}</td>
                        <td>{{ $game->team2->name }}</td>
                        <td>{{ $game->match_date }}</td>
                        <td>{{ $game->location }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('public.tournaments.index') }}" class="back-link">Quay lại giải đấu</a>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButton = document.querySelector('.toggle-teams-btn');
        const teamList = document.querySelector('.team-list');

        toggleButton.addEventListener('click', function () {
            teamList.classList.toggle('show');
            toggleButton.textContent = teamList.classList.contains('show')
                ? 'Ẩn danh sách đội bóng'
                : 'Hiển thị danh sách đội bóng';
        });
    });
</script>

@endsection