@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $tournament->name }}</h1>
        <p>Thời gian: {{ $tournament->start_date }} - {{ $tournament->end_date }}</p>

        <h2>Danh sách đội bóng</h2>
        @if($tournament->teams->isEmpty())
            <p>Không có đội bóng nào tham gia giải đấu này.</p>
        @else
            <ul>
                @foreach($tournament->teams as $team)
                    <li>{{ $team->name }}</li>
                @endforeach
            </ul>
        @endif

        <h2>Lịch thi đấu</h2>
        @if($tournament->games->isEmpty())
            <p>Không có lịch thi đấu.</p>
        @else
            <ul>
                @foreach($tournament->games as $game)
                    <li>{{ $game->team_a->name }} vs {{ $game->team_b->name }} - {{ $game->date }}</li>
                @endforeach
            </ul>
        @endif

        <a href="{{ route('public.tournaments.index') }}">Quay lại danh sách giải đấu</a>
    </div>
@endsection
