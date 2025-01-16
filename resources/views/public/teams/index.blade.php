@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/teams.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="teams-container">
    <div class="page-header">
        <h1 class="page-title">Danh Sách Đội Bóng</h1>
        <form action="#" method="GET" class="search-form">
            <input type="text" name="search" class="search-input" placeholder="Tìm đội bóng">
            <button type="submit" class="search-btn">Tìm Kiếm</button>
        </form>
    </div>
    <div>
        @if($teams->isEmpty())
            <p class="no-teams-message">Hiện tại không có đội bóng nào trong danh sách.</p>
        @else
            <div class="team-list">
                @foreach($teams as $team)
                    <div class="team-card">
                        <h2 class="team-name">{{ $team->name }}</h2>
                        <p class="coach-name"><strong>Huấn luyện viên:</strong> {{ $team->coach_name ?? 'Không có thông tin' }}
                        </p>
                        <p class="tournament-name">
                            <strong>Thuộc giải đấu:</strong>
                            {{ $team->tournament->name ?? 'Không rõ' }}
                        </p>
                        <div class="buttom_tt">
                            <a href="" class="info-link">Tham Gia</a>
                            <a href="" class="info-link">Xem chi tiết</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection