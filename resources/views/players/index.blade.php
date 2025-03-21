@extends('layouts.app')
@section('styles')
    <link href="{{ asset('css/player.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <h1>Danh sách cầu thủ của đội: {{ $team->name }}</h1>

        @if ($players->isEmpty())
            <p>Không có cầu thủ nào trong đội này.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Tên</th>
                        <th>Tuổi</th>
                        <th>Vị trí</th>
                        <th>Số áo</th>
                        <th>Email</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($players as $player)
                        <tr>
                            <td>{{ $player->name }}</td>
                            <td>{{ $player->age ?? 'N/A' }}</td>
                            <td>{{ $player->position ?? 'N/A' }}</td>
                            <td>{{ $player->jersey_number }}</td>
                            <td>{{ $player->email }}</td>
                            <td>
                                <a href="{{ route('players.edit', ['teamId' => $team->id, 'playerId' => $player->id]) }}"
                                    class="btn btn-warning">Sửa</a>
                                <form action="{{ route('players.destroy', ['teamId' => $team->id, 'playerId' => $player->id]) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa cầu thủ này không?')">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('players.create', $team->id) }}" class="btn btn-primary">Thêm cầu thủ</a>

        <a href="{{ route('players.import', $team->id) }}" class="btn btn-primary">Thêm từ excel</a>
    </div>
@endsection