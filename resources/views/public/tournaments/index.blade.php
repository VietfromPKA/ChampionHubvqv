@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/tournaments.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <h1 class="title">Danh sách các giải đấu</h1>
    <div class="tournament-list">
        @foreach ($tournaments as $tournament)
            <div class="tournament-card">
                <div class="tournament-banner">
                    <img src="{{ asset('images/banner_gd.svg') }}" alt="Banner" class="banner-img">
                </div>
                <div class="tournament-details">
                    <h2 class="tournament-name">{{ $tournament->name }}</h2>
                    <p class="tournament-date" >📅 {{ $tournament->start_date }} đến {{ $tournament->end_date }}</p>
                    <p>⚽ {{ $tournament->teams->count() }} Đội</p>

                    <button class="follow-btn">Theo dõi</button>
                    <div class="tournament-meta">
                        <a href="" class="info-link">Đăng Ký →</a>
                        <a href="" class="info-link">Thông tin →</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection