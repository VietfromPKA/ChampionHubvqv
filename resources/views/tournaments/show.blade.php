@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/qlygiaidau.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="tournament-details">
        <h1 class="tournament-title">{{ $tournament->name }}</h1>
        <p class="tournament-date"><strong>Thời gian:</strong>Từ {{ $tournament->start_date }} đến {{ $tournament->end_date }}</p>
        <p class="team-count"><strong>Số đội tham gia:</strong> {{ $tournament->team_count }}</p>

        <h2 class="team-list-title">Danh sách đội bóng</h2>
        @if ($tournament->teams->isEmpty())
            <p class="no-teams">Không có đội bóng nào tham gia giải đấu này.</p>
        @else
            <ul class="team-list">
                @foreach ($tournament->teams as $team)
                    <li class="team-item">
                        <strong class="team-name">Tên đội:</strong> {{ $team->name }} 
                        <br>
                        <strong class="coach-name">Huấn luyện viên:</strong> {{ $team->coach_name ?? 'Không có thông tin' }}
                    </li>
                @endforeach
            </ul>
        @endif

        <a href="{{ route('tournament.index') }}" class="back-link">Quay lại danh sách giải đấu</a>
    </div>
@endsection
