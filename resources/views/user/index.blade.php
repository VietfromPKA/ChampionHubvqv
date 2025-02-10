@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="profile-container">
    <h1 class="profile-title">Thông Tin Cá Nhân</h1>

    <div class="profile-card">

        <img src="{{ asset('images/avt.svg') }}" alt="Avatar" class="profile-avatar">
        <!-- @if ($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="profile-avatar">
        @else
            <img src="{{ asset('images/avt.svg') }}" alt="Avatar" class="profile-avatar"> -->

        @endif
        <div class="profile-info">
            <h2 class="user-name">{{ $user->name ?? 'Người Dùng' }}</h2>
            <p class="user-email"><strong>Email:</strong> {{ $user->email ?? 'Chưa có thông tin' }}</p>
            <p class="join-date"><strong>Ngày tham gia:</strong> {{ $user->created_at->format('d-m-Y') ?? '---' }}</p>
        </div>
    </div>
    <div class="profile-details">
        <h3 class="list-title">Các giải đấu đã tạo:</h3>
        <button class="toggle-tournaments-btn">Hiển thị các giải đấu đã tạo</button>

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
        <button class="toggle-teams-btn">Hiển thị đội bóng tham gia</button>
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
    </div>
    <div>
        <a href="{{ route('logout') }}" class="logout-link"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

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

    document.addEventListener('DOMContentLoaded', function () {
        const toggleButton = document.querySelector('.toggle-tournaments-btn');
        const tournamentList = document.querySelector('.tournament-list');

        toggleButton.addEventListener('click', function () {
            tournamentList.classList.toggle('show');
            toggleButton.textContent = tournamentList.classList.contains('show')
                ? 'Ẩn danh sách giải đấu'
                : 'Hiển thị danh sách giải đấu';
        });
    });
</script>
@endsection