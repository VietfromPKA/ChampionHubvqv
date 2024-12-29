@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/games.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-games">
    <h1>Danh sách Trận đấu</h1>
    <a href="{{ route('games.create') }}" class="btn-primary-games">Tạo trận đấu mới</a>
    <table class="table-games mt-3">
        <thead>
            <tr>
                <th>Giải đấu</th>
                <th>Đội 1</th>
                <th>Đội 2</th>
                <th>Ngày giờ</th>
                <th>Địa điểm</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($games as $game)
                <tr>
                    <td>{{ $game->tournament->name }}</td>
                    <td>{{ $game->team1->name }}</td>
                    <td>{{ $game->team2->name }}</td>
                    <td>{{ $game->match_date }}</td>
                    <td>{{ $game->location }}</td>
                    <td>

                        <form action="{{ route('games.edit', $game->id) }}" method="GET" style="display:inline;">
                            <button type="submit" class="btn-warning-games">Chỉnh sửa</button>
                        </form>

                        <form action="{{ route('games.destroy', $game->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger-games">Xóa</button>
                        </form>


                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection