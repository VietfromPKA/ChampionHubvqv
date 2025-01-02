@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/teams.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="teams-container">
        <h1 class="page-title">Danh Sách Đội Bóng</h1>

        @if($teams->isEmpty())
            <p class="no-teams-message">Hiện tại không có đội bóng nào trong danh sách.</p>
        @else
            <div class="team-list">
                @foreach($teams as $team)
                    <div class="team-card">
                        <h2 class="team-name">{{ $team->name }}</h2>
                        <p class="coach-name"><strong>Huấn luyện viên:</strong> {{ $team->coach_name ?? 'Không có thông tin' }}</p>
                        <p class="tournament-name">
                            <strong>Thuộc giải đấu:</strong> 
                            {{ $team->tournament->name ?? 'Không rõ' }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
