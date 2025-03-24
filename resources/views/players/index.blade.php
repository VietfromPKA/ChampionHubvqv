@extends('layouts.app')
@section('styles')
    <link href="{{ asset('css/qlydoibong.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="team-list-conteainer">
        <div class="header-section">
            <h1 class="page-title">Danh sách cầu thủ của đội: {{ $team->name }}</h1>
        </div>
        <div class="table-container">

            @if ($players->isEmpty())
                <p>Không có cầu thủ nào trong đội này.</p>
            @else
                <table class="team-table" id="team-table">
                    <thead>
                        <tr>
                            <th>Tên cầu thủ</th>
                            <th>Tuổi</th>
                            <th>Vị trí</th>
                            <th>Số áo</th>
                            <th>Email</th>
                            <th>Sửa thông tin</th>
                            <th>Xóa cầu thủ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($players as $player)
                            <tr>
                                <td data-title="Tên cầu thủ">{{ $player->name }}</td>
                                <td data-title="Tuổi">{{ $player->age ?? 'N/A' }}</td>
                                <td data-title="Vị trí">{{ $player->position ?? 'N/A' }}</td>
                                <td data-title="Số áo">{{ $player->jersey_number }}</td>
                                <td data-title="Email">{{ $player->email }}</td>
                                <td class="action-buttons-cell">
                                    <a href="{{ route('players.edit', ['team_id' => $team->id, 'player' => $player->id]) }}" class="btn-wrapper">
                                        <button type="button" class="edit-button">Sửa</button>
                                    </a>
                                </td>
                                <td data-title="Thao tác" class="action-buttons-cell">
                                    <form action="{{ route('players.destroy', ['team_id' => $team->id, 'player' => $player->id]) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-button"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa cầu thủ này không?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="add-team-button">
            <a href="{{ route('players.create', $team->id) }}" class="btn btn-primary">Thêm cầu thủ</a>
            <a href="{{ route('players.importForm', $team->id) }}" class="btn btn-primary">Thêm từ excel</a>
        </div>

        <div class="back-link-container">
            <a href="{{ route('teams.index') }}" class="back-link">Quay lại danh sách đội bóng</a>
        </div>
    </div>

@endsection