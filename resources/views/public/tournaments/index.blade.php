@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/tournaments.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="tournaments-container">
    <div class="page-header">
        <h1 class="title">Danh sách các giải đấu</h1>
        <form action="#" method="GET" class="search-form">
            <input type="text" name="search" class="search-input" placeholder="Tìm đội bóng">
            <button type="submit" class="search-btn">Tìm Kiếm</button>
        </form>
    </div>
    <div class="tournament-list">
        @foreach ($tournaments as $tournament)
            <div class="tournament-card">
                <div class="tournament-banner">
                    <img src="{{ asset('images/banner_gd.svg') }}" alt="Banner" class="banner-img">
                </div>
                <div class="tournament-details">
                    <h2 class="tournament-name">{{ $tournament->name }}</h2>
                    <p class="tournament-date">📅 {{ $tournament->start_date }} đến {{ $tournament->end_date }}</p>
                    <p>⚽ {{ $tournament->teams->count() }} Đội</p>

                    <button class="follow-btn">Theo dõi</button>
                    <div class="buttom_tt">
                        
                        <a href="" class="info-link">Đăng Ký →</a>
                        <a href="" class="info-link">Thông tin →</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection