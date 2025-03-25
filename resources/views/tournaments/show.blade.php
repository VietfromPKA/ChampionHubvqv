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
                    <div class="match-card" data-match-id="{{ $match->id }}" data-team1-name="{{ $match->team1->name }}" data-team2-name="{{ $match->team2->name }}">
                        <div class="match-header">
                            <span class="match-date">{{ date('d/m/Y H:i', strtotime($match->match_date)) }}</span>
                            <span class="schedule-type">{{ ucfirst($match->schedule_type) }}</span>
                        </div>
                        <div class="match-body">
                            <div class="teams">
                                <span class="team">{{ $match->team1->name }}</span>
                                <span class="vs">
                                    @if ($match->status === 'completed')
                                        {{ $match->scoreTeam1 }} - {{ $match->scoreTeam2 }}
                                    @else
                                        vs
                                    @endif
                                </span>
                                <span class="team">{{ $match->team2->name }}</span>
                            </div>
                            <p class="match-info"><strong>Sân:</strong> {{ $match->stadium->name }} - Số{{ $match->field_number }}</p>
                            <p class="match-info"><strong>Địa điểm:</strong> {{ $match->location }}</p>
                        </div>
                        @if (auth()->check() && auth()->user()->id === $tournament->user_id) 
                            <div class="match-actions">
                                <a href="{{ route('matches.edit', $match->id) }}" class="btn btn-primary">Chỉnh sửa</a>
                                <a class="open-score-form btn btn-primary" data-match-id="{{ $match->id }}">Cập nhật tỷ số</a>
                                <form action="{{ route('matches.destroy', $match->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </div>
                            <!-- Form cập nhật điểm số duy nhất -->
                            <div id="scoreForm" class="hidden">
                                <div>
                                    <h2>Cập Nhật Tỉ Số</h2>
                                    <div class="teams">
                                        <span id="scoreTeam1Name" class="team"></span>
                                        <span class="vs">vs</span>
                                        <span id="scoreTeam2Name" class="team"></span>
                                    </div>
                                    <form id="scoreUpdateForm" method="POST" action="{{ route('matches.updateScore') }}">
                                        @csrf                                        
                                        <input type="hidden" name="match_id" id="matchId" value="">
                                        <input type="hidden" name="tournament_id" id="tournamentId" value="{{ $tournament->id }}">
                                        <div>
                                            <label id="scoreTeam1Label" for="scoreTeam1">Tỉ số đội 1</label>
                                            <input type="number" name="scoreTeam1" id="scoreTeam1" placeholder="0" required min="0">
                                        </div>
                                        <div>
                                            <label id="scoreTeam2Label" for="scoreTeam2">Tỉ số đội 2</label>
                                            <input type="number" name="scoreTeam2" id="scoreTeam2" placeholder="0" required min="0">
                                        </div>
                                        <div class="flex justify-between mt-6">
                                            <button type="button" id="closeFormBtn">Hủy</button>
                                            <button type="submit">Cập Nhật</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>



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
                            <td>{{ $team->matches()->count() }}</td>
                            <td>{{ $team->winsCount() }}</td>
                            <td>{{ $team->drawsCount() }}</td>
                            <td>{{ $team->lossesCount() }}</td>
                            <td>{{ $team->goalDifference() }}</td>
                            <td>{{ $team->totalPoints() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <!-- Hành động -->
        <div class="tournament-actions">
            @if (auth()->check() && auth()->user()->id === $tournament->user_id) 
                <a href="{{ route('matches.create', ['tournamentId' => $tournament->id]) }}" class="btn action-btn">Tạo trận đấu</a>
            @endif
            <a href="{{ url()->previous() }}" class="btn action-btn">Quay lại</a>
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

        document.addEventListener('DOMContentLoaded', function() {
            const scoreForm = document.getElementById('scoreForm');
            const matchCards = document.querySelectorAll('.match-card');
            const openScoreFormButtons = document.querySelectorAll('.open-score-form');
            const closeFormBtn = document.getElementById('closeFormBtn');

            // Thêm sự kiện cho các nút "Cập nhật tỷ số"
            openScoreFormButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const matchId = this.getAttribute('data-match-id');
                    const matchCard = document.querySelector(`.match-card[data-match-id="${matchId}"]`);
                    
                    // Điền thông tin vào form
                    document.getElementById('matchId').value = matchId;
                    document.getElementById('scoreTeam1Name').textContent = matchCard.getAttribute('data-team1-name');
                    document.getElementById('scoreTeam2Name').textContent = matchCard.getAttribute('data-team2-name');
                    document.getElementById('scoreTeam1Label').textContent = `Tỉ số ${matchCard.getAttribute('data-team1-name')}`;
                    document.getElementById('scoreTeam2Label').textContent = `Tỉ số ${matchCard.getAttribute('data-team2-name')}`;

                    // Hiển thị form
                    scoreForm.classList.remove('hidden');
                });
            });

            // Đóng form
            closeFormBtn.addEventListener('click', function() {
                scoreForm.classList.add('hidden');
            });
        });
    </script>
@endsection