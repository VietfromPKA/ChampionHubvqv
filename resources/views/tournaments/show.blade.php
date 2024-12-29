@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/qlygiaidau.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="tournament-details">
    <h1 class="tournament-title">{{ $tournament->name }}</h1>
    <p class="tournament-date"><strong>Thời gian:</strong>Từ {{ $tournament->start_date }} đến
        {{ $tournament->end_date }}</p>

    <h2 class="team-list-title">Danh sách đội bóng</h2>
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
                    <th>Chỉnh sửa</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tournament->games as $game)
                    <tr>
                        <td>{{ $game->team1->name }}</td>
                        <td>{{ $game->team2->name }}</td>
                        <td>{{ $game->match_date }}</td>
                        <td>{{ $game->location }}</td>
                        <td>
                            <a href="{{ route('games.index', $game->id) }}" class="btn btn-primary">Chỉnh sửa</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Nếu người dùng là người tạo giải đấu, hiển thị nút tạo trận đấu mới -->
    <a href="{{ route('games.create', ['tournament' => $tournament->id]) }}" class="back-link">Tạo trận đấu mới</a>

    <a href="{{ route('tournament.index') }}" class="back-link">Quay lại giải đấu</a>
</div>
@endsection