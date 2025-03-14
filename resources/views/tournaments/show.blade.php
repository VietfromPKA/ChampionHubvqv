@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/qlygiaidau.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="tournament-details">
        <h1 class="tournament-title">{{ $tournament->name }}</h1>
        <p class="tournament-date"><strong>Thời gian:</strong> Từ {{ $tournament->start_date }} đến
            {{ $tournament->end_date }}</p>

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
                                <strong class="team-name">Tên đội:</strong> {{ $team->name }}<br>
                                <strong class="coach-name">Huấn luyện viên:</strong> {{ $team->coach_name ?? 'Không có thông tin' }}
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endif

        <h2 class="game-schedule-title">Lịch thi đấu</h2>
        @if ($tournament->matchSchedules->isEmpty())
            <p class="no-games">Chưa có lịch thi đấu cho giải đấu này.</p>
        @else
            <table class="game-schedule-table">
                <thead>
                    <tr>
                        <th>Ngày giờ</th>
                        <th>Đội 1</th>
                        <th>Đội 2</th>
                        <th>Sân thi đấu</th>
                        <th>Số sân</th>
                        <th>Loại lịch đấu</th>
                        <th>Địa điểm</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tournament->matchSchedules as $matchSchedule)
                        <tr>
                            <td>{{ $matchSchedule->match_date }}</td>
                            <td>{{ $matchSchedule->team1->name }}</td>
                            <td>{{ $matchSchedule->team2->name }}</td>
                            <td>{{ $matchSchedule->stadium->name }}</td>
                            <td>{{ $matchSchedule->field_number }}</td>
                            <td>{{ ucfirst($matchSchedule->schedule_type) }}</td>
                            <td>{{ $matchSchedule->location }}</td>
                            <td>
                                <a href="{{ route('matches.edit', $matchSchedule->id) }}" class="btn btn-primary">Chỉnh sửa</a>
                                <form action="{{ route('matches.destroy', $matchSchedule->id) }}" method="POST"
                                    style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa trận đấu này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- Nút tạo lịch đấu mới -->
        <a href="{{ route('matches.create', ['tournamentId' => $tournament->id]) }}" class="btn btn-success">
            Tạo lịch đấu mới
        </a>


        <a href="{{ route('tournament.index') }}" class="back-link">Quay lại giải đấu</a>
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