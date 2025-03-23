@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/qlydoibong.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="team-list-container">
        <div class="header-section">
            <h1 class="page-title">Danh sách đội bóng</h1>
        </div>

        <div class="table-container">
            @if(count($teams) > 0)
                <table class="team-table" id="team-table">
                    <thead>
                        <tr>
                            <th>Tên đội bóng</th>
                            <th>Huấn luyện viên</th>
                            <th>Giải đấu</th>
                            <th>Sửa đội bóng</th>
                            <th>Xóa đội bóng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teams as $team)
                            <tr>
                                <td class="team-name">
                                    <a href="{{ route('players.index', $team->id) }}">{{ $team->name }}</a>
                                </td>
                                <td>{{ $team->coach_name }}</td>
                                <td>{{ $team->tournament->name }}</td>
                                <td class="action-buttons-cell">
                                    <a href="{{ route('teams.edit', $team->id) }}" class="btn-wrapper">
                                        <button type="button" class="edit-button">Sửa</button>
                                    </a>
                                </td>
                                <td class="action-buttons-cell">
                                    <form action="{{ route('teams.destroy', $team->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-button">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-teams">
                    <p>Chưa có đội bóng nào. Hãy thêm đội bóng mới!</p>
                </div>
            @endif
        </div>
        <div class="add-team-button">
            <a href="{{ route('teams.create') }}">
                Thêm đội bóng
            </a>
        </div>
    </div>
@endsection