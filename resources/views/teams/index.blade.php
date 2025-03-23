@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/qlydoibong.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="team-list-container">
    <h1 class="page-title">Danh sách đội bóng</h1>
    <a href="{{ route('teams.create') }}" class="add-team-btn">Thêm đội bóng</a>

    <table class="team-table" id="team-table">
        <thead>
            <tr>
                <th>Tên đội bóng</th>
                <th>Huấn luyện viên</th>
                <th>Giải đấu</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teams as $team)
                <tr>
                    <td>{{ $team->name }}</td>
                    <td>{{ $team->coach_name }}</td>
                    <td>{{ $team->tournament->name }}</td>
                    <td class="action-buttons">
                        <a href="{{ route('teams.player.index', ['team_id' => $team->id]) }}"><button type="submit" class="action-btn">Danh sách cầu thủ</button></a>
                        <a href="{{ route('teams.edit', $team->id) }}"><button type="submit" class="edit-button">Sửa</button></a>
                        <form action="{{ route('teams.destroy', $team->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn delete-btn">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection