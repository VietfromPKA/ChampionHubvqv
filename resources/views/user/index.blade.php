@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="profile-container">
    <h1 class="profile-title">Thông Tin Cá Nhân</h1>

    <div class="profile-card">
        <img src="{{ asset('images/avt.svg') }}" alt="Avatar" class="profile-avatar">

        <div class="profile-info">
            <h2 class="user-name">{{ $user->name ?? 'Người Dùng' }}</h2>
            <p class="user-email"><strong>Email:</strong> {{ $user->email ?? 'Chưa có thông tin' }}</p>
            <p class="join-date"><strong>Ngày tham gia:</strong> {{ $user->created_at->format('d-m-Y') ?? '---' }}</p>
        </div>
    </div>
    <div>
        <h3 class="list-title">Các giải đấu đã tạo:</h3>
        @if ($tournaments->isEmpty())
            <p class="no-tournaments">Bạn chưa tạo giải đấu nào.</p>
        @else
            <ul class="tournament-list">
                @foreach ($tournaments as $tournament)
                    <li class="tournament-item">
                        <a href="{{ route('tournaments.show', $tournament->id) }}">{{ $tournament->name }}</a>
                    </li>
                @endforeach
            </ul>
        @endif

        <h3 class="list-title">Các đội bóng tham gia:</h3>
        @if ($teams->isEmpty())
            <p class="no-teams">Bạn chưa tham gia đội bóng nào.</p>
        @else
            <ul class="team-list">
                @foreach ($teams as $team)
                    <li class="team-item">
                        <a href="#">{{ $team->name }}</a>
                    </li>
                @endforeach
            </ul>
        @endif

        <a href="{{ route('logout') }}" class="logout-link"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

</div>
@endsection