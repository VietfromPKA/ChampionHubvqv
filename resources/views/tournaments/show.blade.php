@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/tournament_show.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="tournament-container">
        <header class="tournament-header">
            <h1 class="tournament-title" style="color : white">Giải đấu: {{ $tournament->name }}</h1>
            <p class="tournament-date" style="color : white"><strong>Thời gian: </strong>từ ngày {{ $tournament->start_date }} đến ngày
                {{ $tournament->end_date }}</p>
            
        </header>

        <!-- Danh sách đội bóng -->
        <section class="teams-section">
            <h2 class="section-title">Danh sách đội bóng</h2>
            <button class="toggle-teams-btn">Hiển thị danh sách đội</button>
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
        </section>

        <!-- Lịch thi đấu -->
        <section class="schedule-section">
            <h2 class="section-title">Lịch thi đấu</h2>
            <div class="match-card-container">
                @foreach ($tournament->matchSchedules->sortBy('match_date') as $match)
                    <div class="match-card">
                        <div class="match-header">
                            <span class="match-date">{{ date('d/m/Y H:i', strtotime($match->match_date)) }}</span>
                            <span class="schedule-type">{{ ucfirst($match->schedule_type) }}</span>
                        </div>
                        <div class="match-body">
                            <div class="teams">
                                <span class="team">{{ $match->team1->name }}</span>
                                <span class="vs">vs</span>
                                <span class="team">{{ $match->team2->name }}</span>
                            </div>
                            <p class="match-info"><strong>Sân:</strong> {{ $match->stadium->name }} - Số
                                {{ $match->field_number }}</p>
                            <p class="match-info"><strong>Địa điểm:</strong> {{ $match->location }}</p>
                        </div>
                        <div class="match-actions">
                            <a href="{{ route('matches.edit', $match->id) }}" class="btn btn-primary">Chỉnh sửa</a>
                            <a class="open-score-form btn btn-primary" data-match-id="{{ $match->id }}">Cập nhật tỷ số</a>
                            <form action="{{ route('matches.destroy', $match->id) }}" method="POST"
                                onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <div id="scoreForm" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-lg">
            <div class="w-full max-w-md p-8 bg-white rounded-3xl shadow-2xl transform transition-all scale-95 hover:scale-100">
                <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-6">Cập Nhật Tỉ Số</h2>
                <form id="scoreUpdateForm" class="space-y-6">
                    <input type="hidden" id="matchId">
                    <div>
                        <label class="block text-lg font-semibold text-gray-700 mb-2">Tỉ số đội 1</label>
                        <input type="number" id="scoreTeam1" class="w-full p-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-md placeholder-gray-400" placeholder="0">
                    </div>
                    <div>
                        <label class="block text-lg font-semibold text-gray-700 mb-2">Tỉ số đội 2</label>
                        <input type="number" id="scoreTeam2" class="w-full p-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-md placeholder-gray-400" placeholder="0">
                    </div>
                    <div class="flex justify-between mt-6">
                        <button type="button" id="closeFormBtn" class="px-6 py-3 text-gray-700 bg-gray-300 rounded-2xl hover:bg-gray-400 transition-all shadow-md">Hủy</button>
                        <button type="submit" class="px-6 py-3 text-white bg-blue-600 rounded-2xl hover:bg-blue-700 transition-all shadow-lg">Cập Nhật</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bảng xếp hạng -->
        <section class="standings-section">
            <h2 class="section-title">Bảng xếp hạng</h2>
            <table class="standings-table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Đội</th>
                        <th>Trận</th>
                        <th>Thắng</th>
                        <th>Hòa</th>
                        <th>Thua</th>
                        <th>Hiệu số</th>
                        <th>Điểm</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tournament->teams as $index => $team)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $team->name }}</td>
                            <td>{{ $team->matches_played }}</td>
                            <td>{{ $team->wins }}</td>
                            <td>{{ $team->draws }}</td>
                            <td>{{ $team->losses }}</td>
                            <td>{{ $team->goal_difference }}</td>
                            <td>{{ $team->points }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <!-- Hành động -->
        <div class="tournament-actions">
            <a href="{{ route('matches.create', ['tournamentId' => $tournament->id]) }}" class="btn action-btn">Tạo trận
                đấu</a>
            <a href="{{ route('user.index') }}" class="btn action-btn">Quay lại</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.querySelector('.toggle-teams-btn');
            const teamList = document.querySelector('.team-list');
            toggleBtn.addEventListener('click', function () {
                teamList.classList.toggle('hidden');
                toggleBtn.textContent = teamList.classList.contains('hidden') ? 'Hiển thị danh sách đội' : 'Ẩn danh sách đội';
            });
        });

        document.querySelectorAll('.open-score-form').forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('scoreForm').classList.remove('hidden');
            });
        });

        document.getElementById('closeFormBtn').addEventListener('click', function () {
            document.getElementById('scoreForm').classList.add('hidden');
        });
    </script>
@endsection